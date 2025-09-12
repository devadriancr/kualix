<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Department;
use App\Models\FSO;
use App\Models\Material;
use App\Models\MaterialMovement;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MaterialController extends Controller
{
    /**
     * Display a listing of the materials.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');

        $materials = Material::when($search, function ($query, $search) {
            return $query->where('barcode', 'like', "%{$search}%")
                ->orWhere('order_number', 'like', "%{$search}%")
                ->orWhere('part_number', 'like', "%{$search}%");
        })
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('materials.index', compact('materials', 'search'));
    }

    /**
     * Show the movements of a specific material.
     */
    public function movements($id, Request $request)
    {
        $material = Material::findOrFail($id);
        // $search = $request->get('search');

        $movements = MaterialMovement::with(['user', 'area'])
            ->where('material_id', $id)
            // ->when($search, function ($query, $search) {
            //     return $query->whereHas('user', function ($q) use ($search) {
            //         $q->where('name', 'like', "%{$search}%");
            //     })
            //         ->orWhere('type', 'like', "%{$search}%")
            //         ->orWhere('comment', 'like', "%{$search}%");
            // })
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('materials.movements', compact('material', 'movements'));
    }

    /**
     * Show the form for scanning materials.
     */
    public function scan()
    {
        return view('materials.scan');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'scanInput' => 'required|string|max:20',
        ], [
            'scanInput.required' => 'El campo de escaneo es obligatorio.',
            'scanInput.string'   => 'El campo de escaneo debe ser una cadena.',
            'scanInput.max'      => 'El campo de escaneo no puede tener más de 20 caracteres.',
        ]);

        $barcode        = $validated['scanInput'];
        $orderNumber    = substr($barcode, 0, 8);
        $sequence       = substr($barcode, 8, 6);
        $standardPack   = substr($barcode, 14, 6);

        $material = Material::where('barcode', $barcode)->first();

        $partNumberCode = FSO::query()
            ->selectRaw('TRIM(SPROD) AS part_number')
            ->where('SORD', $orderNumber)
            ->value('PART_NUMBER');

        if (!$partNumberCode) {
            return back()->with('error', 'Número de parte no encontrado');
        }

        if (!$material) {
            // Primer escaneo → Registrar material como pendiente
            $material = Material::create([
                'barcode'       => $barcode,
                'order_number'  => $orderNumber,
                'sequence'      => $sequence,
                'standard_pack' => $standardPack,
                'status'        => 'pending',
                'part_number'   => $partNumberCode,
            ]);

            // Registrar entrada
            $material->materialMovements()->create([
                'area_id' => Auth::user()->area_id ?? null,
                'user_id' => Auth::id(),
                'type'    => 'inspection',
            ]);

            return back()->with('success', "Material registrado: {$barcode}");
        }

        // Segundo escaneo (ya existe)
        if ($material->status === 'pending') {
            return redirect()->route('materials.inspect', $material->id);
        }

        $statusLabels = [
            'pending'   => 'Pendiente',
            'approved'  => 'Aprobado',
            'rejected'  => 'Rechazado',
            'validated' => 'Validado',
        ];

        $statusLabel = $statusLabels[$material->status] ?? ucfirst($material->status ?? 'Sin estado');

        return back()->with('error', "Este material ya fue procesado con estado: {$statusLabel}");
    }

    /**
     * Show the form for inspecting materials.
     */
    public function inspect(Material $material)
    {
        if ($material->status !== 'pending') {
            return redirect()->route('materials.scan')->withErrors(['Este material ya fue procesado.']);
        }

        return view('materials.inspect', compact('material'));
    }

    public function storeInspection(Request $request, Material $material)
    {
        $validated = $request->validate([
            'status'   => 'required|in:approved,rejected',
            'comment'  => 'nullable|string|max:255',
        ], [
            'status.required' => 'El campo de estado es obligatorio.',
            'status.in'       => 'El estado debe ser "Aprobado" o "Rechazado".',
            'comment.string'  => 'El comentario debe ser una cadena.',
            'comment.max'     => 'El comentario no puede tener más de 255 caracteres.',
        ]);

        $material->update([
            'status' => $validated['status'],
        ]);

        $material->materialMovements()->create([
            'area_id'   => Auth::user()->area_id ?? null,
            'user_id'   => Auth::id(),
            'type'      => $validated['status'] === 'approved' ? 'validated' : 'rejection',
            'comment'   => $validated['comment'],
        ]);


        return redirect()->route('materials.print-label', $material->id);
    }

    /**
     * Mostrar la etiqueta para impresión
     */
    public function printLabel($id)
    {
        $material = Material::findOrFail($id);

        return view('materials.print-label', compact('material'));
    }

    public function validate(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'scanInput' => 'required|string|max:26' // Cambié a 26 para ULID
            ], [
                'scanInput.required' => 'El campo de entrada de escaneo es obligatorio.',
                'scanInput.string'   => 'El campo de entrada de escaneo debe ser una cadena.',
                'scanInput.max'      => 'El campo de entrada de escaneo no puede tener más de 26 caracteres.',
            ]);

            // Buscar por ULID en lugar de barcode
            $material = Material::with(['materialMovements' => function ($query) {
                $query->latest()->with(['user', 'area.department']);
            }])->where('ulid', $request->scanInput)->first();

            if (!$material) {
                return back()->with('error', 'Material no encontrado');
            }

            $lastMovement = $material->materialMovements->first();

            return back()->with([
                'material' => $material,
                'lastMovement' => $lastMovement,
                'success' => 'Material encontrado'
            ]);
        }

        return view('materials.validate');
    }

    public function statistics(Request $request)
    {
        // Opciones permitidas y valor por defecto
        $allowedDays = [7, 14, 30, 60];
        $days = (int) $request->query('days', 14);
        if (!in_array($days, $allowedDays)) {
            $days = 14;
        }

        // Total de materiales
        $totalMaterials = Material::count();

        // Conteo por status
        $statusCounts = Material::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->orderBy('status')
            ->get()
            ->pluck('total', 'status')
            ->toArray();

        // Movimientos por área — solo áreas con > 0 movimientos
        $movementsByAreaQuery = DB::table('areas')
            ->leftJoin('material_movements', 'areas.id', '=', 'material_movements.area_id')
            ->select('areas.id', 'areas.name', DB::raw('COUNT(material_movements.id) as total'))
            ->groupBy('areas.id', 'areas.name')
            ->havingRaw('COUNT(material_movements.id) > 0') // <- quita ceros
            ->orderByDesc('total');

        $movementsByArea = $movementsByAreaQuery
            ->pluck('total', 'name') // ['Área A' => 12, ...]
            ->toArray();

        $start = Carbon::now()->subDays($days - 1)->startOfDay();

        $materialsPerDayQuery = Material::where('created_at', '>=', $start)
            ->select(DB::raw("CAST(created_at AS DATE) as date"), DB::raw('count(*) as total'))
            ->groupBy(DB::raw("CAST(created_at AS DATE)"))
            ->orderBy('date')
            ->get()
            ->pluck('total', 'date')
            ->toArray();

        $labelsDates = [];
        $materialsPerDay = [];
        for ($i = 0; $i < $days; $i++) {
            $d = $start->copy()->addDays($i)->format('Y-m-d');
            $labelsDates[] = $d;
            $materialsPerDay[] = isset($materialsPerDayQuery[$d]) ? (int)$materialsPerDayQuery[$d] : 0;
        }

        // Movimientos recientes
        $recentMovements = MaterialMovement::with(['material', 'area', 'user'])
            ->latest()
            ->limit(10)
            ->get();

        return view('materials.statistics', [
            'totalMaterials' => $totalMaterials,
            'statusCounts' => $statusCounts,
            'movementsByArea' => $movementsByArea,
            'materialsPerDayLabels' => $labelsDates,
            'materialsPerDayValues' => $materialsPerDay,
            'recentMovements' => $recentMovements,
            'days' => $days,
            'daysOptions' => $allowedDays,
        ]);
    }
}

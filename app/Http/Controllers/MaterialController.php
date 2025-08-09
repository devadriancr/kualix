<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaterialController extends Controller
{
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

        if (!$material) {
            // Primer escaneo → Registrar material como pendiente
            $material = Material::create([
                'barcode'       => $barcode,
                'order_number'  => $orderNumber,
                'sequence'      => $sequence,
                'standard_pack' => $standardPack,
                'status'        => 'pending',
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

        return back()->with('error', "Este material ya fue procesado con estado: " .
            ($material->status == 'approved' ? 'Aprobado' : 'Rechazado'));
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

        return redirect()->route('materials.scan')->with('success', 'Resultado de inspección guardado correctamente.');
    }

    public function validate(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'scanInput' => 'required|string|max:20'
            ], [
                'scanInput.required' => 'El campo de entrada de escaneo es obligatorio.',
                'scanInput.string'   => 'El campo de entrada de escaneo debe ser una cadena.',
                'scanInput.max'      => 'El campo de entrada de escaneo no puede tener más de 20 caracteres.',
            ]);

            $material = Material::with(['materialMovements' => function ($query) {
                $query->latest()->with(['user', 'area.department']);
            }])->where('barcode', $request->scanInput)->first();

            if (!$material) {
                return back()->with('error', 'Etiqueta no encontrada');
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
}

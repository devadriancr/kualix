<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Material;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function scan()
    {
        return view('materials.scan');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'scanInput' => 'required|string|max:20',
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
                'status'        => '
                ',
            ]);

            // Registrar entrada
            $material->materialMovements()->create([
                'area_id' => Auth::user()->area_id ?? null,
                'user_id' => Auth::id(),
                'type'    => 'entry',
            ]);

            return back()->with('success', "Material registrado: {$barcode}");
        }

        // Segundo escaneo (ya existe)
        if ($material->status === 'pending') {
            return redirect()->route('materials.inspect', $material->id);
        }

        return back()->with('success', "Este material ya fue procesado con estado: {$material->status}");
    }

    public function inspect(Material $material)
    {
        if ($material->status !== 'pending') {
            return redirect()->route('label-scan')->withErrors(['Este material ya fue procesado.']);
        }

        return view('materials.inspection', compact('material'));
    }

    public function storeInspection(Request $request, Material $material)
    {
        $validated = $request->validate([
            'status'   => 'required|in:good,bad',
            'comment'  => 'nullable|string|max:255',
        ]);

        $material->update([
            'status' => $validated['status'],
        ]);

        $material->materialMovements()->create([
            'user_id'  => auth()->id(),
            'area_id'  => auth()->user()->area_id,
            'type'     => $validated['status'] === 'good' ? 'exit' : 'rejection',
            'comment'  => $validated['comment'],
        ]);

        return redirect()->route('label-scan')->with('success', 'Resultado de inspección guardado correctamente.');
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\Venta;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
class FacturaController extends Controller
{
    public function index()
    {
        // Obtener todas las facturas junto con su venta y cliente asociados
        $facturas = Factura::with(['venta', 'cliente'])->get();
        // Obtener ventas que aún no tienen factura
        $ventas = Venta::doesntHave('factura')->with('cliente')->get();

        return view('facturas.index', compact('facturas', 'ventas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'venta_id' => 'required|exists:ventas,id',
            'ci_nit' => 'required|string',
            'monto_total' => 'required|numeric',
            'estado' => 'required|in:emitida,pagada,anulada',
        ]);

        // Calcular el IVA
        $montoSinIVA = $request->monto_total / 1.13;
        $iva = $request->monto_total - $montoSinIVA;

        // Obtener la venta y su cliente asociado
        $venta = Venta::find($request->venta_id);
        $clienteId = $venta->cliente_id;

        // Crear la factura
        Factura::create([
            'venta_id' => $request->venta_id,
            'cliente_id' => $clienteId,
            'ci_nit' => $request->ci_nit,
            'fecha_emision' => now(),
            'monto_total' => $request->monto_total,
            'iva' => $iva,
            'estado' => $request->estado,
        ]);

        return redirect()->route('facturas.index')->with('success', 'Factura creada exitosamente.');
    }

    public function update(Request $request, Factura $factura)
    {
        $request->validate([
            'ci_nit' => 'required|string',
            'monto_total' => 'required|numeric',
            'estado' => 'required|in:emitida,pagada,anulada',
        ]);

        // Calcular el IVA
        $montoSinIVA = $request->monto_total / 1.13;
        $iva = $request->monto_total - $montoSinIVA;

        // Actualizar la factura
        $factura->update([
            'ci_nit' => $request->ci_nit,
            'monto_total' => $request->monto_total,
            'iva' => $iva,
            'estado' => $request->estado,
        ]);

        return redirect()->route('facturas.index')->with('success', 'Factura actualizada exitosamente.');
    }

    public function destroy(Factura $factura)
    {
        $factura->delete();
        return redirect()->route('facturas.index')->with('success', 'Factura eliminada exitosamente.');
    }
    public function generarPDF(Factura $factura)
    {
        $pdf = Pdf::loadView('facturas.pdf', compact('factura'));
        return $pdf->download("Factura_{$factura->id}.pdf");
    }
}

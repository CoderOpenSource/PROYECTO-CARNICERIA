<?php

namespace App\Http\Controllers;

use App\Models\Caja;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CajaController extends Controller
{
    public function index()
    {
        $cajas = Caja::orderBy('fecha', 'desc')->get();

        return view('cajas.index', compact('cajas'));
    }
    public function abrir()
    {
        $caja = Caja::whereDate('fecha', Carbon::today())->first();

        if (!$caja || $caja->estado === 'cerrada') {
            Caja::create([
                'fecha' => Carbon::today(),
                'saldo_inicial' => 0,
                'estado' => 'abierta',
                'fecha_apertura' => now(),
            ]);
        }

        return redirect()->route('ventas.index')->with('success', 'Caja abierta correctamente.');
    }

    public function cerrar(Caja $caja)
    {
        if ($caja->estado === 'abierta') {
            $caja->update([
                'saldo_final' => $caja->saldo_inicial + $caja->total_entradas - $caja->total_salidas,
                'fecha_cierre' => now(),
                'estado' => 'cerrada',
            ]);
        }

        return redirect()->route('ventas.index')->with('success', 'Caja cerrada correctamente.');
    }
    public function actualizarMontoInicial(Request $request, Caja $caja)
    {
        $request->validate([
            'saldo_inicial' => 'required|numeric|min:0',
        ]);

        $caja->update([
            'saldo_inicial' => $request->saldo_inicial,
        ]);

        return redirect()->route('ventas.index')->with('success', 'Caja abierta con monto inicial actualizado.');
    }


}


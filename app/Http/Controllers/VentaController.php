<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\Pago;
use App\Models\Producto;
use App\Models\Caja;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Carbon;
class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        // Obtener la fecha seleccionada o usar la fecha de hoy por defecto
        $fecha = $request->input('fecha', Carbon::today()->toDateString());

        // Verificar si existe una caja para la fecha seleccionada
        $caja = Caja::whereDate('fecha', $fecha)->first();

        // Si no existe una caja para esa fecha y es hoy, crear una nueva caja
        if (!$caja && $fecha == Carbon::today()->toDateString()) {
            // Obtener el saldo final del día anterior como saldo inicial, si se requiere
            $saldoInicial = Caja::whereDate('fecha', Carbon::yesterday()->toDateString())
                ->value('saldo_final') ?? 0;

            $caja = Caja::create([
                'fecha' => Carbon::today(),
                'saldo_inicial' => $saldoInicial,
                'estado' => 'abierta',
                'fecha_apertura' => now(),
            ]);
        }

        // Verificar si el saldo inicial es 0 para mostrar el modal de apertura
        $mostrarModalApertura = $caja && $caja->saldo_inicial == 0;

        // Obtener todas las ventas asociadas a la caja seleccionada, si existe
        $ventas = $caja
            ? Venta::with(['detalles.producto', 'pago', 'cliente'])->where('caja_id', $caja->id)->get()
            : collect(); // Si no hay caja, retornar una colección vacía

        $productos = Producto::all(); // Obtener productos disponibles para el modal
        $clientes = Usuario::where('rol', 'cliente')->get(); // Obtener todos los clientes

        // Retornar la vista con las ventas, productos, clientes, caja y fecha seleccionada
        return view('ventas.index', compact('ventas', 'productos', 'clientes', 'caja', 'fecha', 'mostrarModalApertura'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (session('rol') !== 'administrador' && session('rol') !== 'empleado') {
            return redirect('/login')->withErrors(['No tienes acceso a esta área.']);
        }

        $request->validate([
            'cliente_id' => 'required|exists:usuarios,id',
            'total' => 'required|numeric',
            'productos' => 'required|array',
            'productos.*.producto_id' => 'required|exists:productos,id',
            'productos.*.peso_vendido' => 'required|numeric|min:0.01',
            'metodo_pago' => 'required|string',
            'imagen_pago' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        DB::transaction(function () use ($request) {
            // Obtener la caja abierta del día actual
            $caja = Caja::whereDate('fecha', Carbon::today())->where('estado', 'abierta')->firstOrFail();

            // Crear la venta y asociarla con la caja actual
            $venta = Venta::create([
                'total' => 0, // Inicialmente en 0, lo actualizaremos después
                'cliente_id' => $request->cliente_id,
                'fecha' => now(),
                'caja_id' => $caja->id, // Asociar la venta con el registro de caja
            ]);

            $totalVenta = 0;

            foreach ($request->productos as $productoData) {
                $productoInfo = Producto::find($productoData['producto_id']);
                $pesoVendido = $productoData['peso_vendido'];

                if ($productoInfo->peso_disponible < $pesoVendido) {
                    throw new \Exception("Stock insuficiente para el producto {$productoInfo->nombre}");
                }

                $precioVenta = $productoInfo->precio_por_unidad * $pesoVendido;
                $ganancia = ($productoInfo->precio_por_unidad - $productoInfo->precio_compra) * $pesoVendido;

                $productoInfo->peso_disponible -= $pesoVendido;
                $productoInfo->save();

                DetalleVenta::create([
                    'venta_id' => $venta->id,
                    'producto_id' => $productoInfo->id,
                    'peso_vendido' => $pesoVendido,
                    'precio_venta' => $precioVenta,
                    'ganancia' => $ganancia,
                ]);

                $totalVenta += $precioVenta;
            }

            // Actualizar el total de la venta
            $venta->update(['total' => $totalVenta]);

            // Actualizar total_entradas en la caja
            $caja->increment('total_entradas', $totalVenta);

            // Subir la imagen de pago si es necesario
            $imagenPagoUrl = null;
            if ($request->metodo_pago === 'QR' && $request->hasFile('imagen_pago')) {
                $uploadedFileUrl = Cloudinary::upload($request->file('imagen_pago')->getRealPath())->getSecurePath();
                $imagenPagoUrl = $uploadedFileUrl;
            }

            Pago::create([
                'venta_id' => $venta->id,
                'metodo_pago' => $request->metodo_pago,
                'imagen_pago' => $imagenPagoUrl,
                'monto' => $totalVenta,
            ]);
        });

        return redirect()->route('ventas.index')->with('success', 'Venta creada exitosamente.');
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Venta $venta)
    {
        $venta->load(['detalles', 'pago']);
        $productos = Producto::all();
        $clientes = Usuario::where('rol', 'cliente')->get();

        return view('ventas.edit', compact('venta', 'productos', 'clientes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Venta $venta)
    {
        $request->validate([
            'cliente_id' => 'required|exists:usuarios,id',
            'total' => 'required|numeric',
            'productos' => 'required|array',
            'productos.*.producto_id' => 'required|exists:productos,id',
            'productos.*.peso_vendido' => 'required|numeric|min:0.01',
            'metodo_pago' => 'required|string',
            'imagen_pago' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        DB::transaction(function () use ($request, $venta) {
            $caja = $venta->caja;

            // Restar el total anterior de la venta de total_entradas
            $caja->decrement('total_entradas', $venta->total);

            $venta->update(['total' => 0, 'cliente_id' => $request->cliente_id]);

            $nuevosProductosIds = collect($request->productos)->pluck('producto_id')->toArray();
            DetalleVenta::where('venta_id', $venta->id)
                ->whereNotIn('producto_id', $nuevosProductosIds)
                ->delete();

            $totalVenta = 0;

            foreach ($request->productos as $productoData) {
                $productoInfo = Producto::find($productoData['producto_id']);
                $pesoVendido = $productoData['peso_vendido'];

                $detalle = DetalleVenta::where('venta_id', $venta->id)
                    ->where('producto_id', $productoInfo->id)
                    ->first();

                if ($detalle) {
                    $productoInfo->peso_disponible += $detalle->peso_vendido;
                    $productoInfo->save();

                    $precioVenta = $productoInfo->precio_por_unidad * $pesoVendido;
                    $ganancia = ($productoInfo->precio_por_unidad - $productoInfo->precio_compra) * $pesoVendido;

                    $detalle->update([
                        'peso_vendido' => $pesoVendido,
                        'precio_venta' => $precioVenta,
                        'ganancia' => $ganancia,
                    ]);
                } else {
                    if ($productoInfo->peso_disponible < $pesoVendido) {
                        throw new \Exception("Stock insuficiente para el producto {$productoInfo->nombre}");
                    }

                    $precioVenta = $productoInfo->precio_por_unidad * $pesoVendido;
                    $ganancia = ($productoInfo->precio_por_unidad - $productoInfo->precio_compra) * $pesoVendido;

                    DetalleVenta::create([
                        'venta_id' => $venta->id,
                        'producto_id' => $productoInfo->id,
                        'peso_vendido' => $pesoVendido,
                        'precio_venta' => $precioVenta,
                        'ganancia' => $ganancia,
                    ]);
                }

                $productoInfo->peso_disponible -= $pesoVendido;
                $productoInfo->save();

                $totalVenta += $precioVenta;
            }

            // Actualizar el total de la venta con el nuevo total
            $venta->update(['total' => $totalVenta]);

            // Sumar el nuevo total de la venta a total_entradas en la caja
            $caja->increment('total_entradas', $totalVenta);

            $imagenPagoUrl = $venta->pago->imagen_pago;
            if ($request->metodo_pago === 'QR' && $request->hasFile('imagen_pago')) {
                $uploadedFileUrl = Cloudinary::upload($request->file('imagen_pago')->getRealPath())->getSecurePath();
                $imagenPagoUrl = $uploadedFileUrl;
            }

            $venta->pago->update([
                'metodo_pago' => $request->metodo_pago,
                'monto' => $totalVenta,
                'imagen_pago' => $imagenPagoUrl,
            ]);
        });

        return redirect()->route('ventas.index')->with('success', 'Venta actualizada exitosamente.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Venta $venta)
    {
        $caja = $venta->caja;

        // Restar el total de la venta de total_entradas en la caja
        $caja->decrement('total_entradas', $venta->total);

        $venta->detalles()->delete();
        $venta->pago()->delete();
        $venta->delete();

        return redirect()->route('ventas.index')->with('success', 'Venta eliminada exitosamente.');
    }

}

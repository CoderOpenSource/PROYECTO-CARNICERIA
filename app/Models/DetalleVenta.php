<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    protected $table = 'detalle_ventas';

    protected $fillable = [
        'venta_id',
        'producto_id',
        'peso_vendido', // Cambiado a peso vendido
        'precio_venta',
        'ganancia',
    ];

    // Relación con Venta
    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }

    // Relación con Producto
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    /**
     * Calcula el precio de venta en base al peso vendido.
     */
    public function calcularPrecioVenta()
    {
        $producto = $this->producto;
        $this->precio_venta = $producto->precio_por_unidad * $this->peso_vendido;
    }

    /**
     * Calcula la ganancia en base al peso vendido y el precio de compra.
     */
    public function calcularGanancia()
    {
        $producto = $this->producto;
        $this->ganancia = ($producto->precio_por_unidad - $producto->precio_compra) * $this->peso_vendido;
    }
}

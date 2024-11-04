<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;

    protected $fillable = [
        'venta_id',
        'cliente_id',
        'ci_nit',
        'fecha_emision',
        'monto_total',
        'iva',
        'estado',
    ];

    /**
     * Relación con la clase Venta.
     * Una factura pertenece a una venta.
     */
    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }

    /**
     * Relación con la clase Usuario (Cliente).
     * Una factura pertenece a un cliente.
     */
    public function cliente()
    {
        return $this->belongsTo(Usuario::class, 'cliente_id');
    }
}

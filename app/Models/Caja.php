<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    use HasFactory;

    protected $table = 'caja';

    protected $fillable = [
        'fecha',
        'saldo_inicial',
        'saldo_final',
        'estado',
        'fecha_apertura',
        'fecha_cierre',
        'total_entradas',
        'total_salidas',
    ];
    protected $casts = [
        'fecha' => 'date',
        'fecha_apertura' => 'datetime',
        'fecha_cierre' => 'datetime',
    ];

    // Aquí puedes definir relaciones con otros modelos, como ventas
}

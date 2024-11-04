<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    // Definimos la tabla relacionada con el modelo
    protected $table = 'usuarios';

    // Permitimos la asignación masiva de estos atributos
    protected $fillable = [
        'nombre',
        'email',
        'password',
        'telefono', // Añadido el campo telefono
        'rol',
    ];

    /**
     * Relación de Usuario con Facturas.
     * Un cliente puede tener muchas facturas.
     */
    public function facturas()
    {
        return $this->hasMany(Factura::class, 'cliente_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriaProducto extends Model
{
    // Definimos la tabla relacionada con el modelo
    protected $table = 'categoria_productos';

    // Permitimos la asignación masiva de estos atributos
    protected $fillable = [
        'nombre',
    ];
}

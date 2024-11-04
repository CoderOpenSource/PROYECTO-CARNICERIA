<?php

// App\Models\Producto.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio_compra',
        'precio_por_unidad',
        'peso_disponible',
        'unidad_medida',
        'foto_url',
        'categoria_id',
        'proveedor_id', // Agregado proveedor_id aquí
    ];

    public function categoria()
    {
        return $this->belongsTo(CategoriaProducto::class, 'categoria_id');
    }

    public function proveedor()
    {
        return $this->belongsTo(Usuario::class, 'proveedor_id')->where('rol', 'proveedor');
    }
}

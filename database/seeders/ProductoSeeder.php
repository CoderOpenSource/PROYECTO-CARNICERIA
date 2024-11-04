<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Producto;

class ProductoSeeder extends Seeder
{
    public function run()
    {
        $productos = [
            ['nombre' => 'Carne de Res', 'descripcion' => 'Carne de res fresca', 'precio_compra' => 100, 'precio_por_unidad' => 120, 'peso_disponible' => 50, 'unidad_medida' => 'kg', 'foto_url' => 'https://res.cloudinary.com/dkpuiyovk/image/upload/v1730415729/mg3kxzvgrkczwop0fl7d.png', 'categoria_id' => 1, 'proveedor_id' => 6],
            ['nombre' => 'Costilla de Cerdo', 'descripcion' => 'Costillas de cerdo frescas', 'precio_compra' => 90, 'precio_por_unidad' => 110, 'peso_disponible' => 30, 'unidad_medida' => 'kg', 'foto_url' => 'imagen2.jpg', 'categoria_id' => 2, 'proveedor_id' => 7],
            ['nombre' => 'Pechuga de Pollo', 'descripcion' => 'Pechuga sin hueso', 'precio_compra' => 70, 'precio_por_unidad' => 85, 'peso_disponible' => 40, 'unidad_medida' => 'kg', 'foto_url' => 'imagen3.jpg', 'categoria_id' => 3, 'proveedor_id' => 8],
            ['nombre' => 'Pierna de Cordero', 'descripcion' => 'Pierna de cordero', 'precio_compra' => 130, 'precio_por_unidad' => 150, 'peso_disponible' => 20, 'unidad_medida' => 'kg', 'foto_url' => 'imagen4.jpg', 'categoria_id' => 4, 'proveedor_id' => 9],
            ['nombre' => 'Filete de Pescado', 'descripcion' => 'Filetes frescos', 'precio_compra' => 60, 'precio_por_unidad' => 80, 'peso_disponible' => 25, 'unidad_medida' => 'kg', 'foto_url' => 'imagen5.jpg', 'categoria_id' => 5, 'proveedor_id' => 10],
            ['nombre' => 'Hígado de Res', 'descripcion' => 'Hígado de res fresco', 'precio_compra' => 50, 'precio_por_unidad' => 65, 'peso_disponible' => 15, 'unidad_medida' => 'kg', 'foto_url' => 'imagen6.jpg', 'categoria_id' => 1, 'proveedor_id' => 6],
            ['nombre' => 'Chorizo de Cerdo', 'descripcion' => 'Chorizo artesanal', 'precio_compra' => 75, 'precio_por_unidad' => 90, 'peso_disponible' => 35, 'unidad_medida' => 'kg', 'foto_url' => 'imagen7.jpg', 'categoria_id' => 2, 'proveedor_id' => 7],
            ['nombre' => 'Muslo de Pollo', 'descripcion' => 'Muslo con piel', 'precio_compra' => 60, 'precio_por_unidad' => 75, 'peso_disponible' => 25, 'unidad_medida' => 'kg', 'foto_url' => 'imagen8.jpg', 'categoria_id' => 3, 'proveedor_id' => 8],
            ['nombre' => 'Costillar de Cordero', 'descripcion' => 'Costillar de cordero', 'precio_compra' => 140, 'precio_por_unidad' => 160, 'peso_disponible' => 10, 'unidad_medida' => 'kg', 'foto_url' => 'imagen9.jpg', 'categoria_id' => 4, 'proveedor_id' => 9],
            ['nombre' => 'Pescado Entero', 'descripcion' => 'Pescado fresco entero', 'precio_compra' => 55, 'precio_por_unidad' => 70, 'peso_disponible' => 20, 'unidad_medida' => 'kg', 'foto_url' => 'imagen10.jpg', 'categoria_id' => 5, 'proveedor_id' => 10],
        ];

        Producto::insert($productos);
    }
}

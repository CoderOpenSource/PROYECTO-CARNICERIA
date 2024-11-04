<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CategoriaProducto;

class CategoriaProductoSeeder extends Seeder
{
    public function run()
    {
        $categorias = [
            ['nombre' => 'Res'],
            ['nombre' => 'Cerdo'],
            ['nombre' => 'Pollo'],
            ['nombre' => 'Cordero'],
            ['nombre' => 'Pescado'],
        ];

        CategoriaProducto::insert($categorias);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear un usuario administrador
        Usuario::create([
            'nombre' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin12345'), // Hasheando la contraseña
            'rol' => 'administrador',
        ]);
        // Crear 5 clientes
        $clientes = [
            ['nombre' => 'Cliente 1', 'email' => 'cliente1@example.com', 'telefono' => '1234567890', 'rol' => 'cliente'],
            ['nombre' => 'Cliente 2', 'email' => 'cliente2@example.com', 'telefono' => '1234567891', 'rol' => 'cliente'],
            ['nombre' => 'Cliente 3', 'email' => 'cliente3@example.com', 'telefono' => '1234567892', 'rol' => 'cliente'],
            ['nombre' => 'Cliente 4', 'email' => 'cliente4@example.com', 'telefono' => '1234567893', 'rol' => 'cliente'],
            ['nombre' => 'Cliente 5', 'email' => 'cliente5@example.com', 'telefono' => '1234567894', 'rol' => 'cliente'],
        ];

        // Crear 5 proveedores
        $proveedores = [
            ['nombre' => 'Proveedor 1', 'email' => 'proveedor1@example.com', 'telefono' => '2234567890', 'rol' => 'proveedor'],
            ['nombre' => 'Proveedor 2', 'email' => 'proveedor2@example.com', 'telefono' => '2234567891', 'rol' => 'proveedor'],
            ['nombre' => 'Proveedor 3', 'email' => 'proveedor3@example.com', 'telefono' => '2234567892', 'rol' => 'proveedor'],
            ['nombre' => 'Proveedor 4', 'email' => 'proveedor4@example.com', 'telefono' => '2234567893', 'rol' => 'proveedor'],
            ['nombre' => 'Proveedor 5', 'email' => 'proveedor5@example.com', 'telefono' => '2234567894', 'rol' => 'proveedor'],
        ];

        Usuario::insert(array_merge($clientes, $proveedores));
    }
}

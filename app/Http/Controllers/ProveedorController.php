<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProveedorController extends Controller
{
    public function index()
    {
        // Verificar si el usuario tiene el rol de administrador
        if (session('rol') !== 'administrador') {
            return redirect('/login')->withErrors(['No tienes acceso a esta área.']);
        }

        // Obtener solo los usuarios con el rol 'proveedores'
        $proveedores = Usuario::where('rol', 'proveedor')->get();

        return view('proveedores.index', compact('proveedores'));
    }

    public function store(Request $request)
    {
        // Verificar si el usuario tiene el rol de administrador
        if (session('rol') !== 'administrador') {
            return redirect('/login')->withErrors(['No tienes acceso a esta área.']);
        }

        // Validar los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email',
            'telefono' => 'required|string|max:15', // Validar que el teléfono sea requerido
        ]);

        // Crear el usuario con la contraseña hasheada
        Usuario::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'telefono' => $request->telefono, // Guardar el teléfono
            'rol' => 'proveedor', // Asignar rol de proveedores
        ]);

        return redirect()->route('proveedores.index')->with('success', 'Proveedor creado exitosamente.');
    }

    public function update(Request $request, Usuario $usuario)
    {
        // Verificar si el usuario tiene el rol de administrador
        if (session('rol') !== 'administrador') {
            return redirect('/login')->withErrors(['No tienes acceso a esta área.']);
        }

        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email,' . $usuario->id,
            'telefono' => 'required|string|max:15', // Validar que el teléfono sea requerido
        ]);

        $usuario->update([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'telefono' => $request->telefono, // Actualizar el teléfono
        ]);

        return redirect()->route('proveedores.index')->with('success', 'Proveedor actualizado exitosamente.');
    }

    public function destroy(Usuario $usuario)
    {
        // Verificar si el usuario tiene el rol de administrador
        if (session('rol') !== 'administrador') {
            return redirect('/login')->withErrors(['No tienes acceso a esta área.']);
        }

        $usuario->delete();

        return redirect()->route('proveedores.index')->with('success', 'Proveedor eliminado exitosamente.');
    }
}

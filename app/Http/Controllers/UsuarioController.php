<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index()
    {
        // Verificar si el usuario tiene el rol de administrador
        if (session('rol') !== 'administrador') {
            return redirect('/login')->withErrors(['No tienes acceso a esta área.']);
        }

        // Obtener solo los usuarios con el rol 'empleado'
        $empleados = Usuario::where('rol', 'empleado')->get();

        return view('clientes.index', compact('empleados'));
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
            'password' => 'required|string|min:6',
        ]);

        // Crear el usuario con la contraseña hasheada
        Usuario::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hasheando la contraseña
            'rol' => 'empleado',
        ]);

        return redirect()->route('clientes.index')->with('success', 'Empleado creado exitosamente.');
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
        ]);

        $usuario->update([
            'nombre' => $request->nombre,
            'email' => $request->email,
        ]);

        return redirect()->route('clientes.index')->with('success', 'Empleado actualizado exitosamente.');
    }

    public function destroy(Usuario $usuario)
    {
        // Verificar si el usuario tiene el rol de administrador
        if (session('rol') !== 'administrador') {
            return redirect('/login')->withErrors(['No tienes acceso a esta área.']);
        }

        $usuario->delete();

        return redirect()->route('clientes.index')->with('success', 'Empleado eliminado exitosamente.');
    }
}

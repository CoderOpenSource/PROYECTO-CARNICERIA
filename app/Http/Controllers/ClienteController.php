<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index()
    {
        // Verificar si el usuario tiene el rol de administrador
        if (session('rol') !== 'administrador') {
            return redirect('/login')->withErrors(['No tienes acceso a esta área.']);
        }

        // Obtener solo los usuarios con el rol 'cliente'
        $clientes = Usuario::where('rol', 'cliente')->get();

        return view('clientes.index', compact('clientes'));
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
            'email' => 'nullable|email|unique:usuarios,email', // Email no es requerido
            'telefono' => 'nullable|string|max:15', // Teléfono no es requerido
        ]);

        // Crear el usuario
        Usuario::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'telefono' => $request->telefono, // Guardar el teléfono
            'rol' => 'cliente',
        ]);

        return redirect()->route('clientes.index')->with('success', 'Cliente creado exitosamente.');
    }

    public function update(Request $request, Usuario $usuario)
    {
        // Verificar si el usuario tiene el rol de administrador
        if (session('rol') !== 'administrador') {
            return redirect('/login')->withErrors(['No tienes acceso a esta área.']);
        }

        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'nullable|email|unique:usuarios,email,' . $usuario->id, // Email no es requerido
            'telefono' => 'nullable|string|max:15', // Teléfono no es requerido
        ]);

        $usuario->update([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'telefono' => $request->telefono, // Actualizar el teléfono
        ]);

        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado exitosamente.');
    }

    public function destroy(Usuario $usuario)
    {
        // Verificar si el usuario tiene el rol de administrador
        if (session('rol') !== 'administrador') {
            return redirect('/login')->withErrors(['No tienes acceso a esta área.']);
        }

        $usuario->delete();

        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado exitosamente.');
    }
}

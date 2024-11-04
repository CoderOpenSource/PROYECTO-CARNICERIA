<?php

namespace App\Http\Controllers;

use App\Models\CategoriaProducto;
use Illuminate\Http\Request;

class CategoriaProductoController extends Controller
{
    public function index()
    {
        // Verificar si el usuario tiene el rol de administrador
        if (session('rol') !== 'administrador') {
            return redirect('/login')->withErrors(['No tienes acceso a esta área.']);
        }

        // Obtener todas las categorías de productos
        $categorias = CategoriaProducto::all();

        return view('categorias.index', compact('categorias'));
    }

    public function store(Request $request)
    {
        // Verificar si el usuario tiene el rol de administrador
        if (session('rol') !== 'administrador') {
            return redirect('/login')->withErrors(['No tienes acceso a esta área.']);
        }

        $request->validate([
            'nombre' => 'required|string|max:255|unique:categoria_productos,nombre',
        ]);

        CategoriaProducto::create([
            'nombre' => $request->nombre,
        ]);

        return redirect()->route('categorias.index')->with('success', 'Categoría creada exitosamente.');
    }

    public function update(Request $request, CategoriaProducto $categoria)
    {
        // Verificar si el usuario tiene el rol de administrador
        if (session('rol') !== 'administrador') {
            return redirect('/login')->withErrors(['No tienes acceso a esta área.']);
        }

        $request->validate([
            'nombre' => 'required|string|max:255|unique:categoria_productos,nombre,' . $categoria->id,
        ]);

        $categoria->update([
            'nombre' => $request->nombre,
        ]);

        return redirect()->route('categorias.index')->with('success', 'Categoría actualizada exitosamente.');
    }

    public function destroy(CategoriaProducto $categoria)
    {
        // Verificar si el usuario tiene el rol de administrador
        if (session('rol') !== 'administrador') {
            return redirect('/login')->withErrors(['No tienes acceso a esta área.']);
        }

        $categoria->delete();

        return redirect()->route('categorias.index')->with('success', 'Categoría eliminada exitosamente.');
    }
}

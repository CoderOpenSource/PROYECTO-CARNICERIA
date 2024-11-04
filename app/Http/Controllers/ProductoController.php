<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\CategoriaProducto;
use App\Models\Usuario;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ProductoController extends Controller
{
    public function index()
    {
        if (session('rol') !== 'administrador' && session('rol') !== 'empleado') {
            return redirect('/login')->withErrors(['No tienes acceso a esta área.']);
        }

        $productos = Producto::with('categoria', 'proveedor')->get();
        $categorias = CategoriaProducto::all();
        $proveedores = Usuario::where('rol', 'proveedor')->get();

        return view('productos.index', compact('productos', 'categorias', 'proveedores'));
    }

    public function store(Request $request)
    {
        if (session('rol') !== 'administrador') {
            return redirect('/login')->withErrors(['No tienes acceso a esta área.']);
        }

        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio_compra' => 'required|numeric',
            'precio_por_unidad' => 'required|numeric', // Precio por unidad de peso
            'peso_disponible' => 'required|numeric|min:0.01', // Peso disponible en inventario
            'unidad_medida' => 'required|string|max:10', // Unidad de medida (kg, g, etc.)
            'foto_url' => 'nullable',
            'categoria_id' => 'required|exists:categoria_productos,id',
            'proveedor_id' => 'required|exists:usuarios,id', // Validar que el proveedor exista
        ]);

        $fotoUrl = null;
        if ($request->hasFile('foto_url')) {
            $uploadedFileUrl = Cloudinary::upload($request->file('foto_url')->getRealPath())->getSecurePath();
            $fotoUrl = $uploadedFileUrl;
        }

        Producto::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio_compra' => $request->precio_compra,
            'precio_por_unidad' => $request->precio_por_unidad,
            'peso_disponible' => $request->peso_disponible,
            'unidad_medida' => $request->unidad_medida,
            'foto_url' => $fotoUrl,
            'categoria_id' => $request->categoria_id,
            'proveedor_id' => $request->proveedor_id, // Guardar el proveedor
        ]);

        return redirect()->route('productos.index')->with('success', 'Producto creado exitosamente.');
    }

    public function update(Request $request, Producto $producto)
    {
        if (session('rol') !== 'administrador') {
            return redirect('/login')->withErrors(['No tienes acceso a esta área.']);
        }

        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio_compra' => 'required|numeric',
            'precio_por_unidad' => 'required|numeric', // Precio por unidad de peso
            'peso_disponible' => 'required|numeric|min:0.01', // Peso disponible en inventario
            'unidad_medida' => 'required|string|max:10',
            'foto_url' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'categoria_id' => 'required|exists:categoria_productos,id',
            'proveedor_id' => 'required|exists:usuarios,id', // Validar proveedor
        ]);

        if ($request->hasFile('foto_url')) {
            $uploadedFileUrl = Cloudinary::upload($request->file('foto_url')->getRealPath())->getSecurePath();
            $producto->foto_url = $uploadedFileUrl;
        }

        $producto->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio_compra' => $request->precio_compra,
            'precio_por_unidad' => $request->precio_por_unidad,
            'peso_disponible' => $request->peso_disponible,
            'unidad_medida' => $request->unidad_medida,
            'categoria_id' => $request->categoria_id,
            'proveedor_id' => $request->proveedor_id, // Actualizar proveedor
        ]);

        return redirect()->route('productos.index')->with('success', 'Producto actualizado exitosamente.');
    }

    public function destroy(Producto $producto)
    {
        if (session('rol') !== 'administrador') {
            return redirect('/login')->withErrors(['No tienes acceso a esta área.']);
        }

        $producto->delete();

        return redirect()->route('productos.index')->with('success', 'Producto eliminado exitosamente.');
    }
}

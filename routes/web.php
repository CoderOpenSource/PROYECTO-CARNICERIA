<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
Use App\Http\Controllers\CategoriaProductoController;
Use App\Http\Controllers\ProductoController;
Use App\Http\Controllers\VentaController;
Use App\Http\Controllers\FacturaController;
use App\Http\Controllers\CajaController;


Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->name('dashboard');

Route::get('/tables', function () {
    return view('pages.table');
})->name('tables');
Route::get('/typography', function () {
    return view('pages.typography');
})->name('typography');

Route::get('/clientes', [App\Http\Controllers\ClienteController::class, 'index'])->name('clientes.index');
Route::post('/clientes', [App\Http\Controllers\ClienteController::class, 'store'])->name('clientes.store');
Route::put('/clientes/{usuario}', [App\Http\Controllers\ClienteController::class, 'update'])->name('clientes.update');
Route::delete('/clientes/{usuario}', [App\Http\Controllers\ClienteController::class, 'destroy'])->name('clientes.destroy');

Route::get('/proveedores', [App\Http\Controllers\ProveedorController::class, 'index'])->name('proveedores.index');
Route::post('/proveedores', [App\Http\Controllers\ProveedorController::class, 'store'])->name('proveedores.store');
Route::put('/proveedores/{usuario}', [App\Http\Controllers\ProveedorController::class, 'update'])->name('proveedores.update');
Route::delete('/proveedores/{usuario}', [App\Http\Controllers\ProveedorController::class, 'destroy'])->name('proveedores.destroy');


Route::get('/categorias', [CategoriaProductoController::class, 'index'])->name('categorias.index');
Route::post('/categorias', [CategoriaProductoController::class, 'store'])->name('categorias.store');
Route::put('/categorias/{categoria}', [CategoriaProductoController::class, 'update'])->name('categorias.update');
Route::delete('/categorias/{categoria}', [CategoriaProductoController::class, 'destroy'])->name('categorias.destroy');

// Rutas para productos
Route::get('/productos', [ProductoController::class, 'index'])->name('productos.index');
Route::post('/productos', [ProductoController::class, 'store'])->name('productos.store');
Route::put('/productos/{producto}', [ProductoController::class, 'update'])->name('productos.update');
Route::delete('/productos/{producto}', [ProductoController::class, 'destroy'])->name('productos.destroy');

// Rutas para ventas
Route::get('/ventas', [VentaController::class, 'index'])->name('ventas.index');
Route::get('/ventas/create', [VentaController::class, 'create'])->name('ventas.create');
Route::post('/ventas', [VentaController::class, 'store'])->name('ventas.store');
Route::get('/ventas/{venta}/edit', [VentaController::class, 'edit'])->name('ventas.edit');
Route::put('/ventas/{venta}', [VentaController::class, 'update'])->name('ventas.update');
Route::delete('/ventas/{venta}', [VentaController::class, 'destroy'])->name('ventas.destroy');

// Rutas para facturas
Route::get('/facturas', [FacturaController::class, 'index'])->name('facturas.index');
Route::post('/facturas', [FacturaController::class, 'store'])->name('facturas.store');
Route::put('/facturas/{factura}', [FacturaController::class, 'update'])->name('facturas.update');
Route::delete('/facturas/{factura}', [FacturaController::class, 'destroy'])->name('facturas.destroy');
Route::get('/facturas/{factura}/pdf', [FacturaController::class, 'generarPDF'])->name('facturas.pdf');


Route::post('/caja/abrir', [CajaController::class, 'abrirCaja']);
Route::post('/caja/{caja}/cerrar', [CajaController::class, 'cerrar'])->name('caja.cerrar');
Route::get('/caja/estado', [CajaController::class, 'estadoCaja']);
Route::put('/caja/{caja}/actualizar-monto-inicial', [CajaController::class, 'actualizarMontoInicial'])->name('caja.actualizarMontoInicial');
Route::get('/cajas', [CajaController::class, 'index'])->name('cajas.index');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::post('/logout', function () {
    return redirect('/login'); // Redirige a la página de login después de cerrar la sesión
})->name('logout');
Route::get('/register', function () {
    return view('dashboard');
})->name('register');

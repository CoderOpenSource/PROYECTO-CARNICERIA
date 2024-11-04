@extends('layouts.app')

@section('title', 'Dashboard Control de Ventas')
@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-lg rounded">
                    <div class="card-header text-center">
                        <h1 class="display-4 text-dark">Proyecto de Control de Ventas y Facturación</h1>
                        <p class="lead text-dark">Producto del Bachiller Técnico Humanístico representado al Colegio Juancito Pinto</p>
                    </div>
                    <div class="card-body">
                        <div class="row row-cols-3">
                            <!-- Tarjeta para Nueva Categoría -->
                            <div class="col mb-4">
                                <a href="{{ route('categorias.index') }}" class="text-decoration-none">
                                    <div class="card h-100 text-center shadow-sm">
                                        <div class="card-body">
                                            <h5 class="card-title">Categoría de Productos</h5>
                                            <img src="{{ asset('assets/img/categorias.png') }}" alt="Nueva Categoría" class="img-fluid mb-3" style="width: 120px; height: 120px;">
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <!-- Tarjeta para Nuevo Proveedor -->
                            <div class="col mb-4">
                                <a href="{{ route('proveedores.index') }}" class="text-decoration-none">
                                    <div class="card h-100 text-center shadow-sm">
                                        <div class="card-body">
                                            <h5 class="card-title">Proveedor</h5>
                                            <img src="{{ asset('assets/img/proveedor.png') }}" alt="Nuevo Proveedor" class="img-fluid mb-3" style="width: 120px; height: 120px;">
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <!-- Tarjeta para Cliente -->
                            <div class="col mb-4">
                                <a href="{{ route('clientes.index') }}" class="text-decoration-none">
                                    <div class="card h-100 text-center shadow-sm">
                                        <div class="card-body">
                                            <h5 class="card-title">Cliente</h5>
                                            <img src="{{ asset('assets/img/cliente.png') }}" alt="Cliente" class="img-fluid mb-3" style="width: 120px; height: 120px;">
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <!-- Tarjeta para Productos -->
                            <div class="col mb-4">
                                <a href="{{ route('productos.index') }}" class="text-decoration-none">
                                    <div class="card h-100 text-center shadow-sm">
                                        <div class="card-body">
                                            <h5 class="card-title">Productos</h5>
                                            <img src="{{ asset('assets/img/carnes.png') }}" alt="Productos" class="img-fluid mb-3" style="width: 120px; height: 120px;">
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <!-- Tarjeta para Ventas de los Productos -->
                            <div class="col mb-4">
                                <a href="{{ route('ventas.index') }}" class="text-decoration-none">
                                    <div class="card h-100 text-center shadow-sm">
                                        <div class="card-body">
                                            <h5 class="card-title">Ventas de los Productos</h5>
                                            <img src="{{ asset('assets/img/ventas.png') }}" alt="Ventas de los Productos" class="img-fluid mb-3" style="width: 120px; height: 120px;">
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <!-- Tarjeta para Facturas -->
                            <div class="col mb-4">
                                <a href="{{ route('facturas.index') }}" class="text-decoration-none">
                                    <div class="card h-100 text-center shadow-sm">
                                        <div class="card-body">
                                            <h5 class="card-title">Facturas</h5>
                                            <img src="{{ asset('assets/img/facturas.png') }}" alt="Facturas" class="img-fluid mb-3" style="width: 120px; height: 120px;">
                                        </div>
                                    </div>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

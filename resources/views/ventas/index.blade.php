@extends('layouts.app')

@section('title', 'Ventas')

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <!-- Formulario para seleccionar la fecha -->
                    <form method="GET" action="{{ route('ventas.index') }}" class="mb-3 d-flex align-items-center">
                        <label for="fecha" class="mr-2">Seleccione la fecha:</label>
                        <input type="date" name="fecha" id="fecha" value="{{ $fecha }}" class="form-control mr-2" style="width: auto;">
                        <button type="submit" class="btn btn-primary btn-sm mr-2">Filtrar</button>
                    </form>

                    <!-- Información de la Caja -->
                    @if($caja)
                        <div class="card mb-4">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="mb-0">Información de la Caja</h4>
                                @if($caja->estado === 'abierta')
                                    <form action="{{ route('caja.cerrar', $caja->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">Cerrar Caja</button>
                                    </form>
                                @endif
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Fecha de Caja</th>
                                        <td>{{ $caja->fecha }}</td>
                                        <th>Saldo Inicial</th>
                                        <td>${{ number_format($caja->saldo_inicial, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Total Entradas</th>
                                        <td>${{ number_format($caja->total_entradas, 2) }}</td>
                                        <th>Estado de la Caja</th>
                                        <td>{{ ucfirst($caja->estado) }}</td>
                                    </tr>
                                    @if($caja->estado === 'cerrada')
                                        <tr>
                                            <th>Saldo Final</th>
                                            <td>${{ number_format($caja->saldo_final, 2) }}</td>
                                            <th>Fecha de Cierre</th>
                                            <td>{{ $caja->fecha_cierre ? $caja->fecha_cierre->format('d/m/Y H:i') : 'N/A' }}</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <th>Fecha de Apertura</th>
                                        <td>{{ $caja->fecha_apertura ? $caja->fecha_apertura->format('d/m/Y H:i') : 'N/A' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    @endif

                    <!-- Tabla de Ventas -->
                    <div class="card data-tables">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="mb-0">Ventas</h3>
                            @if($caja && $caja->estado === 'abierta')
                                <!-- Mostrar el botón de "Añadir Venta" solo si la caja está abierta -->
                                <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#crearVentaModal">
                                    Añadir Venta
                                </button>
                            @endif
                        </div>
                        <div class="card-body table-full-width table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                <tr>
                                    <th>Cliente</th>
                                    <th>Fecha</th>
                                    <th>Total</th>
                                    <th>Productos</th>
                                    <th>Pago</th>
                                    <th>Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($ventas as $venta)
                                    <tr>
                                        <td>{{ $venta->cliente->nombre ?? 'No especificado' }}</td>
                                        <td>{{ $venta->fecha }}</td>
                                        <td>{{ $venta->total }}</td>
                                        <td>
                                            <ul>
                                                @foreach($venta->detalles as $detalle)
                                                    <li>{{ $detalle->producto->nombre }} ({{ $detalle->peso_vendido }} {{ $detalle->producto->unidad_medida }})</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>
                                            <p>Método: {{ $venta->pago->metodo_pago }}</p>
                                            <p>Monto: {{ $venta->pago->monto }}</p>
                                            @if($venta->pago->imagen_pago)
                                                <img src="{{ $venta->pago->imagen_pago }}" alt="Imagen Pago" style="width: 100px;">
                                            @endif
                                        </td>
                                        <td>
                                            @if(session('rol') === 'administrador')
                                                <a href="#" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editarVentaModal{{ $venta->id }}">Editar</a>
                                                <form action="{{ route('ventas.destroy', $venta->id) }}" method="POST" style="display:inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>

                                    @include('ventas.partials.editar_venta_modal', [
                                        'venta' => $venta,
                                        'productos' => $productos,
                                        'clientes' => $clientes,
                                        'action' => route('ventas.update', $venta->id)
                                    ])
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No hay ventas para la fecha seleccionada.</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($caja && $caja->estado === 'abierta')
            <!-- Modal para crear venta solo se carga si la caja está abierta -->
            @include('ventas.partials.crear_venta_modal', [
                'productos' => $productos,
                'clientes' => $clientes,
                'action' => route('ventas.store')
            ])
        @endif

        @if($mostrarModalApertura)
            <div class="modal fade" id="abrirCajaModal" tabindex="-1" role="dialog" aria-labelledby="abrirCajaModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form action="{{ route('caja.actualizarMontoInicial', $caja->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-header">
                                <h5 class="modal-title" id="abrirCajaModalLabel">Abrir Caja</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="saldo_inicial">Monto Inicial</label>
                                    <input type="number" name="saldo_inicial" id="saldo_inicial" class="form-control" min="0" step="0.01" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <script>
                $(document).ready(function() {
                    $('#abrirCajaModal').modal('show');
                });
            </script>
        @endif
    </div>
@endsection

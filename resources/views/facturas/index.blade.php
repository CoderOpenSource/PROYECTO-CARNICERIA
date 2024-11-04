@extends('layouts.app')

@section('title', 'Gestión de Facturas')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

                    <!-- Alerta de éxito -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>¡Éxito!</strong> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Alerta de errores -->
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error:</strong>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <div class="card data-tables">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h3 class="mb-0">Facturas</h3>
                                    <p class="text-sm mb-0">Listado de todas las facturas emitidas.</p>
                                </div>
                                @if(session('rol') === 'administrador')
                                    <div class="col-4 text-right">
                                        <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#crearFacturaModal">Crear Factura</button>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="card-body table-full-width table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                <tr>
                                    <th>Venta Asociada</th>
                                    <th>Cliente</th>
                                    <th>CI/NIT</th>
                                    <th>Fecha de Emisión</th>
                                    <th>Monto Total</th>
                                    <th>IVA</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($facturas as $factura)
                                    <tr>
                                        <td>Venta #{{ $factura->venta->id }}</td>
                                        <td>{{ $factura->cliente->nombre }}</td>
                                        <td>{{ $factura->ci_nit }}</td>
                                        <td>{{ $factura->fecha_emision }}</td>
                                        <td>{{ $factura->monto_total }}</td>
                                        <td>{{ $factura->iva }}</td>
                                        <td>{{ ucfirst($factura->estado) }}</td>
                                        <td class="d-flex justify-content-end">
                                            @if(session('rol') === 'administrador')
                                                <a href="{{ route('facturas.pdf', $factura->id) }}" class="btn btn-secondary btn-sm mr-2" title="Generar PDF">
                                                    <i class="fas fa-file-pdf"></i>
                                                </a>
                                                <a href="#" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editarFacturaModal{{ $factura->id }}">Editar</a>
                                                <form action="{{ route('facturas.destroy', $factura->id) }}" method="POST" style="display:inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>

                                    <!-- Modal para Editar Factura -->
                                    <div class="modal fade" id="editarFacturaModal{{ $factura->id }}" tabindex="-1" role="dialog" aria-labelledby="editarFacturaLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editarFacturaLabel">Editar Factura #{{ $factura->id }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('facturas.update', $factura->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="ci_nit">CI/NIT</label>
                                                            <input type="text" class="form-control" name="ci_nit" value="{{ $factura->ci_nit }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="monto_total">Monto Total</label>
                                                            <input type="number" step="0.01" class="form-control" name="monto_total" value="{{ $factura->monto_total }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="estado">Estado de la Factura</label>
                                                            <select name="estado" class="form-control" required>
                                                                <option value="emitida" {{ $factura->estado == 'emitida' ? 'selected' : '' }}>Emitida</option>
                                                                <option value="pagada" {{ $factura->estado == 'pagada' ? 'selected' : '' }}>Pagada</option>
                                                                <option value="anulada" {{ $factura->estado == 'anulada' ? 'selected' : '' }}>Anulada</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para Crear Factura -->
        <div class="modal fade" id="crearFacturaModal" tabindex="-1" role="dialog" aria-labelledby="crearFacturaLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="crearFacturaLabel">Crear Factura</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('facturas.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="venta_id">Seleccionar Venta</label>
                                <select name="venta_id" id="venta_id" class="form-control" required onchange="document.getElementById('monto_total').value = this.options[this.selectedIndex].getAttribute('data-total')">
                                    <option value="" disabled selected>Seleccione una venta</option>
                                    @foreach($ventas as $venta)
                                        <option value="{{ $venta->id }}" data-total="{{ $venta->total }}">Venta #{{ $venta->id }} - Cliente: {{ $venta->cliente->nombre }} - Total: {{ $venta->total }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="ci_nit">CI/NIT</label>
                                <input type="text" class="form-control" name="ci_nit" required>
                            </div>
                            <div class="form-group">
                                <label for="monto_total">Monto Total</label>
                                <input type="number" step="0.01" class="form-control" name="monto_total" id="monto_total" readonly required>
                            </div>
                            <div class="form-group">
                                <label for="estado">Estado de la Factura</label>
                                <select name="estado" class="form-control" required>
                                    <option value="emitida">Emitida</option>
                                    <option value="pagada">Pagada</option>
                                    <option value="anulada">Anulada</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Crear Factura</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

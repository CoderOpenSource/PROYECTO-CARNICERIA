@extends('layouts.app')

@section('title', 'Registro de Cajas')
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

                    <div class="card data-tables">
                        <div class="card-header">
                            <h3 class="mb-0">Registro de Cajas</h3>
                            <p class="text-sm mb-0">Listado de cajas abiertas y cerradas.</p>
                        </div>
                        <div class="card-body table-full-width table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Saldo Inicial</th>
                                    <th>Saldo Final</th>
                                    <th>Estado</th>
                                    <th>Fecha Apertura</th>
                                    <th>Fecha Cierre</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($cajas as $caja)
                                    <tr>
                                        <td>{{ $caja->fecha->format('d-m-Y') }}</td>
                                        <td>{{ $caja->saldo_inicial }}</td>
                                        <td>{{ $caja->saldo_final ?? 'No disponible' }}</td>
                                        <td>{{ ucfirst($caja->estado) }}</td>
                                        <td>{{ $caja->fecha_apertura ? $caja->fecha_apertura->format('d-m-Y H:i') : 'No disponible' }}</td>
                                        <td>{{ $caja->fecha_cierre ? $caja->fecha_cierre->format('d-m-Y H:i') : 'No disponible' }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<!DOCTYPE html>

<html lang="en">

<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js"></script>

    <!-- Incluye Chartist CSS y JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">
    <!-- Otros scripts y estilos -->
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.ico') }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>@yield('title', 'Control de Ventas Para Cosméticos')</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet" />
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/light-bootstrap-dashboard.css?v=2.0.0') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/demo.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<div class="wrapper">
    <div class="sidebar">
        <div class="sidebar-wrapper bg-primary">
            <div class="logo">
                <a href="#" class="simple-text">
                    Panel de Administración
                </a>
            </div>
            <ul class="nav">
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('dashboard') }}">
                        <i class="nc-icon nc-chart-pie-35"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                @if(session('rol') === 'administrador')
                    <li>
                        <a class="nav-link" href="{{ route('clientes.index') }}">
                            <i class="nc-icon nc-circle-09"></i>
                            <p>Gestionar Clientes</p>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="{{ route('proveedores.index') }}">
                            <i class="nc-icon nc-circle-09"></i>
                            <p>Gestionar Proveedores</p>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="{{ route('categorias.index') }}">
                            <i class="nc-icon nc-notes"></i>
                            <p>Gestionar Categoría Productos</p>
                        </a>
                    </li>
                @endif
                <li>
                    <a class="nav-link" href="{{ route('productos.index') }}">
                        <i class="nc-icon nc-paper-2"></i>
                        <p>Gestionar Productos</p>
                    </a>
                </li>
                <li>
                    <a class="nav-link" href="{{ route('ventas.index')  }}">
                        <i class="nc-icon nc-atom"></i>
                        <p>Gestionar Ventas</p>
                    </a>
                </li>
                <li>
                    <a class="nav-link" href="{{ route('facturas.index') }}">
                        <i class="nc-icon nc-paper-2"></i>
                        <p>Gestionar Facturas</p>
                    </a>
                </li>

                <li>
                    <a class="nav-link" href="{{ route('cajas.index') }}">
                        <i class="nc-icon nc-paper-2"></i>
                        <p>Ver Registro de Cajas</p>
                    </a>
                </li>

                <li>
                    <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="nc-icon nc-button-power"></i>
                        <p>{{ __('Log out') }}</p>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>

            </ul>
        </div>
    </div>

    <div class="main-panel">
        <div class="content">
            @yield('content')
        </div>

    </div>

</div>
<!-- Footer -->
<footer class="footer text-center mt-5" style="background-color: #f8f9fa; padding: 20px;">
    <div class="container">
        <p class="text-muted mb-0">© 2024 Todos los derechos reservados | Proyecto Bachiller Técnico Humanístico</p>
    </div>
</footer>
</body>
<!--   Core JS Files   -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('assets/js/core/popper.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/core/bootstrap.min.js') }}" type="text/javascript"></script>
<!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
<script src="{{ asset('assets/js/plugins/bootstrap-switch.js') }}"></script>
<!--  Notifications Plugin    -->
<script src="{{ asset('assets/js/plugins/bootstrap-notify.js') }}"></script>
<!-- Control Center for Light Bootstrap Dashboard: scripts for the example pages etc -->
<script src="{{ asset('assets/js/light-bootstrap-dashboard.js?v=2.0.0') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/demo.js') }}"></script>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js"></script>


<!-- Popper.js (requerido para Bootstrap JS) -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        if (typeof Chartist !== 'undefined') {
            demo.initDashboardPageCharts();
        } else {
            console.error("Chartist no está definido. Asegúrate de cargar la librería de Chartist.");
        }

        demo.showNotification();
    });
</script>


</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sistema de Control de Ventas y Facturación para Carnicería "Salazar"</title>
    <!-- Fonts and icons -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
    <!-- CSS Files -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/light-bootstrap-dashboard.css?v=2.0.0') }}" rel="stylesheet" />
</head>

<body>
<!-- Botón de Login en la parte superior con fondo rojo -->
<div class="d-flex justify-content-end p-3 bg-primary">
    <a href="{{ route('login') }}" class="btn" style="background-color: white; color: black; border: 1px solid black;">Login</a>
</div>

<!-- Título descriptivo -->
<div class="text-center p-3" style="border-radius: 10px;">
    <h1 class="text-black font-weight-bold" style="text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);">
        {{ __('Sistema de Control de Ventas y Facturación para Carnicería "Salazar" Ubicada en Mercado Satélite Norte') }}
    </h1>
    <p class="text-black font-weight-bold" style="text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3);">
        {{ __('Sistema diseñado para gestionar productos, ventas, pagos y reportes, optimizando la eficiencia y el control en la carnicería.') }}
    </p>
</div>


<!-- Slider de imágenes -->
<div class="full-page section-image" style="background-size: cover; background-position: center; background-repeat: no-repeat; height: 100vh; display: flex; align-items: center; justify-content: center;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <!-- Carrusel Bootstrap para el slider con margen inferior -->
                <div id="projectSlider" class="carousel slide mb-5" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img class="d-block w-100" src="{{ asset('assets/img/slider-image1.png') }}" alt="Primera Imagen" style="object-fit: cover; height: 100%;">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src="{{ asset('assets/img/slider-image2.png') }}" alt="Segunda Imagen" style="object-fit: cover; height: 100%;">
                        </div>
                    </div>
                    <!-- Controles del slider -->
                    <a class="carousel-control-prev" href="#projectSlider" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#projectSlider" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer -->
<footer class="footer text-center mt-5" style="background-color: #f8f9fa; padding: 20px;">
    <div class="container">
        <p class="text-muted mb-0">© 2024 Todos los derechos reservados | Proyecto Bachiller Técnico Humanístico</p>
    </div>
</footer>


<!-- JavaScript Files -->
<script src="{{ asset('assets/js/core/jquery.3.2.1.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/core/popper.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/core/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/plugins/bootstrap-switch.js') }}"></script>
<script src="{{ asset('assets/js/plugins/chartist.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap-notify.js') }}"></script>
<script src="{{ asset('assets/js/light-bootstrap-dashboard.js?v=2.0.0') }}" type="text/javascript"></script>
</body>
</html>

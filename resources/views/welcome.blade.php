@include('layoutsprincipal.header')
<script>
    window.productos = @json($productos);
</script>


<body>
    <main class="main" id="top">


        @include('layoutsprincipal.nav')





        <!-- Menú de Categorías y Subenlaces -->

        <style>
            .cards {
                /* Copiar aquí todos los estilos de .card */
                /* Ejemplo de algunos estilos comunes: */
                display: flex;
                flex-direction: column;
                background-color: #fff;
                border: 1px solid #dee2e6;
                border-radius: 0.25rem;
                padding: 1rem;
                /* Agregar todos los estilos necesarios */
            }

            .main {
                margin-bottom: 0;
                padding-bottom: 0;
            }

            @media (max-width: 767.98px) {
                #home {
                    padding-top: 0 !important;
                    padding-bottom: 0 !important;
                }
            }
        </style>

<section class="py-6 overflow-hidden position-relative" id="home" style="min-height: 100vh;">
    <!-- Contenido de la sección -->
    <div class="d-none d-md-block"></div>
    <div id="homeCarousel" class="carousel slide" data-bs-interval="3000" data-bs-wrap="true">
        <!-- Indicators -->
        <div class="carousel-indicators">
            @foreach ($informaciones as $index => $informacion)
                @if ($informacion->tipo == 'encabezado')
                    <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="{{ $index }}"
                        class="{{ $index == 0 ? 'active' : '' }}"
                        aria-current="{{ $index == 0 ? 'true' : 'false' }}"
                        aria-label="Slide {{ $index + 1 }}"></button>
                @endif
            @endforeach
        </div>

        <div class="carousel-inner">
            @foreach ($informaciones as $index => $informacion)
                @if ($informacion->tipo == 'encabezado')
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        <div style="background: url('{{ asset($informacion->imagen) }}') no-repeat center center; background-size: cover; height: 100vh; position: relative;">
                            <div class="overlay position-absolute w-100 h-100" style="background: rgba(64, 92, 87, 0.5); top: 0; bottom: 0; left: 0; right: 0;"></div>
                            <div class="container position-relative" style="z-index: 1;">
                                <div class="row flex-center">
                                    <div class="col-md-7 col-lg-6 py-8 text-md-start text-center text-white">
                                        <h1 class="display-1 fs-md-5 fs-lg-6 fs-xl-8 text-white">{{ $informacion->titulo }}</h1>
                                        <h1 class="mb-5 fs-4 text-white">{{ $informacion->descripcion }}</h1>
                                        @if ($index == 0)
                                            <div class="cards w-xxl-100">
                                                <div class="card-body">
                                                    <nav class="mb-3">
                                                        <div class="nav nav-tabs justify-content-center" id="nav-auth-tab" role="tablist">
                                                            <button class="nav-link text-danger active" id="nav-login-tab" data-bs-toggle="tab" data-bs-target="#nav-login" type="button" role="tab" aria-controls="nav-login" aria-selected="true">
                                                                <i class="fas fa-sign-in-alt me-2"></i>Inicia Sesión
                                                            </button>
                                                            <button class="nav-link text-danger" id="nav-register-tab" data-bs-toggle="tab" data-bs-target="#nav-register" type="button" role="tab" aria-controls="nav-register" aria-selected="false">
                                                                <i class="fas fa-user-plus me-2"></i>Regístrate
                                                            </button>
                                                        </div>
                                                    </nav>

                                                    <div class="tab-content mt-3" id="nav-tabContent">
                                                        <div class="tab-pane fade" id="nav-register" role="tabpanel" aria-labelledby="nav-register-tab">
                                                            <div class="d-grid gap-3 col-sm-auto">
                                                                <a href="{{ route('register') }}" class="btn btn-primary">Regístrate y obtén diferentes beneficios</a>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade show active" id="nav-login" role="tabpanel" aria-labelledby="nav-login-tab">
                                                            <div class="d-grid gap-3 col-sm-auto">
                                                                <a href="{{ route('login') }}" class="btn btn-primary">Inicia Sesión</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var myCarousel = document.querySelector('#homeCarousel');
        var carousel = new bootstrap.Carousel(myCarousel, {
            interval: 3000,
            wrap: true
        });

        var indicators = myCarousel.querySelectorAll('.carousel-indicators button');

        indicators.forEach(function(indicator, index) {
            indicator.addEventListener('click', function() {
                carousel.to(index);
            });
        });

        myCarousel.addEventListener('slide.bs.carousel', function(event) {
            indicators.forEach(function(indicator) {
                indicator.classList.remove('active');
            });
            indicators[event.to].classList.add('active');
        });
    });
</script>


            <style>
                .custom-carousel .card-fixed {
                    height: 100%;
                    display: flex;
                    flex-direction: column;
                    overflow: hidden;
                }

                .custom-carousel .img-fixed {
                    width: 100%;
                    height: auto;
                    object-fit: cover;
                }

                .custom-carousel .description {
                    overflow: hidden;
                    text-overflow: ellipsis;
                    display: -webkit-box;
                    -webkit-box-orient: vertical;
                }

                @media (max-width: 768px) {
                    .custom-carousel .card-fixed {
                        height: auto;
                    }

                    .custom-carousel .img-fixed {
                        height: auto;
                        max-height: 200px;
                    }

                    .custom-carousel .description {
                        font-size: 0.75rem;
                        -webkit-line-clamp: 3;
                    }

                    .custom-carousel .card-titlea,
                    .custom-carousel .card-titlee {
                        font-size: 1.25rem;
                    }

                    .custom-carousel .fes-2,
                    .custom-carousel .fss-2 {
                        font-size: 0.75rem;
                    }

                    .custom-carousel .carousel-control-prev,
                    .custom-carousel .carousel-control-next {
                        display: none;
                    }
                }

                @media (min-width: 769px) {
                    .custom-carousel .description {
                        font-size: 1rem;
                        -webkit-line-clamp: 5;
                    }

                    .custom-carousel .card-titlea,
                    .custom-carousel .card-titlee {
                        font-size: 1.5rem;
                    }

                    .custom-carousel .fes-2,
                    .custom-carousel .fss-2 {
                        font-size: 1.25rem;
                    }

                    .custom-carousel .carousel-control-prev,
                    .custom-carousel .carousel-control-next {
                        display: flex;
                        position: absolute;
                        top: 50%;
                        transform: translateY(-50%);
                        width: auto;
                        height: auto;
                        padding: 10px;
                        border-radius: 50%;
                    }

                    .custom-carousel .carousel-control-prev {
                        left: -50px;
                    }

                    .custom-carousel .carousel-control-next {
                        right: -50px;
                    }
                }
            </style>

            <section class="pb-3 pt-3">
                <div class="container position-relative">
                    <div id="informacionesCarousel" class="carousel slide custom-carousel" data-bs-ride="carousel"
                        data-bs-interval="2000">
                        <div class="carousel-inner">
                            @foreach ($informacionesI as $informacion)
                                <div class="carousel-item @if ($loop->first) active @endif">
                                    <div class="col-12 mb-4 h-100">
                                        <div class="card card-fixed h-100">
                                            <div class="row g-0 h-100">
                                                @if ($loop->index < 2 || ($loop->index % 2 == 0 && $loop->index >= 4))
                                                    <div class="col-12 col-md-8 order-md-2">
                                                        <img class="img-fluid w-100 fit-cover rounded-end img-fixed"
                                                            src="{{ asset($informacion->imagen) }}"
                                                            alt="{{ $informacion->titulo }}" />
                                                    </div>
                                                    <div
                                                        class="col-12 col-md-4 d-flex flex-column justify-content-center p-4 order-md-1">
                                                        <h1 class="card-titlea h4 h-md-3">
                                                            @php
                                                                $tituloPartes = explode(' ', $informacion->titulo, 2);
                                                            @endphp
                                                            <span class="text-primary">{{ $tituloPartes[0] }}</span>
                                                            @if (isset($tituloPartes[1]))
                                                                <span
                                                                    style="color: #00CFFF;">{{ $tituloPartes[1] }}</span>
                                                            @endif
                                                        </h1>
                                                        <p class="fes-2 description"
                                                            style="color: {{ $informacion->color }}">
                                                            {{ $informacion->descripcion }}
                                                        </p>
                                                        <a class="btn btn-primary mt-3"
                                                            href="{{ route('servicios.ver', $informacion->id) }}">Ver
                                                            más <i class="fas fa-chevron-right ms-2"></i></a>
                                                    </div>
                                                @else
                                                    <div class="col-12 col-md-8 order-md-1">
                                                        <img class="img-fluid w-100 fit-cover rounded-start img-fixed"
                                                            src="{{ asset($informacion->imagen) }}"
                                                            alt="{{ $informacion->titulo }}" />
                                                    </div>
                                                    <div
                                                        class="col-12 col-md-4 d-flex flex-column justify-content-center p-4 order-md-2">
                                                        <h1 class="card-titlee h4 h-md-3">
                                                            @php
                                                                $tituloPartes = explode(' ', $informacion->titulo, 2);
                                                            @endphp
                                                            <span class="text-primary">{{ $tituloPartes[0] }}</span>
                                                            @if (isset($tituloPartes[1]))
                                                                <span
                                                                    style="color: #00CFFF;">{{ $tituloPartes[1] }}</span>
                                                            @endif
                                                        </h1>
                                                        <p class="fss-2 description"
                                                            style="color: {{ $informacion->color }}">
                                                            {{ $informacion->descripcion }}
                                                        </p>
                                                        <a class="btn btn-primary mt-3"
                                                            href="{{ route('servicios.ver', $informacion->id) }}">Ver
                                                            más <i class="fas fa-chevron-right ms-2"></i></a>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#informacionesCarousel"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#informacionesCarousel"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </section>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var informacionesCarousel = document.querySelector('#informacionesCarousel');
                    var carousel = new bootstrap.Carousel(informacionesCarousel, {
                        interval: 2000,
                        wrap: true
                    });

                    informacionesCarousel.querySelectorAll('.carousel-control-prev, .carousel-control-next').forEach(
                        function(indicator) {
                            indicator.addEventListener('click', function() {
                                if (indicator.classList.contains('carousel-control-prev')) {
                                    carousel.prev();
                                } else {
                                    carousel.next();
                                }
                            });
                        });
                });
            </script>



            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    function handleChunkSize(section) {
                        var width = window.innerWidth;
                        var chunkSize;

                        if (section === 'productos') {
                            if (width >= 1200) {
                                chunkSize = 4; // Desktops grandes
                            } else if (width >= 768) {
                                chunkSize = 4; // Tablets y desktops pequeños
                            } else {
                                chunkSize = 2; // Móviles
                            }
                        } else if (section === 'categorias') {
                            if (width >= 1200) {
                                chunkSize = 4; // Desktops grandes
                            } else if (width >= 768) {
                                chunkSize = 4; // Tablets y desktops pequeños
                            } else {
                                chunkSize = 1; // Móviles
                            }
                        }

                        var currentChunkSize = new URLSearchParams(window.location.search).get(section + 'ChunkSize');
                        currentChunkSize = parseInt(currentChunkSize, 10);

                        if (currentChunkSize !== chunkSize) {
                            var newUrl = new URL(window.location.href);
                            newUrl.searchParams.set(section + 'ChunkSize', chunkSize);
                            window.location.href = newUrl.toString();
                        }
                    }

                    handleChunkSize('productos');
                    handleChunkSize('categorias');
                });
            </script>

            <section class="bg-primary-gradient py-5 bg-light">
                <div class="container">
                    <div class="row mb-4">
                        <div class="col text-center">
                            <h5 class="fw-bold text-danger fs-2 fs-lg-5 lh-sm my-2">Productos Destacados</h5>
                            <p class="text">Aprovecha nuestras ofertas y descuentos exclusivos</p>
                            <img src="{{ asset('assets/img/gallery/perrotienda5.png') }}" alt="Darkito"
                                class="img-darkitot right-0 bottom-0" style="">
                        </div>
                        <style>
                            .img-darkitot {
                                right: 0;
                                /* Alinea al borde derecho */
                                bottom: 0;
                                transform: translateY(0%) scaleX(1) translateX(70%);
                                /* Ajuste para móviles */
                                position: absolute;
                                max-height: 400px;
                                z-index: -1;
                            }

                            @media (max-width: 768px) {
                                .img-darkitot {
                                    max-height: 200px;
                                    transform: translateY(-185%) scaleX(1) translateX(0%);
                                    /* Ajuste para móviles */
                                    position: absolute;
                                    z-index: -1;
                                }
                            }
                        </style>
                    </div>
                    <div id="productosDestacadosCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @php
                                $chunkSize = isset($_GET['productosChunkSize']) ? (int) $_GET['productosChunkSize'] : 4;
                            @endphp

                            @foreach ($productosDestacados->chunk($chunkSize) as $chunk)
                                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                    <div class="row h-100 gx-2">
                                        @foreach ($chunk as $producto)
                                            <div class="col-6 col-sm-6 col-lg-{{ 12 / $chunkSize }}">
                                                <div
                                                    class="card h-100 text-white rounded-3 position-relative d-flex flex-column">
                                                    <a href="{{ url('/productodetalle', $producto->id) }}">
                                                        <img class="img-fluid rounded-3 product-image"
                                                            src="{{ $producto->imagen_producto ? asset('storage/imagenes_productos/' . $producto->imagen_producto) : asset('assets/img/gallery/default.jpg') }}"
                                                            alt="Producto {{ $producto->nombre }}">
                                                    </a>
                                                    <div class="card-img-overlay ps-0" style="pointer-events: none;">
                                                        @if ($producto->descuento)
                                                            @if ($producto->descuento->porcentaje)
                                                                <span class="badge bg-danger p-2 ms-3"
                                                                    style="pointer-events: auto;">
                                                                    <i class="fas fa-tag me-2 fs-0"></i>
                                                                    <span
                                                                        class="fs-0">{{ rtrim(rtrim(number_format($producto->descuento->porcentaje, 2), '0'), '.') }}%
                                                                        off</span>
                                                                </span>
                                                            @elseif($producto->descuento->monto)
                                                                <span class="badge bg-danger p-2 ms-3"
                                                                    style="pointer-events: auto;">
                                                                    <i class="fas fa-tag me-2 fs-0"></i>
                                                                    <span
                                                                        class="fs-0">-${{ number_format($producto->descuento->monto, 0, ',', '.') }}</span>
                                                                </span>
                                                            @endif
                                                            <span class="badge ms-2 me-1 p-2"
                                                                style="background-color: #40E0D0; pointer-events: auto;">
                                                                <i class="fas fa-crown me-1 fs-0"></i>
                                                                <span class="fs-0">Descuento</span>
                                                            </span>
                                                        @else
                                                            <span class="badge bg-transparent p-2 ms-3"
                                                                style="visibility: hidden;">
                                                                <i class="fas fa-tag me-2 fs-0"></i>
                                                                <span class="fs-0">-</span>
                                                            </span>
                                                            <span class="badge bg-transparent p-2 ms-2 me-1"
                                                                style="visibility: hidden;">
                                                                <i class="fas fa-crown me-1 fs-0"></i>
                                                                <span class="fs-0">Descuento</span>
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div class="card-body ps-0 d-flex flex-column flex-grow-1">
                                                        <h5 class="fw-bold text-1000 product-name">
                                                            {{ $producto->nombre }}</h5>
                                                        <div
                                                            class="d-flex align-items-center justify-content-between flex-grow-1">
                                                            @if ($producto->descuento)
                                                                <span
                                                                    class="text-muted text-decoration-line-through">${{ number_format($producto->precio_venta_bruto, 0, ',', '.') }}</span>
                                                                <span class="text-danger fw-bold">
                                                                    @if ($producto->descuento->porcentaje)
                                                                        ${{ number_format($producto->precio_venta_bruto * (1 - $producto->descuento->porcentaje / 100), 0, ',', '.') }}
                                                                    @elseif($producto->descuento->monto)
                                                                        ${{ number_format($producto->precio_venta_bruto - $producto->descuento->monto, 0, ',', '.') }}
                                                                    @endif
                                                                </span>
                                                            @else
                                                                <span class="text-danger fw-bold">
                                                                    ${{ number_format($producto->precio_venta_bruto, 0, ',', '.') }}
                                                                </span>
                                                                <span class="text-muted text-decoration-line-through"
                                                                    style="visibility: hidden;">$0</span>
                                                            @endif
                                                        </div>
                                                        <div
                                                            class="d-flex flex-column flex-sm-row align-items-center justify-content-between mt-2">
                                                            <span
                                                                class="badge bg-soft-success py-2 px-3 mt-2 w-100 w-sm-auto">
                                                                <span class="fw-bold fs-1 text-success">En Stock:
                                                                    {{ $producto->cantidad_disponible }}</span>
                                                            </span>
                                                            <button class="btn btn-success btn-sm mt-2 w-100 w-sm-auto"
                                                                onclick="openQuantityModal({{ $producto->id }})">
                                                                <i class="fas fa-shopping-cart"></i>
                                                            </button>
                                                        </div>
                                                        @if ($producto->descuento)
                                                            <span
                                                                class="badge bg-soft-danger py-2 px-3 mt-2 w-100 text-center text-sm-start">
                                                                <span class="fs-1 text-danger"
                                                                    style="display:inline-block; max-width: 100%; white-space: nowrap;">
                                                                    {{ $producto->descuento->dias_restantes }}
                                                                </span>
                                                            </span>
                                                        @else
                                                            <span
                                                                class="badge bg-soft-success py-2 px-3 mt-2 w-100 text-center text-sm-start">
                                                                <span class="fs-1 text-success text-center"
                                                                    style="display: flex; justify-content: center; align-items: center;">
                                                                    Destacado
                                                                </span>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <button class="carousel-control-prev d-none d-md-flex" type="button"
                            data-bs-target="#productosDestacadosCarousel" data-bs-slide="prev" style="left: -70px;">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next d-none d-md-flex" type="button"
                            data-bs-target="#productosDestacadosCarousel" data-bs-slide="next" style="right: -70px;">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                        <div class="text-center mt-4">
                            <a href="{{ url('productosVentas') }}" class="btn btn-danger">Ver todos los Productos</a>
                        </div>
                    </div>
            </section>

            <style>
                .carousel-item .card {
                    height: 350px;
                    display: flex;
                    flex-direction: column;
                    justify-content: space-between;
                }

                .carousel-item .product-image {
                    height: 200px;
                    width: 100%;
                    object-fit: cover;
                }

                .carousel-item .card-body {
                    display: flex;
                    flex-direction: column;
                    justify-content: space-between;
                    flex-grow: 1;
                }

                .product-image {
                    width: 100%;
                    height: 200px;
                    object-fit: cover;
                }

                .product-name {
                    display: block;
                    overflow: hidden;
                    text-overflow: ellipsis;
                    white-space: nowrap;
                    max-width: 180px;
                }

                .card {
                    height: 100%;
                }

                .card-body {
                    flex-grow: 1;
                    display: flex;
                    flex-direction: column;
                }

                @media (min-width: 576px) {
                    .product-name {
                        white-space: normal;
                        height: 3em;
                        line-height: 1.5em;
                        text-overflow: clip;
                    }
                }

                @media (max-width: 576px) {
                    .product-image {
                        height: 200px;
                    }

                    .carousel-control-prev,
                    .carousel-control-next {
                        width: 10%;
                    }
                }

                @media (min-width: 768px) {

                    .carousel-control-prev,
                    .carousel-control-next {
                        display: flex;
                        position: absolute;
                        top: 50%;
                        transform: translateY(-50%);
                        width: auto;
                        height: auto;
                        padding: 10px;
                        border-radius: 50%;
                    }

                    .carousel-control-prev {
                        left: -70px;
                        /* Cambia este valor para mover el botón más hacia afuera */
                    }

                    .carousel-control-next {
                        right: -70px;
                        /* Cambia este valor para mover el botón más hacia afuera */
                    }
                }
            </style>





            <!-- ============================================-->
            <!-- <section> Seccion del como funcionamos ============================-->
            <section class="py-0 bg-primary-gradient position-relative">
                <div class="container">
                    <div class="row justify-content-center g-0">
                        <div class="col-xl-9">
                            <div class="col-lg-6 text-center mx-auto mb-3 mb-md-5 mt-4">
                                <h5 class="fw-bold text-danger fs-3 fs-lg-5 lh-sm my-6">Cómo funcionamos</h5>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-md-3 mb-6">
                                    <div class="text-center">
                                        <i class="fas fa-map-marker-alt fa-3x text-danger"></i>
                                        <h5 class="mt-4 fw-bold">Selecciona el lugar</h5>
                                        <p class="mb-md-0">Recibe tu pedido en casa o retíralo en una tienda cercana.
                                        </p>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3 mb-6">
                                    <div class="text-center">
                                        <i class="fas fa-paw fa-3x text-danger"></i>
                                        <h5 class="mt-4 fw-bold">Elige tu producto</h5>
                                        <p class="mb-md-0">Selecciona entre una amplia variedad de productos para tus
                                            mascotas.</p>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3 mb-6">
                                    <div class="text-center">
                                        <i class="fas fa-credit-card fa-3x text-danger"></i>
                                        <h5 class="mt-4 fw-bold">Métodos de pago</h5>
                                        <p class="mb-md-0">Paga con tarjeta, transferencia bancaria o efectivo en
                                            tienda.</p>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3 mb-6">
                                    <div class="text-center">
                                        <i class="fas fa-shopping-cart fa-3x text-danger"></i>
                                        <h5 class="mt-4 fw-bold">Disfruta comprando</h5>
                                        <p class="mb-md-0">Compra de manera fácil y segura, y recibe tus productos a
                                            domicilio o recógelos en nuestra tienda.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <img src="{{ asset('assets/img/gallery/perrotienda1.png') }}" alt="Darkito"
                        class="img-darkito-right right-0 bottom-0" style="">
                </div>
                <img src="{{ asset('assets/img/gallery/perrotienda4.png') }}" alt="Darkito"
                    class="img-darkito-left  left-0 bottom-0" style="">

                <style>
                    .img-darkito-left {
                        max-height: 400px;
                        object-fit: cover;
                        position: absolute;
                        z-index: -1;
                        /* Establece las imágenes detrás de otros contenidos */
                        transform: translateX(-27%) scaleX(-1);

                    }

                    .img-darkito-right {
                        right: 0;
                        /* Alinea al borde derecho */
                        bottom: 0;
                        transform: translateY(0%) scaleX(-1) translateX(-50%);
                        /* Ajuste para móviles */
                        position: absolute;
                        max-height: 400px;
                        z-index: -1;


                    }

                    @media (max-width: 768px) {
                        .img-darkito-right {
                            max-height: 200px;
                            transform: translateY(-200%) scaleX(-1) translateX(-25%);
                            /* Ajuste para móviles */
                            position: absolute;
                            z-index: -1;
                        }
                    }

                    @media (max-width: 768px) {
                        .img-darkito-left {
                            max-height: 300px;
                            position: absolute;
                            z-index: -1;
                        }
                    }

                    .container {
                        position: relative;
                        z-index: 1;
                        /* Asegura que el contenido del contenedor esté sobre las imágenes */
                    }
                </style>
            </section>



            <!-- ============================================-->
            <!-- <section> Seccion de los productos para ventas  ============================-->
            <section class="bg-primary-gradient bg-light pt-2">
                <div class="bg-holder"
                    style="background-image:url(assets/img/gallery/cta-one-bg.png);background-position:center;background-size:cover;">
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col text-center">
                            <h5 class="fw-bold text-danger fs-2 fs-lg-5 lh-sm my-2">Productos</h5>
                            <p class="text">Navega por todo nuestro catálogo variado</p>
                        </div>
                    </div>

                    <!-- Productos - Vista en Escritorio -->
                    <div class="row h-100 gx-2 d-none d-md-flex">
                        @foreach ($productos->shuffle()->take(8) as $producto)
                            <div class="col-6 col-sm-6 col-lg-3 mb-4">
                                <div class="card h-100 text-white rounded-3 position-relative d-flex flex-column">
                                    <a href="{{ url('/productodetalle', $producto->id) }}">
                                        <img class="img-fluid rounded-3 product-image"
                                            src="{{ $producto->imagen_producto ? asset('storage/imagenes_productos/' . $producto->imagen_producto) : asset('assets/img/gallery/default.jpg') }}"
                                            alt="Producto {{ $producto->nombre }}">
                                    </a>
                                    <div class="card-img-overlay ps-0" style="pointer-events: none;">
                                        @if ($producto->descuento)
                                            @if ($producto->descuento->porcentaje)
                                                <span class="badge bg-danger p-2 ms-3" style="pointer-events: auto;">
                                                    <i class="fas fa-tag me-2 fs-0"></i>
                                                    <span
                                                        class="fs-0">{{ rtrim(rtrim(number_format($producto->descuento->porcentaje, 2), '0'), '.') }}%
                                                        off</span>
                                                </span>
                                            @elseif($producto->descuento->monto)
                                                <span class="badge bg-danger p-2 ms-3" style="pointer-events: auto;">
                                                    <i class="fas fa-tag me-2 fs-0"></i>
                                                    <span
                                                        class="fs-0">-${{ number_format($producto->descuento->monto, 0, ',', '.') }}</span>
                                                </span>
                                            @endif
                                            <span class="badge ms-2 me-1 p-2"
                                                style="background-color: #40E0D0; pointer-events: auto;">
                                                <i class="fas fa-crown me-1 fs-0"></i>
                                                <span class="fs-0">Descuento</span>
                                            </span>
                                        @else
                                            <span class="badge bg-transparent p-2 ms-3" style="visibility: hidden;">
                                                <i class="fas fa-tag me-2 fs-0"></i>
                                                <span class="fs-0">-</span>
                                            </span>
                                            <span class="badge bg-transparent p-2 ms-2 me-1"
                                                style="visibility: hidden;">
                                                <i class="fas fa-crown me-1 fs-0"></i>
                                                <span class="fs-0">Descuento</span>
                                            </span>
                                            <!-- Línea invisible para mantener la altura consistente -->
                                            <span class="badge bg-transparent py-2 px-3 mt-2 w-100"
                                                style="visibility: hidden;"></span>
                                        @endif
                                    </div>
                                    <div class="card-body ps-0 d-flex flex-column flex-grow-1">
                                        <h5 class="fw-bold text-1000 product-name">{{ $producto->nombre }}</h5>
                                        <div class="d-flex align-items-center justify-content-between flex-grow-1">
                                            @if ($producto->descuento)
                                                <span
                                                    class="text-muted text-decoration-line-through">${{ number_format($producto->precio_venta_bruto, 0, ',', '.') }}</span>
                                                <span class="text-danger fw-bold">
                                                    @if ($producto->descuento->porcentaje)
                                                        ${{ number_format($producto->precio_venta_bruto * (1 - $producto->descuento->porcentaje / 100), 0, ',', '.') }}
                                                    @elseif($producto->descuento->monto)
                                                        ${{ number_format($producto->precio_venta_bruto - $producto->descuento->monto, 0, ',', '.') }}
                                                    @endif
                                                </span>
                                            @else
                                                <span class="text-danger fw-bold">
                                                    ${{ number_format($producto->precio_venta_bruto, 0, ',', '.') }}
                                                </span>
                                                <span class="text-muted text-decoration-line-through"
                                                    style="visibility: hidden;">$0</span>
                                            @endif
                                        </div>
                                        <div
                                            class="d-flex flex-column flex-sm-row align-items-center justify-content-between mt-2">
                                            <span class="badge bg-soft-success py-2 px-3 mt-2 w-100 w-sm-auto">
                                                <span class="fw-bold fs-1 text-success">En Stock:
                                                    {{ $producto->cantidad_disponible }}</span>
                                            </span>
                                            <button class="btn btn-success btn-sm mt-2 w-100 w-sm-auto"
                                                onclick="openQuantityModal({{ $producto->id }})">
                                                <i class="fas fa-shopping-cart"></i>
                                            </button>
                                        </div>
                                        @if ($producto->descuento)
                                            <span
                                                class="badge bg-soft-danger py-2 px-3 mt-2 w-100 text-center text-sm-start">
                                                <span class="fs-1 text-danger"
                                                    style="display:inline-block; max-width: 100%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                    {{ $producto->descuento->dias_restantes }}
                                                </span>
                                            </span>
                                        @else
                                            <span
                                                class="badge bg-soft-success py-2 px-3 mt-2 w-100 text-center text-sm-start">
                                                <span class="fs-1 text-success text-center"
                                                    style="display: flex; justify-content: center; align-items: center;">
                                                    Destacado
                                                </span>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Productos - Vista en Móvil -->
                    <div id="productosCarousel" class="carousel slide d-md-none" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach ($productos->shuffle()->take(8)->chunk(2) as $chunk)
                                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                    <div class="row h-100 gx-2">
                                        @foreach ($chunk as $producto)
                                            <div class="col-6 mb-5">
                                                <div
                                                    class="card h-100 text-white rounded-3 position-relative d-flex flex-column">
                                                    <a href="{{ url('/productodetalle', $producto->id) }}">
                                                        <img class="img-fluid rounded-3 product-image"
                                                            src="{{ $producto->imagen_producto ? asset('storage/imagenes_productos/' . $producto->imagen_producto) : asset('assets/img/gallery/default.jpg') }}"
                                                            alt="Producto {{ $producto->nombre }}">
                                                    </a>
                                                    <div class="card-img-overlay ps-0" style="pointer-events: none;">
                                                        @if ($producto->descuento)
                                                            @if ($producto->descuento->porcentaje)
                                                                <span class="badge bg-danger p-2 ms-3"
                                                                    style="pointer-events: auto;">
                                                                    <i class="fas fa-tag me-2 fs-0"></i>
                                                                    <span
                                                                        class="fs-0">{{ rtrim(rtrim(number_format($producto->descuento->porcentaje, 2), '0'), '.') }}%
                                                                        off</span>
                                                                </span>
                                                            @elseif($producto->descuento->monto)
                                                                <span class="badge bg-danger p-2 ms-3"
                                                                    style="pointer-events: auto;">
                                                                    <i class="fas fa-tag me-2 fs-0"></i>
                                                                    <span
                                                                        class="fs-0">-${{ number_format($producto->descuento->monto, 0, ',', '.') }}</span>
                                                                </span>
                                                            @endif
                                                            <span class="badge ms-2 me-1 p-2"
                                                                style="background-color: #40E0D0; pointer-events: auto;">
                                                                <i class="fas fa-crown me-1 fs-0"></i>
                                                                <span class="fs-0">Descuento</span>
                                                            </span>
                                                        @else
                                                            <span class="badge bg-transparent p-2 ms-3"
                                                                style="visibility: hidden;">
                                                                <i class="fas fa-tag me-2 fs-0"></i>
                                                                <span class="fs-0">-</span>
                                                            </span>
                                                            <span class="badge bg-transparent p-2 ms-2 me-1"
                                                                style="visibility: hidden;">
                                                                <i class="fas fa-crown me-1 fs-0"></i>
                                                                <span class="fs-0">Descuento</span>
                                                            </span>
                                                            <!-- Línea invisible para mantener la altura consistente -->
                                                            <span class="badge bg-transparent py-2 px-3 mt-2 w-100"
                                                                style="visibility: hidden;"></span>
                                                        @endif
                                                    </div>
                                                    <div class="card-body ps-0 d-flex flex-column flex-grow-1">
                                                        <h5 class="fw-bold text-1000 product-name">
                                                            {{ $producto->nombre }}</h5>
                                                        <div
                                                            class="d-flex align-items-center justify-content-between flex-grow-1">
                                                            @if ($producto->descuento)
                                                                <span
                                                                    class="text-muted text-decoration-line-through">${{ number_format($producto->precio_venta_bruto, 0, ',', '.') }}</span>
                                                                <span class="text-danger fw-bold">
                                                                    @if ($producto->descuento->porcentaje)
                                                                        ${{ number_format($producto->precio_venta_bruto * (1 - $producto->descuento->porcentaje / 100), 0, ',', '.') }}
                                                                    @elseif($producto->descuento->monto)
                                                                        ${{ number_format($producto->precio_venta_bruto - $producto->descuento->monto, 0, ',', '.') }}
                                                                    @endif
                                                                </span>
                                                            @else
                                                                <span class="text-danger fw-bold">
                                                                    ${{ number_format($producto->precio_venta_bruto, 0, ',', '.') }}
                                                                </span>
                                                                <span class="text-muted text-decoration-line-through"
                                                                    style="visibility: hidden;">$0</span>
                                                            @endif
                                                        </div>
                                                        <div
                                                            class="d-flex flex-column flex-sm-row align-items-center justify-content-between mt-2">
                                                            <span
                                                                class="badge bg-soft-success py-2 px-3 mt-2 w-100 w-sm-auto">
                                                                <span class="fw-bold fs-1 text-success">En Stock:
                                                                    {{ $producto->cantidad_disponible }}</span>
                                                            </span>
                                                            <button class="btn btn-success btn-sm mt-2 w-100 w-sm-auto"
                                                                onclick="openQuantityModal({{ $producto->id }})">
                                                                <i class="fas fa-shopping-cart"></i>
                                                            </button>
                                                        </div>
                                                        @if ($producto->descuento)
                                                            <span
                                                                class="badge bg-soft-danger py-2 px-3 mt-2 w-100 text-center text-sm-start">
                                                                <span class="fs-1 text-danger"
                                                                    style="display:inline-block; max-width: 100%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                                    {{ $producto->descuento->dias_restantes }}
                                                                </span>
                                                            </span>
                                                        @else
                                                            <span
                                                                class="badge bg-soft-success py-2 px-3 mt-2 w-100 text-center text-sm-start">
                                                                <span class="fs-1 text-success text-center"
                                                                    style="display: flex; justify-content: center; align-items: center;">
                                                                    Destacado
                                                                </span>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                    <div class="text-center mt-4">
                        <a href="{{ url('productosVentas') }}" class="btn btn-danger btn-lg w-100 w-md-auto">Ver
                            todos los Productos</a>
                    </div>
                </div>
            </section>

            <style>
                .product-image {
                    width: 100%;
                    height: 200px;
                    object-fit: cover;
                }

                .product-name {
                    display: block;
                    overflow: hidden;
                    text-overflow: ellipsis;
                    white-space: nowrap;
                    max-width: 180px;
                }

                .card {
                    height: 100%;
                }

                .card-body {
                    flex-grow: 1;
                    display: flex;
                    flex-direction: column;
                }

                @media (min-width: 576px) {
                    .product-name {
                        white-space: normal;
                        height: 3em;
                        line-height: 1.5em;
                        text-overflow: clip;
                    }
                }

                @media (max-width: 576px) {

                    .card-body .badge.bg-soft-success,
                    .card-body .btn,
                    .card-body .badge.bg-soft-danger {
                        width: 100%;
                        text-align: center;
                    }

                    .card-body .badge.bg-soft-danger span {
                        display: inline-block;
                        max-width: 100%;
                        white-space: nowrap;
                        overflow: hidden;
                        text-overflow: ellipsis;
                    }

                    .product-image {
                        height: auto;
                    }

                    .carousel-control-prev,
                    .carousel-control-next {
                        width: 10%;
                    }
                }

                @media (min-width: 768px) {

                    .carousel-control-prev,
                    .carousel-control-next {
                        display: none;
                    }
                }
            </style>



            <section class="bg-primary-gradient py-5 bg-light">
                <div class="container">
                    <div class="row justify-content-center mb-6">
                        <div class="col-lg-7 text-center">
                            <h5 class="fw-bold fs-3 fs-lg-5 lh-sm">Buscar por Categorías</h5>
                        </div>
                    </div>

                    <!-- Vista en Escritorio -->
                    <div class="row flex-center d-none d-md-flex">
                        @foreach ($categoriasPadre->shuffle()->take(4) as $categoria)
                            <div class="col-12 col-md-6 col-lg-3 mb-5">
                                <div class="card card-span h-100">
                                    <a href="#">
                                        <img class="img-fluid w-100"
                                            src="{{ asset('storage/imagenes_categorias/' . $categoria->imagen_categoria) }}"
                                            alt="{{ $categoria->nombre }}" style="border-radius: 10px;" />
                                    </a>
                                    <div class="card-body">
                                        <h5 class="text-center fw-bold mb-2">{{ $categoria->nombre }}</h5>
                                        <p class="text-center mb-3">{{ $categoria->descripcion }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Vista en Móvil -->
                    <div id="carouselCategorias" class="carousel slide d-md-none" data-bs-touch="true"
                        data-bs-interval="false">
                        <div class="carousel-inner">
                            @foreach ($categoriasPadre->shuffle()->take(4)->chunk(1) as $chunk)
                                <div class="carousel-item @if ($loop->first) active @endif">
                                    <div class="row h-100 align-items-center">
                                        @foreach ($chunk as $categoria)
                                            <div class="col-12 mb-5">
                                                <div class="card card-span h-100">
                                                    <a href="#">
                                                        <img class="img-fluid w-100"
                                                            src="{{ asset('storage/imagenes_categorias/' . $categoria->imagen_categoria) }}"
                                                            alt="{{ $categoria->nombre }}"
                                                            style="border-radius: 10px;" />
                                                    </a>
                                                    <div class="card-body">
                                                        <h5 class="text-center fw-bold mb-2">{{ $categoria->nombre }}
                                                        </h5>
                                                        <p class="text-center mb-3">{{ $categoria->descripcion }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button class="carousel-control-prev s-icon-prev carousel-icon" type="button"
                            data-bs-target="#carouselCategorias" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon hover-top-shadow" aria-hidden="true"></span>
                            <span class="visually-hidden">Anterior</span>
                        </button>
                        <button class="carousel-control-next s-icon-next carousel-icon" type="button"
                            data-bs-target="#carouselCategorias" data-bs-slide="next">
                            <span class="carousel-control-next-icon hover-top-shadow" aria-hidden="true"></span>
                            <span class="visually-hidden">Siguiente</span>
                        </button>
                    </div>
                </div>
            </section>

            <style>
                .carousel-item {
                    transition: transform 0.5s ease-in-out;
                }

                .carousel-control-prev,
                .carousel-control-next {
                    width: 5%;
                }

                @media (max-width: 576px) {

                    .carousel-control-prev,
                    .carousel-control-next {
                        width: 15%;
                    }
                }

                @media (min-width: 768px) {

                    .carousel-control-prev,
                    .carousel-control-next {
                        display: none;
                    }
                }
            </style>

            </style>


            <!-- <section> close ============================-->
            <!-- ============================================-->


            <section>
                <div class="bg-holder"
                    style="background-image:url(assets/img/gallery/cta-one-bg.png);background-position:center;background-size:cover;">
                </div>
                <!--/.bg-holder-->

                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-xxl-10">
                            <div class="card card-span shadow-warning" style="border-radius: 35px;">
                                <div class="card-body py-5">
                                    <div class="row justify-content-evenly">
                                        <div class="col-md-3">
                                            <div
                                                class="d-flex d-md-block d-xl-flex justify-content-evenly justify-content-lg-between">
                                                <img src="assets/img/icons/discounts.png" width="100"
                                                    alt="Descuentos diarios" />
                                                <div class="d-flex d-lg-block d-xl-flex flex-center">
                                                    <h2 class="fw-bolder text-1000 mb-0 text-gradient">Descuentos
                                                        Diarios
                                                    </h2>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 hr-vertical">
                                            <div
                                                class="d-flex d-md-block d-xl-flex justify-content-evenly justify-content-lg-between">
                                                <img src="assets/img/icons/live-tracking.png" width="100"
                                                    alt="Seguimiento en vivo" />
                                                <div class="d-flex d-lg-block d-xl-flex flex-center">
                                                    <h2 class="fw-bolder text-1000 mb-0 text-gradient"> Castro y
                                                        Quellón
                                                    </h2>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 hr-vertical">
                                            <div
                                                class="d-flex d-md-block d-xl-flex justify-content-evenly justify-content-lg-between">
                                                <img src="assets/img/icons/quick-delivery.png" width="100"
                                                    alt="Entrega rápida" />
                                                <div class="d-flex d-lg-block d-xl-flex flex-center">
                                                    <h2 class="fw-bolder text-1000 mb-0 text-gradient">Entrega Rápida
                                                    </h2>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row flex-center mt-md-8">
                        <div class="col-lg-5 d-none d-lg-block" style="margin-bottom: -122px;">
                            <img class="w-100 move-down-general" src="assets/img/gallery/perrotienda2.png"
                                alt="..." />

                        </div>
                        <style>
                            .move-down-general {
                                transform: translateY(-25%);
                                /* Ajusta el valor según necesites */
                            }
                        </style>


                        <div class="col-lg-5 mt-7 mt-md-0">
                            <h1 class="text-primary">Regístrate o usa nuestra app web</h1>
                            <p>Usar nuestra app web en diferentes dispositivos nunca ha sido más fácil. Regístrate y
                                obtén
                                descuentos exclusivos al instante.</p>


                            <a href="" target="_blank">
                                <img class="w-100 move-left-mobile-transform"
                                    src="assets/img/gallery/perrotienda7.png" width="550" alt="Google Play" />
                            </a>

                        </div>
                        <style>
                            @media (max-width: 768px) {
                                .move-left-mobile-transform {
                                    transform: translateX(0px);
                                    /* Ajusta el valor según necesites */
                                }
                            }
                        </style>

                    </div>
                </div>


            </section>

            <!-- ============================================-->
            <!-- <section> Informativa con la descripcion y su imagen ============================-->
            <!-- ============================================-->

            <!-- <section> close ============================-->
            <!-- ============================================-->
            @include('layoutsprincipal.footer')

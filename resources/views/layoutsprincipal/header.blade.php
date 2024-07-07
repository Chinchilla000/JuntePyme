<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Ferretería El Martillo</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Ferretería El Martillo" name="keywords">
    <meta content="Ferretería El Martillo" name="description">

    <!-- Favicon -->
    <link href="{{ asset('img/logoelmartillo.png') }}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <style>
        .text-gradient {
            background: linear-gradient(to right, #1abc9c, #f39c12);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .card-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .badge-foodwagon {
            background-color: #40e0d0 !important;
        }

        .btn-turquoise {
            background-color: #1abc9c;
            color: #fff;
            border: none;
        }

        .btn-turquoise:hover {
            background-color: #16a085;
            color: #fff;
        }

        .btn-outline-turquoise {
            border: 2px solid #1abc9c;
            color: #1abc9c;
            background-color: transparent;
        }

        .btn-outline-turquoise:hover {
            border-color: #16a085;
            color: #16a085;
            background-color: transparent;
        }

        .cart-button {
            position: fixed;
            bottom: 20px;
            border: 3px solid #40E0D0;
            right: 20px;
            border-radius: 50%;
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1060;
            background-color: #FFFFFF;
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease;
        }

        .cart-button i {
            font-size: 24px;
        }

        .cart-button:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.45);
        }

        .cart-button:active {
            transform: scale(0.9);
        }

        .remove-icon {
            cursor: pointer;
            display: flex;
            align-items: center;
        }

        .cart-item-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            margin-right: 10px;
        }

        .discounted .item-price {
            color: red;
            font-weight: bold;
        }

        .price-original {
            color: grey;
            text-decoration: line-through;
        }

        .price-with-discount {
            color: red;
            font-weight: bold;
        }

        .cart-button .badge {
            top: -10px;
            right: -10px;
            font-size: 0.75rem;
            display: none;
        }
    </style>
</head>

<body>
    <main class="main" id="top">
        <script>
            window.productos = @json($productos);
        </script>

        <!-- Topbar Start -->
        <div class="container-fluid">
            <div class="row align-items-center bg-white py-2 px-xl-5 d-none d-lg-flex">
                <div class="col-lg-2 d-flex align-items-center">
                    <a href="#" class="text-decoration-none d-flex align-items-center">
                        <img src="{{ asset('img/logoelmartillo.png') }}" alt="Ferretería El Martillo"
                            style="max-width: 80px;">
                        <span class="h5 text-dark ml-3 mb-0">Ferretería El Martillo</span>
                    </a>
                </div>
                <div class="col-lg-4 col-6 text-left">
                    <form action="">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Buscar productos">
                            <div class="input-group-append">
                                <span class="input-group-text bg-transparent text-danger">
                                    <i class="fa fa-search"></i>
                                </span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-4 col-6">
                    <div class="d-flex flex-column">
                        <p class="m-0">
                            <i class="fas fa-map-marker-alt text-danger"></i>
                            <a href="https://www.google.com/maps/search/?api=1&query=Esquina+Freire+Poniente+415"
                                target="_blank" class="text-dark">Dirección: Esquina freire poniente 415, Dalcahue,
                                Chiloé</a>
                        </p>
                        <p class="m-0">
                            <i class="fas fa-clock text-danger"></i>
                            Horario: 8:30 a 12:30 y 14:00 a 18:30 hrs
                        </p>
                        <p class="m-0">
                            <i class="fas fa-calendar-alt text-danger"></i>
                            Lunes a viernes
                        </p>
                    </div>
                </div>
                <div class="col-lg-2 col-6 text-right">
                    <p class="m-0">Atención al cliente</p>
                    <a href="https://wa.me/56988696580" class="btn btn-success mb-0 rounded-pill shadow">
                        <i class="fab fa-whatsapp"></i> WhatsApp
                    </a>
                </div>
            </div>
        </div>
        <!-- Topbar End -->

        <style>
            .container-fluid .row .col-lg-4 .d-flex {
                display: flex;
                flex-direction: column;
                justify-content: center;
            }

            .dropdown-item.active,
            .dropdown-item:active {
                background-color: transparent !important;
                /* Elimina el fondo amarillo */
                color: inherit !important;
                /* Mantiene el color del texto */
            }

            .dropdown-item.font-weight-bold.text-danger {
                font-weight: bold;
                color: #dc3545;
                /* Rojo */
            }

            .dropdown-item.font-weight-bold.text-danger:hover {
                background-color: #f8f9fa;
                /* Fondo claro al pasar el cursor */
                color: #dc3545;
                /* Rojo */
            }
        </style>

        <!-- Navbar Start -->
        <div class="container-fluid bg-dark mb-30">
            <div class="row px-xl-5">
                <div class="col-lg-3 d-none d-lg-block">
                    <a class="btn d-flex align-items-center justify-content-between bg-danger w-100"
                        data-toggle="collapse" href="#navbar-vertical" style="height: 65px; padding: 0 30px;">
                        <h6 class="text-white m-0"><i class="fa fa-bars mr-2"></i>Categorías</h6>
                        <i class="fa fa-angle-down text-white"></i>
                    </a>
                    <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 bg-light"
                        id="navbar-vertical" style="width: calc(100% - 30px); z-index: 999;">
                        <div class="navbar-nav w-100">
                            @foreach ($categoriasPadre as $categoriaPadre)
                                @if ($categoriaPadre->subcategorias->count() > 0)
                                    <div class="nav-item dropdown dropright">
                                        <a href="#" class="nav-link dropdown-toggle"
                                            data-toggle="dropdown">{{ $categoriaPadre->nombre }} <i
                                                class="fa fa-angle-right float-right mt-1"></i></a>
                                        <div class="dropdown-menu position-absolute rounded-0 border-0 m-0">
                                            <a href="{{ route('productosVentas.categoria', $categoriaPadre->id) }}"
                                                class="dropdown-item font-weight-bold text-danger">{{ $categoriaPadre->nombre }}</a>
                                            @foreach ($categoriaPadre->subcategorias as $subcategoria)
                                                <a href="{{ route('productosVentas.categoria', $subcategoria->id) }}"
                                                    class="dropdown-item">{{ $subcategoria->nombre }}</a>
                                            @endforeach
                                        </div>
                                    </div>
                                @else
                                    <a href="{{ route('productosVentas.categoria', $categoriaPadre->id) }}"
                                        class="nav-item nav-link">{{ $categoriaPadre->nombre }}</a>
                                @endif
                            @endforeach
                        </div>
                    </nav>
                </div>
                <div class="col-lg-9">
                    <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-3 py-lg-0 px-0">
                        <!-- Este enlace se muestra solo en dispositivos móviles -->
                        <a href="{{ route('welcome') }}" class="text-decoration-none d-block d-lg-none">
                            <img src="{{ asset('img/logoelmartillo.png') }}" alt="Ferretería El Martillo"
                                style="max-width: 80px;">
                            <span class="h5 text-white ms-2">Ferretería El Martillo</span>
                        </a>

                        <button type="button" class="navbar-toggler" data-toggle="collapse"
                            data-target="#navbarCollapse">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                            <div class="navbar-nav d-none d-lg-flex">
                                <a href="{{ route('welcome') }}"
                                    class="nav-item nav-link active text-white">Inicio</a>
                                <a href="{{ url('productosVentas') }}"
                                    class="nav-item nav-link text-white">Productos</a>
                     
                                <div class="nav-item dropdown">
                                    <a href="#" class="nav-link dropdown-toggle text-white"
                                        data-toggle="dropdown">Páginas <i class="fa fa-angle-down mt-1"></i></a>
                                    <div class="dropdown-menu bg-light rounded-0 border-0 m-0">
                                        <a href="{{ url('carrito') }}" class="dropdown-item text-dark">Carrito de Compras</a>
                                        <a href="{{ url('checkout') }}" class="dropdown-item text-dark">Checkout</a>
                                    </div>
                                </div>
                                <a href="{{ url('contacto') }}" class="nav-item nav-link text-white">Contacto</a>
                            </div>
                            <div class="navbar-nav ml-auto py-0 d-none d-lg-block">
                                <a href="" class="btn px-0">
                                    <i class="fas fa-heart text-danger"></i>
                                    <span class="badge text-secondary border border-secondary rounded-circle"
                                        style="padding-bottom: 2px;">0</span>
                                </a>
                                <div class="btn-group">
                                    <a href="#" class="btn px-0 ml-3 dropdown-toggle" data-toggle="dropdown">
                                        <i class="fas fa-shopping-cart text-danger"></i>
                                        <span class="badge text-secondary border border-secondary rounded-circle"
                                            style="padding-bottom: 2px;">{{ $carritoProductos->count() }}</span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <div class="dropdown-item">
                                            @foreach ($carritoProductos as $carritoProducto)
                                                <div class="d-flex align-items-center mb-2">
                                                    <img src="{{ asset('storage/imagenes_productos/' . $carritoProducto->producto->imagen_producto) }}"
                                                        alt="{{ $carritoProducto->producto->nombre }}"
                                                        style="width: 50px; height: 50px; object-fit: cover;">
                                                    <div class="ml-2">
                                                        <h6 class="font-weight-bold mb-0">
                                                            {{ $carritoProducto->producto->nombre }}</h6>
                                                        <small class="text-muted">Cantidad:
                                                            {{ $carritoProducto->cantidad }}</small>
                                                    </div>
                                                </div>
                                            @endforeach
                                            <div class="text-center mt-3">
                                                <a href="{{ route('carrito.index') }}"
                                                    class="btn btn-sm btn-danger">Ver Carrito</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </nav>
                </div>

            </div>
        </div>
        <!-- Navbar End -->

        <!-- Mobile Sidebar Menu -->
        <div class="offcanvas-backdrop" id="offcanvas-backdrop"></div>
        <div class="offcanvas-menu" id="offcanvas-menu">
            <button type="button" class="btn close-btn" data-dismiss="offcanvas-menu">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="offcanvas-menu-content">
                <div class="offcanvas-menu-header">
                    <a href="{{ route('welcome') }}">
                        <img src="{{ asset('img/logoelmartillo.png') }}" alt="Ferretería El Martillo" style="max-width: 100px;">
                    </a>
                    <h5 class="mt-2">Ferretería El Martillo</h5>

                </div>
                <div class="offcanvas-menu-body">
                    <ul class="navbar-nav">
                        <li class="nav-item"><a href="{{ route('welcome') }}" class="nav-link">Inicio</a></li>
                        
                        <li class="nav-item"><a href="{{ url('contacto') }}" class="nav-link">Contacto</a></li>
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Páginas</a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ url('carrito') }}" class="dropdown-item">Carrito de Compras</a></li>
                                <li><a href="{{ url('checkout') }}" class="dropdown-item">Checkout</a></li>
                            </ul>
                        </li>
                      
                    </ul>
                    <!-- Carrito de compras -->
                    <div class="offcanvas-menu-body mt-4">
                        <h5>Carrito de Compras</h5>
                        <ul class="navbar-nav">
                            @foreach ($carritoProductos as $item)
                                <li class="nav-item d-flex align-items-center mb-2">
                                    <img src="{{ asset('storage/imagenes_productos/' . $item->producto->imagen_producto) }}"
                                        alt="{{ $item->producto->nombre }}" class="cart-item-img">
                                    <div class="d-flex flex-column ml-2">
                                        <span>{{ $item->producto->nombre }}</span>
                                        <small>Cantidad: {{ $item->cantidad }}</small>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        <a href="{{ route('carrito.index') }}" class="btn btn-primary btn-block mt-4">Ver Carrito</a>
                    </div>
                    <div class="sidebar-extra-info mt-4">
                        <h6 class="text-uppercase">Dirección</h6>
                        <p><i class="fa fa-map-marker-alt text-danger"></i> Esquina freire poniente 415, Dalcahue,
                            Chiloé</p>
                        <a href="https://www.google.com/maps/place/42%C2%B022'46.4%22S+73%C2%B039'10.8%22W/@-42.3795512,-73.6555699,17z/data=!3m1!4b1!4m4!3m3!8m2!3d-42.3795512!4d-73.652995?hl=es&entry=ttu"
                            class="text-dark" target="_blank">Ver en Google Maps</a>
                        <h6 class="text-uppercase mt-3">Horario</h6>
                        <p><i class="fa fa-clock text-danger"></i> Lunes - Viernes: 8:30 - 12:30 (colación) 14:00 -
                            18:30 hrs</p>
                        <div class="d-flex flex-column align-items-center mt-3">
                            <h6 class="text-uppercase">Atención al Cliente</h6>
                            <a href="https://wa.me/56988696580" class="btn btn-success mb-2 rounded-pill shadow"
                                target="_blank">
                                <i class="fab fa-whatsapp"></i> WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Mobile Sidebar Menu End -->

        <style>
            .custom-text {
                font-size: 1.2rem;
            }

            @media (min-width: 992px) {
                .custom-text {
                    font-size: 1.5rem;
                }
            }

            .scrollable-menu {
                max-height: calc(100vh - 100px);
                /* Ajusta la altura máxima */
                overflow-y: auto;
                padding-bottom: 10px;
            }

            .offcanvas-menu {
                position: fixed;
                top: 0;
                left: 0;
                width: 300px;
                height: 100%;
                background-color: #fff;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                z-index: 1050;
                overflow-y: auto;
                /* Permite el desplazamiento dentro del sidebar */
            }

            .offcanvas-menu.open {
                transform: translateX(0);
            }

            .offcanvas-menu .close-btn {
                position: absolute;
                top: 10px;
                right: 10px;
                font-size: 30px;
                cursor: pointer;
            }

            .offcanvas-menu .offcanvas-menu-content {
                padding: 20px;
            }

            .offcanvas-menu .offcanvas-menu-header {
                text-align: center;
                margin-bottom: 20px;
            }

            .offcanvas-menu .offcanvas-menu-body {
                overflow-y: auto;
            }

            .offcanvas-menu .navbar-nav {
                list-style: none;
                padding: 0;
            }

            .offcanvas-menu .navbar-nav .nav-item {
                margin: 0;
            }

            .offcanvas-menu .navbar-nav .nav-link {
                display: block;
                padding: 10px 15px;
                color: #000;
                text-decoration: none;
            }

            .offcanvas-menu .navbar-nav .dropdown-menu {
                background: #f8f9fa;
                border: none;
                box-shadow: none;
            }

            .offcanvas-backdrop {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 1040;
                display: none;
            }

            .offcanvas-backdrop.show {
                display: block;
            }

            .sidebar-extra-info {
                padding: 10px;
                background-color: #f8f9fa;
                border-radius: 5px;
            }

            .sidebar-extra-info h6 {
                margin-top: 15px;
                font-size: 14px;
                font-weight: bold;
            }

            .sidebar-extra-info p {
                font-size: 14px;
                margin: 5px 0;
            }

            .sidebar-extra-info a {
                text-decoration: none;
            }

            body.no-scroll {
                overflow: hidden;
                /* Prevenir el desplazamiento del body */
            }

            /* Estilos específicos para móviles */
            @media (max-width: 576px) {
                .btn-custom {
                    font-size: 14px;
                    /* Ajusta el tamaño de la fuente */
                    padding: 10px 20px;
                    /* Ajusta el padding */
                }

                .container-fluid {
                    padding-left: 15px;
                    padding-right: 15px;
                }

                .cart-button {
                    width: 60px;
                    /* Ajusta el tamaño del botón */
                    height: 60px;
                    /* Ajusta el tamaño del botón */
                }
            }
        </style>

        <script>
            document.querySelector('.navbar-toggler').addEventListener('click', function() {
                document.getElementById('offcanvas-menu').classList.add('open');
                document.getElementById('offcanvas-backdrop').classList.add('show');
            });
            document.querySelector('.close-btn').addEventListener('click', function() {
                document.getElementById('offcanvas-menu').classList.remove('open');
                document.getElementById('offcanvas-backdrop').classList.remove('show');
            });
            document.getElementById('offcanvas-backdrop').addEventListener('click', function() {
                document.getElementById('offcanvas-menu').classList.remove('open');
                document.getElementById('offcanvas-backdrop').classList.remove('show');
            });
        </script>

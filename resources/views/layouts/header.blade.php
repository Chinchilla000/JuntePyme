<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Meta tags, título e íconos -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'FullBigotes')</title>
    <!-- Vinculaciones de CSS aquí -->

    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/gallery/logo2.png') }}">
    <!-- Helpers -->
    <script src="{{ asset('/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('/js/config.js') }}"></script>

    <!-- Fonts, Icons y Core CSS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">


    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/fonts/boxicons.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/css/core.css') }}" class="template-customizer-core-css">
    <link rel="stylesheet" href="{{ asset('vendor/css/theme-default.css') }}" class="template-customizer-theme-css">
    <link rel="stylesheet" href="{{ asset('css/demo.css') }}">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('/img/favicon/favicon.ico') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/libs/apex-charts/apex-charts.css') }}" />

    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('/vendor/js/menu.js') }}"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('/vendor/libs/apex-charts/apexcharts.js') }}"></script>


    <!-- Vendors JS -->
    <script src="{{ asset('/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <!-- Main JS -->
    <script src="{{ asset('/js/main.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ asset('/js/dashboards-analytics.js') }}"></script>




    <!-- Estilos personalizados -->
    <style>
        body,
        html {
            margin: 0;
            padding: 0;
            font-family: 'Public Sans', sans-serif;
            /* Asegurándonos de aplicar la fuente deseada */
        }

        .header-title {
            font-size: 24px;
            /* Tamaño de fuente grande para que parezca un H1 */
            margin-left: 10px;
            /* Mantenemos un poco de margen */
            font-weight: bold;
            /* Hacemos que el texto sea negrita */
        }


        .logo {
            max-height: 50px;
            /* Ajusta la altura máxima del logo según sea necesario */
            width: auto;
            /* Mantener la proporción del logo */
        }



        .menu-vertical {
            min-width: 80px;
            max-width: 250px;
            /* O cualquier ancho máximo deseado */
            overflow: hidden;
            white-space: nowrap;
            /* Evita que los textos se ajusten al cambiar el tamaño */
        }

        .menu-vertical:not(.menu-collapsed) {
            width: auto;
            /* O 'max-content' para ajustar al contenido */
        }

        .menu-vertical:hover,
        .menu-vertical:not(.menu-collapsed) {
            width: 250px;
        }

        .menu-item {
            margin-bottom: 5px;
        }

        .menu-link {
            display: flex;
            align-items: center;
            padding: 10px;
            border-radius: 5px;
            text-decoration: none;
            color: #000;
        }

        .menu-icon {
            margin-right: 10px;
        }

        .nav-profile {
            display: flex;
            align-items: center;
            /* Alinea los ítems verticalmente en el centro */
            justify-content: space-between;
            /* Distribuye el espacio entre los elementos de manera uniforme */
            gap: 10px;
            /* Espacio entre elementos */
        }

        .nav-profile a,
        .nav-profile span {
            white-space: nowrap;
            /* Evita que los textos se partan */
        }

        .navbar-toggler {
            border: none;
            /* Elimina el borde del botón */
            background: transparent;
            /* Fondo transparente */
        }

        .navbar-toggler .bx {
            font-size: 24px;
            /* Ajusta el tamaño del icono de menú */
        }

        @media (max-width: 768px) {
            .nav-profile {
                flex-direction: row;
                /* Orientación horizontal en dispositivos móviles */
                justify-content: flex-start;
                /* Alinea los elementos al inicio */
            }
        }

        .app-brand {
            display: none;
            /* Se oculta cuando el menú está colapsado */
            font-size: 16px;
            text-align: center;
            padding: 10px 0;
            font-weight: bold;
            line-height: 20px;
            /* Ajusta esto según necesites */
        }

        .menu-vertical:not(.menu-collapsed) .app-brand {
            display: block;
            /* Mostrar solo cuando el menú está expandido */
            text-align: center;
            padding: 5px 0;
            font-size: 16px;
            font-weight: bold;
        }

        .navbar-toggler .bx {
            font-size: 30px;
            /* Ajusta este valor según necesites */
        }

        /* Estilos personalizados */
        @media screen and (max-width: 768px) {
            .menu-vertical {
                position: fixed;
                /* Hace que el sidebar sea flotante */
                left: 0;
                top: 0;
                bottom: 0;
                /* Ajusta para llenar toda la altura */
                z-index: 1000;
                /* Asegura que el sidebar esté sobre el contenido */
                width: 80%;
                /* Define un ancho estándar para cuando el sidebar esté abierto */
                transform: translateX(-100%);
                /* Mueve el sidebar fuera de la pantalla */
                transition: transform 0.3s ease;
                /* Transición suave para la animación del sidebar */
                overflow-y: auto;
                /* Permite desplazarse verticalmente si es necesario */
            }

            .menu-vertical.active {
                transform: translateX(0);
                /* Mueve el sidebar de regreso a la vista */
            }

            .flex-grow-1.container-fluid {
                width: 100%;
                /* Usa todo el ancho disponible */
                margin-left: 0;
                /* Asegura que no haya margen innecesario */
                padding-left: 20px;
                /* Añade un poco de espacio al contenido */
            }
        }

        .flex-grow-1 {
            flex-grow: 1;
            /* Esto asegura que el contenido crezca para llenar el espacio disponible, empujando el footer hacia abajo */
        }

        footer {
            flex-shrink: 0;
            /* Esto asegura que el footer no se reduzca */
            margin-top: auto;
            /* Asegura que el footer esté siempre al final */
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 15px; // Asegúrate de tener un padding uniforme.
        }

        .navbar-toggler {
            padding: 0;
            margin: 0;
            background: none;
            border: none;
            outline: none;
        }

        .navbar-toggler .bx {
            font-size: 30px;
        }

        .navbar-toggler .bx {
            font-size: 30px;
            /* Ajusta el tamaño del icono del menú */
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column; // Esto apila los elementos verticalmente en pantallas pequeñas.
                align-items: flex-start;
            }

            .navbar-toggler {
                align-self: flex-end; // Alinea el botón del menú a la derecha en la vista móvil.
            }
        }
    </style>
</head>

<body>
    <header class="p-1 bg-light header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <!-- Contenedor para el logo y el título -->
                <div class="d-flex align-items-center">
                    <img src="{{ asset('assets/img/gallery/logoelmartillo.png') }}" alt="Logo" class="logo me-2">
                    <h1 class="header-title mb-0">Ferreteria El Martillo</h1>
                </div>
    
                @if (Auth::check())
                    <!-- Contenedor para el perfil del usuario -->
                    <div class="nav-profile">
                        <a href="{{ route('inicio.perfilUsuario') }}" class="text-decoration-none me-2">
                            {{ Auth::user()->name }}
                        </a>
                        <span class="me-2">Perfil</span>
                        <button class="navbar-toggler" type="button" onclick="toggleSidebar()">
                            <span class="bx bx-menu"></span>
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </header>
    
    <div class="d-flex" style="min-height: calc(100vh - 56px);">
        <!-- Asumiendo que el header tiene una altura de 56px -->
        <!-- Asumiendo que el header tiene una altura de 56px -->
        <div class="menu menu-vertical bg-menu-theme py-3 menu-collapsed" id="menu-1">
            @php
                $isLoggedIn = Auth::check();
                $userRole = optional(Auth::user())->role; // Safely get the user role
            @endphp

            @if ($isLoggedIn)
                <ul class="menu-inner py-1 col-6 col-sm-4 col-md-3">
                <!-- Dashboard -->
                <li class="menu-item {{ request()->is('inicio', 'inicio/*') ? 'active' : '' }}">
                    <a href="{{ route('dashboard.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-home-circle"></i>
                        <div>Inicio</div>
                    </a>
                </li>


                    <!-- Secciones accesibles para los usuarios que da permiso el admin-->
                    @if ($userRole != 'User')

                        @if (!empty($preferenciasUsuario['Categorias']) && $preferenciasUsuario['Categorias'])
                            <li class="menu-item {{ request()->is('categorias', 'categorias/*') ? 'active' : '' }}">
                                <a href="{{ route('categorias.indexCategorias') }}" class="menu-link">
                                    <i class="menu-icon fas fa-tags"></i>
                                    <div>Categorias</div>
                                </a>
                            </li>
                        @endif

                        @if (!empty($preferenciasUsuario['Productos']) && $preferenciasUsuario['Productos'])
                            <li class="menu-item {{ request()->is('productos', 'productos/*') ? 'active' : '' }}">
                                <a href="{{ route('productos.index') }}" class="menu-link">
                                    <i class="menu-icon tf-icons bx bx-box"></i>
                                    <div>Productos</div>
                                </a>
                            </li>
                        @endif

                        @if (!empty($preferenciasUsuario['Proveedores']) && $preferenciasUsuario['Proveedores'])
                            <li class="menu-item {{ request()->is('proveedores', 'proveedores/*') ? 'active' : '' }}">
                                <a href="{{ route('proveedores.indexProveedores') }}" class="menu-link">
                                    <i class="menu-icon tf-icons bx bx-building"></i>
                                    <div>Proveedores</div>
                                </a>
                            </li>
                        @endif
                        @if (!empty($preferenciasUsuario['Descuentos']) && $preferenciasUsuario['Descuentos'])
                        <li class="menu-item {{ request()->is('descuentos', 'descuentos/*') ? 'active' : '' }}">
                            <a href="{{ route('descuentos.indexDescuentos') }}" class="menu-link">
                                <i class="menu-icon tf-icons bx bxs-offer"></i>
                                <div>Descuentos</div>
                            </a>
                        </li>
                    @endif

                    @if (!empty($preferenciasUsuario['Ventas']) && $preferenciasUsuario['Ventas'])
                    <li class="menu-item {{ request()->is('ventas/ordenes', 'ventas/ordenes/*') ? 'active' : '' }}">
                        <a href="{{ route('ordenes.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-cart"></i>
                            <div>Ventas</div>
                        </a>
                    </li>
                @endif

                        @if (!empty($preferenciasUsuario['GestionSitio']) && $preferenciasUsuario['GestionSitio'])
                            <li
                                class="menu-item {{ request()->is('GestionSitio', 'GestionSitio/*') ? 'active' : '' }}">
                                <a href="{{ route('inicio.gestionSitioWeb') }}" class="menu-link">
                                    <i class="menu-icon tf-icons bx bx-cog"></i>
                                    <div>Gestión del Sitio</div>
                                </a>
                            </li>
                        @endif

                        @if (!empty($preferenciasUsuario['Rendicion']) && $preferenciasUsuario['Rendicion'])
                            <li class="menu-item {{ request()->is('rendicion', 'rendicion/*') ? 'active' : '' }}">
                                <a href="" class="menu-link">
                                    <i class="menu-icon tf-icons bx bx-calculator"></i>
                                    <div>Rendición</div>
                                </a>
                            </li>
                        @endif
                        @if (!empty($preferenciasUsuario['Contactos']) && $preferenciasUsuario['Contactos'])
                        <li class="menu-item {{ request()->is('admin/contactos', 'admin/contactos/*') ? 'active' : '' }}">
                            <a href="{{ route('admin.contactos') }}" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-user"></i>
                                <div>Contactos</div>
                            </a>
                        </li>
                    @endif
                    @endif

                    <li class="menu-item">
                        <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                            @csrf
                            <button type="submit" class="menu-link"
                                style="border: none; background: none; padding: 10px;">
                                <i class="menu-icon bx bx-log-out"></i>
                                <div style="margin-left: 5px;">Salir</div>
                            </button>
                        </form>
                    </li>
                </ul>
            @endif
        </div>

        <!-- Contenido Principal -->
        <div class="flex-grow-1 container-fluid">
            @yield('page-indicator')
            @yield('content')
        </div>
        <br>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Variables globales para controlar el estado del menú
            let isMenuFixed = false;
            const menu = document.getElementById('menu-1');
            const navbarToggler = document.querySelector('.navbar-toggler');

            // Función para abrir y cerrar el menú
            function toggleSidebar() {
                isMenuFixed = !isMenuFixed;
                if (isMenuFixed) {
                    menu.classList.add('active'); // Marca el menú como activo
                    menu.classList.remove('menu-collapsed'); // Asegura que no esté marcado como colapsado
                    menu.style.width = '250px'; // Establece el ancho para la versión expandida
                } else {
                    menu.classList.remove('active'); // Marca el menú como no activo
                    setTimeout(() => {
                        menu.classList.add(
                            'menu-collapsed'); // Marca el menú como colapsado después de la animación
                        menu.style.width = '0'; // Esconde completamente el menú
                    }, 300); // Tiempo para coincidir con la animación CSS
                }
            }

            // Evento de clic para el botón que alterna el sidebar
            navbarToggler.addEventListener('click', toggleSidebar);

            // Esta función ahora alternará el sidebar también al hacer clic en cualquier parte de él.
            menu.addEventListener('click', function(event) {
                if (window.innerWidth <= 768) {
                    // Evita que los clics en links cierren el sidebar
                    if (!event.target.matches('.menu-link, .menu-link *')) {
                        toggleSidebar();
                    }
                }
            });

            // Aplica o remueve efecto de hover basado en el tamaño de pantalla
            function applyHoverEffect() {
                if (window.innerWidth >= 768) {
                    menu.onmouseenter = () => {
                        if (!isMenuFixed) {
                            menu.style.width = '250px';
                        }
                    };
                    menu.onmouseleave = () => {
                        if (!isMenuFixed) {
                            menu.style.width = '80px';
                        }
                    };
                } else {
                    menu.onmouseenter = null;
                    menu.onmouseleave = null;
                }
            }

            applyHoverEffect();
            window.onresize = applyHoverEffect;

            // Cierra el sidebar si se hace clic fuera de él
            document.addEventListener('click', function(event) {
                if (!menu.contains(event.target) && !navbarToggler.contains(event.target) && isMenuFixed &&
                    window.innerWidth <= 768) {
                    toggleSidebar();
                }
            });
        });
    </script>

    @yield('custom-js')

    @extends('layouts.footer')
</body>

</html>

<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top" data-navbar-on-scroll="data-navbar-on-scroll">
    <div class="container d-flex flex-column">
        <!-- Versión para Escritorio -->
        <div class="d-none d-lg-block w-100">
            <div class="container">
                <!-- Primer Contenedor: Logo y Toggler -->
                <div class="d-flex justify-content-between align-items-center">
                    <a class="navbar-brand d-inline-flex d-lg-none" href="/">
                        <img class="d-inline-block logo-fullbigotes" src="{{ asset('assets/img/gallery/iconof.png') }}" alt="FullBigotes Logo" loading="lazy">
                        <span class="text-1000 fs-3 fw-bold ms-2 text-gradient align-self-center">FullBigotes</span>
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContentDesktop" aria-controls="navbarSupportedContentDesktop" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse border-top border-lg-0 my-2 mt-lg-0" id="navbarSupportedContentDesktop">
                    <a class="navbar-brand d-none d-lg-inline-flex align-items-center" href="/">
                        <img class="d-inline-block logo-fullbigotes" src="{{ asset('assets/img/gallery/iconof.png') }}" alt="FullBigotes Logo" loading="lazy">
                        <span class="text-1000 fs-3 fw-bold ms-2 text-gradient align-self-center">FullBigotes</span>
                    </a>
                    <style>
                        .logo-fullbigotes {
                            height: 70px;
                        }
                    </style>
                    <script>
                        window.productos = @json($productos);
                    </script>
                    <div class="d-flex align-items-center mx-auto pt-5 pt-lg-0">
                        <p class="mb-0 fw-bold text-justify">
                            <i class="fas fa-map-marker-alt text-warning mx-2"></i>
                            <span class="fw-normal">Sucursal Castro:</span>
                            <span>Ignacio Serrano 531</span>
                            <br>
                            <i class="fas fa-map-marker-alt text-warning mx-2"></i>
                            <span class="fw-normal">Sucursal Quellón:</span>
                            <span>Av. la paz 423</span>
                        </p>
                    </div>
                    <form class="d-flex mt-4 mt-lg-0 ms-lg-auto ms-xl-0">
                        <div class="input-group-icon pe-2">
                            <i class="fas fa-search input-box-icon text-primary"></i>
                            <input class="form-control border-0 input-box bg-100" type="search" placeholder="Buscar Producto" aria-label="Search" />
                        </div>
                    </form>
                    @if (Auth::check())
                    <div class="d-flex mt-4 mt-lg-0 ms-lg-auto ms-xl-0">
                        <a href="{{ url('/perfiluser') }}" class="btn btn-outline-turquoise shadow-warning py-1 px-2" style="font-size: 0.8rem;">
                            Bienvenid@, {{ Auth::user()->name }}
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn btn-orange ms-2 py-1 px-2" type="submit" style="font-size: 0.8rem;">Cerrar Sesión</button>
                        </form>
                    </div>
                    @else
                    <div class="d-flex mt-4 mt-lg-0 ms-lg-auto ms-xl-0">
                        <a href="{{ route('login') }}" class="btn btn-orange">Iniciar Sesión</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Versión para Móviles -->
        <div class="d-lg-none w-100">
            <div class="d-flex justify-content-between align-items-center p-2 bg-light border-bottom">
                <a class="navbar-brand" href="/">
                    <img class="d-inline-block" src="{{ asset('assets/img/gallery/iconof.png') }}" alt="FullBigotes Logo" style="height: 65px;" loading="lazy">
                    <span class="text-1000 fs-3 fw-bold ms-2 text-gradient">FullBigotes</span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContentMobile" aria-controls="navbarSupportedContentMobile" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse bg-light" id="navbarSupportedContentMobile">
                <div class="d-flex flex-column align-items-center mt-3">
                    @if (Auth::check())
                    <a href="{{ url('/perfiluser') }}" class="btn btn-outline-turquoise mb-2 w-100 text-center">Bienvenid@, {{ Auth::user()->name }}</a>
                    <form action="{{ route('logout') }}" method="POST" class="w-100 text-center">
                        @csrf
                        <button class="btn btn-orange w-100" type="submit">Cerrar Sesión</button>
                    </form>
                    @else
                    <a href="{{ route('login') }}" class="btn btn-orange w-100 text-center">Iniciar Sesión</a>
                    @endif
                </div>
                <div class="text-center mt-3">
                    <p class="mb-0 fw-bold">
                        <i class="fas fa-map-marker-alt text-warning mx-2"></i>
                        <span class="fw-normal">Sucursal Castro:</span> Ignacio Serrano 531
                        <br>
                        <i class="fas fa-map-marker-alt text-warning mx-2"></i>
                        <span class="fw-normal">Sucursal Quellón:</span> Av. la paz 423
                    </p>
                </div>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ url('/') }}">Inicio</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="categoriasDropdownMobile" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Categorías
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="categoriasDropdownMobile">
                            @foreach($categorias as $categoria)
                            @if ($categoria->categoria_padre_id === null)
                            <li class="dropdown-submenu">
                                <a class="dropdown-item {{ count($categoria->subcategorias) > 0 ? 'dropdown-toggle' : '' }}" href="{{ count($categoria->subcategorias) > 0 ? '#' : route('productosVentas.categoria', $categoria->id) }}">{{ $categoria->nombre }}</a>
                                @if(count($categoria->subcategorias) > 0)
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item text-uppercase text-danger" href="{{ route('productosVentas.categoria', $categoria->id) }}">{{ $categoria->nombre }}</a></li>
                                    @foreach($categoria->subcategorias as $subcategoria)
                                    <li><a class="dropdown-item" href="{{ route('productosVentas.categoria', $subcategoria->id) }}">{{ $subcategoria->nombre }}</a></li>
                                    @endforeach
                                </ul>
                                @endif
                            </li>
                            @endif
                            @endforeach
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('descuentosProductos') }}">Descuentos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('productosVentas') }}">Productos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('servicios.index') }}">Servicios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('contacto') }}">Contacto</a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Segundo Contenedor: Navegación Principal -->
        <div class="collapse navbar-collapse d-none d-lg-block" id="navbarSupportedContentDesktop">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ url('/') }}">Inicio</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="categoriasDropdownDesktop" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Categorías
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="categoriasDropdownDesktop">
                        @foreach($categorias as $categoria)
                        @if ($categoria->categoria_padre_id === null)
                        <li class="dropdown-submenu">
                            <a class="dropdown-item {{ count($categoria->subcategorias) > 0 ? 'dropdown-toggle' : '' }}" href="{{ count($categoria->subcategorias) > 0 ? '#' : route('productosVentas.categoria', $categoria->id) }}">{{ $categoria->nombre }}</a>
                            @if(count($categoria->subcategorias) > 0)
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item text-uppercase text-danger" href="{{ route('productosVentas.categoria', $categoria->id) }}">{{ $categoria->nombre }}</a></li>
                                @foreach($categoria->subcategorias as $subcategoria)
                                <li><a class="dropdown-item" href="{{ route('productosVentas.categoria', $subcategoria->id) }}">{{ $subcategoria->nombre }}</a></li>
                                @endforeach
                            </ul>
                            @endif
                        </li>
                        @endif
                        @endforeach
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('descuentosProductos') }}">Descuentos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('productosVentas') }}">Productos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('servicios.index') }}">Servicios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('contacto') }}">Contacto</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- resources/views/components/cart.blade.php -->
<button class="cart-button" data-bs-toggle="modal" data-bs-target="#cartModal">
    <i class="fas fa-shopping-cart" style="color: #40E0D0;"></i>
    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="cartItemCount">0</span>
</button>

<div class="modal fade" id="quantityModal" tabindex="-1" aria-labelledby="quantityModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="quantityModalLabel">Añadir al Carrito</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Producto: <span id="modalProductName"></span></p>
                <div class="mb-3">
                    <label for="modalProductQuantity" class="form-label">Cantidad</label>
                    <input type="number" class="form-control" id="modalProductQuantity" min="1" value="1">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="addToCartFromModal()">Añadir</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true" style="z-index: 1050;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cartModalLabel">Carrito de Compras</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group" id="cartItems"></ul>
            </div>
            <div class="modal-footer">
                <h5>Total: $<span id="cartTotal">0.00</span></h5>
                <button type="button" id="proceedToCheckoutButton" class="btn btn-primary" onclick="proceedToCheckout()">Proceder al Pago</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Confirmar Eliminación de Producto -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar Eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="confirmDeleteModalBody">
                ¿Estás seguro de que deseas eliminar este producto?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteButton">Eliminar</button>
            </div>
        </div>
    </div>
</div>

<!-- CSS Adicional -->
<style>
    /* Para dispositivos móviles, los submenús deben ser desplegables al hacer clic */
    @media (max-width: 991px) {
        .dropdown-submenu .dropdown-menu {
            display: none;
        }

        .dropdown-submenu.show .dropdown-menu {
            display: block;
        }
    }

    /* Para escritorio, mostrar submenús al pasar el mouse */
    @media (min-width: 992px) {
        .dropdown-submenu:hover .dropdown-menu {
            display: block;
        }
    }
</style>

<!-- JavaScript Adicional -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var categoriasToggleMobile = document.querySelector('#categoriasDropdownMobile');
        var categoriasToggleDesktop = document.querySelector('#categoriasDropdownDesktop');
        var submenus = document.querySelectorAll('.dropdown-submenu');
    
        // Manejador para el toggle de Categorías en móvil
        categoriasToggleMobile.addEventListener('click', function (e) {
            e.stopPropagation();
            var parentMenu = categoriasToggleMobile.closest('.dropdown');
            var dropdownMenu = categoriasToggleMobile.nextElementSibling;
    
            // Cerrar cualquier otro menú abierto
            var openMenus = document.querySelectorAll('.navbar-collapse .dropdown.show');
            openMenus.forEach(function (menu) {
                if (menu !== parentMenu) {
                    menu.classList.remove('show');
                    var submenu = menu.querySelector('.dropdown-menu');
                    if (submenu) {
                        submenu.classList.remove('show');
                    }
                }
            });
    
            // Asegura que el menú se abre o se cierra con un solo clic
            var isOpen = dropdownMenu.classList.contains('show');
            dropdownMenu.classList.toggle('show', !isOpen);
            parentMenu.classList.toggle('show', !isOpen);
            categoriasToggleMobile.setAttribute('aria-expanded', !isOpen);
        });
    
        // Manejador para el toggle de Categorías en escritorio
        categoriasToggleDesktop.addEventListener('click', function (e) {
            e.stopPropagation();
            var parentMenu = categoriasToggleDesktop.closest('.dropdown');
            var dropdownMenu = categoriasToggleDesktop.nextElementSibling;
    
            // Cerrar cualquier otro menú abierto
            var openMenus = document.querySelectorAll('.navbar-nav .dropdown.show');
            openMenus.forEach(function (menu) {
                if (menu !== parentMenu) {
                    menu.classList.remove('show');
                    var submenu = menu.querySelector('.dropdown-menu');
                    if (submenu) {
                        submenu.classList.remove('show');
                    }
                }
            });
    
            // Asegura que el menú se abre o se cierra con un solo clic
            var isOpen = dropdownMenu.classList.contains('show');
            dropdownMenu.classList.toggle('show', !isOpen);
            parentMenu.classList.toggle('show', !isOpen);
            categoriasToggleDesktop.setAttribute('aria-expanded', !isOpen);
        });
    
        // Manejadores para los submenús en móvil
        submenus.forEach(function (submenu) {
            submenu.querySelector('.dropdown-item').addEventListener('click', function (e) {
                if (window.innerWidth <= 991) {
                    e.preventDefault();
                    e.stopPropagation();
    
                    // Cerrar otros submenús
                    submenus.forEach(function (otherSubmenu) {
                        if (otherSubmenu !== submenu) {
                            otherSubmenu.classList.remove('show');
                            var otherDropdownMenu = otherSubmenu.querySelector('.dropdown-menu');
                            if (otherDropdownMenu) {
                                otherDropdownMenu.classList.remove('show');
                            }
                        }
                    });
    
                    submenu.classList.toggle('show');
                    var dropdownMenu = submenu.querySelector('.dropdown-menu');
                    dropdownMenu.classList.toggle('show');
                }
            });
        });
    
        // Cerrar los menús cuando se hace clic fuera de ellos en móvil
        document.addEventListener('click', function (e) {
            if (window.innerWidth <= 991) {
                var dropdowns = document.querySelectorAll('.navbar-collapse .dropdown');
                dropdowns.forEach(function (dropdown) {
                    if (!dropdown.contains(e.target)) {
                        dropdown.classList.remove('show');
                        var dropdownMenu = dropdown.querySelector('.dropdown-menu');
                        if (dropdownMenu) {
                            dropdownMenu.classList.remove('show');
                        }
                    }
                });
            }
        });
    
        // Abrir submenús al pasar el mouse en escritorio
        var desktopDropdowns = document.querySelectorAll('.navbar-nav .dropdown');
        desktopDropdowns.forEach(function (dropdown) {
            dropdown.addEventListener('mouseenter', function () {
                if (window.innerWidth > 991) {
                    var submenu = dropdown.querySelector('.dropdown-menu');
                    submenu.classList.add('show');
                }
            });
            dropdown.addEventListener('mouseleave', function () {
                if (window.innerWidth > 991) {
                    var submenu = dropdown.querySelector('.dropdown-menu');
                    submenu.classList.remove('show');
                }
            });
        });
    });
    </script>
    
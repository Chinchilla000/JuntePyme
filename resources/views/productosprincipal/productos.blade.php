@include('layoutsprincipal.header')
@include('layoutsprincipal.nav')
<script>
    window.productos = @json($productos);
</script>
<script src="{{ asset('js/app.js') }}" defer></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<style>
    .text-orange {
        color: #FFA500;
    }
    .text-turquoise {
        color: #40E0D0;
    }
    .text-white {
        color: white;
    }
    .discount-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background-color: #FF6347;
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 0.9em;
    }
    .product-filter {
        margin-bottom: 20px;
    }
    .card-span {
        transition: box-shadow .3s ease-in-out, transform .3s ease-in-out;
        cursor: pointer;
    }
    .card-span:hover {
        transform: scale(1.05);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.19), 0 6px 6px rgba(0, 0, 0, 0.23);
    }
    .btn-cart {
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
    }
    .precio-tachado {
        color: grey;
    }
    .product-image {
        width: 100%;
        height: auto; /* Mantener la proporción original */
        object-fit: contain; /* Asegurar que la imagen no se estire */
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
            height: auto; /* Mantener la proporción original en dispositivos móviles */
        }
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
            display: block;
        }
    }
    .search-container {
        display: flex;
        align-items: center;
    }
    .search-container input {
        border-radius: 0.375rem 0 0 0.375rem;
        border-right: none;
    }
    .search-container button {
        border-radius: 0 0.375rem 0.375rem 0;
        border-left: none;
    }
</style>

<!-- Modal de Aviso -->
<div class="modal fade" id="avisoModal" tabindex="-1" aria-labelledby="avisoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="avisoModalLabel">Aviso</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="avisoModalBody">
                Por favor, ingrese un término de búsqueda.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<br>

<section class="bg-primary-gradient py-5 bg-light">
    <div class="bg-holder" style="background-image:url(assets/img/gallery/cta-one-bg.png);background-position:center;background-size:cover;">
    </div>
    <div class="container">
        <div class="row mb-4">
            <div class="col text-center">
                <h5 class="fw-bold text-danger fs-2 fs-lg-5 lh-sm my-2">Productos Destacados</h5>
                <p class="text">Aprovecha nuestras ofertas y descuentos exclusivos</p>
            </div>
        </div>
        
        <!-- Carousel for PC view -->
        <div id="productosDestacadosCarouselPC" class="carousel slide d-none d-md-block" data-bs-ride="carousel">
            <div class="carousel-inner">
                @php
                    $chunks = $productos->filter(function ($producto) {
                        return $producto->es_destacado;
                    })->chunk(4);
                @endphp
                @foreach($chunks as $chunk)
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                        <div class="row gx-2">
                            @foreach($chunk as $producto)
                                <div class="col-lg-3 mb-5">
                                    <div class="card h-100 text-white rounded-3 position-relative">
                                        <a href="{{ url('/productodetalle', $producto->id) }}">
                                            <img class="img-fluid rounded-3 product-image" src="{{ $producto->imagen_producto ? asset('storage/imagenes_productos/' . $producto->imagen_producto) : asset('assets/img/gallery/default.jpg') }}" alt="Producto {{ $producto->nombre }}">
                                        </a>
                                        <div class="card-img-overlay ps-0" style="pointer-events: none;">
                                            @if($producto->descuento)
                                                @if($producto->descuento->porcentaje)
                                                    <span class="badge bg-danger p-2 ms-3" style="pointer-events: auto;">
                                                        <i class="fas fa-tag me-2 fs-0"></i>
                                                        <span class="fs-0">{{ rtrim(rtrim(number_format($producto->descuento->porcentaje, 2), '0'), '.') }}% off</span>
                                                    </span>
                                                @elseif($producto->descuento->monto)
                                                    <span class="badge bg-danger p-2 ms-3" style="pointer-events: auto;">
                                                        <i class="fas fa-tag me-2 fs-0"></i>
                                                        <span class="fs-0">-${{ number_format($producto->descuento->monto, 0, ',', '.') }}</span>
                                                    </span>
                                                @endif
                                                <span class="badge ms-2 me-1 p-2" style="background-color: #40E0D0; pointer-events: auto;">
                                                    <i class="fas fa-crown me-1 fs-0"></i>
                                                    <span class="fs-0">Descuento</span>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="card-body d-flex flex-column">
                                            <h5 class="fw-bold text-dark product-name">{{ \Illuminate\Support\Str::limit($producto->nombre, 20, '...') }}</h5>
                                            <div class="d-flex align-items-center justify-content-between">
                                                @if($producto->descuento)
                                                    <span class="text-muted text-decoration-line-through">${{ number_format($producto->precio_venta_bruto, 0, ',', '.') }}</span>
                                                    <span class="text-danger fw-bold">
                                                        @if($producto->descuento->porcentaje)
                                                            ${{ number_format($producto->precio_venta_bruto * (1 - $producto->descuento->porcentaje / 100), 0, ',', '.') }}
                                                        @elseif($producto->descuento->monto)
                                                            ${{ number_format($producto->precio_venta_bruto - $producto->descuento->monto, 0, ',', '.') }}
                                                        @endif
                                                    </span>
                                                @else
                                                    <span class="text-danger fw-bold">
                                                        ${{ number_format($producto->precio_venta_bruto, 0, ',', '.') }}
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center mt-2">
                                                <small class="text-muted">Disponible: {{ $producto->cantidad_disponible }}</small>
                                                <button class="btn btn-success btn-sm mt-2 w-100 w-sm-auto" onclick="openQuantityModal({{ $producto->id }})">
                                                    <i class="fas fa-shopping-cart"></i>
                                                </button>
                                            </div>
                                            @if($producto->descuento)
                                                <span class="badge bg-soft-danger py-2 px-3 mt-2 w-100 text-center text-sm-start">
                                                    <span class="fs-1 text-danger" style="display:inline-block; max-width: 100%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                        {{ $producto->descuento->dias_restantes }}
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
            <button class="carousel-control-prev" type="button" data-bs-target="#productosDestacadosCarouselPC" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#productosDestacadosCarouselPC" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <!-- Carousel for mobile view -->
        <div id="productosDestacadosCarouselMobile" class="carousel slide d-md-none" data-bs-ride="carousel">
            <div class="carousel-inner">
                @php
                    $chunks = $productos->filter(function ($producto) {
                        return $producto->es_destacado;
                    })->chunk(2);
                @endphp
                @foreach($chunks as $chunk)
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                        <div class="row gx-2">
                            @foreach($chunk as $producto)
                                <div class="col-6 mb-3">
                                    <div class="card h-100 text-white rounded-3 position-relative">
                                        <a href="{{ url('/productodetalle', $producto->id) }}">
                                            <img class="img-fluid rounded-3 product-image" src="{{ $producto->imagen_producto ? asset('storage/imagenes_productos/' . $producto->imagen_producto) : asset('assets/img/gallery/default.jpg') }}" alt="Producto {{ $producto->nombre }}">
                                        </a>
                                        <div class="card-img-overlay ps-0" style="pointer-events: none;">
                                            @if($producto->descuento)
                                                @if($producto->descuento->porcentaje)
                                                    <span class="badge bg-danger p-2 ms-3" style="pointer-events: auto;">
                                                        <i class="fas fa-tag me-2 fs-0"></i>
                                                        <span class="fs-0">{{ rtrim(rtrim(number_format($producto->descuento->porcentaje, 2), '0'), '.') }}% off</span>
                                                    </span>
                                                @elseif($producto->descuento->monto)
                                                    <span class="badge bg-danger p-2 ms-3" style="pointer-events: auto;">
                                                        <i class="fas fa-tag me-2 fs-0"></i>
                                                        <span class="fs-0">-${{ number_format($producto->descuento->monto, 0, ',', '.') }}</span>
                                                    </span>
                                                @endif
                                                <span class="badge ms-2 me-1 p-2" style="background-color: #40E0D0; pointer-events: auto;">
                                                    <i class="fas fa-crown me-1 fs-0"></i>
                                                    <span class="fs-0">Descuento</span>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="card-body d-flex flex-column">
                                            <h5 class="fw-bold text-dark product-name">{{ \Illuminate\Support\Str::limit($producto->nombre, 20, '...') }}</h5>
                                            <div class="d-flex align-items-center justify-content-between">
                                                @if($producto->descuento)
                                                    <span class="text-muted text-decoration-line-through">${{ number_format($producto->precio_venta_bruto, 0, ',', '.') }}</span>
                                                    <span class="text-danger fw-bold">
                                                        @if($producto->descuento->porcentaje)
                                                            ${{ number_format($producto->precio_venta_bruto * (1 - $producto->descuento->porcentaje / 100), 0, ',', '.') }}
                                                        @elseif($producto->descuento->monto)
                                                            ${{ number_format($producto->precio_venta_bruto - $producto->descuento->monto, 0, ',', '.') }}
                                                        @endif
                                                    </span>
                                                @else
                                                    <span class="text-danger fw-bold">
                                                        ${{ number_format($producto->precio_venta_bruto, 0, ',', '.') }}
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center mt-2">
                                                <small class="text-muted">Disponible: {{ $producto->cantidad_disponible }}</small>
                                                <button class="btn btn-success btn-sm" type="button" onclick="openQuantityModal({{ $producto->id }})">
                                                    <i class="fas fa-shopping-cart"></i>
                                                </button>
                                            </div>
                                            @if($producto->descuento)
                                                <span class="badge bg-soft-danger py-2 px-3 mt-2 w-100 text-center text-sm-start">
                                                    <span class="fs-1 text-danger" style="display:inline-block; max-width: 100%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                        {{ $producto->descuento->dias_restantes }}
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
            <button class="carousel-control-prev" type="button" data-bs-target="#productosDestacadosCarouselMobile" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#productosDestacadosCarouselMobile" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</section>

<section class="py-4" style="background-color: #FEEFCE;">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-4">
                <h5 class="fw-bold fs-3 fs-lg-5 lh-sm">Productos a la venta</h5>
            </div>
            <!-- Ajustes de espaciado entre sidebar y sección de productos -->
            <div class="d-flex flex-wrap align-items-start justify-content-center">
                <!-- Sidebar con filtros desplegables, ajuste para centrar en pantallas pequeñas -->
                <div class="col-12 col-md-3 pe-md-4 mb-3 mb-md-0">
                    <div class="mb-4">
                        <h5 class="fw-bold text-md-start text-center">Filtrar por</h5>
                        <div class="accordion" id="filterAccordion">
                            <!-- Detalles de los filtros -->
                            <form method="GET" action="{{ url()->current() }}">
                                <!-- Filtro por Marca -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingBrand">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseBrand" aria-expanded="true"
                                            aria-controls="collapseBrand">
                                            Marca
                                        </button>
                                    </h2>
                                    <div id="collapseBrand" class="accordion-collapse collapse show" aria-labelledby="headingBrand">
                                        <div class="accordion-body">
                                            @foreach($marcas as $marca)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="{{ $marca }}" name="marca[]" id="brand{{ $marca }}" {{ in_array($marca, request()->input('marca', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="brand{{ $marca }}">
                                                        {{ $marca }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <!-- Filtro por Peso -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingWeight">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseWeight"
                                            aria-expanded="false" aria-controls="collapseWeight">
                                            Peso
                                        </button>
                                    </h2>
                                    <div id="collapseWeight" class="accordion-collapse collapse"
                                        aria-labelledby="headingWeight">
                                        <div class="accordion-body">
                                            @foreach($pesos as $peso)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="{{ $peso }}" name="peso[]" id="weight{{ $peso }}" {{ in_array($peso, request()->input('peso', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="weight{{ $peso }}">
                                                        {{ $peso }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <!-- Filtro por Edad de la Mascota -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingAge">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseAge" aria-expanded="false"
                                            aria-controls="collapseAge">
                                            Edad Mascota
                                        </button>
                                    </h2>
                                    <div id="collapseAge" class="accordion-collapse collapse"
                                        aria-labelledby="headingAge">
                                        <div class="accordion-body">
                                            @foreach($edadesMascota as $edad)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="{{ $edad }}" name="edad_mascota[]" id="age{{ $edad }}" {{ in_array($edad, request()->input('edad_mascota', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="age{{ $edad }}">
                                                        {{ $edad }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <!-- Filtro por Necesidades Especiales -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingSpecialNeeds">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseSpecialNeeds"
                                            aria-expanded="false" aria-controls="collapseSpecialNeeds">
                                            Necesidades Especiales
                                        </button>
                                    </h2>
                                    <div id="collapseSpecialNeeds" class="accordion-collapse collapse"
                                        aria-labelledby="headingSpecialNeeds">
                                        <div class="accordion-body">
                                            @foreach($necesidadesEspeciales as $necesidad)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="{{ $necesidad }}" name="necesidades_especiales[]" id="special{{ $necesidad }}" {{ in_array($necesidad, request()->input('necesidades_especiales', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="special{{ $necesidad }}">
                                                        {{ $necesidad }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary mt-3">Aplicar Filtros</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Contenido principal con productos, ajuste de margen izquierdo -->
                <div class="col-md-9 ps-md-4">
                    <div class="product-filter mb-4">
                        <div class="search-container">
                            <input type="text" class="form-control" id="buscar-productos" placeholder="Buscar productos...">
                            <button class="btn btn-primary" id="boton-buscar"><i class="fas fa-search"></i></button>
                        </div>
                        <button class="btn btn-danger mt-2" id="boton-ver-todos">Limpiar buscar</button>
                    </div>
                    <div class="row gx-3" id="productos-lista">
                        @foreach ($productos as $producto)
                        <div class="col-6 col-lg-3 mb-5"> <!-- Ajuste de clases de columnas para mostrar 2 por fila en dispositivos móviles y tablets -->
                            <div class="card card-span h-100 rounded-3 shadow-sm hover-shadow position-relative">
                                <div class="img-container" style="cursor: pointer;">
                                    <a href="{{ url('/productodetalle', $producto->id) }}">
                                        @if($producto->imagen_producto)
                                            <img class="img-fluid rounded-3 product-image" src="{{ asset('storage/imagenes_productos/' . $producto->imagen_producto) }}" alt="Producto {{ $producto->nombre }}">
                                        @else
                                            <img class="img-fluid rounded-3 product-image" src="{{ asset('assets/img/gallery/default.jpg') }}" alt="Default Image">
                                        @endif
                                    </a>
                                    @if($producto->descuento)
                                        <div class="card-img-overlay ps-0" style="pointer-events: none;">
                                            @if($producto->descuento->porcentaje)
                                                <span class="badge bg-danger p-2 ms-3" style="pointer-events: auto;">
                                                    <i class="fas fa-tag me-2 fs-0"></i>
                                                    <span class="fs-0">{{ rtrim(rtrim(number_format($producto->descuento->porcentaje, 2), '0'), '.') }}% off</span>
                                                </span>
                                            @elseif($producto->descuento->monto)
                                                <span class="badge bg-danger p-2 ms-3" style="pointer-events: auto;">
                                                    <i class="fas fa-tag me-2 fs-0"></i>
                                                    <span class="fs-0">-${{ number_format($producto->descuento->monto, 0, ',', '.') }}</span>
                                                </span>
                                            @endif
                                            <span class="badge ms-2 me-1 p-2" style="background-color: #40E0D0; pointer-events: auto;">
                                                <i class="fas fa-crown me-1 fs-0"></i>
                                                <span class="fs-0">Descuento</span>
                                            </span>
                                        </div>
                                    @endif
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <h5 class="fw-bold text-dark product-name">{{ \Illuminate\Support\Str::limit($producto->nombre, 20, '...') }}</h5>
                                    <div class="d-flex justify-content-between align-items-center mt-auto">
                                        @if($producto->descuento)
                                            <span class="text-muted text-decoration-line-through">${{ number_format($producto->precio_venta_bruto, 0, ',', '.') }}</span>
                                            <span class="text-danger fw-bold">
                                                @if($producto->descuento->porcentaje)
                                                    ${{ number_format($producto->precio_venta_bruto * (1 - $producto->descuento->porcentaje / 100), 0, ',', '.') }}
                                                @elseif($producto->descuento->monto)
                                                    ${{ number_format($producto->precio_venta_bruto - $producto->descuento->monto, 0, ',', '.') }}
                                                @endif
                                            </span>
                                        @else
                                            <span class="text-1000 fw-bold">${{ number_format($producto->precio_venta_bruto, 0, ',', '.') }}</span>
                                        @endif
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                        <small class="text-muted">Disponible: {{ $producto->cantidad_disponible }}</small>
                                        <button class="btn btn-cart btn-success btn-sm" type="button"  onclick="openQuantityModal({{ $producto->id }})">
                                            <i class="fas fa-cart-plus"></i> 
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-center">
                        {{ $productos->appends(['searchTerm' => request('searchTerm')])->links('vendor.pagination.custom') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    window.productos = @json($productos->items());
</script>
<script>
    // Guardar la posición del scroll en el almacenamiento local antes de que la página se recargue
    window.addEventListener('beforeunload', function() {
        localStorage.setItem('scrollPosition', window.scrollY);
    });

    // Restaurar la posición del scroll cuando se carga la página
    window.addEventListener('load', function() {
        if (localStorage.getItem('scrollPosition') !== null) {
            window.scrollTo(0, parseInt(localStorage.getItem('scrollPosition'), 10));
            localStorage.removeItem('scrollPosition'); // Limpiar después de restaurar
        }
    });
    function loadCart() {
        const savedCart = sessionStorage.getItem('cart');
        if (savedCart) {
            cart = JSON.parse(savedCart);
        } else {
            fetch('/cargar-carrito')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok.');
                    }
                    return response.json();
                })
                .then(data => {
                    cart = data.cart || [];
                    updateCart();
                    if (document.getElementById('checkoutItems')) {
                        updateCheckout();
                    }
                })
                .catch(error => {
                    console.error('Error al cargar el carrito:', error);
                });
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        var cart = [];

        // Búsqueda dinámica de productos
        // Búsqueda dinámica de productos
        document.getElementById('boton-buscar').addEventListener('click', function() {
            const query = document.getElementById('buscar-productos').value;
            if (!query.trim()) {
                document.getElementById('avisoModalBody').textContent =
                    'Por favor, ingrese un término de búsqueda.';
                var myModal = new bootstrap.Modal(document.getElementById('avisoModal'));
                myModal.show();
                return;
            }

            fetch(`/buscar-productos?query=${query}`)
                .then(response => response.json())
                .then(data => {
                    const productosLista = document.getElementById('productos-lista');
                    productosLista.innerHTML = '';

                    if (data.message) {
                        productosLista.innerHTML =
                            `<div class="col-12 text-center"><p>${data.message}</p></div>`;
                    } else {
                        data.forEach(producto => {
                            const precioVentaBruto = Math.floor(parseFloat(producto.precio_venta_bruto)).toLocaleString('es-CL');
                            const precioFinal = Math.floor(parseFloat(producto.precio_final)).toLocaleString('es-CL');
                            const descuentoPorcentaje = producto.descuento && producto.descuento.porcentaje ?
                                `${Math.floor(producto.descuento.porcentaje)}% off` : '';
                            const descuentoMonto = producto.descuento && producto.descuento.monto ?
                                `-$${Math.floor(producto.descuento.monto)}` : '';

                            productosLista.innerHTML += `
                            <div class="col-6 col-lg-3 mb-5" id="product-${producto.id}">
                                <div class="card card-span h-100 rounded-3 shadow-sm hover-shadow position-relative">
                                    <div class="img-container" style="cursor: pointer;">
                                        <a href="/productodetalle/${producto.id}">
                                            <img class="img-fluid rounded-3 product-image" src="${producto.imagen_url}" alt="Producto ${producto.nombre}">
                                        </a>
                                        ${producto.descuento ? `
                                            <div class="card-img-overlay ps-0" style="pointer-events: none;">
                                                ${descuentoPorcentaje ? `<span class="badge bg-danger p-2 ms-3" style="pointer-events: auto;"><i class="fas fa-tag me-2 fs-0"></i><span class="fs-0">${descuentoPorcentaje}</span></span>` : ''}
                                                ${descuentoMonto ? `<span class="badge bg-danger p-2 ms-3" style="pointer-events: auto;"><i class="fas fa-tag me-2 fs-0"></i><span class="fs-0">${descuentoMonto}</span></span>` : ''}
                                                <span class="badge ms-2 me-1 p-2" style="background-color: #40E0D0; pointer-events: auto;"><i class="fas fa-crown me-1 fs-0"></i><span class="fs-0">Descuento</span></span>
                                            </div>` : ''}
                                    </div>
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="fw-bold text-dark product-name">${producto.nombre}</h5>
                                        <p class="text-muted">${producto.descripcion.substring(0, 25)}...</p>
                                        <div class="d-flex justify-content-between align-items-center mt-auto">
                                            ${producto.descuento ? `
                                                <span class="text-muted text-decoration-line-through">$${precioVentaBruto}</span>
                                                <span class="text-danger fw-bold product-price" data-final-price="${Math.floor(producto.precio_final)}">$${precioFinal}</span>
                                            ` : `
                                                <span class="text-1000 fw-bold product-price" data-final-price="${Math.floor(producto.precio_final)}">$${precioFinal}</span>
                                            `}
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mt-2">
                                            <small class="text-muted">Disponible: ${producto.cantidad_disponible}</small>
                                            <button class="btn btn-cart btn-success btn-sm" type="button" onclick="openQuantityModal(${producto.id})">
                                                <i class="fas fa-cart-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                        });

                        // Reasignar el evento click a los nuevos botones de "Añadir al carrito"
                        document.querySelectorAll('.btn-cart').forEach(button => {
                            button.addEventListener('click', function() {
                                const productId = parseInt(this.getAttribute(
                                    'onclick').match(/\d+/)[0]);
                                openQuantityModal(productId);
                            });
                        });
                    }
                })
                .catch(error => console.error('Error:', error));
        });

        // Limpiar búsqueda y recargar productos originales
        document.getElementById('boton-ver-todos').addEventListener('click', function() {
            document.getElementById('buscar-productos').value = '';
            location.reload();
        });
    });

    function openQuantityModal(productoId) {
        // Aquí puedes agregar la lógica para abrir el modal de cantidad y añadir al carrito
        console.log(`Abrir modal para el producto con ID ${productoId}`);
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        function adjustProductNames() {
            const productNames = document.querySelectorAll('.product-name');
            productNames.forEach(function(nameElement) {
                const originalText = nameElement.getAttribute('data-original-text') || nameElement.innerText;
                nameElement.setAttribute('data-original-text', originalText);

                if (window.innerWidth <= 576) {
                    // Para pantallas pequeñas (móviles)
                    nameElement.innerText = originalText.length > 13 ? originalText.substring(0, 13) + '.' : originalText;
                } else {
                    // Para pantallas grandes
                    nameElement.innerText = originalText.length > 22 ? originalText.substring(0, 22) + '.' : originalText;
                }
            });
        }

        adjustProductNames();
        window.addEventListener('resize', adjustProductNames);
    });
</script>

@include('layoutsprincipal.footer')
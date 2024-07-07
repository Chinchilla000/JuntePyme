@include('layoutsprincipal.header')



<!-- Carousel Inicio -->
<div class="container-fluid mb-3">
    <div class="row px-xl-5">
        <div class="col-lg-8">
            <div id="header-carousel" class="carousel slide carousel-fade mb-30 mb-lg-0" data-ride="carousel">
                <ol class="carousel-indicators">
                    @foreach($informaciones as $index => $informacion)
                        @if($informacion->tipo === 'encabezado')
                            <li data-target="#header-carousel" data-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}"></li>
                        @endif
                    @endforeach
                </ol>
                <div class="carousel-inner">
                    @foreach($informaciones as $index => $informacion)
                        @if($informacion->tipo === 'encabezado')
                            <div class="carousel-item position-relative {{ $index == 0 ? 'active' : '' }}" style="height: 430px;">
                                <img class="position-absolute w-100 h-100" src="{{ asset($informacion->imagen) }}" style="object-fit: cover;">
                                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                    <div class="p-3" style="max-width: 700px;">
                                        <h1 class="display-4 text-white mb-3 animate__animated animate__fadeInDown">{{ $informacion->titulo }}</h1>
                                        <p class="mx-md-5 px-5 animate__animated animate__bounceIn">{{ $informacion->descripcion }}</p>
                                        @if($informacion->url)
                                            <a class="btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp" href="{{ $informacion->url }}">Comprar Ahora</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            @foreach($informaciones->where('tipo', 'informativo')->take(2) as $informacion)
                <div class="product-offer mb-30" style="height: 200px;">
                    <img class="img-fluid" src="{{ asset( $informacion->imagen) }}" alt="">
                    <div class="offer-text">
                        <h6 class="text-white text-uppercase">{{ $informacion->titulo }}</h6>
                        <h3 class="text-white mb-3">{{ $informacion->descripcion }}</h3>
                        @if($informacion->url)
                            <a href="{{ $informacion->url }}" class="btn btn-danger">Comprar Ahora</a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
<!-- Carousel Termino -->
<!-- Productos Descuentos -->
<div class="container-fluid pt-5 pb-3">
    <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4">
        <span class="bg-secondary pr-3">Productos con Descuento</span>
    </h2>
    <div id="carouselProductosDescuento" class="carousel slide d-md-none" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach($productos as $index => $producto)
                @if ($producto->descuento)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        <div class="col-12 mb-4">
                            <div class="product-item bg-light h-100 p-3 position-relative">
                                <div class="product-img position-relative overflow-hidden" style="height: 250px;">
                                    <a href="{{ url('/productodetalle', $producto->id) }}">
                                        <img class="img-fluid w-100 h-100" src="{{ asset('storage/imagenes_productos/' . $producto->imagen_producto) }}" style="object-fit: contain; object-position: center;" alt="{{ $producto->nombre }}">
                                    </a>
                                    <div class="position-absolute top-0 start-0 m-2">
                                        <span class="badge bg-danger text-white">Con Descuento</span>
                                    </div>
                                </div>
                                <div class="text-center py-4">
                                    <a class="h6 text-decoration-none text-truncate" href="{{ url('/productodetalle', $producto->id) }}">{{ $producto->nombre }}</a>
                                    <div class="d-flex align-items-center justify-content-center mt-2">
                                        <h5 class="text-danger">${{ number_format($producto->precio_final, 0) }}</h5>
                                        <h6 class="text-muted ml-2"><del>${{ number_format($producto->precio_venta_bruto, 0) }}</del></h6>
                                    </div>
                                    <div class="d-flex justify-content-center mt-2">
                                        <a class="btn btn-danger btn-sm mx-1 btn-ver-detalle" href="{{ route('productosVentas.show', $producto->id) }}">
                                            <i class="fa fa-search"></i> Ver Detalle
                                        </a>
                                        <a class="btn btn-danger btn-sm mx-1 btn-agregar-carrito" href="#" data-producto-id="{{ $producto->id }}">
                                            <i class="fa fa-shopping-cart"></i> Añadir al Carrito
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselProductosDescuento" data-bs-slide="prev" style="width: 10%;">
            <span class="carousel-control-prev-icon" aria-hidden="true" style="display:none;"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselProductosDescuento" data-bs-slide="next" style="width: 10%;">
            <span class="carousel-control-next-icon" aria-hidden="true" style="display:none;"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <div class="row px-xl-5 d-none d-md-flex">
        @foreach($productos as $producto)
            @if ($producto->descuento)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="product-item bg-light h-100 p-3 position-relative">
                        <div class="product-img position-relative overflow-hidden" style="height: 250px;">
                            <a href="{{ url('/productodetalle', $producto->id) }}">
                                <img class="img-fluid w-100 h-100" src="{{ asset('storage/imagenes_productos/' . $producto->imagen_producto) }}" style="object-fit: contain; object-position: center;" alt="{{ $producto->nombre }}">
                            </a>
                            <div class="position-absolute top-0 start-0 m-2">
                                <span class="badge bg-danger text-white">Con Descuento</span>
                            </div>
                        </div>
                        <div class="text-center py-4">
                            <a class="h6 text-decoration-none text-truncate" href="{{ url('/productodetalle', $producto->id) }}">{{ $producto->nombre }}</a>
                            <div class="d-flex align-items-center justify-content-center mt-2">
                                <h5 class="text-danger">${{ number_format($producto->precio_final, 0) }}</h5>
                                <h6 class="text-muted ml-2"><del>${{ number_format($producto->precio_venta_bruto, 0) }}</del></h6>
                            </div>
                            <div class="d-flex justify-content-center mt-2">
                                <a class="btn btn-danger btn-sm mx-1 btn-ver-detalle" href="{{ route('productosVentas.show', $producto->id) }}">
                                    <i class="fa fa-search"></i> Ver Detalle
                                </a>
                                <a class="btn btn-danger btn-sm mx-1 btn-agregar-carrito" href="#" data-producto-id="{{ $producto->id }}">
                                    <i class="fa fa-shopping-cart"></i> Añadir al Carrito
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>
<!-- Productos Termino -->

<style>
    .btn-danger, .btn-danger:hover, .btn-danger:active, .btn-danger:focus, .btn-danger:visited {
        background-color: #dc3545 !important;
        border-color: #dc3545 !important;
        color: #fff !important;
    }

    .btn-ver-detalle, .btn-agregar-carrito {
        background-color: #dc3545 !important;
        border-color: #dc3545 !important;
        color: #fff !important;
    }

    .btn-ver-detalle:hover, .btn-agregar-carrito:hover {
        background-color: #c82333 !important;
        border-color: #bd2130 !important;
        color: #fff !important;
    }

    .btn-ver-detalle i, .btn-agregar-carrito i {
        color: #fff !important;
    }

    .btn-ver-detalle:hover i, .btn-agregar-carrito:hover i {
        color: #fff !important;
    }

    .carousel-control-prev, .carousel-control-next {
        width: 10%;
        background: transparent;
        border: none;
    }

    .carousel-control-prev:hover, .carousel-control-next:hover,
    .carousel-control-prev:focus, .carousel-control-next:focus {
        background: transparent;
        border: none;
    }

    .carousel-control-prev::before, .carousel-control-next::before {
        content: '';
    }

    .carousel-inner .carousel-item {
        transition: transform 0.6s ease-in-out, opacity 0.6s ease-in-out;
    }

    @media (max-width: 767.98px) {
        .carousel-item {
            opacity: 0;
            transition: opacity 0.6s ease-in-out;
        }
        .carousel-item.active {
            opacity: 1;
        }
    }
</style>


<!-- Featured Start -->
<div class="container-fluid pt-5">
    <div class="row px-xl-5 pb-3">
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                <h1 class="fa fa-cart-plus text-danger m-0 mr-3" style="font-size: 2em;"></h1>
                <h5 class="font-weight-semi-bold m-0">Agregar Productos al Carrito</h5>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                <h1 class="fa fa-paper-plane text-danger m-0 mr-3" style="font-size: 2em;"></h1>
                <h5 class="font-weight-semi-bold m-0">Enviar Solicitud de Compra</h5>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                <h1 class="fa fa-check-circle text-danger m-0 mr-3" style="font-size: 2em;"></h1>
                <h5 class="font-weight-semi-bold m-0">Confirmación de Stock y Pago</h5>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center bg-light mb-4" style="padding: 19px;">
                <h1 class="fa fa-truck text-danger m-0 mr-3" style="font-size: 2em;"></h1>
                <h5 class="font-weight-semi-bold m-0">Retiro en Tienda o Despacho Gratis en Chiloé</h5>
            </div>
        </div>
    </div>
</div>
<!-- Featured End -->



<!-- Categorias Inicio -->
<div class="container-fluid pt-5">
    <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4">
        <span class="bg-secondary pr-3">Categorías</span>
    </h2>
    <div class="row px-xl-5 pb-3">
        @foreach($categoriasPadre as $categoria)
            <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                <a class="text-decoration-none" href="{{ route('productosVentas.categoria', $categoria->id) }}">
                    <div class="cat-item d-flex align-items-center mb-4">
                        <div class="overflow-hidden" style="width: 100px; height: 100px;">
                            <img class="img-fluid" src="{{ asset('storage/imagenes_categorias/' . $categoria->imagen_categoria) }}" alt="{{ $categoria->nombre }}">
                        </div>
                        <div class="flex-fill pl-3">
                            <h6>{{ $categoria->nombre }}</h6>
                            <small class="text-body">{{ $categoria->descripcion }}</small>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>
<!-- Categorias Termino -->

<!-- Custom CSS for Hover Effect -->
<style>
    .cat-item:hover {
        background-color: #dc3545 !important; /* Color rojo */
    }
    .cat-item:hover h6,
    .cat-item:hover small {
        color: white !important;
    }
</style>



<!-- Script para cargar la pagina cuando agrega al carrito -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        function agregarProductoAlCarrito(productoId) {
            fetch('{{ route("carrito.agregar-ajax") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ producto_id: productoId, cantidad: 1 })
            }).then(response => response.json()).then(data => {
                if (data.success) {
                    console.log('Producto agregado al carrito');
                    // Actualizar el contador del carrito en la barra de navegación
                    const carritoCountElement = document.querySelector('.fa-shopping-cart + .badge');
                    if (carritoCountElement) {
                        carritoCountElement.textContent = data.count;
                    }
                    // Mostrar el modal de confirmación
                    var successCarritoModal = new bootstrap.Modal(document.getElementById('successCarritoModal'), {});
                    successCarritoModal.show();
    
                    // Recargar la página después de cerrar el modal
                    document.getElementById('closeCarritoModalBtn').addEventListener('click', function () {
                        location.reload();
                    });
    
                    // También recargar la página cuando el modal se oculta automáticamente
                    document.getElementById('successCarritoModal').addEventListener('hidden.bs.modal', function () {
                        location.reload();
                    });
                } else {
                    console.error('Error al agregar el producto al carrito');
                }
            }).catch(error => {
                console.error('Error en la solicitud:', error);
            });
        }
    
        // Agregar evento de clic a todos los botones de agregar al carrito
        document.querySelectorAll('.btn-agregar-carrito').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault(); // Evitar la acción predeterminada del enlace
                const productoId = this.dataset.productoId;
                agregarProductoAlCarrito(productoId);
            });
        });
    });
</script>
    <!-- Modal de éxito para carrito -->
<div class="modal fade" id="successCarritoModal" tabindex="-1" aria-labelledby="successCarritoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title text-white" id="successCarritoModalLabel">Producto agregado al carrito</h5>
            </div>
            <div class="modal-body text-center">
                <i class="fa fa-check-circle fa-3x text-success mb-3"></i>
                <p class="mb-0">Producto agregado al carrito exitosamente.</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="closeCarritoModalBtn">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<!-- Informativo Inicio -->
<div class="container-fluid pt-5 pb-3">
    <div class="row px-xl-5">
        @foreach($informacionesI as $informacion)
            <div class="col-md-6">
                <div class="product-offer mb-30" style="height: 300px;">
                    <img class="img-fluid" src="{{ asset( $informacion->imagen) }}" alt="{{ $informacion->titulo }}">
                    <div class="offer-text">
                        <h6 class="text-white text-uppercase">{{ $informacion->titulo }}</h6>
                        <h3 class="text-white mb-3">{{ $informacion->descripcion }}</h3>
                        @if($informacion->url)
                            <a href="{{ $informacion->url }}" class="btn btn-primary">Shop Now</a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
<!-- Informativo Termino -->

<!-- Productos Inicio -->
<div class="container-fluid pt-5 pb-3">
    <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4">
        <span class="bg-secondary pr-3">Productos</span>
    </h2>
    <div id="carouselProductos" class="carousel slide d-md-none" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach($productos as $index => $producto)
                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                    <div class="col-12 mb-4">
                        <div class="product-item bg-light h-100">
                            <div class="product-img position-relative overflow-hidden" style="height: 250px;">
                                <img class="img-fluid w-100 h-100" src="{{ asset('storage/imagenes_productos/' . $producto->imagen_producto) }}" style="object-fit: contain; object-position: center;" alt="{{ $producto->nombre }}">
                            </div>
                            <div class="text-center py-4">
                                <a class="h6 text-decoration-none text-truncate" href="{{ url('/productodetalle', $producto->id) }}">{{ $producto->nombre }}</a>
                                <div class="d-flex align-items-center justify-content-center mt-2">
                                    <h5 class="text-danger">${{ number_format($producto->precio_final, 0) }}</h5>
                                    @if ($producto->descuento)
                                        <h6 class="text-muted ml-2"><del>${{ number_format($producto->precio_venta_bruto, 0) }}</del></h6>
                                    @endif
                                </div>
                                <div class="d-flex justify-content-center mt-2">
                                    <a class="btn btn-danger btn-sm mx-1 btn-ver-detalle" href="{{ route('productosVentas.show', $producto->id) }}">
                                        <i class="fa fa-search"></i> Ver Detalle
                                    </a>
                                    <a class="btn btn-danger btn-sm mx-1 btn-agregar-carrito" href="#" data-producto-id="{{ $producto->id }}">
                                        <i class="fa fa-shopping-cart"></i> Añadir al Carrito
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselProductos" data-bs-slide="prev" style="width: 10%;">
            <span class="carousel-control-prev-icon" aria-hidden="true" style="display:none;"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselProductos" data-bs-slide="next" style="width: 10%;">
            <span class="carousel-control-next-icon" aria-hidden="true" style="display:none;"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <div class="row px-xl-5 d-none d-md-flex">
        @foreach($productos as $producto)
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="product-item bg-light h-100">
                    <div class="product-img position-relative overflow-hidden" style="height: 250px;">
                        <img class="img-fluid w-100 h-100" src="{{ asset('storage/imagenes_productos/' . $producto->imagen_producto) }}" style="object-fit: contain; object-position: center;" alt="{{ $producto->nombre }}">
                    </div>
                    <div class="text-center py-4">
                        <a class="h6 text-decoration-none text-truncate" href="{{ url('/productodetalle', $producto->id) }}">{{ $producto->nombre }}</a>
                        <div class="d-flex align-items-center justify-content-center mt-2">
                            <h5 class="text-danger">${{ number_format($producto->precio_final, 0) }}</h5>
                            @if ($producto->descuento)
                                <h6 class="text-muted ml-2"><del>${{ number_format($producto->precio_venta_bruto, 0) }}</del></h6>
                            @endif
                        </div>
                        <div class="d-flex justify-content-center mt-2">
                            <a class="btn btn-danger btn-sm mx-1 btn-ver-detalle" href="{{ route('productosVentas.show', $producto->id) }}">
                                <i class="fa fa-search"></i> Ver Detalle
                            </a>
                            <a class="btn btn-danger btn-sm mx-1 btn-agregar-carrito" href="#" data-producto-id="{{ $producto->id }}">
                                <i class="fa fa-shopping-cart"></i> Añadir al Carrito
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
<!-- Productos Termino -->

<style>
    .btn-danger, .btn-danger:hover, .btn-danger:active, .btn-danger:focus {
        background-color: #dc3545 !important;
        border-color: #dc3545 !important;
        color: #fff !important;
    }

    .btn-ver-detalle, .btn-agregar-carrito {
        background-color: #dc3545 !important;
        border-color: #dc3545 !important;
        color: #fff !important;
    }

    .btn-ver-detalle:hover, .btn-agregar-carrito:hover {
        background-color: #c82333 !important;
        border-color: #bd2130 !important;
        color: #fff !important;
    }

    .carousel-control-prev, .carousel-control-next {
        width: 10%;
        background: transparent;
        border: none;
    }

    .carousel-control-prev:hover, .carousel-control-next:hover,
    .carousel-control-prev:focus, .carousel-control-next:focus {
        background: transparent;
        border: none;
    }

    .carousel-control-prev::before, .carousel-control-next::before {
        content: '';
    }

    .carousel-inner .carousel-item {
        transition: transform 0.6s ease-in-out, opacity 0.6s ease-in-out;
    }

    @media (max-width: 767.98px) {
        .carousel-item {
            opacity: 0;
            transition: opacity 0.6s ease-in-out;
        }
        .carousel-item.active {
            opacity: 1;
        }
    }
</style>

@extends('layoutsprincipal.footer')
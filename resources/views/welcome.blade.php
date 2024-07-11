@include('layoutsprincipal.header')
<!-- Incluir jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Incluir Owl Carousel JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>



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
    <div class="owl-carousel vendor-carousel">
        @foreach ($productos as $producto)
            @if ($producto->descuento)
                <div class="bg-light p-4 text-center product-card">
                    <img class="img-fluid" src="{{ asset('storage/imagenes_productos/' . $producto->imagen_producto) }}" alt="{{ $producto->nombre }}">
                    <div class="py-2">
                        <h5 class="h6">{{ $producto->nombre }}</h5>
                        <div class="d-flex justify-content-center align-items-center">
                            <h6 class="text-danger m-0">${{ number_format($producto->precio_final, 0) }}</h6>
                            <h6 class="text-muted ml-2 m-0">
                                <del>${{ number_format($producto->precio_venta_bruto, 0) }}</del>
                            </h6>
                        </div>
                        <div class="d-flex justify-content-center mt-2">
                            <a class="btn btn-danger btn-sm mx-1 btn-ver-detalle" href="{{ route('productosVentas.show', $producto->id) }}">
                                <i class="fa fa-search"></i>
                            </a>
                            <a class="btn btn-danger btn-sm mx-1 btn-agregar-carrito" href="#" data-producto-id="{{ $producto->id }}">
                                <i class="fa fa-shopping-cart"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>

<!-- Productos Termino -->

<style>
   .product-card {
    width: 100%;
    max-width: 250px;
    height: 320px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: center;
    margin: 0 auto;
    padding: 20px 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    background: #fff;
    overflow: hidden;
}

.product-card img {
    width: 100%;
    height: 150px;
    object-fit: contain;
    margin-bottom: 10px;
}

.product-card h5, .product-card h6 {
    white-space: normal;
    overflow: hidden;
    text-overflow: ellipsis;
    width: 100%;
    text-align: center;
    margin-bottom: 10px;
}

.btn-danger, .btn-danger:hover, .btn-danger:active, .btn-danger:focus, .btn-danger:visited {
    background-color: #dc3545 !important;
    border-color: #dc3545 !important;
    color: #fff !important;
}

.vendor-carousel .owl-nav button.owl-prev,
.vendor-carousel .owl-nav button.owl-next {
    position: absolute;
    top: 35%;
    background: #dc3545;
    color: white;
    border-radius: 50%;
    width: 35px;
    height: 35px;
    border: none;
    font-size: 16px;
}

@media (max-width: 576px) {
    .product-card {
        max-width: 100%;
        height: 340px;
    }

    .product-card img {
        height: 170px;
    }
}

</style>

<script>
    $(document).ready(function() {
        $(".vendor-carousel").owlCarousel({
            loop: true,
            margin: 10,
            nav: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 2
                },
                1000: {
                    items: 4
                }
            }
        });
    });
</script>


<!-- Que hacemos -->
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
<!-- Que hacemos -->
<style>
    @media (max-width: 768px) {
        .d-flex {
            padding: 15px !important;
        }
        .d-flex h1 {
            font-size: 1.5em !important;
        }
    }
</style>


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
            <div class="col-md-6 col-sm-12">
                <div class="product-offer mb-30" style="height: 200px;">
                    <img class="img-fluid w-100" src="{{ asset($informacion->imagen) }}" alt="{{ $informacion->titulo }}" style="height: 100%;">
                    <div class="offer-text">
                        <h6 class="text-white text-uppercase">{{ $informacion->titulo }}</h6>
                        <h3 class="text-white mb-3">{{ \Illuminate\Support\Str::limit($informacion->descripcion, 50) }}</h3>
                        @if($informacion->url)
                            <a href="{{ $informacion->url }}" class="btn btn-primary btn-sm">Shop Now</a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
<!-- Informativo Termino -->

<style>
    .product-offer {
        position: relative;
        overflow: hidden;
    }
    .product-offer img {
        object-fit: cover;
        height: 100%;
    }
    .offer-text {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        padding: 20px;
    }
    .offer-text h6, .offer-text h3 {
        margin: 0;
    }
    .offer-text .btn {
        margin-top: 10px;
    }

    @media (max-width: 767px) {
        .product-offer {
            height: 150px;
        }
        .offer-text h6 {
            font-size: 0.9rem;
        }
        .offer-text h3 {
            font-size: 1.1rem;
        }
        .offer-text .btn {
            font-size: 0.8rem;
            padding: 0.3rem 0.6rem;
        }
    }
</style>

<!-- Productos Inicio -->
<!-- Carrusel Inicio -->
<div class="container-fluid py-5">
    <div class="row px-xl-5">
        <div class="col">
            <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4">
                <span class="bg-secondary pr-3">Todos los productos</span>
            </h2>
            <div class="owl-carousel vendor-carousel">
    @foreach($productos as $producto)
        <div class="bg-light p-4 text-center product-card">
            <img class="img-fluid" src="{{ asset('storage/imagenes_productos/' . $producto->imagen_producto) }}" alt="{{ $producto->nombre }}">
            <div class="py-2">
                <h5 class="h6">{{ $producto->nombre }}</h5>
                <div class="d-flex justify-content-center align-items-center">
                    <h6 class="text-danger m-0">${{ number_format($producto->precio_final, 0) }}</h6>
                    @if ($producto->descuento)
                        <h6 class="text-muted ml-2 m-0">
                            <del>${{ number_format($producto->precio_venta_bruto, 0) }}</del>
                        </h6>
                    @endif
                </div>
                <div class="d-flex justify-content-center mt-2">
                    <a class="btn btn-danger btn-sm mx-1 btn-ver-detalle" href="{{ route('productosVentas.show', $producto->id) }}">
                        <i class="fa fa-search"></i>
                    </a>
                    <a class="btn btn-danger btn-sm mx-1 btn-agregar-carrito" href="#" data-producto-id="{{ $producto->id }}">
                        <i class="fa fa-shopping-cart"></i>
                    </a>
                </div>
            </div>
        </div>
    @endforeach
</div>

        </div>
    </div>
</div>
<!-- Carrusel Final -->

<script>
    $(document).ready(function(){
        $(".vendor-carousel").owlCarousel({
            loop: true,
            margin: 10,
            nav: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 2
                },
                1000: {
                    items: 4
                }
            }
        });
    });
</script>

<style>
  .product-card {
    width: 100%;
    max-width: 250px; /* Ajusta el tamaño según tu diseño */
    height: 320px; /* Altura fija para todos los cards */
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: center;
    margin: 0 auto;
    padding: 20px 10px; /* Añade más espacio en la parte inferior */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    background: #fff;
    overflow: hidden; /* Asegura que nada se salga del card */
}

.product-card img {
    width: 100%;
    height: 150px; /* Altura fija para las imágenes */
    object-fit: contain;
    margin-bottom: 10px;
}

.product-card h5 {
    white-space: normal; /* Permite el salto de línea */
    overflow: hidden;
    text-overflow: ellipsis;
    width: 100%;
    text-align: center;
    margin-bottom: 10px;
}

.product-card .btn-container {
    width: 100%;
    display: flex;
    justify-content: space-around;
}

.vendor-carousel .owl-nav button.owl-prev,
.vendor-carousel .owl-nav button.owl-next {
    position: absolute;
    top: 35%;
    background: #dc3545;
    color: white;
    border-radius: 50%;
    width: 35px;
    height: 35px;
    border: none;
    font-size: 16px;
}

.vendor-carousel .owl-nav button.owl-prev {
    left: -15px;
}

.vendor-carousel .owl-nav button.owl-next {
    right: -15px;
}

.btn-danger, .btn-danger:hover, .btn-danger:active, .btn-danger:focus {
    background-color: #dc3545 !important;
    border-color: #dc3545 !important;
    color: #fff !important;
}

.btn-ver-detalle, .btn-agregar-carrito {
    background-color: #dc3545 !important;
    border-color: #dc3545 !important;
    color: #fff !important;
    font-size: 12px;
    padding: 5px 10px;
}

.btn-ver-detalle:hover, .btn-agregar-carrito:hover {
    background-color: #c82333 !important;
    border-color: #bd2130 !important;
    color: #fff !important;
}

@media (max-width: 576px) {
    .product-card {
        max-width: 100%;
        height: 340px; /* Altura fija para vista móvil también */
    }

    .product-card img {
        height: 170px; /* Altura fija para las imágenes en móvil */
    }

    .vendor-carousel .owl-nav button.owl-prev,
    .vendor-carousel .owl-nav button.owl-next {
        width: 30px;
        height: 30px;
        font-size: 14px;
    }
}


</style>
@extends('layoutsprincipal.footer')
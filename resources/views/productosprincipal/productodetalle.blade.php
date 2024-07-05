@include('layoutsprincipal.header')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">



        <!-- Shop Detail Start -->
        <div class="container-fluid pb-5">
            <div class="row px-xl-5">
                <div class="col-lg-5 mb-30">
                    <div id="product-carousel" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner bg-light">
                            @if($producto->imagenes && count($producto->imagenes) > 0)
                            @foreach($producto->imagenes as $imagen)
                                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                    <img class="w-100 h-100" src="{{ asset('storage/imagenes_productos/' . $imagen->url) }}" alt="{{ $producto->nombre }}">
                                </div>
                            @endforeach
                        @else
                            <div class="carousel-item active">
                                <img class="w-100 h-100" src="{{ asset('storage/imagenes_productos/' . $producto->imagen_producto) }}" alt="{{ $producto->nombre }}">
                            </div>
                        @endif
                        
                        </div>
                        <a class="carousel-control-prev" href="#product-carousel" data-slide="prev">
                            <i class="fa fa-2x fa-angle-left text-dark"></i>
                        </a>
                        <a class="carousel-control-next" href="#product-carousel" data-slide="next">
                            <i class="fa fa-2x fa-angle-right text-dark"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-7 h-auto mb-30">
                    <div class="h-100 bg-light p-30">
                        <h3>{{ $producto->nombre }}</h3>
                        <div class="d-flex mb-3">
                            <div class="text-danger mr-2">
                                @for ($i = 0; $i < 5; $i++)
                                    @if ($i < $producto->rating)
                                        <small class="fas fa-star"></small>
                                    @elseif ($i < $producto->rating + 0.5)
                                        <small class="fas fa-star-half-alt"></small>
                                    @else
                                        <small class="far fa-star"></small>
                                    @endif
                                @endfor
                            </div>
                            <small class="pt-1">({{ $producto->reviews_count }} Opiniones)</small>
                        </div>
                        <h3 class="font-weight-semi-bold mb-4">${{ number_format($producto->precio_final, 0) }}</h3>
                        <p class="mb-4">{{ $producto->descripcion }}</p>

                        <div class="d-flex align-items-center mb-4 pt-2">
                            <div class="input-group quantity mr-3" style="width: 130px;">
                                <div class="input-group-btn">
                                    <button class="btn btn-danger btn-minus">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                </div>
                                <input type="text" class="form-control bg-secondary border-0 text-center" value="1">
                                <div class="input-group-btn">
                                    <button class="btn btn-danger btn-plus">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <button class="btn btn-danger px-3"><i class="fa fa-shopping-cart mr-1"></i> Añadir al Carrito</button>
                        </div>
                        <div class="d-flex pt-2">
                            <strong class="text-dark mr-2">Compartir en:</strong>
                            <div class="d-inline-flex">
                                <a class="text-dark px-2" href="">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a class="text-dark px-2" href="">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a class="text-dark px-2" href="">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                                <a class="text-dark px-2" href="">
                                    <i class="fab fa-pinterest"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row px-xl-5">
                <div class="col">
                    <div class="bg-light p-30">
                        <div class="nav nav-tabs mb-4">
                            <a class="nav-item nav-link text-dark active" data-toggle="tab" href="#tab-pane-1">Descripción</a>
                            <a class="nav-item nav-link text-dark" data-toggle="tab" href="#tab-pane-2">Información</a>
                            <a class="nav-item nav-link text-dark" data-toggle="tab" href="#tab-pane-3">Opiniones ({{ $producto->reviews_count }})</a>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="tab-pane-1">
                                <h4 class="mb-3">Descripción del Producto</h4>
                                <p>{{ $producto->descripcion_detallada }}</p>
                            </div>
                            <div class="tab-pane fade" id="tab-pane-2">
                                <h4 class="mb-3">Información Adicional</h4>
                                <p>{{ $producto->informacion_adicional }}</p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item px-0">
                                                Detalle 1 del producto.
                                            </li>
                                            <li class="list-group-item px-0">
                                                Detalle 2 del producto.
                                            </li>
                                            <li class="list-group-item px-0">
                                                Detalle 3 del producto.
                                            </li>
                                            <li class="list-group-item px-0">
                                                Detalle 4 del producto.
                                            </li>
                                          </ul> 
                                    </div>
                                    <div class="col-md-6">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item px-0">
                                                Detalle 5 del producto.
                                            </li>
                                            <li class="list-group-item px-0">
                                                Detalle 6 del producto.
                                            </li>
                                            <li class="list-group-item px-0">
                                                Detalle 7 del producto.
                                            </li>
                                            <li class="list-group-item px-0">
                                                Detalle 8 del producto.
                                            </li>
                                          </ul> 
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tab-pane-3">
                                <div class="row">
                                    
                                    <div class="col-md-6">
                                        <h4 class="mb-4">Deja tu opinión</h4>
                                        <small>Tu dirección de correo electrónico no será publicada. Los campos obligatorios están marcados con *</small>
                                        <div class="d-flex my-3">
                                            <p class="mb-0 mr-2">Tu Calificación * :</p>
                                            <div class="text-danger">
                                                @for ($i = 0; $i < 5; $i++)
                                                    <i class="far fa-star"></i>
                                                @endfor
                                            </div>
                                        </div>
                                        <form action="{{ route('comentarios.store', $producto->id) }}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label for="message">Tu Opinión *</label>
                                                <textarea id="message" name="contenido" cols="30" rows="5" class="form-control" required></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Tu Nombre *</label>
                                                <input type="text" class="form-control" id="name" name="nombre" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Tu Email *</label>
                                                <input type="email" class="form-control" id="email" name="email" required>
                                            </div>
                                            <div class="form-group mb-0">
                                                <input type="submit" value="Enviar Opinión" class="btn btn-danger px-3">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Shop Detail End -->

        <!-- Products Start -->
        <div class="container-fluid py-5">
            <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">También te puede interesar</span></h2>
            <div class="row px-xl-5">
                <div class="col">
                    <div class="owl-carousel related-carousel">
                        <div class="product-item bg-light">
                            <div class="product-img position-relative overflow-hidden">
                                <img class="img-fluid w-100" src="{{ asset('img/product-1.jpg') }}" alt="">
                                <div class="product-action">
                                    <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                                    <a class="btn btn-outline-dark btn-square" href=""><i class="far fa-heart"></i></a>
                                    <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-sync-alt"></i></a>
                                    <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-search"></i></a>
                                </div>
                            </div>
                            <div class="text-center py-4">
                                <a class="h6 text-decoration-none text-truncate" href="">Nombre del Producto</a>
                                <div class="d-flex align-items-center justify-content-center mt-2">
                                    <h5>$123.00</h5><h6 class="text-muted ml-2"><del>$123.00</del></h6>
                                </div>
                                <div class="d-flex align-items-center justify-content-center mb-1">
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small>(99)</small>
                                </div>
                            </div>
                        </div>
                        <div class="product-item bg-light">
                            <div class="product-img position-relative overflow-hidden">
                                <img class="img-fluid w-100" src="{{ asset('img/product-2.jpg') }}" alt="">
                                <div class="product-action">
                                    <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                                    <a class="btn btn-outline-dark btn-square" href=""><i class="far fa-heart"></i></a>
                                    <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-sync-alt"></i></a>
                                    <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-search"></i></a>
                                </div>
                            </div>
                            <div class="text-center py-4">
                                <a class="h6 text-decoration-none text-truncate" href="">Nombre del Producto</a>
                                <div class="d-flex align-items-center justify-content-center mt-2">
                                    <h5>$123.00</h5><h6 class="text-muted ml-2"><del>$123.00</del></h6>
                                </div>
                                <div class="d-flex align-items-center justify-content-center mb-1">
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small>(99)</small>
                                </div>
                            </div>
                        </div>
                        <div class="product-item bg-light">
                            <div class="product-img position-relative overflow-hidden">
                                <img class="img-fluid w-100" src="{{ asset('img/product-3.jpg') }}" alt="">
                                <div class="product-action">
                                    <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                                    <a class="btn btn-outline-dark btn-square" href=""><i class="far fa-heart"></i></a>
                                    <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-sync-alt"></i></a>
                                    <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-search"></i></a>
                                </div>
                            </div>
                            <div class="text-center py-4">
                                <a class="h6 text-decoration-none text-truncate" href="">Nombre del Producto</a>
                                <div class="d-flex align-items-center justify-content-center mt-2">
                                    <h5>$123.00</h5><h6 class="text-muted ml-2"><del>$123.00</del></h6>
                                </div>
                                <div class="d-flex align-items-center justify-content-center mb-1">
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small>(99)</small>
                                </div>
                            </div>
                        </div>
                        <div class="product-item bg-light">
                            <div class="product-img position-relative overflow-hidden">
                                <img class="img-fluid w-100" src="{{ asset('img/product-4.jpg') }}" alt="">
                                <div class="product-action">
                                    <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                                    <a class="btn btn-outline-dark btn-square" href=""><i class="far fa-heart"></i></a>
                                    <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-sync-alt"></i></a>
                                    <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-search"></i></a>
                                </div>
                            </div>
                            <div class="text-center py-4">
                                <a class="h6 text-decoration-none text-truncate" href="">Nombre del Producto</a>
                                <div class="d-flex align-items-center justify-content-center mt-2">
                                    <h5>$123.00</h5><h6 class="text-muted ml-2"><del>$123.00</del></h6>
                                </div>
                                <div class="d-flex align-items-center justify-content-center mb-1">
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small>(99)</small>
                                </div>
                            </div>
                        </div>
                        <div class="product-item bg-light">
                            <div class="product-img position-relative overflow-hidden">
                                <img class="img-fluid w-100" src="{{ asset('img/product-5.jpg') }}" alt="">
                                <div class="product-action">
                                    <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                                    <a class="btn btn-outline-dark btn-square" href=""><i class="far fa-heart"></i></a>
                                    <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-sync-alt"></i></a>
                                    <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-search"></i></a>
                                </div>
                            </div>
                            <div class="text-center py-4">
                                <a class="h6 text-decoration-none text-truncate" href="">Nombre del Producto</a>
                                <div class="d-flex align-items-center justify-content-center mt-2">
                                    <h5>$123.00</h5><h6 class="text-muted ml-2"><del>$123.00</del></h6>
                                </div>
                                <div class="d-flex align-items-center justify-content-center mb-1">
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small>(99)</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Products End -->

<script>
    function openQuantityModal(productoId) {
        console.log("ID solicitado:", productoId);
        // Aquí puedes agregar la lógica para abrir el modal de cantidad y añadir al carrito
        console.log(`Abrir modal para el producto con ID ${productoId}`);
        // Suponemos que tienes una función para mostrar el modal
        const modalElement = document.getElementById('quantityModal'); // Asegúrate de que el ID corresponde a tu modal
        if (modalElement) {
            const modal = new bootstrap.Modal(modalElement);
            modal.show();
        }
    }
    </script>
    
@include('layoutsprincipal.footer')
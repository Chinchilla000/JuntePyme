@include('layoutsprincipal.header')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<!-- Shop Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <!-- Productos filtrar -->
        <div class="col-lg-3 col-md-4">
            <!-- Marca Start -->
            <h5 class="section-title position-relative text-uppercase mb-3">
                <span class="bg-secondary pr-3 d-block d-lg-none" data-toggle="collapse" data-target="#filter-marca"
                    aria-expanded="true" aria-controls="filter-marca">Filtra Por Marca</span>
                <span class="bg-secondary pr-3 d-none d-lg-block">Filtra Por Marca</span>
            </h5>
            <div class="bg-light p-4 mb-30 collapse show d-lg-block" id="filter-marca">
                <form method="GET" action="{{ route('productosVentas.categoria', $categoria->id) }}">
                    @foreach ($marcas as $marca)
                        <div
                            class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="brand-{{ $marca }}"
                                name="marca[]" value="{{ $marca }}"
                                {{ in_array($marca, request()->input('marca', [])) ? 'checked' : '' }}>
                            <label class="custom-control-label"
                                for="brand-{{ $marca }}">{{ $marca }}</label>
                        </div>
                    @endforeach
            </div>
            <!-- Marca End -->

            <!-- Price Start -->
            <h5 class="section-title position-relative text-uppercase mb-3">
                <span class="bg-secondary pr-3 d-block d-lg-none" data-toggle="collapse" data-target="#filter-price"
                    aria-expanded="false" aria-controls="filter-price">Filtra Por Precio</span>
                <span class="bg-secondary pr-3 d-none d-lg-block">Filtra Por Precio</span>
            </h5>
            <div class="bg-light p-4 mb-30 collapse d-lg-block" id="filter-price">
                <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                    <input type="checkbox" class="custom-control-input" id="price-all" name="precio_all"
                        {{ request()->has('precio_min') && request()->has('precio_max') ? '' : 'checked' }}>
                    <label class="custom-control-label" for="price-all">Todos los precios</label>
                </div>
                @foreach ($precios as $index => $precio)
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" id="price-{{ $index }}"
                               name="precio[]" value="{{ $precio['min'] . '-' . $precio['max'] }}" {{ in_array($precio['min'] . '-' . $precio['max'], request()->input('precio', [])) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="price-{{ $index }}">${{ number_format($precio['min']) }} - ${{ number_format($precio['max']) }}</label>
                    </div>
                @endforeach
            </div>
            <!-- Price End -->

            <!-- Tipo de Trabajo Start -->
            <h5 class="section-title position-relative text-uppercase mb-3">
                <span class="bg-secondary pr-3 d-block d-lg-none" data-toggle="collapse"
                    data-target="#filter-tipo-trabajo" aria-expanded="false" aria-controls="filter-tipo-trabajo">Filtra
                    Para el tipo de trabajo</span>
                <span class="bg-secondary pr-3 d-none d-lg-block">Filtra Para el tipo de trabajo</span>
            </h5>
            
            <div class="bg-light p-4 mb-30 collapse d-lg-block" id="filter-tipo-trabajo">
                @foreach ($tiposTrabajo as $tipo)
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" id="tipo-{{ $tipo }}"
                            name="tipo_trabajo[]" value="{{ $tipo }}"
                            {{ in_array($tipo, request()->input('tipo_trabajo', [])) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="tipo-{{ $tipo }}">{{ $tipo }}</label>
                    </div>
                @endforeach
            </div>
            <!-- Tipo de Trabajo End -->

            <!-- Otra Especificación Start -->
            <h5 class="section-title position-relative text-uppercase mb-3">
                <span class="bg-secondary pr-3 d-block d-lg-none" data-toggle="collapse"
                    data-target="#filter-otra-especificacion" aria-expanded="false"
                    aria-controls="filter-otra-especificacion">Otras Especificaciones</span>
                <span class="bg-secondary pr-3 d-none d-lg-block">Otras Especificaciones</span>
            </h5>
            <div class="bg-light p-4 mb-30 collapse d-lg-block" id="filter-otra-especificacion">
                @foreach ($otrasEspecificaciones as $especificacion)
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" id="especificacion-{{ $especificacion }}"
                            name="otra_especificacion[]" value="{{ $especificacion }}"
                            {{ in_array($especificacion, request()->input('otra_especificacion', [])) ? 'checked' : '' }}>
                        <label class="custom-control-label"
                            for="especificacion-{{ $especificacion }}">{{ $especificacion }}</label>
                    </div>
                @endforeach
            </div>
            <button type="submit" class="btn btn-danger btn-block">Aplicar Filtros</button>
            </form>
            <br>
            <!-- Otra Especificación End -->
        </div>
        <!-- Productos filtrar -->

        <style>
            .custom-control-input:checked~.custom-control-label::before {
                border-color: #dc3545;
                background-color: #dc3545;
            }
        </style>


        <!-- Productos según la categoría -->
        <div class="col-lg-9 col-md-8">
            <!-- Buscador de Productos -->
            <div class="mt-3 mb-4">
                <form action="{{ route('productosVentas.buscar', ['categoria' => $categoria->id]) }}" method="GET"
                    class="d-flex flex-column flex-lg-row">
                    <div class="d-flex flex-fill">
                        <input type="text" name="query" class="form-control" placeholder="Buscar productos"
                            value="{{ request()->input('query') }}">
                        <button type="submit" class="btn btn-danger ml-2">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                    <div class="mt-2 mt-lg-0 ml-lg-2">
                        <a href="{{ route('productosVentas.categoria', $categoria->id) }}"
                            class="btn btn-danger btn-block">Limpiar Filtros</a>
                    </div>
                </form>
            </div>
            <div class="row pb-3">
                @foreach ($productos as $producto)
                    <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                        <div class="product-item bg-light mb-4 h-100 d-flex flex-column">
                            <div class="product-img position-relative overflow-hidden" style="height: 250px;">
                                <a href="{{ route('productosVentas.show', $producto->id) }}">
                                    <img class="img-fluid w-100 h-100"
                                        src="{{ asset('storage/imagenes_productos/' . $producto->imagen_producto) }}"
                                        style="object-fit: contain; object-position: center;"
                                        alt="{{ $producto->nombre }}">
                                </a>
                                <div class="product-action d-none d-md-flex">
                                    <a class="btn btn-sm btn-danger btn-ver-detalle"
                                        href="{{ route('productosVentas.show', $producto->id) }}">
                                        <i class="fa fa-search"></i> Ver Detalle
                                    </a>
                                </div>
                            </div>
                            <div class="text-center py-4 flex-grow-1 d-flex flex-column justify-content-between">
                                <div>
                                    <a class="h6 text-decoration-none text-truncate"
                                        href="{{ url('/productodetalle', $producto->id) }}">{{ $producto->nombre }}</a>
                                    <div class="d-flex align-items-center justify-content-center mt-2">
                                        <h5 class="text-danger">${{ number_format($producto->precio_final, 0) }}</h5>
                                        @if ($producto->descuento)
                                            <h6 class="text-muted ml-2">
                                                <del>${{ number_format($producto->precio_venta_bruto, 0) }}</del>
                                            </h6>
                                        @endif
                                    </div>
                                    <p class="mt-2">
                                        {{ \Illuminate\Support\Str::limit($producto->descripcion, 100) }}</p>
                                </div>
                                <div class="d-flex flex-column mt-2">
                                    <a class="btn btn-sm btn-danger btn-agregar-carrito mx-auto" href="#"
                                        data-producto-id="{{ $producto->id }}">
                                        <i class="fa fa-shopping-cart"></i> Añadir al Carrito
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="col-12">
                    <nav>
                        <ul class="pagination justify-content-center">
                            {{ $productos->links() }}
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Productos según la categoría -->

        <style>
            .btn-danger,
            .btn-danger:hover,
            .btn-danger:active,
            .btn-danger:focus {
                background-color: #dc3545 !important;
                border-color: #dc3545 !important;
                color: #fff !important;
            }

            .btn-ver-detalle,
            .btn-agregar-carrito {
                background-color: #dc3545 !important;
                border-color: #dc3545 !important;
                color: #fff !important;
            }

            .btn-ver-detalle:hover,
            .btn-agregar-carrito:hover {
                background-color: #c82333 !important;
                border-color: #bd2130 !important;
                color: #fff !important;
            }

            .product-action {
                position: absolute;
                bottom: 10px;
                left: 50%;
                transform: translateX(-50%);
                z-index: 10;
                display: flex;
                justify-content: center;
                opacity: 0;
                transition: opacity 0.3s;
            }

            .product-action a {
                margin: 0 5px;
            }

            .product-img:hover .product-action {
                opacity: 1;
            }

            .d-flex.align-items-center.justify-content-center.mt-2 h5,
            .d-flex.align-items-center.justify-content-center.mt-2 h6 {
                display: inline-block;
                margin: 0 2px;
            }

            .d-flex.justify-content-center.mt-2 a {
                width: calc(50% - 10px);
            }

            .btn-agregar-carrito {
                width: auto;
                /* Ajusta el ancho del botón */
                padding: 5px 10px;
                /* Ajusta el padding para hacer el botón más pequeño */
            }

            @media (min-width: 768px) {
                .product-action {
                    opacity: 1;
                }

                .d-flex.flex-column.mt-2.d-md-none {
                    display: none !important;
                }
            }

            @media (max-width: 767px) {
                .product-action {
                    display: none;
                }
            }
        </style>

    </div>
</div>
<!-- Shop End -->

@include('layoutsprincipal.footer')

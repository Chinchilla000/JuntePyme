@include('layoutsprincipal.header')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">


    <!-- Shop Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <!-- Productos filtrar -->
<div class="col-lg-3 col-md-4">
    <!-- Marca Start -->
    <h5 class="section-title position-relative text-uppercase mb-3">
        <span class="bg-secondary pr-3 d-block d-lg-none" data-toggle="collapse" data-target="#filter-marca" aria-expanded="false" aria-controls="filter-marca">Filtra Por Marca</span>
        <span class="bg-secondary pr-3 d-none d-lg-block">Filtra Por Marca</span>
    </h5>
    <div class="bg-light p-4 mb-30 collapse d-lg-block" id="filter-marca">
        <form method="GET" action="{{ route('productosVentas.categoria', $categoria->id) }}">
            @foreach($marcas as $marca)
                <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                    <input type="checkbox" class="custom-control-input" id="brand-{{ $marca }}" name="marca[]" value="{{ $marca }}" {{ in_array($marca, request()->input('marca', [])) ? 'checked' : '' }}>
                    <label class="custom-control-label" for="brand-{{ $marca }}">{{ $marca }}</label>
                </div>
            @endforeach
    </div>
    <!-- Marca End -->

    <!-- Price Start -->
    <h5 class="section-title position-relative text-uppercase mb-3">
        <span class="bg-secondary pr-3 d-block d-lg-none" data-toggle="collapse" data-target="#filter-price" aria-expanded="false" aria-controls="filter-price">Filtra Por Precio</span>
        <span class="bg-secondary pr-3 d-none d-lg-block">Filtra Por Precio</span>
    </h5>
    <div class="bg-light p-4 mb-30 collapse d-lg-block" id="filter-price">
        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
            <input type="checkbox" class="custom-control-input" id="price-all" name="precio_all" {{ request()->has('precio_min') && request()->has('precio_max') ? '' : 'checked' }}>
            <label class="custom-control-label" for="price-all">Todos los precios</label>
        </div>
        @foreach($precios as $index => $precio)
            <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                <input type="checkbox" class="custom-control-input" id="price-{{ $index }}" name="precio" value="{{ $precio['min'] . '-' . $precio['max'] }}" {{ request()->input('precio') == $precio['min'] . '-' . $precio['max'] ? 'checked' : '' }}>
                <label class="custom-control-label" for="price-{{ $index }}">${{ $precio['min'] }} - ${{ $precio['max'] }}</label>
            </div>
        @endforeach
    </div>
    <!-- Price End -->

    <!-- Tipo de Trabajo Start -->
    <h5 class="section-title position-relative text-uppercase mb-3">
        <span class="bg-secondary pr-3 d-block d-lg-none" data-toggle="collapse" data-target="#filter-tipo-trabajo" aria-expanded="false" aria-controls="filter-tipo-trabajo">Filtra Para el tipo de trabajo</span>
        <span class="bg-secondary pr-3 d-none d-lg-block">Filtra Para el tipo de trabajo</span>
    </h5>
    <div class="bg-light p-4 mb-30 collapse d-lg-block" id="filter-tipo-trabajo">
        @foreach($tiposTrabajo as $tipo)
            <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                <input type="checkbox" class="custom-control-input" id="tipo-{{ $tipo }}" name="tipo_trabajo[]" value="{{ $tipo }}" {{ in_array($tipo, request()->input('tipo_trabajo', [])) ? 'checked' : '' }}>
                <label class="custom-control-label" for="tipo-{{ $tipo }}">{{ $tipo }}</label>
            </div>
        @endforeach
    </div>
    <!-- Tipo de Trabajo End -->

    <!-- Otra Especificación Start -->
    <h5 class="section-title position-relative text-uppercase mb-3">
        <span class="bg-secondary pr-3 d-block d-lg-none" data-toggle="collapse" data-target="#filter-otra-especificacion" aria-expanded="false" aria-controls="filter-otra-especificacion">Otras Especificaciones</span>
        <span class="bg-secondary pr-3 d-none d-lg-block">Otras Especificaciones</span>
    </h5>
    <div class="bg-light p-4 mb-30 collapse d-lg-block" id="filter-otra-especificacion">
        @foreach($otrasEspecificaciones as $especificacion)
            <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                <input type="checkbox" class="custom-control-input" id="especificacion-{{ $especificacion }}" name="otra_especificacion[]" value="{{ $especificacion }}" {{ in_array($especificacion, request()->input('otra_especificacion', [])) ? 'checked' : '' }}>
                <label class="custom-control-label" for="especificacion-{{ $especificacion }}">{{ $especificacion }}</label>
            </div>
        @endforeach
    </div>
    <button type="submit" class="btn btn-primary btn-block">Aplicar Filtros</button>
    </form>
    <br>
    <!-- Otra Especificación End -->
</div>
<!-- Productos filtrar -->


             <!-- Productos segun la categoria -->
                <div class="col-lg-9 col-md-8">
                    <div class="row pb-3">

                        @foreach($productos as $producto)
                            <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                                <div class="product-item bg-light mb-4" style="height: 100%;">
                                    <div class="product-img position-relative overflow-hidden" style="height: 250px;">
                                        <img class="img-fluid w-100 h-100" style="object-fit: contain;" src="{{ asset('storage/imagenes_productos/' . $producto->imagen_producto) }}" alt="{{ $producto->nombre }}">
                                        <div class="product-action">
                                            <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                                            <a class="btn btn-outline-dark btn-square" href=""><i class="far fa-heart"></i></a>
                                            <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-sync-alt"></i></a>
                                            <a class="btn btn-outline-dark btn-square" href="{{ route('productosVentas.show', $producto->id) }}"><i class="fa fa-search"></i></a>
                                        </div>
                                    </div>
                                    <div class="text-center py-4" style="height: 150px;">
                                        <a class="h6 text-decoration-none text-truncate" href="">{{ $producto->nombre }}</a>
                                        <div class="d-flex align-items-center justify-content-center mt-2">
                                            <h5>${{ number_format($producto->precio_final, 0) }}</h5>
                                            @if($producto->precio_venta_bruto != $producto->precio_final)
                                                <h6 class="text-muted ml-2"><del>${{ number_format($producto->precio_venta_bruto, 0) }}</del></h6>
                                            @endif
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
            <!-- Productos segun la categoria -->
        </div>
    </div>
    <!-- Shop End -->


    @include('layoutsprincipal.footer')

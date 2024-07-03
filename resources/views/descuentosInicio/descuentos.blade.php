@include('layoutsprincipal.header')
@include('layoutsprincipal.nav')
<script>
    window.productos = @json($productos->items());
</script>
<section class="py-4"
    style="background-image:url('{{ asset('assets/img/gallery/cta-one-bg.png') }}'); background-size: cover;">
    <div class="d-none d-md-block"><br><br><br></div> <!-- Solo visible en escritorio -->
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-4">
                <h5 class="fw-bold fs-3 fs-lg-5 lh-sm text-danger">
                    @if (request()->is('descuentosProductos'))
                        Productos con Descuento
                    @else
                        Productos
                    @endif
                </h5>
            </div>
            <div class="d-flex flex-wrap align-items-start justify-content-center">
                <div class="col-12 col-md-3 pe-md-4 mb-3 mb-md-0">
                    <div class="mb-4">
                        <h5 class="fw-bold text-md-start text-center">Filtrar por</h5>
                        <div class="accordion" id="filterAccordion">
                            <form id="filterForm" method="GET" action="{{ url()->current() }}">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingBrand">
                                        <button class="accordion-button bg-danger text-white" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseBrand"
                                            aria-expanded="true" aria-controls="collapseBrand">
                                            Marca
                                        </button>
                                    </h2>
                                    <div id="collapseBrand" class="accordion-collapse collapse show"
                                        aria-labelledby="headingBrand">
                                        <div class="accordion-body">
                                            @foreach ($marcas as $marca)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        value="{{ $marca }}" name="marca[]"
                                                        id="brand{{ $marca }}"
                                                        {{ in_array($marca, request()->input('marca', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="brand{{ $marca }}">
                                                        {{ $marca }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingAge">
                                        <button class="accordion-button bg-danger text-white collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseAge"
                                            aria-expanded="false" aria-controls="collapseAge">
                                            Edad Mascota
                                        </button>
                                    </h2>
                                    <div id="collapseAge" class="accordion-collapse collapse"
                                        aria-labelledby="headingAge">
                                        <div class="accordion-body">
                                            @foreach ($edadesMascota as $edad)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        value="{{ $edad }}" name="edad_mascota[]"
                                                        id="age{{ $edad }}"
                                                        {{ in_array($edad, request()->input('edad_mascota', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="age{{ $edad }}">
                                                        {{ $edad }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingSpecialNeeds">
                                        <button class="accordion-button bg-danger text-white collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseSpecialNeeds"
                                            aria-expanded="false" aria-controls="collapseSpecialNeeds">
                                            Necesidades Especiales
                                        </button>
                                    </h2>
                                    <div id="collapseSpecialNeeds" class="accordion-collapse collapse"
                                        aria-labelledby="headingSpecialNeeds">
                                        <div class="accordion-body">
                                            @foreach ($necesidadesEspeciales as $necesidad)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        value="{{ $necesidad }}" name="necesidades_especiales[]"
                                                        id="special{{ $necesidad }}"
                                                        {{ in_array($necesidad, request()->input('necesidades_especiales', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="special{{ $necesidad }}">
                                                        {{ $necesidad }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary mt-3 w-100">Aplicar Filtros</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-9 ps-md-4">
                    <div class="product-filter mb-4">
                        <input type="text" class="form-control" id="buscar-productos"
                            placeholder="Buscar productos...">
                        <button class="btn btn-danger mt-2" id="boton-buscar">Buscar</button>
                    </div>
                    <div class="row gx-3" id="productos-lista">
                        @foreach ($productos as $producto)
                            <div class="col-6 col-lg-3 mb-5 product-card" data-nombre="{{ $producto->nombre }}">
                                <div class="card card-span h-100 rounded-3 shadow-sm hover-shadow position-relative">
                                    <div class="img-container" style="cursor: pointer;">
                                        <a href="{{ url('/productodetalle', $producto->id) }}">
                                            @if ($producto->imagen_producto)
                                                <img class="img-fluid rounded-3 product-image"
                                                    src="{{ asset('storage/imagenes_productos/' . $producto->imagen_producto) }}"
                                                    alt="Producto {{ $producto->nombre }}">
                                            @else
                                                <img class="img-fluid rounded-3 product-image"
                                                    src="{{ asset('assets/img/gallery/default.jpg') }}"
                                                    alt="Default Image">
                                            @endif
                                        </a>
                                        @if ($producto->descuento)
                                            <div class="card-img-overlay ps-0" style="pointer-events: none;">
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
                                            </div>
                                        @endif
                                    </div>
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="fw-bold text-dark product-name">{{ $producto->nombre }}</h5>
                                        <div class="d-flex justify-content-between align-items-center mt-auto">
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
                                                <span
                                                    class="text-1000 fw-bold">${{ number_format($producto->precio_venta_bruto, 0, ',', '.') }}</span>
                                            @endif
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mt-2">
                                            <small class="text-muted">Disponible:
                                                {{ $producto->cantidad_disponible }}</small>
                                            <button class="btn btn-cart btn-success btn-sm " type="button"
                                                onclick="openQuantityModal({{ $producto->id }})">
                                                <i class="fas fa-cart-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-center">
                        {{ $productos->appends(request()->input())->links('vendor.pagination.custom') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('layoutsprincipal.footer')



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

    @media (max-width: 576px) {
        .card-body .btn-cart {
            width: auto;
            padding: 0.5rem 1rem;
        }
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
    }
</style>
<script>
    document.getElementById('buscar-productos').addEventListener('input', function () {
        let searchQuery = this.value.toLowerCase();
        let productCards = document.querySelectorAll('.product-card');
        
        productCards.forEach(function (card) {
            let productName = card.getAttribute('data-nombre').toLowerCase();
            if (productName.includes(searchQuery)) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    });
</script>

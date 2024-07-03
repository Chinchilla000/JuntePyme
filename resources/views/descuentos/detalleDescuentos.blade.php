@extends('layouts.header')

@section('title', 'Detalles del Descuento')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    <h4 class="card-title">Información del Descuento</h4>
                    <p class="card-text"><strong>Nombre:</strong> {{ $descuento->nombre }}</p>
                    <p class="card-text"><strong>Tipo de Descuento:</strong>
                        @if ($descuento->monto)
                            Monto Fijo: ${{ number_format($descuento->monto, 2) }}
                        @elseif ($descuento->porcentaje)
                            Porcentaje: {{ $descuento->porcentaje }}%
                        @elseif ($descuento->codigo_promocional)
                            Código Promocional: {{ $descuento->codigo_promocional }}
                        @endif
                    </p>
                    <p class="card-text"><strong>Fecha de Inicio:</strong> {{ \Carbon\Carbon::parse($descuento->inicio)->format('d/m/Y H:i') }}</p>
                    <p class="card-text"><strong>Fecha de Fin:</strong> {{ \Carbon\Carbon::parse($descuento->fin)->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('descuentos.aplicar', $descuento->id) }}" method="POST">
        @csrf

        <!-- Filtros de búsqueda y selección -->
        <div class="mb-4 d-flex flex-wrap gap-2">
            <input type="text" id="searchItems" class="form-control flex-grow-1" placeholder="Buscar por nombre de producto o categoría">
            <button type="button" class="btn btn-secondary" onclick="selectAll()">Seleccionar Todo</button>
            <button type="button" class="btn btn-secondary" onclick="deselectAll()">Deseleccionar Todo</button>
        </div>

        <div class="accordion" id="accordionExample">
            <!-- Productos -->
            <div class="accordion-item border rounded mb-2">
                <h2 class="accordion-header" id="headingProductos">
                    <button class="accordion-button {{ $productos->where('descuento_id', $descuento->id)->isEmpty() ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapseProductos" aria-expanded="{{ $productos->where('descuento_id', $descuento->id)->isEmpty() ? 'false' : 'true' }}" aria-controls="collapseProductos">
                        Seleccionar Productos
                    </button>
                </h2>
                <div id="collapseProductos" class="accordion-collapse collapse {{ $productos->where('descuento_id', $descuento->id)->isEmpty() ? '' : 'show' }}" aria-labelledby="headingProductos">
                    <div class="accordion-body">
                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4" id="productosContainer">
                            @foreach ($productos as $producto)
                            <div class="col item producto-item">
                                <div class="card h-100 shadow-sm">
                                    <div class="img-container" style="cursor: pointer;">
                                        @if($producto->imagen_producto)
                                            <img class="card-img-top img-fluid rounded-3" src="{{ asset('storage/imagenes_productos/' . $producto->imagen_producto) }}" alt="Producto {{ $producto->nombre }}">
                                        @else
                                            <img class="card-img-top img-fluid rounded-3" src="{{ asset('assets/img/gallery/default.jpg') }}" alt="Default Image">
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $producto->nombre }}</h5>
                                        <p class="card-text">${{ number_format($producto->precio, 2) }}</p>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input item-checkbox" name="productos[]" value="{{ $producto->id }}" {{ $producto->descuento_id == $descuento->id ? 'checked' : '' }}>
                                            <label class="form-check-label">Aplicar Descuento</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Categorías -->
            <div class="accordion-item border rounded mb-2">
                <h2 class="accordion-header" id="headingCategorias">
                    <button class="accordion-button {{ $categorias->where('descuento_id', $descuento->id)->isEmpty() ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCategorias" aria-expanded="{{ $categorias->where('descuento_id', $descuento->id)->isEmpty() ? 'false' : 'true' }}" aria-controls="collapseCategorias">
                        Seleccionar Categorías
                    </button>
                </h2>
                <div id="collapseCategorias" class="accordion-collapse collapse {{ $categorias->where('descuento_id', $descuento->id)->isEmpty() ? '' : 'show' }}" aria-labelledby="headingCategorias">
                    <div class="accordion-body">
                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4" id="categoriasContainer">
                            @foreach ($categorias as $categoria)
                            <div class="col item categoria-item">
                                <div class="card h-100 shadow-sm">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $categoria->nombre }}</h5>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input item-checkbox" name="categorias[]" value="{{ $categoria->id }}" {{ $categoria->descuento_id == $descuento->id ? 'checked' : '' }}>
                                            <label class="form-check-label">Aplicar Descuento</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Subcategorías -->
            <div class="accordion-item border rounded mb-2">
                <h2 class="accordion-header" id="headingSubcategorias">
                    <button class="accordion-button {{ $subcategorias->where('descuento_id', $descuento->id)->isEmpty() ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSubcategorias" aria-expanded="{{ $subcategorias->where('descuento_id', $descuento->id)->isEmpty() ? 'false' : 'true' }}" aria-controls="collapseSubcategorias">
                        Seleccionar Subcategorías
                    </button>
                </h2>
                <div id="collapseSubcategorias" class="accordion-collapse collapse {{ $subcategorias->where('descuento_id', $descuento->id)->isEmpty() ? '' : 'show' }}" aria-labelledby="headingSubcategorias">
                    <div class="accordion-body">
                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4" id="subcategoriasContainer">
                            @foreach ($subcategorias as $subcategoria)
                            <div class="col item subcategoria-item">
                                <div class="card h-100 shadow-sm">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $subcategoria->nombre }}</h5>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input item-checkbox" name="subcategorias[]" value="{{ $subcategoria->id }}" {{ $subcategoria->descuento_id == $descuento->id ? 'checked' : '' }}>
                                            <label class="form-check-label">Aplicar Descuento</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-4">Guardar Cambios</button>
    </form>
    <br>
</div>

<script>
    function selectAll() {
        document.querySelectorAll('.item-checkbox').forEach(checkbox => checkbox.checked = true);
        document.querySelectorAll('.accordion-collapse').forEach(collapse => {
            const bsCollapse = new bootstrap.Collapse(collapse, { show: true });
        });
    }

    function deselectAll() {
        document.querySelectorAll('.item-checkbox').forEach(checkbox => checkbox.checked = false);
        document.querySelectorAll('.accordion-collapse').forEach(collapse => {
            const bsCollapse = new bootstrap.Collapse(collapse, { hide: true });
        });
    }

    function filterItems() {
        const filter = document.getElementById('searchItems').value.toLowerCase();
        const items = document.getElementsByClassName('item');
        const sections = [
            { container: 'productosContainer', collapse: 'collapseProductos' },
            { container: 'categoriasContainer', collapse: 'collapseCategorias' },
            { container: 'subcategoriasContainer', collapse: 'collapseSubcategorias' }
        ];

        sections.forEach(section => {
            let anyVisible = false;
            const items = document.getElementById(section.container).getElementsByClassName('item');
            Array.from(items).forEach(item => {
                const title = item.querySelector('.card-title').textContent.toLowerCase();
                if (title.includes(filter)) {
                    item.style.display = '';
                    anyVisible = true;
                } else {
                    item.style.display = 'none';
                }
            });

            const collapseElement = document.getElementById(section.collapse);
            const bsCollapse = new bootstrap.Collapse(collapseElement, { toggle: false });
            if (anyVisible) {
                bsCollapse.show();
            } else {
                bsCollapse.hide();
            }
        });
    }

    document.getElementById('searchItems').addEventListener('input', filterItems);
</script>
@endsection

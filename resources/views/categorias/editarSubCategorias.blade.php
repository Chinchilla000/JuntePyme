@extends('layouts.header')

@section('title', 'Editar Subcategoría')

@section('content')
<style>
    /* CSS para pantallas pequeñas */
    @media (max-width: 768px) {
        .container {
            padding: 0 10px;
        }

        .card {
            margin-bottom: 15px;
        }

        .card-header,
        .card-body {
            padding: 5px;
        }

        .btn {
            width: 100%;
            margin-bottom: 5px;
        }

        .form-control {
            font-size: 12px;
        }
    }
    .card {
        transition: transform 0.2s ease-in-out;
    }
    .card:hover {
        transform: scale(1.03);
    }
    .card-img-top {
        height: 200px; /* Ajusta según tus necesidades */
        object-fit: cover; /* Mantiene la proporción sin recortar */
    }
    .card-footer {
        background: rgba(0, 0, 0, 0.03);
    }
    .btn-ver-detalles {
        width: 100%;
    }
    @media (max-width: 576px) { /* Ajuste para dispositivos pequeños */
        .input-group .form-control {
            margin-bottom: 10px; /* Añade un margen debajo del input */
        }
        .input-group button {
            width: 100%; /* Hace que el botón ocupe todo el ancho disponible */
        }
    }
</style>
<script>
    function abrirAgregarProductoModal() {
        $('#agregarProductoModal').modal('show');
    }

    function agregarProducto() {
        var formData = $('#agregarProductoForm').serialize();
        $.ajax({
            type: 'POST',
            url: '{{ route('productos.store') }}',
            data: formData,
            success: function(response) {
                window.location.reload();
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }
</script>

<div class="container mt-4">
    <h3>Subcategoria {{ $categoria->nombre }}</h3>

    <!-- Buscador -->
    <div class="mb-3">
        <form method="GET" action="{{ route('categorias.indexCategorias') }}" class="input-group">
            <input type="text" name="searchTerm" class="form-control" placeholder="Buscar por nombre, código..."
                id="searchTerm" value="{{ request('searchTerm') }}">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i> Buscar
            </button>
        </form>
    </div>

    <!-- Botón para agregar producto -->
    <div class="mb-3">
        <button type="button" class="btn btn-primary" onclick="abrirAgregarProductoModal()">Agregar Producto</button>
    </div>

    <!-- Modal para agregar producto -->
<div class="modal fade" id="agregarProductoModal" tabindex="-1" aria-labelledby="agregarProductoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="agregarProductoModalLabel">Agregar Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="agregarProductoForm">
                @csrf  <!-- Token CSRF incluido en el formulario -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="codigo" class="form-label">Código</label>
                                <input type="text" name="codigo" id="codigo" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" name="nombre" id="nombre" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="precio_unitario" class="form-label">Precio Unitario</label>
                                <input type="number" name="precio_unitario" id="precio_unitario" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="unidad_de_medida" class="form-label">Unidad de Medida</label>
                                <input type="text" name="unidad_de_medida" id="unidad_de_medida" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="cantidad_disponible" class="form-label">Cantidad Disponible</label>
                                <input type="number" name="cantidad_disponible" id="cantidad_disponible" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="categoria_id" class="form-label">Categoría</label>
                                <select name="categoria_id" id="categoria_id" class="form-control" required>
                                    <option value="">Seleccione una categoría</option>
                                    @foreach ($categorias as $categoria)
                                        <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="proveedor_id" class="form-label">Proveedor</label>
                                <select name="proveedor_id" id="proveedor_id" class="form-control">
                                    <option value="">Seleccione un proveedor (opcional)</option>
                                    @foreach ($proveedores as $proveedor)
                                        <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea name="descripcion" id="descripcion" class="form-control" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="agregarProducto()">Agregar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Sección para mostrar los productos -->
<div class="row row-cols-1 row-cols-md-3 g-4">
    @foreach ($productos as $producto)
    <div class="col">
        <div class="card h-100 shadow-sm">
            <!-- Sección de imagen con ajuste para mostrar completamente -->
            <div class="img-container" style="cursor: pointer;">
                <!-- El enlace se coloca solo en la imagen -->
                <a href="{{ url('/productodetalle', $producto->id) }}">
                    @if($producto->imagen_producto)
                        <img class="img-fluid rounded-3" src="{{ asset('storage/imagenes_productos/' . $producto->imagen_producto) }}" alt="Producto {{ $producto->nombre }}">
                    @else
                        <img class="img-fluid rounded-3" src="{{ asset('assets/img/gallery/default.jpg') }}" alt="Default Image">
                    @endif
                </a>
            </div>
            <div class="card-body">
                <h5 class="card-title">{{ $producto->nombre }}</h5>
                <p class="card-text">{{ \Illuminate\Support\Str::limit($producto->descripcion, 50, '...') }}</p>
                <p class="card-text">
                    <strong>Precio:</strong>
                    @if ($producto->precio_venta_bruto)
                        ${{ number_format($producto->precio_venta_bruto, 2) }}
                    @else
                        <span class="text-danger">Agregar precio</span>
                    @endif
                </p>
            </div>
            <div class="card-footer bg-transparent">
                <small class="text-muted">Disponibles: {{ $producto->cantidad_disponible }}</small>
                <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-primary btn-sm mt-2 btn-ver-detalles">Ver detalles</a>
            </div>
        </div>
    </div>
    @endforeach
</div>

    <br>
</div>
@endsection

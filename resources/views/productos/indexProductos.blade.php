@extends('layouts.header')

@section('title', 'Gestión de Productos')

@section('content')
<style>
    /* Estilos CSS similares a los de tu vista proveedores para mantener consistencia */
    @media (max-width: 768px) {
        /* Estilos para responsividad omitidos para brevedad */
    }
    .naranja {
        color: orange;
        margin-left: 5px;
    }
    .rojo {
        color: red;
        margin-left: 5px;
    }
</style>

<div class="container mt-4">
    <!-- Barra de búsqueda -->
    <div class="mb-4">
        <form method="GET" action="{{ route('productos.index') }}" class="input-group">
            <input type="text" name="searchTerm" class="form-control" placeholder="Buscar por código, nombre..." value="{{ request('searchTerm') }}">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i> Buscar
            </button>
        </form>
    </div>

    <!-- Botón para agregar producto -->
    <div>
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#crearProductoModal">Agregar Producto</button>
    </div>
<!-- Modal para agregar producto -->
<div class="modal fade" id="crearProductoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Agregar Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Campos del formulario organizados en dos columnas -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="codigo_barras" class="form-label">Código de Barras</label>
                                <input type="text" name="codigo_barras" id="codigo_barras" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="cantidad_disponible" class="form-label">Cantidad Disponible</label>
                                <input type="number" name="cantidad_disponible" id="cantidad_disponible" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="precio_venta_bruto" class="form-label">Precio Venta Bruto</label>
                                <input type="number" name="precio_venta_bruto" id="precio_venta_bruto" class="form-control" required step="0.01">
                            </div>
                            <div class="mb-3">
                                <label for="unidad_de_medida" class="form-label">Unidad de Medida</label>
                                <select name="unidad_de_medida" id="unidad_de_medida" class="form-control" required>
                                    <option value="">Seleccione una unidad de medida</option>
                                    <option value="unidad">Unidad</option>
                                    <option value="kilos">Kilos</option>
                                    <option value="litros">Litros</option>
                                    <option value="gramos">Gramos</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" name="nombre" id="nombre" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="categoria_id" class="form-label">Categoría</label>
                                <select name="categoria_id" id="categoria_id" class="form-control" required>
                                    <option value="">Seleccione una categoría</option>
                                    @foreach ($categorias as $categoria)
                                        <option value="{{ $categoria->id }}" style="font-weight: bold;">{{ $categoria->nombre }}</option>
                                        @if($categoria->subcategorias->isNotEmpty())
                                            @foreach ($categoria->subcategorias as $subcategoria)
                                                <option value="{{ $subcategoria->id }}">&nbsp;&nbsp;&nbsp;{{ $subcategoria->nombre }}</option>
                                            @endforeach
                                        @endif
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
                            <div class="mb-3">
                                <label for="marca" class="form-label">Marca</label>
                                <input type="text" name="marca" id="marca" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea name="descripcion" id="descripcion" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

    <!-- Lista de productos -->
    <div class="card">
        <div class="card-header">
            Lista de Productos
        </div>
        <div class="table-responsive">
            <table class="table w-100">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Cantidad Disponible</th>
                        <th>Precio Venta</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($productos as $producto)
                    <tr>
                        <td>{{ $producto->codigo_barras }}</td>
                        <td>{{ $producto->nombre }}</td>
                        <td>
                            {{ $producto->cantidad_disponible }}
                            @if($producto->cantidad_disponible <= $producto->cantidad_minima + 5 && $producto->cantidad_disponible >= $producto->cantidad_minima - 5)
                                <span class="naranja" data-bs-toggle="tooltip" data-bs-placement="top" title="Revise el stock o actualícelo">
                                    <i class="fas fa-exclamation-circle"></i>
                                </span>
                            @elseif($producto->cantidad_disponible < $producto->cantidad_minima - 5)
                                <span class="rojo" data-bs-toggle="tooltip" data-bs-placement="top" title="Revise el stock o actualícelo">
                                    <i class="fas fa-exclamation-circle"></i>
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($producto->precio_venta_bruto)
                                $ {{ number_format($producto->precio_venta_bruto, 0) }}
                            @else
                                <span style="color: red;">$ Asigna un precio</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-warning">Editar</a>
                            <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Está seguro de eliminar este producto?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">No hay productos registrados.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <br>
            <div class="d-flex justify-content-center">
                {{ $productos->links('pagination.custom') }}
            </div>
        </div>
    </div>
</div>

<script>
    // Inicializar tooltips de Bootstrap
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>

@endsection
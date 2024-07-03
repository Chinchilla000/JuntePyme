@extends('layouts.header')

@section('title', 'Editar Categoría')

@section('content')
    <div class="container mt-4">
        <div class="row">
            @if (!$categoria->categoria_padre_id)
                <!-- Columna para la imagen (solo para categorías padre) -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5>Actualizar Imagen de Categoría</h5>
                        </div>
                        <div class="card-body text-center">
                            <form action="{{ route('categorias.updateImage', $categoria->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="imagen_categoria" class="form-label">Imagen de Categoría</label>
                                    <input type="file" name="imagen_categoria" id="imagen_categoria"
                                        class="form-control">
                                    @if ($categoria->imagen_categoria)
                                        <img src="{{ asset('storage/imagenes_categorias/' . $categoria->imagen_categoria) }}"
                                            alt="Imagen de la categoría" class="img-fluid mt-2" style="max-width: 200px;">
                                    @endif
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary w-100">Actualizar Imagen</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
            <!-- Columna para la información de la categoría -->
            <div class="@if ($categoria->categoria_padre_id) col-md-12 @else col-md-8 @endif">
                <div class="card">
                    <div class="card-header">
                        <h5>Editar Categoría: {{ $categoria->nombre }}</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('categorias.update', $categoria->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" name="nombre" id="nombre" class="form-control"
                                    value="{{ $categoria->nombre }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <textarea name="descripcion" id="descripcion" class="form-control">{{ $categoria->descripcion }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="categoria_padre_id" class="form-label">Categoría Padre</label>
                                <select name="categoria_padre_id" id="categoria_padre_id" class="form-control">
                                    <option value="">Selecciona una categoría padre (opcional)</option>
                                    @foreach ($categoriasPadre as $cat)
                                        <option value="{{ $cat->id }}"
                                            @if ($cat->id == $categoria->categoria_padre_id) selected @endif>{{ $cat->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    onclick="window.location='{{ route('categorias.indexCategorias') }}'">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Guardar cambios</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>



            <hr>
            <div class="container mt-4">
                <h3>Productos de la Categoría {{ $categoria->nombre }}</h3>

                <!-- Buscador -->
                <div class="mb-3">
                    <form method="GET" action="{{ route('categorias.indexCategorias') }}" class="input-group">
                        <input type="text" name="searchTerm" class="form-control"
                            placeholder="Buscar por nombre, código..." id="searchTerm" value="{{ request('searchTerm') }}">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Buscar
                        </button>
                    </form>
                </div>

                <!-- Grupo de botones con display flex -->
                <div class="d-flex mb-3">
                    <!-- Botón para agregar producto -->
                    <!-- Botón para agregar producto -->
                    <div>
                        <button class="btn btn-primary mb-3" data-bs-toggle="modal"
                            data-bs-target="#crearProductoModal">Agregar Producto</button>
                    </div>
                </div>

                <!-- Modal para agregar producto -->
                <div class="modal fade" id="crearProductoModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title">Agregar Producto</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <!-- Campos del formulario organizados en dos columnas -->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="codigo_barras" class="form-label">Código de Barras</label>
                                                <input type="text" name="codigo_barras" id="codigo_barras"
                                                    class="form-control">
                                            </div>
                                            <div class="mb-3">
                                                <label for="cantidad_disponible" class="form-label">Cantidad
                                                    Disponible</label>
                                                <input type="number" name="cantidad_disponible" id="cantidad_disponible"
                                                    class="form-control" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="precio_venta_bruto" class="form-label">Precio Venta
                                                    Bruto</label>
                                                <input type="number" name="precio_venta_bruto" id="precio_venta_bruto"
                                                    class="form-control" required step="0.01">
                                            </div>
                                            <div class="mb-3">
                                                <label for="unidad_de_medida" class="form-label">Unidad de Medida</label>
                                                <select name="unidad_de_medida" id="unidad_de_medida"
                                                    class="form-control" required>
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
                                                <input type="text" name="nombre" id="nombre" class="form-control"
                                                    required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="categoria_id" class="form-label">Categoría</label>
                                                <select name="categoria_id" id="categoria_id" class="form-control" required>
                                                    <option value="{{ $categoria->id }}" selected>{{ $categoria->nombre }}</option>
                                                    @if ($categoria->categoria_padre_id)
                                                        <!-- Si es una subcategoría, mostrar solo esta subcategoría -->
                                                        @foreach ($categoria->subcategorias as $subcategoria)
                                                            <option value="{{ $subcategoria->id }}">{{ $subcategoria->nombre }}</option>
                                                        @endforeach
                                                    @else
                                                        <!-- Si es una categoría padre, mostrar esta categoría y sus subcategorías -->
                                                        @foreach ($categoria->subcategorias as $subcategoria)
                                                            <option value="{{ $subcategoria->id }}">{{ $subcategoria->nombre }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="proveedor_id" class="form-label">Proveedor</label>
                                                <select name="proveedor_id" id="proveedor_id" class="form-control">
                                                    <option value="">Seleccione un proveedor (opcional)</option>
                                                    @foreach ($proveedores as $proveedor)
                                                        <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="marca" class="form-label">Marca</label>
                                                <input type="text" name="marca" id="marca" class="form-control"
                                                    required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="descripcion" class="form-label">Descripción</label>
                                        <textarea name="descripcion" id="descripcion" class="form-control" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Sección para mostrar los productos -->
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
                    @foreach ($productos as $producto)
                        <div class="col">
                            <div class="card h-100 shadow-sm">
                                <!-- Sección de imagen con ajuste para mostrar completamente -->
                                <div class="img-container" style="cursor: pointer;">
                                    <!-- El enlace se coloca solo en la imagen -->
                                    <a href="">
                                        @if ($producto->imagen_producto)
                                            <img class="img-fluid rounded-3"
                                                src="{{ asset('storage/imagenes_productos/' . $producto->imagen_producto) }}"
                                                alt="Producto {{ $producto->nombre }}">
                                        @else
                                            <img class="img-fluid rounded-3"
                                                src="{{ asset('assets/img/gallery/default.jpg') }}" alt="Default Image">
                                        @endif
                                    </a>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">{{ $producto->nombre }}</h5>
                                    <p class="card-text">
                                        {{ \Illuminate\Support\Str::limit($producto->descripcion, 50, '...') }}</p>
                                    <p class="card-text">
                                        <strong>Precio:</strong>
                                        @if ($producto->precio_venta_bruto)
                                            ${{ number_format($producto->precio_venta_bruto, 2) }}
                                        @else
                                            <span class="text-danger">Agregar precio</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="card-footer bg-transparent d-flex justify-content-between">
                                    <small class="text-muted">Disponibles: {{ $producto->cantidad_disponible }}</small>
                                    <a href="{{ route('productos.edit', $producto->id) }}"
                                        class="btn btn-primary btn-sm">Ver detalles</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <br>
            </div>
        </div>
    </div>
@endsection
@section('footer')

@endsection

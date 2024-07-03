@extends('layouts.header')

@section('title', 'Editar Producto')

@section('content')
<div class="container mt-4">
    {{-- Mensajes de éxito y error --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Título --}}
    <div class="titulo text-center mb-4">
        <h2>Detalles del producto</h2>
    </div>

    {{-- Detalles del producto --}}
    <div class="row">
        {{-- Imagen del producto --}}
        <div class="col-md-4 mb-3 mb-md-0">
            <div class="card">
                <div class="card-header">
                    Imagen del Producto
                </div>
                <div class="card-body">
                    @if ($producto->imagen_producto && Storage::disk('public')->exists('imagenes_productos/' . $producto->imagen_producto))
                        <img src="{{ asset('storage/imagenes_productos/' . $producto->imagen_producto) }}" alt="Imagen del Producto" class="img-fluid rounded" style="height: 200px; width: 100%; object-fit: contain; background-color: #f8f9fa;">
                    @else
                        <p class="text-muted">No hay imagen cargada para este producto.</p>
                    @endif
                </div>
            </div>

            {{-- Sección para cargar una nueva imagen del producto --}}
            <div class="card mt-4">
                <div class="card-header">
                    Cargar Nueva Imagen del Producto
                </div>
                <div class="card-body">
                    <form action="{{ route('productos.updateImage', $producto->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="mb-3">
                            <label for="imagen_producto" class="form-label">Seleccionar imagen</label>
                            <input type="file" class="form-control" id="imagen_producto" name="imagen_producto" accept="image/*" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Cargar Imagen</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Formulario de edición del producto --}}
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Detalles del Producto
                </div>
                <div class="card-body">
                    <form action="{{ route('productos.update', $producto->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            {{-- Columna izquierda --}}
                            <div class="col-md-6">
                                <div class="row mb-3">
                                    <label for="codigo" class="col-sm-4 col-form-label">Código</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="codigo" name="codigo" value="{{ $producto->codigo }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="codigo_barras" class="col-sm-4 col-form-label">Código de Barras</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="codigo_barras" name="codigo_barras" value="{{ $producto->codigo_barras }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="nombre" class="col-sm-4 col-form-label">Nombre</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $producto->nombre }}" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="precio_venta_bruto" class="col-sm-4 col-form-label">Precio Venta Bruto</label>
                                    <div class="col-sm-8">
                                        <input type="number" class="form-control" id="precio_venta_bruto" name="precio_venta_bruto" value="{{ number_format($producto->precio_venta_bruto, 0, '.', '') }}" required step="0.01">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="precio_venta_neto" class="col-sm-4 col-form-label">Precio Venta Neto</label>
                                    <div class="col-sm-8">
                                        <input type="number" class="form-control" id="precio_venta_neto" name="precio_venta_neto" readonly value="{{ number_format($producto->precio_venta_neto, 0, '.', '') }}" step="0.01">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="cantidad_minima" class="col-sm-4 col-form-label">Cantidad Mínima</label>
                                    <div class="col-sm-8">
                                        <input type="number" class="form-control" id="cantidad_minima" name="cantidad_minima" value="{{ $producto->cantidad_minima }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="cantidad_disponible" class="col-sm-4 col-form-label">Cantidad Disponible</label>
                                    <div class="col-sm-8">
                                        <input type="number" class="form-control" id="cantidad_disponible" name="cantidad_disponible" value="{{ $producto->cantidad_disponible }}" required>
                                    </div>
                                </div>
                            </div>
                            {{-- Columna derecha --}}
                            <div class="col-md-6">
                                <div class="row mb-3">
                                    <label for="categoria_id" class="col-sm-4 col-form-label">Categoría</label>
                                    <div class="col-sm-8">
                                        <select class="form-select" id="categoria_id" name="categoria_id" required>
                                            <option value="">Seleccione una categoría</option>
                                            @foreach ($categorias as $categoria)
                                                <option value="{{ $categoria->id }}" {{ $producto->categoria_id == $categoria->id ? 'selected' : '' }}>{{ $categoria->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="proveedor_id" class="col-sm-4 col-form-label">Proveedor</label>
                                    <div class="col-sm-8">
                                        <select class="form-select" id="proveedor_id" name="proveedor_id">
                                            <option value="">Seleccione un proveedor (opcional)</option>
                                            @foreach ($proveedores as $proveedor)
                                                <option value="{{ $proveedor->id }}" {{ $producto->proveedor_id == $proveedor->id ? 'selected' : '' }}>{{ $proveedor->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="marca" class="col-sm-4 col-form-label">Marca</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="marca" name="marca" value="{{ $producto->marca }}" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="unidad_de_medida" class="col-sm-4 col-form-label">Unidad de Medida</label>
                                    <div class="col-sm-8">
                                        <select class="form-select" id="unidad_de_medida" name="unidad_de_medida" required>
                                            <option value="">Seleccione una unidad de medida</option>
                                            <option value="unidad" {{ $producto->unidad_de_medida == 'unidad' ? 'selected' : '' }}>Unidad</option>
                                            <option value="kilos" {{ $producto->unidad_de_medida == 'kilos' ? 'selected' : '' }}>Kilos</option>
                                            <option value="litros" {{ $producto->unidad_de_medida == 'litros' ? 'selected' : '' }}>Litros</option>
                                            <option value="gramos" {{ $producto->unidad_de_medida == 'gramos' ? 'selected' : '' }}>Gramos</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="iva_venta" class="col-sm-4 col-form-label">IVA Venta</label>
                                    <div class="col-sm-8">
                                        <input type="number" class="form-control" id="iva_venta" name="iva_venta" readonly value="{{ number_format($producto->iva_venta, 0, '.', '') }}" step="0.01">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="fecha_de_vencimiento" class="col-sm-4 col-form-label">Fecha de Vencimiento</label>
                                    <div class="col-sm-8">
                                        <input type="date" class="form-control" id="fecha_de_vencimiento" name="fecha_de_vencimiento" value="{{ $producto->fecha_de_vencimiento }}">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="estado" class="col-sm-4 col-form-label text-primary fw-bold">Listo para vender</label>
                                    <div class="col-sm-8 d-flex align-items-center">
                                        <div class="form-check form-switch">
                                            <input type="hidden" name="estado" value="0">
                                            <input class="form-check-input" type="checkbox" id="estado" name="estado" value="1" {{ $producto->estado ? 'checked' : '' }}>
                                            <label class="form-check-label ms-2" for="estado"></label>
                                        </div>
                                        <span id="estado-label" class="ms-2">{{ $producto->estado ? 'Sí' : 'No' }}</span>
                                    </div>
                                </div>

                                <script>
                                    document.getElementById('estado').addEventListener('change', function() {
                                        document.getElementById('estado-label').textContent = this.checked ? 'Sí' : 'No';
                                    });
                                </script>

                                <style>
                                    .form-check-input:checked {
                                        background-color: #0d6efd;
                                        border-color: #0d6efd;
                                    }

                                    .form-check-input {
                                        cursor: pointer;
                                    }

                                    #estado-label {
                                        font-weight: bold;
                                        color: #0d6efd;
                                    }
                                </style>
                            </div>
                        </div>
                        {{-- Descripción --}}
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="3">{{ $producto->descripcion }}</textarea>
                        </div>
                        {{-- Botones de guardar y cancelar --}}
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#especificacionesModal">
                                Añadir Especificaciones
                            </button>
                            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#detallesModal">
                                Añadir Detalles
                            </button>
                            <button type="submit" class="btn btn-primary me-md-2 mb-2 mb-md-0">Guardar Cambios</button>
                            <a href="{{ route('productos.index') }}" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal para añadir especificaciones --}}
<div class="modal fade" id="especificacionesModal" tabindex="-1" aria-labelledby="especificacionesModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="especificacionesModalLabel">Añadir Especificaciones</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('especificaciones.store', $producto->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="clave" class="form-label">Nombre de la Especificación</label>
                        <input type="text" class="form-control" id="clave" name="clave" required>
                    </div>
                    <div class="mb-3">
                        <label for="valor" class="form-label">Valor de la Especificación</label>
                        <input type="text" class="form-control" id="valor" name="valor" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar Especificaciones</button>
                </form>
                <hr>
                {{-- Tabla de especificaciones existentes --}}
                <h5>Especificaciones del producto</h5>
                @if($especificaciones->isEmpty())
                    <p class="text-muted">No hay especificaciones para este producto.</p>
                @else
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Valor</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($especificaciones as $especificacion)
                                <tr>
                                    <td>{{ $especificacion->clave }}</td>
                                    <td>{{ $especificacion->valor }}</td>
                                    <td>
                                        <form action="{{ route('especificaciones.destroy', $especificacion->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Modal para añadir detalles --}}
<div class="modal fade" id="detallesModal" tabindex="-1" aria-labelledby="detallesModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detallesModalLabel">Añadir Detalles del Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('productos.detalles.store', $producto->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título del Detalle</label>
                        <input type="text" class="form-control" id="titulo" name="titulo" required>
                    </div>
                    <div class="mb-3">
                        <label for="contenido" class="form-label">Contenido del Detalle</label>
                        <textarea class="form-control" id="contenido" name="contenido" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar Detalles</button>
                </form>
                <hr>
                {{-- Tabla de detalles existentes --}}
                <h5>Detalles del producto</h5>
                @if($detalles->isEmpty())
                    <p class="text-muted">No hay detalles para este producto.</p>
                @else
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Título</th>
                                <th>Contenido</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($detalles as $detalle)
                                <tr>
                                    <td>{{ $detalle->titulo }}</td>
                                    <td>{{ $detalle->contenido }}</td>
                                    <td>
                                        <form action="{{ route('productos.detalles.destroy', $detalle->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>

<br>
@endsection

@section('footer')
    {{-- Aquí puedes agregar contenido personalizado para el footer si es necesario --}}
@endsection

@push('scripts')
    {{-- Aquí puedes incluir cualquier script adicional que necesites --}}
@endpush
@extends('layouts.header')

@section('title', 'Editar Proveedor')

@section('content')
<style>
    /* CSS para pantallas pequeñas */
    @media (max-width: 768px) {
        .container {
            padding: 0 15px;
        }

        .card {
            margin-bottom: 20px;
        }

        .card-header,
        .card-body {
            padding: 10px;
        }

        .btn {
            width: 100%;
            margin-bottom: 10px;
        }

        .modal-dialog {
            margin: 20px;
        }

        .modal-content {
            padding: 10px;
        }

        .form-control {
            font-size: 12px;
        }

        .pagination {
            font-size: 12px;
            justify-content: center;
        }

        .input-group {
            flex-direction: column;
        }

        .input-group .form-control {
            width: 100%;
            margin-bottom: 10px;
        }

        .input-group button {
            width: 100%;
        }

        /* Estilo adicional para la tabla */
        .table {
            margin-bottom: 20px;
        }

        .table td,
        .table th {
            padding: .75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }
        /* Cambiar el color de fondo al pasar el cursor sobre la fila */
        .clickable-row:hover {
            background-color: #ff0b0b; /* Cambia a un color gris claro al pasar el cursor */
        }
    }
</style>
<div class="container mt-4">
    <div class="row">
        <div class="col-lg-6">
            <!-- Aquí va el formulario de edición del proveedor -->
            <div class="card">
                <div class="card-header">
                    Editar Datos del Proveedor
                </div>
                <div class="card-body">
                    <form action="{{ route('proveedores.update', $proveedor) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $proveedor->nombre }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" value="{{ $proveedor->telefono }}">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $proveedor->email }}">
                        </div>
                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección</label>
                            <input type="text" class="form-control" id="direccion" name="direccion" value="{{ $proveedor->direccion }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        <a href="{{ route('proveedores.indexProveedores') }}" class="btn btn-secondary">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <!-- Aquí va la tabla de productos -->
            <div class="card">
                <div class="card-header">
                    Lista de Productos
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Stock</th>
                                <th>Precio</th>
                                <!-- Agrega más columnas según tus necesidades -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($proveedor->productos as $producto)
                            <tr>
                                <tr onclick="window.location='{{ route('productos.edit', $producto->id) }}';" style="cursor: pointer;">
                                <td>{{ $producto->nombre }}</td>
                                <td>{{ $producto->cantidad_disponible }}</td>
                                <td>
                                    @if($producto->precio_venta_bruto)
                                        ${{ number_format($producto->precio_venta_bruto, 0) }}
                                    @else
                                        <span style="color: red;">Asigna precio</span>
                                    @endif
                                </td>
                                <!-- Agrega más celdas según tus necesidades -->
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
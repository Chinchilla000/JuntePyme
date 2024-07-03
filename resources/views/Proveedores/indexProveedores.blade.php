@extends('layouts.header')

@section('title', 'Gestión de Proveedores')

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

        /* Ocultar las columnas de la tabla en dispositivos móviles */
        .mobile-table th:not(:first-child),
        .mobile-table td:not(:first-child) {
            display: none;
        }

        .mobile-table th:first-child,
        .mobile-table td:first-child {
            display: table-cell;
        }
    }
</style>

<div class="container mt-4">
    <!-- Barra de búsqueda -->
    <div class="mb-4">
        <form method="GET" action="{{ route('proveedores.indexProveedores') }}" class="input-group">
            <input type="text" name="searchTerm" class="form-control" placeholder="Buscar por nombre, contacto..."
                id="searchTerm" value="{{ request('searchTerm') }}">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i> Buscar
            </button>
        </form>
    </div>

    <!-- Botón para ingresar proveedor -->
    <div>
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#crearProveedorModal">Ingresar Proveedor</button>
    </div>

    <!-- Modal para ingresar proveedor -->
    <div class="modal fade" id="crearProveedorModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('proveedores.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Ingresar Proveedor</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Campos del formulario -->
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ingrese el nombre del proveedor" required>
                        </div>
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="text" name="telefono" id="telefono" class="form-control" placeholder="Número de teléfono">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Email del proveedor">
                        </div>
                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección</label>
                            <input type="text" name="direccion" id="direccion" class="form-control" placeholder="Dirección del proveedor">
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

<!-- Lista de proveedores -->
<div class="card">
    <div class="card-header">
        Lista de Proveedores
    </div>
    <!-- Tabla responsive -->
    <div class="table-responsive">
        <table class="table w-100"> <!-- Agregamos la clase "w-100" para que la tabla ocupe todo el ancho disponible -->
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th class="d-none d-lg-table-cell">Teléfono</th>
                    <th class="d-none d-lg-table-cell">Email</th>
                    <th class="d-none d-lg-table-cell">Dirección</th>
                    <th class="d-none d-lg-table-cell">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($proveedores as $proveedor)
                <tr>
                    <!-- Mostrar nombre, teléfono y botones en dispositivos móviles -->
                    <td>{{ $proveedor->nombre }}</td>
                    <td class="d-none d-lg-table-cell">{{ $proveedor->telefono }}</td>
                    <td class="d-none d-lg-table-cell">{{ $proveedor->email }}</td>
                    <td class="d-none d-lg-table-cell">{{ $proveedor->direccion }}</td>
                    <td class="d-none d-lg-table-cell">
                        <!-- Botones de acciones -->
                        <a href="{{ route('proveedores.edit', $proveedor) }}" class="btn btn-warning">Editar</a>
                        <!-- Botón para eliminar proveedor -->
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $proveedor->id }}">
                            Eliminar
                        </button>
                    </td>
                    <!-- Enlace para ver detalles en dispositivos móviles -->
                    <td class="d-lg-none">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#detalleProveedorModal{{ $proveedor->id }}">Ver Detalles</button>
                    </td>
                </tr>
                <!-- Modal para ver detalles del proveedor -->
                <div class="modal fade" id="detalleProveedorModal{{ $proveedor->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Detalles del Proveedor</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p><strong>Nombre:</strong> {{ $proveedor->nombre }}</p>
                                <p><strong>Teléfono:</strong> {{ $proveedor->telefono }}</p>
                                <p><strong>Email:</strong> {{ $proveedor->email }}</p>
                                <p><strong>Dirección:</strong> {{ $proveedor->direccion }}</p>
                            </div>
                            <div class="modal-footer">
                                <!-- Botones de acciones en el modal -->
                                <a href="{{ route('proveedores.edit', $proveedor) }}" class="btn btn-warning">Editar</a>
                                <form action="{{ route('proveedores.destroy', $proveedor->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que quieres eliminar este proveedor?');">Eliminar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal de confirmación de eliminación -->
                <div class="modal fade" id="confirmDeleteModal{{ $proveedor->id }}" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar eliminación</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                ¿Estás seguro de que quieres eliminar este proveedor?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <!-- Formulario para eliminar el proveedor -->
                                <form action="{{ route('proveedores.destroy', $proveedor->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <tr>
                    <td colspan="5">No hay proveedores registrados.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <br>
    <div class="d-flex justify-content-center">
        {{ $proveedores->links('pagination.custom') }}
    </div>
</div>
</div>
@endsection
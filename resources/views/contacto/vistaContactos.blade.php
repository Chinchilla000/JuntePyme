@extends('layouts.header')

@section('title', 'Gestión de Contactos')

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
        <form method="GET" action="{{ route('admin.contactos') }}" class="input-group">
            <input type="text" name="searchTerm" class="form-control" placeholder="Buscar por nombre, email..."
                id="searchTerm" value="{{ request('searchTerm') }}">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i> Buscar
            </button>
        </form>
    </div>

    <!-- Lista de contactos -->
    <div class="card">
        <div class="card-header">
            Lista de Contactos
        </div>
        <!-- Tabla responsive -->
        <div class="table-responsive">
            <table class="table w-100 mobile-table"> <!-- Agregamos la clase "w-100" para que la tabla ocupe todo el ancho disponible -->
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th class="d-none d-lg-table-cell">Email</th>
                        <th class="d-none d-lg-table-cell">Teléfono</th>
                        <th class="d-none d-lg-table-cell">Mensaje</th>
                        <th class="d-none d-lg-table-cell">Fecha</th>
                        <th class="d-none d-lg-table-cell">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($contactos as $contacto)
                    <tr>
                        <!-- Mostrar nombre, teléfono y botones en dispositivos móviles -->
                        <td>{{ $contacto->nombre }}</td>
                        <td class="d-none d-lg-table-cell">{{ $contacto->email }}</td>
                        <td class="d-none d-lg-table-cell">{{ $contacto->telefono }}</td>
                        <td class="d-none d-lg-table-cell">{{ $contacto->mensaje }}</td>
                        <td class="d-none d-lg-table-cell">{{ $contacto->created_at->format('d/m/Y H:i') }}</td>
                        <td class="d-none d-lg-table-cell">
                            <!-- Botón para ver detalles del contacto -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#detalleContactoModal{{ $contacto->id }}">Ver Detalles</button>
                        </td>
                        <!-- Enlace para ver detalles en dispositivos móviles -->
                        <td class="d-lg-none">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#detalleContactoModal{{ $contacto->id }}">Ver Detalles</button>
                        </td>
                    </tr>
                    <!-- Modal para ver detalles del contacto -->
                    <div class="modal fade" id="detalleContactoModal{{ $contacto->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Detalles del Contacto</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>Nombre:</strong> {{ $contacto->nombre }}</p>
                                    <p><strong>Email:</strong> {{ $contacto->email }}</p>
                                    <p><strong>Teléfono:</strong> {{ $contacto->telefono }}</p>
                                    <p><strong>Mensaje:</strong> {{ $contacto->mensaje }}</p>
                                    <p><strong>Fecha:</strong> {{ $contacto->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                                <div class="modal-footer">
                                    <!-- Botón de eliminación dentro del modal -->
                                    <form action="{{ route('contactos.destroy', $contacto->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que quieres eliminar este contacto?');">Eliminar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <tr>
                        <td colspan="6">No hay mensajes de contacto.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <br>
        <div class="d-flex justify-content-center">
            {{ $contactos->links('pagination.custom') }}
        </div>
    </div>
</div>
@endsection
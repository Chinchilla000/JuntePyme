@extends('layouts.header')

@section('title', 'Gestión de Categorías')

@section('content')
    <style>
        /* Estilos similares al manejo de proveedores */
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

            .mobile-table th:not(:first-child),
            .mobile-table td:not(:first-child) {
                display: none;
            }

            .mobile-table th:first-child,
            .mobile-table td:first-child {
                display: table-cell;
            }
        }

        /* Estilos para columnas de tabla */
        .column {
            float: left;
            width: 50%;
            padding: 10px;
        }

        /* Limpiar floats después de las columnas */
        .row:after {
            content: "";
            display: table;
            clear: both;
        }
    </style>

    <div class="container mt-4">
        <div class="mb-4">
            <form method="GET" action="{{ route('categorias.indexCategorias') }}" class="input-group">
                <input type="text" name="searchTerm" class="form-control" placeholder="Buscar por nombre, descripción..."
                    id="searchTerm" value="{{ request('searchTerm') }}">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Buscar
                </button>
            </form>
        </div>

        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#crearCategoriaModal">Añadir
            Categoría</button>

        <!-- Modal para crear o editar categorías -->
        <div class="modal fade" id="crearCategoriaModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('categorias.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Ingresar Nueva Categoría</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" name="nombre" id="nombre" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <textarea name="descripcion" id="descripcion" class="form-control"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="imagen_categoria" class="form-label">Imagen de Categoría</label>
                                <input type="file" name="imagen_categoria" id="imagen_categoria" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="categoria_padre_id" class="form-label">Categoría Padre</label>
                                <select name="categoria_padre_id" id="categoria_padre_id" class="form-control">
                                    <option value="">Selecciona una categoría padre (opcional)</option>
                                    @foreach ($categoriasPadre as $categoria)
                                        @if ($categoria->categoriaPadre === null)
                                            <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                                        @endif
                                    @endforeach
                                </select>
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
        

        <div class="row">
            <!-- Columna de categorías padre -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-white">Categorías Padre</div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Dentro del bucle foreach que muestra las categorías padre -->
                                    @foreach ($categoriasPadre as $categoria)
                                        @if (!$categoria->categoriaPadre)
                                            <tr>
                                                <td>{{ $categoria->nombre }}</td>
                                                <td>{{ $categoria->descripcion }}</td>
                                                <td>
                                                    <div
                                                        class="d-flex flex-column flex-lg-row align-items-center justify-content-center">
                                                        <!-- Botón Editar, visible solo en lg y tamaños superiores -->
                                                        <a href="{{ route('categorias.contenido', $categoria->id) }}"
                                                            class="btn btn-info btn-sm me-2">
                                                            <i class="bi bi-eye-fill"></i> Detalles
                                                        </a>
                                                       <!-- Botón Ver Detalles, visible solo en xs a md -->
                                                       <button class="btn btn-primary d-block d-lg-none"
                                                       data-bs-toggle="modal"
                                                       data-bs-target="#detalleCategoriaModal{{ $categoria->id }}">
                                                       Ver Detalles
                                                   </button>
                                                        <!-- Botón Eliminar, visible solo en lg y tamaños superiores -->
                                                        <button class="btn btn-danger btn-sm d-none d-lg-block"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#eliminarCategoriaModal{{ $categoria->id }}">
                                                            <i class="bi bi-trash-fill"></i> Eliminar
                                                        </button>
                                                        
                                                    </div>
                                                </td>
                                            </tr>
                                           
                                            
                                            @foreach ($categoriasPadre as $categoria)
                                                @if (!$categoria->categoriaPadre)
                                                    <div class="modal fade" id="detalleCategoriaModal{{ $categoria->id }}"
                                                        tabindex="-1" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Editar Categoría</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <form
                                                                    action="{{ route('categorias.update', $categoria->id) }}"
                                                                    method="POST" enctype="multipart/form-data">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="modal-body">
                                                                        <div class="mb-3">
                                                                            <label for="nombre{{ $categoria->id }}"
                                                                                class="form-label">Nombre</label>
                                                                            <input type="text" class="form-control"
                                                                                id="nombre{{ $categoria->id }}"
                                                                                name="nombre"
                                                                                value="{{ $categoria->nombre }}" required>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="descripcion{{ $categoria->id }}"
                                                                                class="form-label">Descripción</label>
                                                                            <textarea class="form-control" id="descripcion{{ $categoria->id }}" name="descripcion">{{ $categoria->descripcion }}</textarea>
                                                                        </div>
                                                                        <!-- Incluye más campos si necesitas editar otros atributos -->
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <form
                                                                            action="{{ route('categorias.destroy', $categoria->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit"
                                                                                class="btn btn-danger">Eliminar</button>
                                                                        </form>
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Guardar
                                                                            Cambios</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                            <!-- Modal de eliminación para la categoría padre -->
                                            <div class="modal fade" id="eliminarCategoriaModal{{ $categoria->id }}"
                                                tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Eliminar Categoría</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>¿Estás seguro de que quieres eliminar esta categoría?</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <form
                                                                action="{{ route('categorias.destroy', $categoria->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="btn btn-danger">Eliminar</button>
                                                            </form>
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Cancelar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <br>
                     
                    </div>
                </div>
            </div>

            <!-- Columna de subcategorías -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-white">Subcategorías</div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                        <th>Categoría Padre</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Dentro del bucle foreach que muestra las subcategorías -->
                                    @foreach ($subcategorias as $categoria)
                                        @if ($categoria->categoriaPadre)
                                            <tr>
                                                <td>{{ $categoria->nombre }}</td>
                                                <td>{{ $categoria->descripcion }}</td>
                                                <td>{{ $categoria->categoriaPadre->nombre }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <!-- Botón para ir a detalles de la subcategoría -->
                                                        <a href="{{ route('categorias.edit', $categoria) }}"
                                                            class="btn btn-primary btn-sm me-2">
                                                            <i class="bi bi-eye-fill"></i> Detalles
                                                        </a>
                                                        <!-- Botón para abrir el modal de eliminación -->
                                                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                            data-bs-target="#eliminarSubcategoriaModal{{ $categoria->id }}">
                                                            <i class="bi bi-trash-fill"></i> Eliminar
                                                        </button>
                                                    </div>
                                                 
                                                </td>
                                            </tr>
                                            <!-- Modal de eliminación para la subcategoría -->
                                            <div class="modal fade" id="eliminarSubcategoriaModal{{ $categoria->id }}"
                                                tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Eliminar Subcategoría</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>¿Estás seguro de que quieres eliminar esta subcategoría?</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <form
                                                                action="{{ route('categorias.destroy', $categoria->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="btn btn-danger">Eliminar</button>
                                                            </form>
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Cancelar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <br>
                       
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

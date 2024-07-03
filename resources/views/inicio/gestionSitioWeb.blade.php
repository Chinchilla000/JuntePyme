@extends('layouts.header')

@section('title', 'Gestión del Sitio Web')

@section('content')
    <!-- JavaScript para capturar los datos del elemento seleccionado -->
    <script>
        $(document).ready(function() {
            $('.dropdown-edit-header').on('click', function() {
                var card = $(this).closest('.carousel-item');
                var id = card.data('id');

                var titulo = card.find('.header-title').text().trim();
                var descripcion = card.find('.header-description').text().trim();

                $('#editarHeaderModal #elemento_id').val(id);
                $('#editarHeaderModal #titulo').val(titulo);
                $('#editarHeaderModal #descripcion').val(descripcion);

                // Actualizar la acción del formulario de edición
                var action = '{{ route('gestionSitio.editarContenido', ':id') }}';
                action = action.replace(':id', id);
                $('#formEditarHeader').attr('action', action);

                $('#editarHeaderModal').modal('show');
            });

            $('.dropdown-edit-informativa').on('click', function() {
                var card = $(this).closest('.informativa-card');
                var id = card.data('id');

                var titulo = card.find('.informativa-title').text().trim();
                var descripcion = card.find('.informativa-description').text().trim();

                $('#editarInformativaModal #elemento_id').val(id);
                $('#editarInformativaModal #titulo').val(titulo);
                $('#editarInformativaModal #descripcion').val(descripcion);

                // Actualizar la acción del formulario de edición
                var action = '{{ route('gestionSitio.editarContenido', ':id') }}';
                action = action.replace(':id', id);
                $('#formEditarInformativa').attr('action', action);

                $('#editarInformativaModal').modal('show');
            });

            $('.dropdown-view-message').on('click', function() {
                var messageRow = $(this).closest('.message-row');
                var nombre = messageRow.data('name');
                var email = messageRow.data('email');
                var telefono = messageRow.data('phone');
                var mensaje = messageRow.data('message');
                var fecha = messageRow.data('date');

                $('#viewMessageModal #message_name').text(nombre);
                $('#viewMessageModal #message_email').text(email);
                $('#viewMessageModal #message_phone').text(telefono);
                $('#viewMessageModal #message_content').text(mensaje);
                $('#viewMessageModal #message_date').text(fecha);

                $('#viewMessageModal').modal('show');
            });

            $('.dropdown-view-comment').on('click', function() {
                var commentRow = $(this).closest('.comment-row');
                var nombre = commentRow.data('name');
                var email = commentRow.data('email');
                var descripcion = commentRow.data('description');
                var fecha = commentRow.data('date');
                var producto = commentRow.data('product');

                $('#viewCommentModal #comment_name').text(nombre);
                $('#viewCommentModal #comment_email').text(email);
                $('#viewCommentModal #comment_description').text(descripcion);
                $('#viewCommentModal #comment_date').text(fecha);
                $('#viewCommentModal #comment_product').text(producto);

                $('#viewCommentModal').modal('show');
            });

            $('.dropdown-delete-comment').on('click', function() {
                var commentRow = $(this).closest('.comment-row');
                var id = commentRow.data('id');

                var action = '{{ route('gestionSitio.eliminarComentario', ':id') }}';
                action = action.replace(':id', id);
                $('#formEliminarComentario').attr('action', action);

                $('#eliminarComentarioModal').modal('show');
            });
        });
    </script>

    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Panel de Bienvenida -->
        <div class="row">
            <div class="col-lg-8 mb-4 order-0">
                <div class="card" data-id="{{ $informacionesEncabezado->id ?? '' }}">
                    <div class="d-flex align-items-end row">
                        <div class="col-sm-7">
                            <div class="card-body">
                                <h5 class="card-title text-primary">¡Bienvenido al Panel de Control del Sitio Web! 🖼️</h5>
                                <p class="mb-4">
                                    Aquí puedes gestionar y actualizar fácilmente las imágenes y textos de tu sitio web
                                    principal. Sube nuevas imágenes y modifica los textos para mantener tu sitio web fresco
                                    y actualizado.
                                </p>
                                <a href="" class="btn btn-sm btn-outline-primary">Gestionar Sitio Web</a>
                            </div>
                        </div>
                        <div class="col-sm-5 text-center">
                            <div class="card-body pb-0 px-0 px-md-4">
                                <img src="{{ asset('assets/img/gallery/logo2.png') }}" height="140" alt="View Badge User"
                                    style="max-width: 100%; height: auto;" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Estadísticas adicionales -->
            <div class="col-lg-4 col-md-4 order-1">
                <div class="row">
                    <!-- Estadística 1: Comentarios de usuarios -->
                    <div class="col-lg-12 col-md-12 mb-4">
                        <div class="card" data-id="1">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <i class="bx bx-envelope rounded" style="font-size: 2rem;"></i>
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn p-0 dropdown-edit-header" type="button" id="cardOpt1"
                                            aria-haspopup="true" aria-expanded="false" data-bs-target="#editarHeaderModal">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                    </div>
                                </div>
                                <!-- Descripción más específica para claridad del usuario -->
                                <span class="fw-semibold d-block mb-1">Nuevo comentario de:</span>
                                <h3 class="card-title header-title mb-2">
                                    @if ($comentarioMasReciente)
                                        {{ $comentarioMasReciente->nombre }} relacionado con el producto
                                        "{{ $comentarioMasReciente->producto->nombre }}"
                                    @else
                                        N/A
                                    @endif
                                </h3>
                                <!-- Modal para más detalles, si es necesario -->
                            </div>
                        </div>
                    </div>

                    <!-- Estadística 3: Mensajes Recibidos Hoy -->
                    <div class="col-lg-12 col-md-12 mb-4">
                        <div class="card" data-id="2">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <i class="bx bx-envelope rounded" style="font-size: 2rem;"></i>
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn p-0 dropdown-view-message" type="button" id="cardOpt3"
                                            aria-haspopup="true" aria-expanded="false" data-bs-target="#viewMessageModal">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                    </div>
                                </div>
                                <span class="fw-semibold d-block mb-1">Mensajes Recibidos Hoy</span>
                                <h3 class="card-title header-description mb-2">{{ $mensajesRecibidosHoy }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para ver el mensaje -->
        <div class="modal fade" id="viewMessageModal" tabindex="-1" aria-labelledby="viewMessageModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewMessageModalLabel">Ver Mensaje</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @foreach ($mensajesRecibidos as $mensaje)
                            <div class="card mt-3 message-row">
                                <div class="card-body">
                                    <h5 class="sender-name">{{ $mensaje->nombre }}</h5>
                                    <p class="message-content">{{ $mensaje->mensaje }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!-- Sección de comentarios -->
        <div class="row">
            <div class="col-lg-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Comentarios</h5>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Correo</th>
                                    <th>Comentario</th>
                                    <th>Fecha</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($comentarios as $comentario)
                                    <tr class="comment-row" data-id="{{ $comentario->id }}"
                                        data-name="{{ $comentario->nombre }}" data-email="{{ $comentario->correo }}"
                                        data-description="{{ $comentario->descripcion }}"
                                        data-date="{{ $comentario->fecha->format('d/m/Y') }}"
                                        data-product="{{ $comentario->producto->nombre }}">
                                        <td>{{ $comentario->nombre }}</td>
                                        <td>{{ $comentario->correo }}</td>
                                        <td>{{ $comentario->descripcion }}</td>
                                        <td>{{ $comentario->fecha->format('d/m/Y') }}</td>
                                        <td>{{ $comentario->producto->nombre }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    Opciones
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item dropdown-view-comment"
                                                            href="#">Ver</a></li>
                                                    <li><a class="dropdown-item dropdown-delete-comment"
                                                            href="#">Eliminar</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <br>
                        <!-- Enlaces de paginación -->
                    <div class="d-flex justify-content-center">
                        {{ $comentarios->links('pagination.custom') }}
                    </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para ver el comentario -->
        <div class="modal fade" id="viewCommentModal" tabindex="-1" aria-labelledby="viewCommentModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewCommentModalLabel">Ver Comentario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Nombre:</strong> <span id="comment_name"></span></p>
                        <p><strong>Correo:</strong> <span id="comment_email"></span></p>
                        <p><strong>Comentario:</strong> <span id="comment_description"></span></p>
                        <p><strong>Fecha:</strong> <span id="comment_date"></span></p>
                        <p><strong>Producto Relacionado:</strong> <span id="comment_product"></span></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para eliminar el comentario -->
        <div class="modal fade" id="eliminarComentarioModal" tabindex="-1"
            aria-labelledby="eliminarComentarioModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="eliminarComentarioModalLabel">Eliminar Comentario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>¿Estás seguro de que deseas eliminar este comentario?</p>
                    </div>
                    <div class="modal-footer">
                        <form id="formEliminarComentario" action="" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección para editar el header principal -->
        <div class="row">
            <div class="col-lg-12 mb-4">
                @if ($informacionesEncabezado->isNotEmpty())
                    <div id="headerCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach ($informacionesEncabezado as $index => $informacion)
                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}" data-id="{{ $informacion->id }}">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row align-items-center mb-4 position-relative">
                                                <div class="col-12 position-absolute h-100"
                                                    style="background: url('{{ asset($informacion->imagen) }}') no-repeat center center; background-size: cover; opacity: 0.7;">
                                                </div>
                                                <div class="col-md-7 col-xl-5 col-xxl-4 p-4 p-lg-5 position-relative" style="z-index: 1;">
                                                    <h1 class="card-title header-title mt-xl-5 mb-4" style="color: rgb(255, 255, 255);">
                                                        {{ $informacion->titulo }}</h1>
                                                    <p class="fs-3 header-description" style="color: rgb(255, 255, 255);">
                                                        {{ $informacion->descripcion }}</p>
                                                </div>
                                            </div>

                                            <div class="text-center mt-4">
                                                <div class="d-flex justify-content-center align-items-center">
                                                
                                                    <button class="btn btn-warning me-2 dropdown-edit-header" type="button" data-id="{{ $informacion->id }}" data-titulo="{{ $informacion->titulo }}" data-descripcion="{{ $informacion->descripcion }}">
                                                        <i class="bx bx-edit"></i>
                                                    </button>
                                                    
                                                    <form action="{{ route('gestionSitio.eliminarHeader', $informacion->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta información?');" class="me-2">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">
                                                            <i class="bx bx-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#headerCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#headerCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                @else
                    <div class="text-center mb-4">
                        <p class="text-muted">Aún no hay información subida.</p>
                    </div>
                @endif
                <br>
                <div class="d-flex justify-content-center mb-4">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarHeaderModal">
                        <i class="bx bx-plus"></i> Agregar Header
                    </button>
                </div>
                
            </div>
          
        </div>

        <!-- Modal para agregar contenido en el header -->
        <div class="modal fade" id="agregarHeaderModal" tabindex="-1" aria-labelledby="agregarHeaderModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="agregarHeaderModalLabel">Agregar Nuevo Contenido en Header</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('gestionSitio.agregarContenido') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="tipo" value="encabezado">
                            <div class="mb-3">
                                <label for="titulo" class="form-label">Título:</label>
                                <input type="text" name="titulo" id="titulo" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="descripcion" class="form-label">Descripción:</label>
                                <input type="text" name="descripcion" id="descripcion" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="imagen">Seleccionar Imagen:</label>
                                <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Agregar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para editar el header -->
        <div class="modal fade" id="editarHeaderModal" tabindex="-1" aria-labelledby="editarHeaderModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editarHeaderModalLabel">Editar Header</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formEditarHeader" action="" method="POST" enctype="multipart/form-data">
                            @csrf
                            <!-- Campo oculto para almacenar el ID del elemento a editar -->
                            <input type="hidden" id="elemento_id" name="elemento_id">
                            <!-- Campos para editar la información -->
                            <div class="mb-3">
                                <label for="titulo" class="form-label">Título:</label>
                                <input type="text" name="titulo" id="titulo" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="descripcion" class="form-label">Descripción:</label>
                                <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="imagen">Seleccionar Imagen:</label>
                                <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
                            </div>
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var editButtons = document.querySelectorAll('.dropdown-edit-header');
                editButtons.forEach(function (button) {
                    button.addEventListener('click', function () {
                        var id = button.getAttribute('data-id');
                        var titulo = button.getAttribute('data-titulo');
                        var descripcion = button.getAttribute('data-descripcion');

                        var form = document.getElementById('formEditarHeader');
                        var action = "{{ route('gestionSitio.editarContenido', ':id') }}";
                        action = action.replace(':id', id);
                        form.action = action;

                        document.getElementById('elemento_id').value = id;
                        document.getElementById('titulo').value = titulo;
                        document.getElementById('descripcion').value = descripcion;

                        $('#editarHeaderModal').modal('show');
                    });
                });
            });
        </script>
<!-- Sección de productos destacados -->
<div class="row">
    <div class="col-lg-12 mb-4">
        <div class="card" data-id="3">
            <div class="card-body">
                <h5 class="card-title text-center">Productos Destacados</h5>
                <!-- Carrusel de productos destacados -->
                <div id="productosDestacadosCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach ($productosDestacados->chunk(4) as $chunk)
                            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                <div class="row gx-2">
                                    @foreach ($chunk as $producto)
                                        <div class="col-md-3 mb-4">
                                            <div class="card h-100 text-white rounded-3">
                                                <img class="img-fluid rounded-3 w-100"
                                                    src="{{ $producto->imagen_producto ? asset('storage/imagenes_productos/' . $producto->imagen_producto) : asset('assets/img/gallery/default.jpg') }}"
                                                    alt="Producto {{ $producto->nombre }}" style="object-fit: cover; height: 200px;">
                                                <div class="card-body ps-2 pe-2">
                                                    <h5 class="fw-bold text-1000 fs-6"
                                                        style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                        {{ $producto->nombre }}
                                                    </h5>
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        @if ($producto->descuento)
                                                            <span
                                                                class="text-muted text-decoration-line-through fs-6">${{ number_format($producto->precio_venta_bruto, 0, ',', '.') }}</span>
                                                            <span class="text-danger fw-bold fs-6">
                                                                @if ($producto->descuento->porcentaje)
                                                                    ${{ number_format($producto->precio_venta_bruto * (1 - $producto->descuento->porcentaje / 100), 0, ',', '.') }}
                                                                @elseif($producto->descuento->monto)
                                                                    ${{ number_format($producto->precio_venta_bruto - $producto->descuento->monto, 0, ',', '.') }}
                                                                @endif
                                                            </span>
                                                        @else
                                                            <span class="text-danger fw-bold fs-6">
                                                                ${{ number_format($producto->precio_venta_bruto, 0, ',', '.') }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev position-absolute top-50 start-0 translate-middle-y"
                        type="button" data-bs-target="#productosDestacadosCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next position-absolute top-50 end-0 translate-middle-y"
                        type="button" data-bs-target="#productosDestacadosCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card img {
        height: 200px;
        object-fit: cover;
        width: 100%;
    }

    .card-body h5 {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>

<!-- Super Card -->
<div class="card" data-id="4">
    <div class="card-body">
        <!-- Formulario de búsqueda -->
        <div class="mb-4">
            <div class="input-group">
                <input type="text" id="searchItems" class="form-control" placeholder="Buscar producto..." onkeypress="handleKeyPress(event)" oninput="clearSearchResults()">
                <button class="btn btn-primary" type="button" onclick="filterItems()">Buscar</button>
            </div>
        </div>

        <button type="button" class="btn btn-primary btn-sm mt-2" onclick="actualizarProductosDestacados()">Actualizar Productos Destacados</button>

        <!-- Listado de productos -->
        <form id="formProductosDestacados">
            @csrf
            <div class="accordion pt-3" id="accordionExample">
                <div class="accordion-item border rounded mb-2">
                    <h2 class="accordion-header" id="headingProductos">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseProductos" aria-expanded="true" aria-controls="collapseProductos">
                            Seleccionar Productos
                        </button>
                    </h2>
                    <div id="collapseProductos" class="accordion-collapse collapse show" aria-labelledby="headingProductos">
                        <div class="accordion-body">
                            <div class="list-group" id="productosList">
                                @foreach ($productosDestacados as $producto)
                                    <div class="list-group-item d-flex justify-content-between align-items-center producto-item item">
                                        <span>{{ $producto->nombre }}</span>
                                        <div class="form-check">
                                            <input class="form-check-input item-checkbox" type="checkbox"
                                                name="productos[]" id="producto_{{ $producto->id }}"
                                                value="{{ $producto->id }}" checked>
                                            <label class="form-check-label" for="producto_{{ $producto->id }}">
                                                Destacado
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="list-group mt-2" id="searchResults"></div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function handleKeyPress(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            filterItems();
        }
    }

    function clearSearchResults() {
        const filter = document.getElementById('searchItems').value;
        if (filter.trim() === '') {
            const searchResults = document.getElementById('searchResults');
            searchResults.innerHTML = '';
        }
    }

    function filterItems() {
        const filter = document.getElementById('searchItems').value.toLowerCase();
        if (filter.length > 2) {
            fetch(`/api/search-products?query=${filter}`)
                .then(response => response.json())
                .then(data => {
                    const searchResults = document.getElementById('searchResults');
                    searchResults.innerHTML = '';
                    data.forEach(product => {
                        const item = document.createElement('div');
                        item.classList.add('list-group-item', 'd-flex', 'justify-content-between', 'align-items-center', 'producto-item', 'item');
                        item.innerHTML = `
                            <span>${product.nombre}</span>
                            <div class="form-check">
                                <input class="form-check-input item-checkbox" type="checkbox" name="productos[]" id="producto_${product.id}" value="${product.id}">
                                <label class="form-check-label" for="producto_${product.id}">Destacado</label>
                            </div>
                        `;
                        searchResults.appendChild(item);
                    });

                    // Abrir el acordeón automáticamente
                    const collapseElement = document.getElementById('collapseProductos');
                    const bsCollapse = new bootstrap.Collapse(collapseElement, {
                        toggle: false
                    });
                    bsCollapse.show();
                });
        } else {
            clearSearchResults();
        }
    }

    function actualizarProductosDestacados() {
        const form = document.getElementById('formProductosDestacados');
        const formData = new FormData(form);
        
        fetch('{{ route("gestion.actualizarProductosDestacados") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        })
        .then(response => response.json())
        .then(data => {
            alert(data.success);
            window.location.reload();
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    document.getElementById('searchItems').addEventListener('keypress', handleKeyPress);
</script>





   <script>
    $(document).ready(function() {
        $('.dropdown-edit-informativa').on('click', function() {
            var card = $(this).closest('.informativa-card');
            var id = card.data('id');

            var titulo = card.find('.informativa-title').text().trim();
            var descripcion = card.find('.informativa-description').text().trim();

            $('#editarInformativaModal #elemento_id').val(id);
            $('#editarInformativaModal #titulo').val(titulo);
            $('#editarInformativaModal #descripcion').val(descripcion);

            var action = '{{ route('gestionSitio.editarContenido', ':id') }}';
            action = action.replace(':id', id);
            $('#formEditarInformativa').attr('action', action);

            $('#editarInformativaModal').modal('show');
        });
    });
</script>
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Sección para gestionar la sección informativa -->
    <div class="row">
        <div class="col-lg-12 mb-4">
            @if ($informacionesInformativas->isNotEmpty())
                <div id="informativaCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach ($informacionesInformativas as $index => $informacion)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}" data-id="{{ $informacion->id }}">
                                <div class="card fixed-card-size">
                                    <div class="card-body">
                                        <div class="row align-items-center mb-4 position-relative">
                                            <div class="col-12 position-absolute h-100 fixed-image-size" style="background: url('{{ asset($informacion->imagen) }}') no-repeat center center; background-size: cover; opacity: 0.7;">
                                            </div>
                                            <div class="col-md-7 col-xl-5 col-xxl-4 p-4 p-lg-5 position-relative" style="z-index: 1;">
                                                <h1 class="card-title informativa-title mt-xl-5 mb-4" style="color: rgb(255, 255, 255);">{{ $informacion->titulo }}</h1>
                                                <p class="fs-5 informativa-description" style="color: rgb(255, 255, 255);">{{ $informacion->descripcion }}</p>
                                            </div>
                                        </div>

                                        <div class="text-center mt-4">
                                            <div class="d-flex justify-content-center align-items-center">

                                                <a href="{{ route('informacion.crearDetallada', ['id' => $informacion->id]) }}" class="btn btn-warning me-2"><i class="bx bx-edit"></i></a>
                                                <form action="{{ route('informacion.eliminar', $informacion->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta información?');" class="me-2">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger"><i class="bx bx-trash"></i></button>
                                                </form>
                                            </div>
                                        </div>
                                    
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <button class="carousel-control-prev" type="button" data-bs-target="#informativaCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#informativaCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            @else
                <div class="text-center mb-4">
                    <p class="text-muted">Aún no hay información subida.</p>
                </div>
            @endif
            <br>
            <div class="d-flex justify-content-center mb-4">
                <button class="btn btn-primary me-2" type="button" data-bs-toggle="modal" data-bs-target="#agregarInformativaModal">
                    <i class="bx bx-plus"></i>Agregar Informativo
                </button>
            </div>
            
          
            <div class="d-flex justify-content-center mt-4">
                {{ $informacionesInformativas->links('pagination.custom', ['paginator' => $informacionesInformativas]) }}
            </div>
        </div>
    </div>
    
    <!-- Modal para agregar contenido en la sección informativa -->
    <div class="modal fade" id="agregarInformativaModal" tabindex="-1" aria-labelledby="agregarInformativaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="agregarInformativaModalLabel">Agregar Nuevo Contenido en Sección Informativa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('gestionSitio.agregarContenido') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="tipo" value="informativo">
                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título:</label>
                            <input type="text" name="titulo" id="titulo" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción:</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="imagen">Seleccionar Imagen:</label>
                            <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Agregar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
@endsection

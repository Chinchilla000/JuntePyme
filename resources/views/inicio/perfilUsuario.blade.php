@extends('layouts.header')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <style>
        @media (max-width: 768px) {

            /* Estilos para pantallas pequeñas, como dispositivos móviles */
            .container {
                padding: 0 15px;
                /* Reduce el padding lateral para más espacio */
            }

            .card {
                margin-bottom: 20px;
                /* Añade más espacio entre las tarjetas */
            }

            .card-header,
            .card-body {
                padding: 10px;
                /* Menos padding dentro de las tarjetas para más espacio */
            }

            .btn {
                width: 100%;
                /* Botones a ancho completo para facilitar la interacción */
                margin-bottom: 10px;
                /* Espacio entre botones si están uno encima del otro */
            }

            .modal-dialog {
                margin: 20px;
                /* Menos margen alrededor de los modales */
            }

            .modal-content {
                padding: 10px;
                /* Menos padding dentro del modal */
            }

            .table-responsive {
                overflow-x: auto;
                /* Permite desplazamiento lateral en tablas si es necesario */
            }
        }

        @media (max-width: 768px) {
            .mobile-friendly-table thead {
                display: none; // Oculta los encabezados en dispositivos pequeños
            }

            .mobile-friendly-table,
            .mobile-friendly-table tbody,
            .mobile-friendly-table tr,
            .mobile-friendly-table td {
                display: block;
                width: 100%;
            }

            .mobile-friendly-table td {
                position: relative;
                padding-left: 40%; // Deja espacio para la etiqueta del encabezado
                text-align: right; // Alinea el contenido a la derecha
                margin-top: 20px; // Espacio entre filas
                border-top: 10px solid #ddd; // Separa visualmente las filas
            }

            .mobile-friendly-table td::before {
                content: attr(data-label);
                position: absolute;
                left: 10px;
                width: 45%;
                padding-right: 15px;
                text-align: left;
                font-weight: bold;
            }

            .mobile-friendly-table td[data-label="Acciones:"] {
                text-align: center; // Centra los botones en su celda
                padding-left: 0; // Remueve el padding para acciones para maximizar el espacio
            }

            .btn-block {
                display: block;
                width: 100%; // Hace que los botones ocupen todo el ancho de la celda
                margin-bottom: 5px; // Añade un espacio entre botones
            }
        }

        @media (max-width: 768px) {
            .pagination {
                font-size: 12px;
                /* Reduce el tamaño para ahorrar espacio */
                justify-content: center;
                /* Centra la paginación */
            }
        }

        @media (max-width: 768px) {
            .form-control {
                font-size: 12px;
                /* Reduce el tamaño de fuente para ajustar mejor los elementos */
            }
        }
    </style>
    <div class="container mt-4">
        <div class="row">
            <!-- Panel/Tabla Lado Izquierdo -->
            <div class="col-md-5">
                <div class="card mb-4">
                    <h5 class="card-header">Información perfil</h5>
                    <div class="card-body">
                        <form id="formAccountSettings" method="POST" action="{{ route('password.update') }}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <!-- Nombre -->
                                <div class="mb-3 col-md-6">
                                    <label for="firstName" class="form-label">Nombre</label>
                                    <input class="form-control" type="text" id="firstName" name="firstName"
                                        value="{{ Auth::user()->name }}" autofocus />
                                </div>
                                <!-- Correo Electrónico -->
                                <div class="mb-3 col-md-6">
                                    <label for="email" class="form-label">Correo Electrónico</label>
                                    <input class="form-control" type="email" id="email" name="email"
                                        value="{{ Auth::user()->email }}" />
                                </div>
                                <!-- Contraseña Actual (opcional, para cambios de contraseña) -->
                                <div class="mb-3 col-md-6">
                                    <label for="currentPassword" class="form-label">Contraseña Actual</label>
                                    <input class="form-control" type="password" id="currentPassword"
                                        name="currentPassword" />
                                </div>
                                <!-- Nueva Contraseña -->
                                <div class="mb-3 col-md-6">
                                    <label for="newPassword" class="form-label">Nueva Contraseña</label>
                                    <input class="form-control" type="password" id="newPassword" name="newPassword" />
                                </div>
                                <!-- Confirmación de Nueva Contraseña -->
                                <div class="mb-3 col-md-6">
                                    <label for="confirmPassword" class="form-label">Confirmar Nueva Contraseña</label>
                                    <input class="form-control" type="password" id="confirmPassword"
                                        name="confirmPassword" />
                                </div>
                                <!-- Botones para guardar o cancelar los cambios -->
                                <div class="mt-2">
                                    <button type="submit" class="btn btn-primary me-2">Guardar Cambios</button>
                                    <button type="reset" class="btn btn-outline-secondary">Cancelar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @if (auth()->user()->role === 'admin')
                <!-- Panel/Tabla Lado Derecho (Creación de Usuarios) -->
                <div class="col-md-7">
                    <div class="card mb-4">
                        <h5 class="card-header">Usuarios</h5>
                        <div class="card-body">
                            <!-- Botón para abrir el modal -->
                            <div class="card-body">
                                <!-- Button trigger modal -->
                                <div class="d-flex flex-column flex-sm-row justify-content-between">
                                    <button type="button" class="btn btn-primary mb-2 mb-sm-0" data-bs-toggle="modal"
                                        data-bs-target="#modalCenter">
                                        Crear usuario
                                    </button>
                                </div>

                                <!-- Modal para el usuario y cliente -->
                                @include('inicio.extencionesCodigo')

                                <script src="../../assets/vendor/js/bootstrap.js"></script>
                            </div>
                            <!-- Tabla para mostrar usuarios (excluyendo a los usuarios con rol 'User') -->
                            <div class="table-responsive">
                                <table class="table mobile-friendly-table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Nombre</th>
                                            <th scope="col">Correo</th>
                                            <th scope="col">Acciones usuarios</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($usuarios as $usuario)
                                            @if ($usuario->role !== 'User')
                                                <tr>
                                                    <td data-label="Nombre:">{{ $usuario->name }}</td>
                                                    <td data-label="Correo:">{{ $usuario->email }}</td>
                                                    <td data-label="Acciones:">
                                                        <button type="button" class="btn btn-primary btn-block"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modalOpciones{{ $usuario->id }}">
                                                            Opciones
                                                        </button>
                                                        <button type="button" class="btn btn-primary btn-block"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modalDetalles{{ $usuario->id }}">
                                                            Detalles
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            {{ $usuarios->links('pagination.custom') }}
                        </div>
                    </div>
                </div>
                 <!-- Tabla de Clientes -->
                <div class="col-md-12">
                    <div class="card mb-4">
                        <h5 class="card-header">Clientes</h5>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table mobile-friendly-table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Nombre</th>
                                            <th scope="col">Correo</th>
                                            <th scope="col">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($clientes as $cliente)
                                        <tr>
                                            <td data-label="Nombre:">{{ $cliente->name }}</td>
                                            <td data-label="Correo:">{{ $cliente->email }}</td>
                                            <td data-label="Acciones:">
                                                <button type="button" class="btn btn-primary btn-block" data-bs-toggle="modal" data-bs-target="#modalDetallesCliente{{ $cliente->id }}">
                                                    Detalles
                                                </button>
                                                <button type="button" class="btn btn-primary btn-block" data-bs-toggle="modal" data-bs-target="#modalEditarDatos{{ $cliente->id }}">
                                                    Editar datos
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- Paginación para clientes (User) -->
                            <div class="d-flex justify-content-center mt-3">
                                {{ $clientes->withQueryString()->links('pagination.custom') }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <!-- Modales para cada cliente para más detalles -->
            <!-- Se hace desde el include -->
        </div>
    </div>

    <!--Modal para las acciones para usuarios -->
    <!-- Modal -->
    @foreach ($usuarios as $usuario)
        <div class="modal fade" id="modalOpciones{{ $usuario->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Vista para el usuario {{ $usuario->name }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    @if ($usuario->role === 'User')
                        <div class="modal-body">
                            <p>Los clientes no trabajan con las vistas de gestión.</p>
                        </div>
                    @else
                        <form id="userPreferenceForm" action="{{ route('inicio.actualizarPreferencias') }}"
                            method="POST">
                            @csrf
                            <input type="hidden" name="userId" value="{{ $usuario->id }}">
                            <div class="modal-body">
                                <!-- Aquí ajustamos las preferencias según los requisitos: Productos, Proveedores, Ventas, rendición, GestionSitio -->
                                <div class="d-flex mb-3">
                                    <i class="menu-icon fas fa-tags"></i>
                                    <div class="flex-grow-1 row">
                                        <div class="col-9 mb-sm-0 mb-2">
                                            <h6 class="mb-0">Categorías</h6>
                                            <small class="text-muted">Activación para gestionar categorías</small>
                                        </div>
                                        <div class="col-3 text-end">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input float-end" type="checkbox"
                                                    name="preferencias[Categorias]" value="1"
                                                    {{ $preferenciasPorUsuario[$usuario->id]['Categorias'] ?? false ? 'checked' : '' }}>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex mb-3">
                                    <i class="menu-icon tf-icons bx bx-box"></i>
                                    <div class="flex-grow-1 row">
                                        <div class="col-9 mb-sm-0 mb-2">
                                            <h6 class="mb-0">Productos</h6>
                                            <small class="text-muted">Activación para gestionar productos</small>
                                        </div>
                                        <div class="col-3 text-end">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input float-end" type="checkbox"
                                                    name="preferencias[Productos]" value="1"
                                                    {{ $preferenciasPorUsuario[$usuario->id]['Productos'] ?? false ? 'checked' : '' }}>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex mb-3">
                                    <i class="menu-icon tf-icons bx bx-building"></i>
                                    <div class="flex-grow-1 row">
                                        <div class="col-9 mb-sm-0 mb-2">
                                            <h6 class="mb-0">Proveedores</h6>
                                            <small class="text-muted">Activación para gestionar los proveedores</small>
                                        </div>
                                        <div class="col-3 text-end">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input float-end" type="checkbox"
                                                    name="preferencias[Proveedores]" value="1"
                                                    {{ $preferenciasPorUsuario[$usuario->id]['Proveedores'] ?? false ? 'checked' : '' }}>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex mb-3">
                                    <i class="menu-icon tf-icons bx bx-building"></i>
                                    <div class="flex-grow-1 row">
                                        <div class="col-9 mb-sm-0 mb-2">
                                            <h6 class="mb-0">Descuentos</h6>
                                            <small class="text-muted">Activación para gestionar los Descuentos</small>
                                        </div>
                                        <div class="col-3 text-end">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input float-end" type="checkbox"
                                                    name="preferencias[Descuentos]" value="1"
                                                    {{ $preferenciasPorUsuario[$usuario->id]['Descuentos'] ?? false ? 'checked' : '' }}>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex mb-3">
                                    <i class="menu-icon tf-icons bx bx-cart"></i>
                                    <div class="flex-grow-1 row">
                                        <div class="col-9 mb-sm-0 mb-2">
                                            <h6 class="mb-0">Ventas</h6>
                                            <small class="text-muted">Activación para visualizar y gestionar ventas</small>
                                        </div>
                                        <div class="col-3 text-end">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input float-end" type="checkbox"
                                                    name="preferencias[Ventas]" value="1"
                                                    {{ $preferenciasPorUsuario[$usuario->id]['Ventas'] ?? false ? 'checked' : '' }}>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex mb-3">
                                    <i class="menu-icon tf-icons bx bx-calculator"></i>
                                    <div class="flex-grow-1 row">
                                        <div class="col-9 mb-sm-0 mb-2">
                                            <h6 class="mb-0">Rendición</h6>
                                            <small class="text-muted">Gestión de rendición de cuentas</small>
                                        </div>
                                        <div class="col-3 text-end">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input float-end" type="checkbox"
                                                    name="preferencias[Rendicion]" value="1"
                                                    {{ $preferenciasPorUsuario[$usuario->id]['Rendicion'] ?? false ? 'checked' : '' }}>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex mb-3">
                                    <i class="menu-icon tf-icons bx bx-cog"></i>
                                    <div class="flex-grow-1 row">
                                        <div class="col-9 mb-sm-0 mb-2">
                                            <h6 class="mb-0">Gestion Sitio</h6>
                                            <small class="text-muted">Gestión del sitio Web</small>
                                        </div>
                                        <div class="col-3 text-end">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input float-end" type="checkbox"
                                                    name="preferencias[GestionSitio]" value="1"
                                                    {{ $preferenciasPorUsuario[$usuario->id]['GestionSitio'] ?? false ? 'checked' : '' }}>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex mb-3">
                                    <i class="menu-icon tf-icons bx bx-user"></i>
                                    <div class="flex-grow-1 row">
                                        <div class="col-9 mb-sm-0 mb-2">
                                            <h6 class="mb-0">Contactos</h6>
                                            <small class="text-muted">Gestionar Contactos</small>
                                        </div>
                                        <div class="col-3 text-end">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input float-end" type="checkbox"
                                                    name="preferencias[Contactos]" value="1"
                                                    {{ $preferenciasPorUsuario[$usuario->id]['Contactos'] ?? false ? 'checked' : '' }}>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                            </div>
                        </form>
                    @endif

                </div>
            </div>
        </div>
    @endforeach
    @foreach ($usuarios as $usuario)
        <div class="modal fade" id="modalDetalles{{ $usuario->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Detalles del Usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Nombre:</strong> {{ $usuario->name }}</p>
                                <p><strong>Correo Electrónico:</strong> {{ $usuario->email }}</p>
                                <p><strong>Rol:</strong> {{ $usuario->role == 'User' ? 'Cliente' : $usuario->role }}</p>
                            </div>
                            <div class="col-md-6">
                                <!-- Mostrar detalles adicionales del usuario -->
                                @php
                                    $user_info = App\Models\UserInformacion::where('user_id', $usuario->id)->first();
                                @endphp
                                @if ($user_info)
                                    <p><strong>RUT:</strong> {{ $user_info->rut }}</p>
                                    <p><strong>Teléfono:</strong> {{ $user_info->telefono }}</p>
                                    <p><strong>Dirección:</strong> {{ $user_info->direccion }}</p>
                                    <!-- Agrega aquí más detalles si es necesario -->
                                @else
                                    <p>No se encontraron detalles adicionales para este usuario.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <form action="{{ route('usuario.eliminar', ['id' => $usuario->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Eliminar Usuario</button>
                        </form>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var optionButtons = document.querySelectorAll('[data-bs-toggle="modal"][data-user-id]');
            optionButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    var userId = button.getAttribute('data-user-id');
                    var modalId = button.getAttribute('data-bs-target');
                    var modal = document.querySelector(modalId);
                    if (modal) {
                        var inputUserId = modal.querySelector('input[name="userId"]');
                        if (inputUserId) {
                            inputUserId.value =
                                userId; // Establecer el valor de userId en el campo oculto
                        }

                        var xhr = new XMLHttpRequest();
                        xhr.onreadystatechange = function() {
                            if (xhr.readyState === XMLHttpRequest.DONE) {
                                if (xhr.status === 200) {
                                    var preferencias = JSON.parse(xhr.responseText);
                                    var opcionesPredeterminadas = ['Categorias','Productos', 'Proveedores', 'Descuentos',
                                        'Ventas', 'Rendicion', 'GestionSitio','Contactos'
                                    ];
                                    opcionesPredeterminadas.forEach(function(opcion) {
                                        var checkbox = modal.querySelector(
                                            `input[name="preferencias[${opcion}]"]`);
                                        if (checkbox) {
                                            checkbox.checked = preferencias[opcion] ==
                                                1;
                                        }
                                    });
                                } else {
                                    console.error(
                                        'Error al obtener las preferencias del usuario: ' +
                                        xhr.statusText);
                                }
                            }
                        };
                        xhr.open('GET', '/inicio/obtener-preferencias/' + userId, true);
                        xhr.send();
                    }
                });
            });
        });
        document.querySelectorAll('.btn-toggle-details').forEach(button => {
            button.addEventListener('click', function() {
                const detailsRow = this.closest('tr')
                .nextElementSibling; // Asume que los detalles están en la siguiente fila
                detailsRow.classList.toggle('d-none');
            });
        });
    </script>
@endsection

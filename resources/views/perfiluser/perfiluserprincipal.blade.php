@include('layoutsprincipal.header')
@include('layoutsprincipal.nav')

<style>
    .profile-img {
        width: 200px;
        height: 200px;
        object-fit: cover;
        border-radius: 50%;
    }
    .modal-content {
        max-width: 100%;
        overflow-x: hidden;
    }
    /* Asegúrate de que el modal ocupe toda la pantalla en dispositivos móviles */
.modal {
    overflow-y: auto;
}

.modal-open {
    overflow: hidden;
}

/* Asegúrate de que el contenido de la tarjeta no se deforme */
.card {
    transition: all 0.3s ease-in-out;
}

   .pagination {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
}

.pagination-wrapper {
    width: 100%;
    overflow-x: auto;
}

</style>

<section class="py-4 bg-light pt-6">
    <br>
    <div class="container">
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="row">
            <!-- Sidebar del Perfil -->
            <div class="col-lg-4 mb-4">
                <div class="card text-center">
                    <img src="assets/img/gallery/sinfoto.png" class="card-img-top profile-img mx-auto" alt="Imagen de Perfil">
                    <div class="card-body">
                        <h1>Perfil de Usuario</h1>
                        <div><strong>Nombre:</strong> {{ $usuario->name }}</div>
                        <div><strong>Email:</strong> {{ $usuario->email }}</div>
                        <div><strong>Fecha de Registro:</strong> {{ $usuario->created_at->format('d/m/Y') }}</div>
                        <button class="btn btn-info mt-3" data-bs-toggle="modal" data-bs-target="#editProfileModal">Editar Perfil</button>
                        <button class="btn btn-secondary mt-3" data-bs-toggle="modal" data-bs-target="#viewDetailsModal">Ver Detalles</button>
                    </div>
                </div>
            </div>

            <!-- Mascotas Section -->
            <div class="col-lg-8 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                        <h5 class="mb-0">Mis Mascotas</h5>
                        <div class="d-flex justify-content-center pt-2 pt-md-0">
                            {{ $mascotas->links('pagination::bootstrap-4') }}
                        </div>
                        <button class="btn btn-success mt-2 mt-md-0" data-bs-toggle="modal" data-bs-target="#addPetModal">Agregar Mascota</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Especie</th>
                                        <th>Raza</th>
                                        <th>Edad</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($mascotas) && $mascotas->isNotEmpty())
                                        @foreach ($mascotas as $mascota)
                                        <tr>
                                            <td>{{ $mascota->nombre }}</td>
                                            <td>{{ $mascota->especie }}</td>
                                            <td>{{ $mascota->raza }}</td>
                                            <td>{{ $mascota->fecha_cumpleanos ? \Carbon\Carbon::parse($mascota->fecha_cumpleanos)->format('d/m/Y') : 'No especificado' }}</td>
                                            <td>
                                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editPetModal{{$mascota->id}}">Editar</button>
                                            </td>
                                        </tr>
                                        <!-- Modal para editar mascota -->
                                        <div class="modal fade" id="editPetModal{{$mascota->id}}" tabindex="-1" aria-labelledby="editPetModalLabel{{$mascota->id}}" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editPetModalLabel{{$mascota->id}}">Editar Mascota</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('mascotas.update', $mascota->id) }}" method="post">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label for="petName{{$mascota->id}}" class="form-label">Nombre</label>
                                                                        <input type="text" class="form-control" id="petName{{$mascota->id}}" name="nombre" required value="{{ $mascota->nombre }}">
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="species{{$mascota->id}}" class="form-label">Especie</label>
                                                                        <input type="text" class="form-control" id="species{{$mascota->id}}" name="especie" required value="{{ $mascota->especie }}">
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="breed{{$mascota->id}}" class="form-label">Raza</label>
                                                                        <input type="text" class="form-control" id="breed{{$mascota->id}}" name="raza" value="{{ $mascota->raza }}">
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="birthday{{$mascota->id}}" class="form-label">Fecha de Nacimiento</label>
                                                                        <input type="text" class="form-control" id="birthday{{$mascota->id}}" name="fecha_cumpleanos_display" value="{{ \Carbon\Carbon::parse($mascota->fecha_cumpleanos)->format('d-m-Y') }}" readonly>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label for="alimento{{$mascota->id}}" class="form-label">Alimento</label>
                                                                        <input type="text" class="form-control" id="alimento{{$mascota->id}}" name="alimento" value="{{ $mascota->alimento }}">
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="peso{{$mascota->id}}" class="form-label">Peso</label>
                                                                        <div class="input-group">
                                                                            <input type="text" class="form-control" id="peso{{$mascota->id}}" name="peso" required value="{{ $mascota->pesoYUnidad['peso'] }}">
                                                                            <select class="form-control" id="unidad{{$mascota->id}}" name="unidad">
                                                                                <option value="kilos" {{ $mascota->pesoYUnidad['unidad'] == 'kilos' ? 'selected' : '' }}>Kilos</option>
                                                                                <option value="gramos" {{ $mascota->pesoYUnidad['unidad'] == 'gramos' ? 'selected' : '' }}>Gramos</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="color{{$mascota->id}}" class="form-label">Color</label>
                                                                        <input type="text" class="form-control" id="color{{$mascota->id}}" name="color" value="{{ $mascota->color }}">
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="sexo{{$mascota->id}}" class="form-label">Sexo</label>
                                                                        <select class="form-control" id="sexo{{$mascota->id}}" name="sexo">
                                                                            <option value="macho" {{ $mascota->sexo == 'macho' ? 'selected' : '' }}>Macho</option>
                                                                            <option value="hembra" {{ $mascota->sexo == 'hembra' ? 'selected' : '' }}>Hembra</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <button type="submit" class="btn btn-primary">Actualizar Mascota</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5">No tienes mascotas registradas y recuerda puedes ingresar 5 mascotas.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <br>
                <div class="card">
    <div id="historial-de-compras" class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Historial de Compras</h5>
        <div class="pagination-wrapper d-flex justify-content-center pt-2 pt-md-0">
            {{ $ordenes->links('pagination::bootstrap-4') }}
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($ordenes) && $ordenes->isNotEmpty())
                        @foreach ($ordenes as $orden)
                            <tr>
                                <td>{{ $orden->created_at->format('d/m/Y') }}</td>
                                <td>${{ number_format($orden->total, 0, ',', '.') }}</td>
                                <td>
                                    @if($orden->status == 'pending')
                                        Pendiente
                                    @elseif($orden->status == 'completed')
                                        Completada
                                    @elseif($orden->status == 'rejected')
                                        Rechazada
                                    @else
                                        {{ ucfirst($orden->status) }}
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#viewOrderDetailsModal{{$orden->id}}">Ver Detalles</button>
                                </td>
                            </tr>
                            <!-- Modal para ver detalles de la orden -->
                            <div class="modal fade" id="viewOrderDetailsModal{{$orden->id}}" tabindex="-1" aria-labelledby="viewOrderDetailsModalLabel{{$orden->id}}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="viewOrderDetailsModalLabel{{$orden->id}}">Detalles de la Orden</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div><strong>ID de Orden:</strong> {{ $orden->reference }}</div>
                                            <div><strong>Total:</strong> ${{ number_format($orden->total, 0, ',', '.') }}</div>
                                            <div><strong>Status:</strong> 
                                                @if($orden->status == 'pending')
                                                    Pendiente
                                                @elseif($orden->status == 'completed')
                                                    Completada
                                                @elseif($orden->status == 'rejected')
                                                    Rechazada
                                                @else
                                                    {{ ucfirst($orden->status) }}
                                                @endif
                                            </div>
                                            <div><strong>Fecha:</strong> {{ $orden->created_at->format('d/m/Y') }}</div>
                                            <div><strong>Productos:</strong></div>
                                            <ul>
                                                @foreach ($orden->productos as $producto)
                                                    <li>{{ $producto->nombre }} - Cantidad: {{ $producto->pivot->cantidad }} - Precio: ${{ number_format($producto->pivot->precio, 0, ',', '.') }} - Descuento: ${{ number_format($producto->pivot->descuento, 0, ',', '.') }}</li>
                                                @endforeach
                                            </ul>
                                        
                                            @if($orden->detallesOrden)
                                                <div><strong>Tipo de Retiro:</strong> {{ $orden->detallesOrden->tipo_retiro }}</div>
                                                @if($orden->detallesOrden->tipo_retiro == 'retiro')
                                                    <div><strong>Estado de Retiro:</strong> 
                                                        <span class="badge" style="background-color: {{ $orden->detallesOrden->listo_para_retiro ? 'green' : 'red' }};">
                                                            {{ $orden->detallesOrden->listo_para_retiro ? 'Pedido listo para retirar' : 'Aún no listo para retirar' }}
                                                        </span>
                                                    </div>
                                                    <div><strong>Estado de Producto Retirado:</strong> 
                                                        <span class="badge" style="background-color: {{ $orden->detallesOrden->retirado ? 'green' : 'red' }};">
                                                            {{ $orden->detallesOrden->retirado ? 'Producto retirado' : 'Producto no retirado' }}
                                                        </span>
                                                    </div>
                                                @elseif($orden->detallesOrden->tipo_retiro == 'domicilio')
                                                    <div><strong>Estado de Envío:</strong> 
                                                        <span class="badge" style="background-color: {{ $orden->detallesOrden->listo_para_retiro ? 'green' : 'red' }};">
                                                            {{ $orden->detallesOrden->listo_para_retiro ? 'Tu pedido fue enviado' : 'Aun no lo envian' }}
                                                        </span>
                                                    </div>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5">No tienes órdenes registradas.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5>Opciones de Cuenta</h5>
            </div>
            <div class="card-body">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#changePasswordModal">Cambiar Contraseña</button>
                <button class="btn btn-danger">Eliminar Cuenta</button>
            </div>
        </div>
    </div>
</section>

<!-- Modal para agregar nueva mascota -->
<div class="modal fade" id="addPetModal" tabindex="-1" aria-labelledby="addPetModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPetModalLabel">Agregar Nueva Mascota</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('mascotas.store') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="petName" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="petName" name="nombre" required>
                            </div>
                            <div class="mb-3">
                                <label for="species" class="form-label">Especie</label>
                                <input type="text" class="form-control" id="species" name="especie" required>
                            </div>
                            <div class="mb-3">
                                <label for="breed" class="form-label">Raza</label>
                                <input type="text" class="form-control" id="breed" name="raza">
                            </div>
                            <div class="mb-3">
                                <label for="birthday" class="form-label">Fecha de Nacimiento</label>
                                <input type="date" class="form-control" id="birthday" name="fecha_cumpleanos">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="alimento" class="form-label">Alimento</label>
                                <input type="text" class="form-control" id="alimento" name="alimento">
                            </div>
                            <div class="mb-3">
                                <label for="peso" class="form-label">Peso</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="peso" name="peso" required>
                                    <select class="form-control" id="unidad" name="unidad">
                                        <option value="kilos">Kilos</option>
                                        <option value="gramos">Gramos</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="color" class="form-label">Color</label>
                                <input type="text" class="form-control" id="color" name="color">
                            </div>
                            <div class="mb-3">
                                <label for="sexo" class="form-label">Sexo</label>
                                <select class="form-control" id="sexo" name="sexo">
                                    <option value="">Seleccione...</option>
                                    <option value="macho">Macho</option>
                                    <option value="hembra">Hembra</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar Mascota</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para editar perfil -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfileModalLabel">Editar Perfil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('perfil.update') }}" method="post" class="form-horizontal">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $usuario->name }}" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="apellido" class="form-label">Apellido</label>
                            <input type="text" class="form-control" id="apellido" name="apellido" value="{{ $informacion->apellido ?? '' }}">
                        </div>
                        
                        <div class="col-md-6">
                            <label for="rut" class="form-label">RUT</label>
                            <input type="text" class="form-control" id="rut" name="rut" value="{{ $informacion->rut ?? '' }}" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $usuario->email }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" value="{{ $informacion->telefono ?? '' }}">
                        </div>
                        <div class="col-md-6">
                            <label for="region" class="form-label">Región</label>
                            <input type="text" class="form-control" id="region" name="region" value="{{ $informacion->region ?? '' }}">
                        </div>
                        <div class="col-md-4">
                            <label for="comuna" class="form-label">Comuna</label>
                            <input type="text" class="form-control" id="comuna" name="comuna" value="{{ $informacion->comuna ?? '' }}">
                        </div>
                        <div class="col-md-4">
                            <label for="ciudad" class="form-label">Ciudad</label>
                            <input type="text" class="form-control" id="ciudad" name="ciudad" value="{{ $informacion->ciudad ?? '' }}">
                        </div>
                        <div class="col-md-4">
                            <label for="calle" class="form-label">Calle</label>
                            <input type="text" class="form-control" id="calle" name="calle" value="{{ $informacion->calle ?? '' }}">
                        </div>
                        <div class="col-md-6">
                            <label for="numero" class="form-label">Número</label>
                            <input type="text" class="form-control" id="numero" name="numero" value="{{ $informacion->numero ?? '' }}">
                        </div>
                        <div class="col-md-6">
                            <label for="departamento" class="form-label">Departamento</label>
                            <input type="text" class="form-control" id="departamento" name="departamento" value="{{ $informacion->departamento ?? '' }}">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Actualizar Perfil</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para ver detalles del usuario -->
<div class="modal fade" id="viewDetailsModal" tabindex="-1" aria-labelledby="viewDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewDetailsModalLabel">Detalles del Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div><strong>Teléfono:</strong> {{ $informacion->telefono ?? 'No especificado' }}</div>
                        <div><strong>Región:</strong> {{ $informacion->region ?? 'No especificado' }}</div>
                        <div><strong>Comuna:</strong> {{ $informacion->comuna ?? 'No especificado' }}</div>
                        <div><strong>Ciudad:</strong> {{ $informacion->ciudad ?? 'No especificado' }}</div>
                        <div><strong>Calle:</strong> {{ $informacion->calle ?? 'No especificado' }}</div>
                        <div><strong>Número:</strong> {{ $informacion->numero ?? 'No especificado' }}</div>
                        <div><strong>Departamento:</strong> {{ $informacion->departamento ?? 'No especificado' }}</div>
                    </div>
                    <div class="col-md-6">
                        <h5>Mascotas</h5>
                        @if(isset($mascotas) && $mascotas->isNotEmpty())
                            <ul>
                                @foreach ($mascotas as $mascota)
                                    <li><strong>Nombre:</strong> {{ $mascota->nombre }}, <strong>Especie:</strong> {{ $mascota->especie }}, <strong>Raza:</strong> {{ $mascota->raza }}, <strong>Fecha de Nacimiento:</strong> {{ $mascota->fecha_cumpleanos ? \Carbon\Carbon::parse($mascota->fecha_cumpleanos)->format('d/m/Y') : 'No especificado' }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p>No tienes mascotas registradas.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para cambiar contraseña -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalLabel">Cambiar Contraseña</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('perfil.changePassword') }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Contraseña Actual</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="new_password" class="form-label">Nueva Contraseña</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="new_password_confirmation" class="form-label">Confirmar Nueva Contraseña</label>
                        <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Cambiar Contraseña</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Store the scroll position in local storage before the page is unloaded
    window.addEventListener('beforeunload', function () {
        localStorage.setItem('scrollPosition', window.scrollY);
    });

    // Restore the scroll position after the page is loaded
    window.addEventListener('load', function () {
        if (localStorage.getItem('scrollPosition') !== null) {
            window.scrollTo(0, localStorage.getItem('scrollPosition'));
            localStorage.removeItem('scrollPosition');
        }
    });
</script>

@include('layoutsprincipal.footer')

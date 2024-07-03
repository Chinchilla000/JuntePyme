<!-- Modal -->
<div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitle">Creación de usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="userCreationForm" action="{{ route('inicio.crearUsuario') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="origin" value="profile">
                    <!-- Campo para el nombre -->
                    <div class="mb-3">
                        <label for="userName" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="userName" name="name" required>
                    </div>
                    <!-- Campo para el correo electrónico -->
                    <!-- Campo para el nombre -->
                    <div class="mb-3">
                        <label for="userRut" class="form-label">Rut</label>
                        <input type="text" class="form-control" id="userRut" name="rut" required>
                    </div>
                    <!-- Campo para el correo electrónico -->
                    <div class="mb-3">
                        <label for="userEmail" class="form-label">Correo
                            Electrónico</label>
                        <input type="email" class="form-control" id="userEmail" name="email" required>
                    </div>
                    <!-- Campo para los roles asignados -->
                    <div class="mb-3">
                        <label for="userRol" class="form-label">Rol del Usuario</label>
                        <select class="form-control" id="userRol" name="role" required>
                            <option value="">Seleccione un Rol</option>
                            <option value="Vendedor">Vendedor</option>
                            <option value="Bodeguero">Bodeguero</option>
                            <option value="User">Cliente</option>
                        </select>
                    </div>
                    <!-- Campo para la contraseña -->
                    <div class="mb-3">
                        <label for="userPassword" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="userPassword" name="password" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <!-- Se cambia el tipo a "submit" -->
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Crear Cliente -->
<div class="modal fade" id="modalCrearCliente" tabindex="-1" aria-labelledby="modalCrearClienteLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCrearClienteLabel">Crear Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST">
                @csrf
                <div class="modal-body">
                    <!-- Campo para el nombre del cliente -->
                    <div class="mb-3">
                        <label for="clienteNombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="clienteNombre" name="nombre" required>
                    </div>
                    <!-- Campo para el correo electrónico del cliente -->
                    <div class="mb-3">
                        <label for="clienteEmail" class="form-label">Correo
                            Electrónico</label>
                        <input type="email" class="form-control" id="clienteEmail" name="email" required>
                    </div>
                    <!-- Campo para el teléfono del cliente -->
                    <div class="mb-3">
                        <label for="clienteTelefono" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="clienteTelefono" name="telefono">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar
                        Cliente</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal para los usuarios cliente -->
@foreach ($clientes as $cliente)
<div class="modal fade" id="modalDetallesCliente{{ $cliente->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitle">Detalles del Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Nombre:</strong> {{ $cliente->name }}</p>
                        <p><strong>Correo Electrónico:</strong> {{ $cliente->email }}</p>
                    </div>
                    <div class="col-md-6">
                        @php
                            $user_info = \App\Models\UserInformacion::where('user_id', $cliente->id)->first();
                        @endphp
                        @if ($user_info)
                            <p><strong>RUT:</strong> {{ $user_info->rut }}</p>
                            <p><strong>Teléfono:</strong> {{ $user_info->telefono }}</p>
                            <p><strong>Dirección:</strong> {{ $user_info->direccion }}</p>
                        @else
                            <p>No se encontraron detalles adicionales para este usuario.</p>
                        @endif
                    </div>
                </div>
                <hr>
                <h5 class="mt-3">Mascotas</h5>
                @if ($cliente->mascotas->isEmpty())
                    <p>El usuario aún no ha registrado mascotas.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Fecha de Cumpleaños</th>
                                    <th>Especie</th>
                                    <th>Raza</th>
                                    <th>Peso</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cliente->mascotas as $mascota)
                                    <tr>
                                        <td>{{ $mascota->nombre }}</td>
                                        <td>{{ $mascota->fecha_cumpleanos}}</td>
                                        <td>{{ $mascota->especie }}</td>
                                        <td>{{ $mascota->raza }}</td>
                                        <td>
                                            @if ($mascota->peso_en_gramos < 1000)
                                                {{ $mascota->peso_en_gramos }} gramos
                                            @else
                                                {{ $mascota->peso_en_gramos / 1000 }} kilos
                                            @endif
                                        </td>
                                        <td>
                                            @if(auth()->user()->role === 'admin')
                                                <form action="{{ route('mascotas.destroy', $mascota->id) }}" method="post" style="display:inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <form action="{{ route('usuario.eliminar', ['id' => $cliente->id]) }}" method="POST">
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

@foreach ($clientes as $cliente)
<div class="modal fade" id="modalEditarDatos{{ $cliente->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitle">Editar datos de {{ $cliente->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('usuario.actualizar', ['id' => $cliente->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <!-- Campos de usuario -->
                        <div class="mb-3 col-md-6">
                            <label for="name{{ $cliente->id }}" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="name{{ $cliente->id }}" name="name" value="{{ $cliente->name }}" required>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="email{{ $cliente->id }}" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" id="email{{ $cliente->id }}" name="email" value="{{ $cliente->email }}" required>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="telefono{{ $cliente->id }}" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="telefono{{ $cliente->id }}" name="telefono" value="{{ $cliente->userInformacion->telefono ?? '' }}">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="direccion{{ $cliente->id }}" class="form-label">Dirección</label>
                            <input type="text" class="form-control" id="direccion{{ $cliente->id }}" name="direccion" value="{{ $cliente->userInformacion->direccion ?? '' }}">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="rut{{ $cliente->id }}" class="form-label">RUT</label>
                            <input type="text" class="form-control" id="rut{{ $cliente->id }}" name="rut" value="{{ $cliente->userInformacion->rut ?? '' }}">
                        </div>
                    </div>
                    <hr>
                    <h5 class="mt-3">Mascotas</h5>
                    @foreach ($cliente->mascotas as $mascota)
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="mascotaNombre{{ $mascota->id }}" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="mascotaNombre{{ $mascota->id }}" name="mascotas[{{ $mascota->id }}][nombre]" value="{{ $mascota->nombre }}">
                            </div>
                            <div class="col-md-6">
                                <label for="mascotaFechaCumpleanos{{ $mascota->id }}" class="form-label">Fecha de Cumpleaños</label>
                                <input type="date" class="form-control" id="mascotaFechaCumpleanos{{ $mascota->id }}" name="mascotas[{{ $mascota->id }}][fecha_cumpleanos]" value="{{ $mascota->fecha_cumpleanos }}">
                            </div>
                            <div class="col-md-6">
                                <label for="mascotaEspecie{{ $mascota->id }}" class="form-label">Especie</label>
                                <input type="text" class="form-control" id="mascotaEspecie{{ $mascota->id }}" name="mascotas[{{ $mascota->id }}][especie]" value="{{ $mascota->especie }}">
                            </div>
                            <div class="col-md-6">
                                <label for="mascotaRaza{{ $mascota->id }}" class="form-label">Raza</label>
                                <input type="text" class="form-control" id="mascotaRaza{{ $mascota->id }}" name="mascotas[{{ $mascota->id }}][raza]" value="{{ $mascota->raza }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="peso{{ $mascota->id }}" class="form-label">Peso</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="peso{{ $mascota->id }}" name="mascotas[{{ $mascota->id }}][peso]" value="{{ $mascota->pesoYUnidad['peso'] }}">
                                    <select class="form-control" id="unidad{{ $mascota->id }}" name="mascotas[{{ $mascota->id }}][unidad]">
                                        <option value="kilos" {{ $mascota->pesoYUnidad['unidad'] == 'kilos' ? 'selected' : '' }}>Kilos</option>
                                        <option value="gramos" {{ $mascota->pesoYUnidad['unidad'] == 'gramos' ? 'selected' : '' }}>Gramos</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
<h1></h1>
@foreach ($clientes as $cliente)
<div class="modal fade" id="modalEditarDatos{{ $cliente->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitle">Editar datos de {{ $cliente->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('usuario.actualizar', ['id' => $cliente->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <!-- Campos de usuario -->
                        <div class="mb-3 col-md-6">
                            <label for="name{{ $cliente->id }}" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="name{{ $cliente->id }}" name="name" value="{{ $cliente->name }}" required>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="email{{ $cliente->id }}" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" id="email{{ $cliente->id }}" name="email" value="{{ $cliente->email }}" required>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="telefono{{ $cliente->id }}" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="telefono{{ $cliente->id }}" name="telefono" value="{{ $cliente->userInformacion->telefono ?? '' }}">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="direccion{{ $cliente->id }}" class="form-label">Dirección</label>
                            <input type="text" class="form-control" id="direccion{{ $cliente->id }}" name="direccion" value="{{ $cliente->userInformacion->direccion ?? '' }}">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="rut{{ $cliente->id }}" class="form-label">RUT</label>
                            <input type="text" class="form-control" id="rut{{ $cliente->id }}" name="rut" value="{{ $cliente->userInformacion->rut ?? '' }}">
                        </div>
                    </div>
                    <hr>
                    <h5 class="mt-3">Mascotas</h5>
                    @foreach ($cliente->mascotas as $mascota)
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="mascotaNombre{{ $mascota->id }}" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="mascotaNombre{{ $mascota->id }}" name="mascotas[{{ $mascota->id }}][nombre]" value="{{ $mascota->nombre }}">
                            </div>
                            <div class="col-md-6">
                                <label for="mascotaFechaCumpleanos{{ $mascota->id }}" class="form-label">Fecha de Cumpleaños</label>
                                <input type="date" class="form-control" id="mascotaFechaCumpleanos{{ $mascota->id }}" name="mascotas[{{ $mascota->id }}][fecha_cumpleanos]" value="{{ $mascota->fecha_cumpleanos }}">
                            </div>
                            <div class="col-md-6">
                                <label for="mascotaEspecie{{ $mascota->id }}" class="form-label">Especie</label>
                                <input type="text" class="form-control" id="mascotaEspecie{{ $mascota->id }}" name="mascotas[{{ $mascota->id }}][especie]" value="{{ $mascota->especie }}">
                            </div>
                            <div class="col-md-6">
                                <label for="mascotaRaza{{ $mascota->id }}" class="form-label">Raza</label>
                                <input type="text" class="form-control" id="mascotaRaza{{ $mascota->id }}" name="mascotas[{{ $mascota->id }}][raza]" value="{{ $mascota->raza }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="peso{{ $mascota->id }}" class="form-label">Peso</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="peso{{ $mascota->id }}" name="mascotas[{{ $mascota->id }}][peso]" value="{{ $mascota->pesoYUnidad['peso'] }}">
                                    <select class="form-control" id="unidad{{ $mascota->id }}" name="mascotas[{{ $mascota->id }}][unidad]">
                                        <option value="kilos" {{ $mascota->pesoYUnidad['unidad'] == 'kilos' ? 'selected' : '' }}>Kilos</option>
                                        <option value="gramos" {{ $mascota->pesoYUnidad['unidad'] == 'gramos' ? 'selected' : '' }}>Gramos</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
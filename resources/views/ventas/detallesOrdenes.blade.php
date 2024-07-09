
@extends('layouts.header')

@section('title', 'Detalles de la Orden')

@section('content')
<div class="container mt-4">
    @if (session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
    @elseif (session('error'))
    <div class="alert alert-danger" role="alert">
        {{ session('error') }}
    </div>
    @endif
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Detalles de la Orden</h4>
                </div>
                <div class="card-body">
                    <h5>Información de la Orden</h5>
                    <div class="row mb-3">
                        <div class="col-sm-4"><strong>Referencia:</strong></div>
                        <div class="col-sm-8">{{ $orden->reference }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4"><strong>Cliente:</strong></div>
                        <div class="col-sm-8">{{ $orden->detalleOrden->first_name }} {{ $orden->detalleOrden->last_name }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4"><strong>RUT:</strong></div>
                        <div class="col-sm-8">{{ $orden->detalleOrden->rut }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4"><strong>Teléfono:</strong></div>
                        <div class="col-sm-8">
                            {{ $orden->detalleOrden->phone }}
                            <a href="https://wa.me/{{ $orden->detalleOrden->phone }}" target="_blank" class="btn btn-success btn-sm ms-2">
                                <i class="fab fa-whatsapp"></i> Chat en WhatsApp
                            </a>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4"><strong>Email:</strong></div>
                        <div class="col-sm-8">{{ $orden->detalleOrden->email }}</div>
                    </div>
                    @if ($orden->detalleOrden->tipo_retiro !== 'retiro')
    <div class="row mb-3">
        <div class="col-sm-4"><strong>Dirección:</strong></div>
        <div class="col-sm-8">{{ $orden->detalleOrden->direccion }}</div>
    </div>
    <div class="row mb-3">
        <div class="col-sm-4"><strong>Ciudad:</strong></div>
        <div class="col-sm-8">{{ $orden->detalleOrden->ciudad }}</div>
    </div>
@endif
                    <div class="row mb-3">
                        <div class="col-sm-4"><strong>Total:</strong></div>
                        <div class="col-sm-8">${{ number_format($orden->total, 0, ',', '.') }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4"><strong>Estado:</strong></div>
                        <div class="col-sm-8">
                            @if ($orden->status == 'pending')
                            Pendiente
                            @elseif($orden->status == 'completed')
                            Completada
                            @elseif($orden->status == 'rejected')
                            Rechazada
                            @else
                            {{ ucfirst($orden->status) }}
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4"><strong>Tipo de Retiro:</strong></div>
                        <div class="col-sm-8">{{ $orden->detalleOrden->tipo_retiro }}</div>
                    </div>

                    <h5>Productos</h5>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio</th>
                                    <th>Descuento</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orden->productos as $producto)
                                <tr>
                                    <td>{{ $producto->nombre }}</td>
                                    <td>{{ $producto->pivot->cantidad }}</td>
                                    <td>${{ number_format($producto->pivot->precio * $producto->pivot->cantidad, 0, ',', '.') }}</td>
                                    <td>${{ number_format($producto->pivot->descuento * $producto->pivot->cantidad, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
<br>
                    <h5>Total Compra</h5>
                    <br>
                    <div class="row">
                        <div class="col-sm-4"><strong>Total:</strong></div>
                        <div class="col-sm-8">${{ number_format($orden->total, 0, ',', '.') }}</div>
                    </div>

                    <a href="{{ route('ordenes.index') }}" class="btn btn-primary mt-4">Volver atrás</a>
                </div>
            </div>
        </div>
        @if ($orden->status != 'rejected')
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    Gestión del Pedido
                </div>
                <div class="card-body">
                    <h5 class="mt-4">Actualizar Estado de la Orden</h5>
                    <form id="formEstado" action="{{ route('ordenes.updateStatus', $orden->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3">
                            <label for="estado" class="form-label">Estado</label>
                            <select class="form-control" id="estado" name="estado" required>
                                <option value="pending" {{ $orden->status == 'pending' ? 'selected' : '' }}>Pendiente</option>
                                <option value="paid" {{ $orden->status == 'paid' ? 'selected' : '' }}>Pagado</option>
                                @if ($orden->detalleOrden->tipo_retiro == 'retiro')
                                    <option value="ready_for_pickup" {{ $orden->status == 'ready_for_pickup' ? 'selected' : '' }}>Listo para Retiro</option>
                                @else
                                    <option value="shipped" {{ $orden->status == 'shipped' ? 'selected' : '' }}>Producto Enviado</option>
                                @endif
                                <option value="completed" {{ $orden->status == 'completed' ? 'selected' : '' }}>Completado</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100">Actualizar Estado</button>
                    </form>

                    <h5 class="mt-4">Problemas con la Orden</h5>
                    <form id="formProblema" action="{{ route('ordenes.reportProblem', $orden->id) }}" method="POST" onsubmit="return reportarProblema(event)">
                        @csrf
                        <div class="mb-3">
                            <label for="descripcion_problema" class="form-label">Descripción del Problema</label>
                            <textarea class="form-control" id="descripcion_problema" name="descripcion_problema" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-danger w-100">Reportar Problema</button>
                    </form>
                    <button class="btn btn-secondary w-100 mt-3" onclick="mostrarModalProblemas()">Ver Problemas Reportados</button>
                </div>
            </div>

           
            <!-- Añadir botón para enviar el correo -->
            @if ($orden->status == 'ready_for_pickup' || $orden->status == 'completed')
            <div class="card mb-4">
                <div class="card-body">
                    <form action="{{ route('ordenes.sendReadyForPickupEmail', $orden->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success w-100">Enviar Correo de Listo para Retiro</button>
                    </form>
                </div>
            </div>
            @endif

        </div>
        @endif

    </div>
    <div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="messageModalLabel">Mensaje</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalMessageBody">
                    <!-- Mensaje dinámico se llenará aquí -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="problemasModal" tabindex="-1" aria-labelledby="problemasModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="problemasModalLabel">Problemas Reportados</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalProblemasBody">
                    <!-- Lista de problemas reportados -->
                    <ul id="listaProblemas">
                        @foreach ($problemas as $problema)
                        <li id="problema-{{ $problema->id }}">{{ $problema->descripcion }} <button class="btn btn-sm btn-danger float-end" onclick="eliminarProblema({{ $problema->id }})">Eliminar</button></li>
                        @endforeach
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function reportarProblema(event) {
        event.preventDefault();

        const form = event.target;
        const formData = new FormData(form);

        fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                showModal(data.message, data.status === 'success' ? 'success' : 'error');
                if (data.status === 'success') {
                    actualizarListaProblemas(data.problemas);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showModal('Ocurrió un error. Por favor, intenta nuevamente.', 'error');
            });
    }

    function actualizarListaProblemas(problemas) {
        const listaProblemas = document.getElementById('listaProblemas');
        listaProblemas.innerHTML = '';
        problemas.forEach(problema => {
            const li = document.createElement('li');
            li.id = problema-${problema.id};
            li.innerHTML =
                ${problema.descripcion} <button class="btn btn-sm btn-danger float-end" onclick="eliminarProblema(${problema.id})">Eliminar</button>;
            listaProblemas.appendChild(li);
        });
    }

    function mostrarModalProblemas() {
        fetch(/ventas/ordenes/{{ $orden->id }}/problemas, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    actualizarListaProblemas(data.problemas);
                    const problemasModal = new bootstrap.Modal(document.getElementById('problemasModal'));
                    problemasModal.show();
                } else {
                    showModal(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showModal('Ocurrió un error. Por favor, intenta nuevamente.', 'error');
            });
    }

    function eliminarProblema(problemaId) {
        fetch(/ventas/problemas/${problemaId}, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    document.getElementById(problema-${problemaId}).remove();
                } else {
                    showModal(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showModal('Ocurrió un error. Por favor, intenta nuevamente.', 'error');
            });
    }

    function showModal(message, type) {
        const modalMessageBody = document.getElementById('modalMessageBody');
        modalMessageBody.textContent = message;

        const messageModal = new bootstrap.Modal(document.getElementById('messageModal'));
        messageModal.show();
    }



</script>
@endsection
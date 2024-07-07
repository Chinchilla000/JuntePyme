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
                        <h4 class="d-inline">Detalles de la Orden</h4>
                    </div>
                    <div class="card-body">
                        <h5>Información de la Orden</h5>
                        <ul>
                            <li><strong>Referencia:</strong> {{ $orden->reference }}</li>
                            <li><strong>Cliente:</strong> {{ $orden->detalleOrden->first_name }}
                                {{ $orden->detalleOrden->last_name }}</li>
                            <li><strong>RUT:</strong> {{ $orden->detalleOrden->rut }}</li>
                            <li><strong>Teléfono:</strong> {{ $orden->detalleOrden->phone }}</li>
                            <li><strong>Email:</strong> {{ $orden->detalleOrden->email }}</li>
                            <li><strong>Dirección:</strong> {{ $orden->detalleOrden->direccion }}</li>
                            <li><strong>Ciudad:</strong> {{ $orden->detalleOrden->ciudad }}</li>
                            <li><strong>Total:</strong> ${{ number_format($orden->total, 0, ',', '.') }}</li>
                            <li><strong>Estado:</strong>
                                @if ($orden->status == 'pending')
                                    Pendiente
                                @elseif($orden->status == 'completed')
                                    Completada
                                @elseif($orden->status == 'rejected')
                                    Rechazada
                                @else
                                    {{ ucfirst($orden->status) }}
                                @endif
                            </li>
                            <li><strong>Tipo de Retiro:</strong> {{ $orden->detalleOrden->tipo_retiro }}</li>
                        </ul>


                        <h5>Productos</h5>
                        <ul>
                            @foreach ($orden->productos as $producto)
                                <li>
                                    <strong>Cantidad:</strong> {{ $producto->pivot->cantidad }} x {{ $producto->nombre }}
                                    -
                                    ${{ number_format($producto->pivot->precio * $producto->pivot->cantidad, 0, ',', '.') }}
                                </li>
                                <li>
                                    <strong>Descuento asignado:</strong>
                                    ${{ number_format($producto->pivot->descuento * $producto->pivot->cantidad, 0, ',', '.') }}
                                </li>
                            @endforeach
                        </ul>
                        <h5>Total Compra</h5>
                        <ul>
                            <strong>Total:</strong> ${{ number_format($orden->total, 0, ',', '.') }}
                        </ul>


                        <a href="{{ route('ordenes.index') }}" class="btn btn-primary">Volver atrás</a>
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
                                    <option value="ready_for_pickup" {{ $orden->status == 'ready_for_pickup' ? 'selected' : '' }}>Listo para Retiro</option>
                                    <option value="completed" {{ $orden->status == 'completed' ? 'selected' : '' }}>Completada</option>
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
                                <li id="problema-{{ $problema->id }}">{{ $problema->descripcion }} <button
                                        class="btn btn-sm btn-danger float-end"
                                        onclick="eliminarProblema({{ $problema->id }})">Eliminar</button></li>
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
                li.id = `problema-${problema.id}`;
                li.innerHTML =
                    `${problema.descripcion} <button class="btn btn-sm btn-danger float-end" onclick="eliminarProblema(${problema.id})">Eliminar</button>`;
                listaProblemas.appendChild(li);
            });
        }

        function mostrarModalProblemas() {
            fetch(`/ventas/ordenes/{{ $orden->id }}/problemas`, {
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
            fetch(`/ventas/problemas/${problemaId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        document.getElementById(`problema-${problemaId}`).remove();
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

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
                    <span id="estadoRetiro" class="badge float-end" style="font-size: 1rem; background-color: {{ $orden->detallesOrden->listo_para_retiro ? 'green' : 'red' }};">
                        @if ($orden->detallesOrden->tipo_retiro == 'retiro')
                            {{ $orden->detallesOrden->listo_para_retiro ? 'Pedido listo para retirar' : 'Aún no listo para retirar' }}
                        @elseif ($orden->detallesOrden->tipo_retiro == 'domicilio')
                            {{ $orden->detallesOrden->listo_para_retiro ? 'Pedido enviado' : 'Aún no listo para enviar' }}
                        @endif
                    </span>
                    @if ($orden->detallesOrden->tipo_retiro == 'retiro')
                        <span id="estadoRetirado" class="badge float-end" style="font-size: 1rem; background-color: {{ $orden->detallesOrden->retirado ? 'green' : 'red' }}; margin-right: 10px;">
                            {{ $orden->detallesOrden->retirado ? 'Producto retirado' : 'Producto no retirado' }}
                        </span>
                    @endif
                </div>
                <div class="card-body">
                    <h5>Información de la Orden</h5>
                    <ul>
                        <li><strong>Referencia:</strong> {{ $orden->reference }}</li>
                        <li><strong>Cliente:</strong> {{ $orden->user->name }}</li>
                        <li><strong>Total:</strong> ${{ number_format($orden->total, 0, ',', '.') }}</li>
                        <li><strong>Estado:</strong> 
                            @if($orden->status == 'pending')
                                Pendiente
                            @elseif($orden->status == 'completed')
                                Completada
                            @elseif($orden->status == 'rejected')
                                Rechazada
                            @else
                                {{ ucfirst($orden->status) }}
                            @endif
                        </li>
                        <li><strong>Tipo de Retiro:</strong> {{ optional($orden->detallesOrden)->tipo_retiro }}</li>
                    </ul>

                    @if($orden->detallesOrden->tipo_retiro == 'domicilio')
                        <h5>Detalles del Despacho a Domicilio</h5>
                        <ul>
                            <li><strong>País:</strong> {{ $orden->detallesOrden->pais }}</li>
                            <li><strong>Dirección:</strong> {{ $orden->detallesOrden->direccion }}</li>
                            <li><strong>Casa/Apartamento:</strong> {{ $orden->detallesOrden->casa_apartamento }}</li>
                            <li><strong>Comuna:</strong> {{ $orden->detallesOrden->comuna }}</li>
                            <li><strong>Región:</strong> {{ $orden->detallesOrden->region }}</li>
                        </ul>
                    @elseif($orden->detallesOrden->tipo_retiro == 'retiro')
                        <h5>Detalles del Retiro en Tienda</h5>
                        <ul>
                            <li><strong>Sucursal de Retiro:</strong> {{ $orden->detallesOrden->sucursal_retiro }}</li>
                            <li><strong>Retira:</strong> {{ $orden->detallesOrden->nombre_receptor }}</li>
                            <li><strong>RUT Receptor:</strong> {{ $orden->detallesOrden->rut_receptor }}</li>
                        </ul>
                    @endif

                    <h5>Productos</h5>
                    <ul>
                        @foreach($orden->productos as $producto)
                            <li><strong>Cantidad Por: </strong>{{ $producto->pivot->cantidad }} x {{ $producto->nombre }} - ${{ number_format($producto->pivot->precio, 0, ',', '.') }}</li>
                            <li><strong>Descuento asignado: </strong>{{ number_format($producto->pivot->descuento, 0, ',', '.') }}</li>
                        @endforeach
                    </ul>
                    <h5>Total compra</h5>
                    <ul>
                        <strong>Total:</strong> ${{ number_format($orden->total, 0, ',', '.') }}
                    </ul>

                    <a href="{{ route('ordenes.index') }}" class="btn btn-primary">Volver atrás</a>
                </div>
            </div>
        </div>
        @if($orden->status != 'rejected')
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    Gestión del Pedido
                </div>
                <div class="card-body">
                    @if($orden->detallesOrden->tipo_retiro == 'retiro')
                        <h5>Retiro en Tienda</h5>
                        <button id="btnListoParaRetiro" class="btn btn-success w-100 mb-2" onclick="marcarListoParaRetiro({{ $orden->id }})" {{ $orden->detallesOrden->listo_para_retiro ? 'disabled' : '' }}>Producto Listo para Retiro</button>
                        <button id="btnRetirado" class="btn btn-info w-100" onclick="marcarRetirado({{ $orden->id }})" {{ !$orden->detallesOrden->listo_para_retiro ? 'disabled' : '' }} {{ $orden->detallesOrden->retirado ? 'disabled' : '' }}>Producto Retirado</button>
                    @elseif($orden->detallesOrden->tipo_retiro == 'domicilio')
                        <h5>Despacho a Domicilio</h5>
                        <form id="formTracking" action="{{ route('ordenes.updateTracking', $orden->id) }}" method="POST" onsubmit="return actualizarSeguimiento(event)">
                            @csrf
                            @method('PATCH')
                            <div class="mb-3">
                                <label for="numero_seguimiento" class="form-label">Número de Seguimiento</label>
                                <input type="text" class="form-control" id="numero_seguimiento" name="numero_seguimiento" value="{{ $orden->detallesOrden->numero_seguimiento ?? '' }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="proveedor" class="form-label">Proveedor de Envío</label>
                                <input type="text" class="form-control" id="proveedor" name="proveedor" value="{{ $orden->detallesOrden->proveedor ?? '' }}" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Actualizar Seguimiento</button>
                        </form>
                        <button id="btnPedidoEnviado" class="btn btn-warning w-100 mt-2" onclick="marcarPedidoEnviado({{ $orden->id }})" {{ !$orden->detallesOrden->numero_seguimiento || !$orden->detallesOrden->proveedor ? 'disabled' : '' }}>Pedido Enviado</button>
                    @endif

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
                        @foreach($problemas as $problema)
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

<script>
    function marcarListoParaRetiro(ordenId) {
        const estadoRetiro = document.getElementById('estadoRetiro');
        const btnListoParaRetiro = document.getElementById('btnListoParaRetiro');
        const btnRetirado = document.getElementById('btnRetirado');
        
        fetch(`/ventas/ordenes/${ordenId}/ready-for-pickup`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({})
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                estadoRetiro.style.backgroundColor = 'green';
                estadoRetiro.textContent = 'Pedido listo para retirar';
                btnListoParaRetiro.disabled = true;
                btnRetirado.disabled = false;
                showModal(data.message, 'success');
            } else {
                showModal(data.message, 'error');
            }
        })
        .catch(error => console.error('Error:', error));
    }

    function actualizarSeguimiento(event) {
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
            if (data.status === 'success') {
                document.getElementById('btnPedidoEnviado').disabled = false;
                showModal(data.message, 'success');
            } else {
                showModal(data.message, 'error');
            }
        })
        .catch(error => console.error('Error:', error));
    }

    function marcarPedidoEnviado(ordenId) {
        const btnPedidoEnviado = document.getElementById('btnPedidoEnviado');
        const estadoRetiro = document.getElementById('estadoRetiro');

        fetch(`/ventas/ordenes/${ordenId}/ready-for-pickup`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({})
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                btnPedidoEnviado.disabled = true;
                estadoRetiro.style.backgroundColor = 'green';
                estadoRetiro.textContent = 'Pedido enviado';
                showModal(data.message, 'success');
            } else {
                showModal(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showModal('Ocurrió un error. Por favor, intenta nuevamente.', 'error');
        });
    }

    function marcarRetirado(ordenId) {
        const estadoRetirado = document.getElementById('estadoRetirado');
        const btnRetirado = document.getElementById('btnRetirado');

        console.log('Sending request to mark as retirado:', ordenId);

        fetch(`/ventas/ordenes/${ordenId}/retirado`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({})
        })
        .then(response => {
            console.log('Response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            if (data.status === 'success') {
                estadoRetirado.style.backgroundColor = 'green';
                estadoRetirado.textContent = 'Producto retirado';
                btnRetirado.disabled = true;
                showModal(data.message, 'success');
            } else {
                showModal(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showModal('Ocurrió un error. Por favor, intenta nuevamente.', 'error');
        });
    }

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
            li.innerHTML = `${problema.descripcion} <button class="btn btn-sm btn-danger float-end" onclick="eliminarProblema(${problema.id})">Eliminar</button>`;
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

    document.addEventListener('DOMContentLoaded', function() {
        const btnListoParaRetiro = document.getElementById('btnListoParaRetiro');
        const btnRetirado = document.getElementById('btnRetirado');

        if (!btnListoParaRetiro.disabled) {
            btnRetirado.disabled = true;
        } else {
            btnRetirado.disabled = false;
        }
    });
</script>
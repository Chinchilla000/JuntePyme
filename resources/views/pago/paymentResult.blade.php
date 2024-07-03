@include('layoutsprincipal.header')
@include('layoutsprincipal.nav')

<div class="container mt-5">
    <br>
    <br>
    <div class="card shadow">
        <div class="card-header text-center bg-primary text-white">
            <h1>Resultado de la Transacción</h1>
        </div>
        <div class="card-body">
            @php
                $estado = '';
                switch ($order->status) {
                    case 'completed':
                        $estado = 'completa';
                        break;
                    case 'pending':
                        $estado = 'pendiente';
                        break;
                    case 'rejected':
                        $estado = 'rechazada';
                        break;
                }
            @endphp

            @if($order->status == 'completed')
                <div class="alert alert-success text-center">
                    <h2>¡Pago aprobado!</h2>
                    <p>Gracias por tu compra. Aquí están los detalles de tu orden:</p>
                    <ul class="list-group">
                        <li class="list-group-item"><strong>ID de Orden:</strong> {{ $order->id }}</li>
                        <li class="list-group-item"><strong>Referencia:</strong> {{ $order->reference }}</li>
                        <li class="list-group-item"><strong>Total:</strong> ${{ number_format($order->total, 0) }}</li>
                        <li class="list-group-item"><strong>Estado:</strong> {{ $estado }}</li>
                    </ul>
                    <h3 class="mt-4">Detalles del Comprador:</h3>
                    <ul class="list-group">
                        @if ($order->user)
                            <li class="list-group-item"><strong>Nombre:</strong> {{ $order->user->userInformation->nombre ?? $order->user->name }}</li>
                            <li class="list-group-item"><strong>Rut:</strong> {{ $order->user->userInformation->rut ?? 'vacío' }}</li>
                            <li class="list-group-item"><strong>Email:</strong> {{ $order->user->email }}</li>
                            <li class="list-group-item"><strong>Teléfono:</strong> {{ $order->user->userInformation->telefono ?? 'vacío' }}</li>
                        @else
                            <li class="list-group-item"><strong>Nombre:</strong> {{ $order->detallesOrden->first_name }} {{ $order->detallesOrden->last_name }}</li>
                            <li class="list-group-item"><strong>Email:</strong> {{ $order->detallesOrden->email }}</li>
                            <li class="list-group-item"><strong>Teléfono:</strong> {{ $order->detallesOrden->phone }}</li>
                        @endif
                    </ul>
                    <h3 class="mt-4">Detalles del Pedido:</h3>
                    @if($order->detallesOrden->tipo_retiro == 'domicilio')
                        <ul class="list-group">
                            <li class="list-group-item"><strong>Tipo de Retiro:</strong> Domicilio</li>
                            <li class="list-group-item"><strong>País:</strong> {{ $order->detallesOrden->pais ?? 'vacío' }}</li>
                            <li class="list-group-item"><strong>Dirección:</strong> {{ $order->detallesOrden->direccion ?? 'vacío' }}</li>
                            <li class="list-group-item"><strong>Casa/Apartamento:</strong> {{ $order->detallesOrden->casa_apartamento ?? 'vacío' }}</li>
                            <li class="list-group-item"><strong>Comuna:</strong> {{ $order->detallesOrden->comuna ?? 'vacío' }}</li>
                            <li class="list-group-item"><strong>Región:</strong> {{ $order->detallesOrden->region ?? 'vacío' }}</li>
                        </ul>
                    @elseif($order->detallesOrden->tipo_retiro == 'retiro')
                        <ul class="list-group">
                            <li class="list-group-item"><strong>Tipo de Retiro:</strong> Retiro</li>
                            <li class="list-group-item"><strong>Sucursal de Retiro:</strong> {{ $order->detallesOrden->sucursal_retiro ?? 'vacío' }}</li>
                            <li class="list-group-item"><strong>Nombre del Receptor:</strong> {{ $order->detallesOrden->nombre_receptor ?? 'vacío' }}</li>
                            <li class="list-group-item"><strong>RUT del Receptor:</strong> {{ $order->detallesOrden->rut_receptor ?? 'vacío' }}</li>
                        </ul>
                    @endif
                    <h3 class="mt-4">Productos:</h3>
                    <ul class="list-group">
                        @foreach($order->productos as $producto)
                            @php
                                $precioFinal = $producto->pivot->precio - ($producto->pivot->descuento ?? 0);
                            @endphp
                            <li class="list-group-item">{{ $producto->pivot->cantidad }} x {{ $producto->nombre }} - ${{ number_format($precioFinal, 0) }}</li>
                        @endforeach
                    </ul>
                </div>
            @elseif($order->status == 'rejected')
                <div class="alert alert-danger text-center">
                    <h2>Pago rechazado</h2>
                    <p>Lo sentimos, tu transacción no pudo ser procesada. Por favor, intenta nuevamente.</p>
                </div>
            @elseif($order->status == 'pending')
                <div class="alert alert-warning text-center">
                    <h2>Pago pendiente</h2>
                    <p>Tu transacción está en proceso. Te notificaremos una vez que se haya completado.</p>
                </div>
            @endif
        </div>
    </div>
</div>
<br>

@include('layoutsprincipal.footer')

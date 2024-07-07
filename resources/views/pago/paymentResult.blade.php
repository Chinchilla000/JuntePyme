@include('layoutsprincipal.header')

<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-lg-12">
            <div class="bg-light p-5 mb-5 text-center">
                <h2 class="mb-4">¡Solicitud de Cotización Enviada!</h2>
                <p class="lead mb-4">
                    Gracias por su solicitud. Su solicitud de cotización ha sido recibida exitosamente. En breve, uno de nuestros agentes se pondrá en contacto con usted a través de WhatsApp al número proporcionado para confirmar la disponibilidad de los productos y continuar con la compra.
                </p>
                <h5 class="mb-3">Detalles de la Solicitud</h5>
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <ul class="list-group">
                            <li class="list-group-item"><strong>Nombre:</strong> {{ $order->detalleOrden->first_name }} {{ $order->detalleOrden->last_name }}</li>
                            <li class="list-group-item"><strong>RUT:</strong> {{ $order->detalleOrden->rut }}</li>
                            <li class="list-group-item"><strong>Teléfono:</strong> {{ $order->detalleOrden->phone }}</li>
                            <li class="list-group-item"><strong>Correo Electrónico:</strong> {{ $order->detalleOrden->email }}</li>
                            <li class="list-group-item"><strong>Tipo de Retiro:</strong> {{ $order->detalleOrden->tipo_retiro == 'retiro' ? 'Retiro en tienda' : 'Envío a domicilio' }}</li>
                            @if($order->detalleOrden->tipo_retiro == 'envio')
                            <li class="list-group-item"><strong>Dirección:</strong> {{ $order->detalleOrden->direccion }}</li>
                            <li class="list-group-item"><strong>Ciudad:</strong> {{ $order->detalleOrden->ciudad }}</li>
                            @endif
                        </ul>
                    </div>
                </div>
                <h5 class="mt-4">Detalles de los Productos</h5>
                <div class="table-responsive mb-4">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio Unitario</th>
                                <th>Descuento Total</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->productos as $producto)
                            <tr>
                                <td>{{ $producto->nombre }}</td>
                                <td>{{ $producto->pivot->cantidad }}</td>
                                <td>${{ number_format($producto->pivot->precio, 0, ',', '.') }}</td>
                                <td>${{ number_format($producto->pivot->descuento * $producto->pivot->cantidad, 0, ',', '.') }}</td>
                                <td>${{ number_format(($producto->pivot->cantidad * $producto->pivot->precio) - ($producto->pivot->descuento * $producto->pivot->cantidad), 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="4" class="text-right">Total</th>
                                <th>${{ number_format($order->total, 0, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <p class="text-muted">
                    Para cualquier consulta adicional, no dude en contactarnos. ¡Gracias por su preferencia!
                </p>
                <a href="{{ route('welcome') }}" class="btn btn-primary">Volver a la tienda</a>
            </div>
        </div>
    </div>
</div>

@include('layoutsprincipal.footer')

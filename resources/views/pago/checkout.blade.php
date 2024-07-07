@include('layoutsprincipal.header')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<!-- Cotización Start -->
<form action="{{ route('checkout.process') }}" method="POST">
    @csrf
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-8">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Información del Cliente</span></h5>
                <div class="bg-light p-30 mb-5">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Nombre</label>
                            <input class="form-control" type="text" name="nombre" placeholder="Juan" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Apellido</label>
                            <input class="form-control" type="text" name="apellido" placeholder="Pérez" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>RUT</label>
                            <input class="form-control" type="text" name="rut" placeholder="12345678-9" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Teléfono</label>
                            <input class="form-control" type="text" name="telefono" value="+569" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <label>Correo (Opcional)</label>
                            <input class="form-control" type="email" name="correo" placeholder="ejemplo@correo.com">
                        </div>
                        <div class="col-md-12 form-group">
                            <label>¿Cómo desea recibir su pedido?</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="metodo_entrega" id="retiro_tienda" value="retiro" checked>
                                <label class="form-check-label" for="retiro_tienda">Retiro en tienda</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="metodo_entrega" id="envio_domicilio" value="envio">
                                <label class="form-check-label" for="envio_domicilio">Envío a domicilio</label>
                            </div>
                        </div>
                        <div id="direccion_envio" class="" style="display: none;">
                            <div class="col-md-11 form-group">
                                <label>Dirección</label>
                                <input class="form-control" type="text" name="direccion" placeholder="123 Calle Principal">
                            </div>
                            <div class="col-md-10 form-group">
                                <label>Ciudad</label>
                                <input class="form-control" type="text" name="ciudad" placeholder="Dalcahue">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Detalles de la Cotización</span></h5>
                <div class="bg-light p-30 mb-5">
                    <div class="border-bottom">
                        <h6 class="mb-3">Productos</h6>
                        @if(isset($carritoProductos))
                            @foreach($carritoProductos as $item)
                                <div class="d-flex mb-3">
                                    <img src="{{ asset('storage/imagenes_productos/' . $item->imagen_producto) }}" alt="{{ $item->nombre }}" style="width: 50px; height: 50px; object-fit: cover;">
                                    <div class="ms-3 w-100">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <p class="mb-1">{{ $item->nombre }}</p>
                                                <p class="mb-0">Cantidad: {{ $item->cantidad }}</p>
                                            </div>
                                            <div class="text-right">
                                                @if ($item->descuento)
                                                    <p class="text-danger mb-0">${{ number_format($item->precio_final, 0, ',', '.') }} <span class="text-muted"><del>${{ number_format($item->precio_venta_bruto, 0, ',', '.') }}</del></span></p>
                                                @else
                                                    <p class="mb-0">${{ number_format($item->precio_final, 0, ',', '.') }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="d-flex justify-content-between">
                                <p>No hay productos en el carrito.</p>
                            </div>
                        @endif
                    </div>
                    <div class="pt-2">
                        <div class="d-flex justify-content-between mt-2">
                            <h5>Total</h5>
                            <h5>${{ isset($subtotal) ? number_format($subtotal, 0, ',', '.') : 0 }}</h5>
                        </div>
                        <p class="text-muted">Envío gratuito para pedidos dentro de Chiloé, dependiendo del monto.</p>
                        <button type="submit" class="btn btn-block btn-primary font-weight-bold py-3">Enviar Cotización</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const retiroTienda = document.getElementById('retiro_tienda');
        const envioDomicilio = document.getElementById('envio_domicilio');
        const direccionEnvio = document.getElementById('direccion_envio');

        retiroTienda.addEventListener('change', function() {
            if (retiroTienda.checked) {
                direccionEnvio.style.display = 'none';
            }
        });

        envioDomicilio.addEventListener('change', function() {
            if (envioDomicilio.checked) {
                direccionEnvio.style.display = 'flex';
            }
        });
    });
</script>

@include('layoutsprincipal.footer')

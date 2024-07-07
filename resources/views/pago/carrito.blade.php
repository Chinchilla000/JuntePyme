@include('layoutsprincipal.header')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<!-- Cart Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-lg-8 table-responsive mb-5">
            <table class="table table-light table-borderless table-hover text-center mb-0">
                <thead class="thead-dark">
                    <tr>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody class="align-middle">
                    @foreach($carritoProductos as $item)
                    <tr data-producto-id="{{ $item->producto_id }}">
                        <td class="align-middle">
                            <img src="{{ asset('storage/imagenes_productos/' . $item->producto->imagen_producto) }}" alt="" style="width: 50px;">
                            {{ $item->producto->nombre }}
                        </td>
                        <td class="align-middle">
                            @if($item->producto->descuento)
                                <span class="text-muted"><del>${{ number_format($item->producto->precio_venta_bruto, 0, ',', '.') }}</del></span>
                                <span class="text-danger precio-final">${{ number_format($item->producto->precio_final, 0, ',', '.') }}</span>
                            @else
                                <span class="precio-final">${{ number_format($item->producto->precio_final, 0, ',', '.') }}</span>
                            @endif
                        </td>
                        <td class="align-middle">
                            <div class="input-group quantity mx-auto" style="width: 100px;">
                                <div class="input-group-btn">
                                    <button class="btn btn-sm btn-primary btn-minus" type="button">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                </div>
                                <input type="number" class="form-control form-control-sm bg-secondary border-0 text-center cantidad" value="{{ $item->cantidad }}" min="1">
                                <div class="input-group-btn">
                                    <button class="btn btn-sm btn-primary btn-plus" type="button">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </td>
                        <td class="align-middle total">${{ number_format($item->total, 0, ',', '.') }}</td>
                        <td class="align-middle">
                            <button class="btn btn-sm btn-danger btn-remove" type="button"><i class="fa fa-times"></i></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-lg-4">
            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Resumen del Carrito</span></h5>
            <div class="bg-light p-30 mb-5">
                <div class="border-bottom pb-2">
                    <div class="d-flex justify-content-between mb-3">
                        <h6>Subtotal</h6>
                        <h6 id="subtotal">${{ number_format($subtotal, 0, ',', '.') }}</h6>
                    </div>
                </div>
                <div class="pt-2">
                    <div class="d-flex justify-content-between mt-2">
                        <h5>Total</h5>
                        <h5 id="total">${{ number_format($subtotal, 0, ',', '.') }}</h5>
                    </div>
                    <a href="{{ route('checkout.index') }}" class="btn btn-block btn-primary font-weight-bold my-3 py-3">Proceder a la Solicitud de Compra</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Cart End -->

<script>
    document.addEventListener('DOMContentLoaded', function() {
        function actualizarSubtotalTotal() {
            let subtotal = 0;
            document.querySelectorAll('tr[data-producto-id]').forEach(row => {
                let total = parseFloat(row.querySelector('.total').textContent.replace(/[$.]/g, '').replace(',', '.'));
                subtotal += total;
            });
            document.getElementById('subtotal').textContent = `$${subtotal.toLocaleString('es-ES', { minimumFractionDigits: 0, maximumFractionDigits: 0 })}`;
            document.getElementById('total').textContent = `$${subtotal.toLocaleString('es-ES', { minimumFractionDigits: 0, maximumFractionDigits: 0 })}`;
        }

        function actualizarCantidad(productoId, cantidad, row) {
            fetch('{{ route("carrito.actualizar-cantidad") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ producto_id: productoId, cantidad: cantidad })
            }).then(response => response.json()).then(data => {
                if (data.success) {
                    var precioFinal = parseFloat(row.querySelector('.precio-final').textContent.replace(/[$.]/g, '').replace(',', '.'));
                    row.querySelector('.total').textContent = `$${(precioFinal * cantidad).toLocaleString('es-ES', { minimumFractionDigits: 0, maximumFractionDigits: 0 })}`;
                    actualizarSubtotalTotal();
                }
            });
        }

        function eliminarProducto(productoId, row) {
            fetch('{{ route("carrito.eliminar-producto") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ producto_id: productoId })
            }).then(response => response.json()).then(data => {
                if (data.success) {
                    row.remove();
                    actualizarSubtotalTotal();
                    location.reload(); // Recargar la página después de eliminar el producto
                }
            });
        }

        // Funcionalidad de los botones + y -
        document.querySelectorAll('.btn-minus').forEach(button => {
            button.addEventListener('click', function() {
                var row = this.closest('tr[data-producto-id]');
                var input = row.querySelector('.cantidad');
                var value = parseInt(input.value);
                if (value > 1) {
                    input.value = value - 1; // Decrementar en 1
                    actualizarCantidad(row.dataset.productoId, input.value, row);
                }
            });
        });

        document.querySelectorAll('.btn-plus').forEach(button => {
            button.addEventListener('click', function() {
                var row = this.closest('tr[data-producto-id]');
                var input = row.querySelector('.cantidad');
                input.value = parseInt(input.value) + 1; // Incrementar en 1
                actualizarCantidad(row.dataset.productoId, input.value, row);
            });
        });

        // Eliminar producto del carrito
        document.querySelectorAll('.btn-remove').forEach(button => {
            button.addEventListener('click', function() {
                var row = this.closest('tr[data-producto-id]');
                var productoId = row.dataset.productoId;
                eliminarProducto(productoId, row);
            });
        });
    });
</script>

@include('layoutsprincipal.footer')

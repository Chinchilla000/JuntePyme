@include('layoutsprincipal.header')
@include('layoutsprincipal.nav')
<br>
<script src="{{ asset('js/app.js') }}"></script>
<div class="container mt-5">
    <h1 class="mb-4">Checkout</h1>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <style>
         @media (max-width: 767px) {
    #checkoutItems img {
        width: 40px;
    }

    #checkoutItems span {
        font-size: 14px;
    }

    #checkoutSubtotal, #checkoutTotal, #checkoutDiscount {
        font-size: 16px;
    }

    .btn-lg {
        font-size: 16px;
        padding: 10px 16px;
    }

    .btn-mobile {
        width: 100%;
        font-size: 18px;
        padding: 12px;
    }
}
    </style>
    <div class="row">
        <div class="col-md-8 order-2 order-md-1">
            <h3>Datos del Comprador</h3>

            @php
                $user = Auth::user();
                $firstName = old('firstName', $user ? ($user->userInformation->nombre ?? $user->name) : '');
                $lastName = old('lastName', $user ? ($user->userInformation->apellido ?? '') : '');
                $phone = old('phone', $user ? ($user->userInformation->telefono ?? '') : '');
                $rut = old('rut', $user ? ($user->userInformation->rut ?? '') : '');
                $email = old('email', $user ? $user->email : '');
                $mascotaDeCumpleanos = $user ? $user->mascotas()->whereDate('fecha_cumpleanos', today())->first() : null;
                $birthdayDiscountUsed = $user ? \App\Models\BirthdayDiscount::where('user_id', $user->id)->where('fecha_uso', today())->exists() : false;
            @endphp

            <div class="form-group mt-3">
                <label for="firstName">Nombre</label>
                <input type="text" class="form-control" id="firstName" placeholder="Nombre" value="{{ $firstName }}" required>
            </div>
            <div class="form-group mt-3">
                <label for="lastName">Apellidos</label>
                <input type="text" class="form-control" id="lastName" placeholder="Apellidos" value="{{ $lastName }}" required>
            </div>
            <div class="form-group mt-3">
                <label for="phone">Teléfono</label>
                <input type="text" class="form-control" id="phone" placeholder="Teléfono" value="{{ $phone }}" required>
            </div>
            <div class="form-group mt-3">
                <label for="rut">RUT</label>
                <input type="text" class="form-control" id="rut" placeholder="RUT" value="{{ $rut }}" required>
            </div>
            <div class="form-group mt-3">
                <label for="email">Correo electrónico</label>
                <input type="email" class="form-control" id="email" placeholder="Correo electrónico" value="{{ $email }}" required>
            </div>

            <h3 class="mt-4">Métodos de Entrega</h3>
            <div class="form-check">
                <input type="radio" class="form-check-input" name="delivery" value="retiro" id="officePickup" checked onclick="toggleDeliveryDetails('pickup')">
                <label class="form-check-label" for="officePickup">Retiro en Tienda</label>
            </div>
            <div class="form-check">
                <input type="radio" class="form-check-input" name="delivery" value="domicilio" id="homeDelivery" onclick="toggleDeliveryDetails('delivery')">
                <label class="form-check-label" for="homeDelivery">Despacho a Domicilio</label>
            </div>

            <div id="deliveryDetails" class="mt-3" style="display: none;">
                <div class="form-group">
                    <label for="country">País / Región</label>
                    <select class="form-control" id="country">
                        <option>Chile</option>
                    </select>
                </div>
                <div class="form-group mt-3">
                    <label for="address">Dirección</label>
                    <input type="text" class="form-control" id="address" placeholder="Dirección">
                </div>
                <div class="form-group mt-3">
                    <label for="apartment">Casa, apartamento, etc. (opcional)</label>
                    <input type="text" class="form-control" id="apartment" placeholder="Casa, apartamento, etc. (opcional)">
                </div>
                <div class="form-group mt-3">
                    <label for="commune">Comuna</label>
                    <input type="text" class="form-control" id="commune" placeholder="Comuna">
                </div>
                <div class="form-group mt-3">
                    <label for="region">Región</label>
                    <select class="form-control" id="region">
                        <option>Los Ríos</option>
                        <!-- Add other regions here -->
                    </select>
                </div>
            </div>

            <div id="pickupDetails" class="mt-3">
                <div class="form-group">
                    <label for="pickupStore">Sucursal de Retiro</label>
                    <select class="form-control" id="pickupStore">
                        <option>Sucursal Castro: Ignacio Serrano 531</option>
                        <option>Sucursal Quellón: Av. la paz 423</option>
                    </select>
                </div>

                <div class="form-check mt-3">
                    <input type="radio" class="form-check-input" name="pickupOption" value="self" id="pickupSelf" onclick="togglePickupOption('self')" checked>
                    <label class="form-check-label" for="pickupSelf">Retiro yo</label>
                </div>
                <div class="form-check mt-3">
                    <input type="radio" class="form-check-input" name="pickupOption" value="other" id="pickupOther" onclick="togglePickupOption('other')">
                    <label class="form-check-label" for="pickupOther">Retira otra persona</label>
                </div>

                <div id="pickupOtherDetails" class="mt-3" style="display: none;">
                    <div class="form-group mt-3">
                        <label for="receiverName">Nombre del Receptor</label>
                        <input type="text" class="form-control" id="receiverName" placeholder="Nombre del Receptor">
                    </div>
                    <div class="form-group mt-3">
                        <label for="receiverRut">RUT del Receptor</label>
                        <input type="text" class="form-control" id="receiverRut" placeholder="RUT del Receptor">
                    </div>
                </div>
            </div>

            <div class="form-check mt-3">
                <input type="checkbox" class="form-check-input" id="saveInfo">
                <label class="form-check-label" for="saveInfo">Guardar mi información y consultar más rápidamente la próxima vez</label>
            </div>
        </div>
        <div class="col-md-4 order-1 order-md-2">
            <h3>Resumen del Pedido</h3>
            <ul class="list-group mb-4" id="checkoutItems">
                @if(!empty($cart))
                    @foreach ($cart as $item)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <img src="{{ $item['imagen_producto'] ? asset('storage/imagenes_productos/' . $item['imagen_producto']) : asset('assets/img/gallery/default.jpg') }}" alt="{{ $item['nombre'] }}" class="img-thumbnail" style="width: 50px;" loading="lazy">
                            <span>{{ $item['nombre'] }}</span>
                            <span>${{ number_format($item['precio_venta_bruto'], 0, ',', '.') }}</span>
                            <span class="badge bg-primary rounded-pill">{{ $item['quantity'] }}</span>
                            <button class="btn btn-danger btn-sm" onclick="removeFromCart({{ $item['id'] }})">Eliminar</button>
                        </li>
                    @endforeach
                @else
                    <li class="list-group-item">Tu carrito está vacío.</li>
                @endif
            </ul>
            <h4>Subtotal: $<span id="checkoutSubtotal">{{ number_format($total, 0, ',', '.') }}</span></h4>
            <div class="card mt-3">
                <div class="card-header" data-bs-toggle="collapse" data-bs-target="#discountDetails" aria-expanded="false" aria-controls="discountDetails">Descuentos Aplicados</div>
                <div id="discountDetails" class="collapse">
                    <ul class="list-group list-group-flush" id="discountInfo"></ul>
                </div>
            </div>
            <h4 id="checkoutDiscountCode"><span id="checkoutDiscount">0</span></h4>
            <h4>Total: $<span id="checkoutTotal">{{ number_format($total, 0, ',', '.') }}</span></h4>
        
            @if($mascotaDeCumpleanos && !$birthdayDiscountUsed)
            <div class="form-group mt-3" id="birthdayDiscountButton">
                <button type="button" class="btn btn-warning btn-lg btn-block" onclick="applyBirthdayDiscount('{{ $mascotaDeCumpleanos->nombre }}')">Aplicar Descuento de Cumpleaños de {{ $mascotaDeCumpleanos->nombre }}</button>
            </div>
            @endif
    
            <div class="form-group mt-3">
                <label for="discountCode">Código de Descuento</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="discountCode" placeholder="Introduce tu código de descuento" @if(session('discount_code') === 'BIRTHDAY') disabled @endif>
                    <div class="input-group-append">
                        <button type="button" class="btn btn-primary" onclick="applyDiscount()" @if(session('discount_code') === 'BIRTHDAY') disabled @endif>Aplicar</button>
                    </div>
                </div>
            </div>

            <form id="paymentForm" action="{{ route('payment.create') }}" method="POST">
    @csrf
    <input type="hidden" name="total" id="paymentTotal" value="">
    <input type="hidden" name="firstName" id="paymentFirstName" value="">
    <input type="hidden" name="lastName" id="paymentLastName" value="">
    <input type="hidden" name="email" id="paymentEmail" value="">
    <input type="hidden" name="rut" id="paymentRut" value="">
    <input type="hidden" name="phone" id="paymentPhone" value="">
    <input type="hidden" name="deliveryMethod" id="paymentDeliveryMethod" value="">
    <input type="hidden" name="deliveryDetails" id="paymentDeliveryDetails" value="">
    <input type="hidden" name="receiverName" id="paymentReceiverName" value="">
    <input type="hidden" name="receiverRut" id="paymentReceiverRut" value="">
    <input type="hidden" name="pickupStore" id="paymentPickupStore" value="">
    <button type="button" class="btn btn-primary btn-lg btn-block mt-4" onclick="proceedToCheckout()"><i class="fas fa-credit-card me-2"></i> Pagar</button>
</form>

        </div>
    </div>
    <div class="d-block d-md-none mt-3 btn-mobil">
        <button type="button" class="btn btn-primary btn-lg btn-block btn-mobile mt-4" onclick="proceedToCheckout()"> <i class="fas fa-credit-card me-2"></i> Pagar</button>      
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="alertModal" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="alertModalLabel">Mensaje</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="alertModalBody">
                <!-- Mensaje se llenará dinámicamente -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="alertModalButton">Aceptar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para inicio de sesión -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Iniciar Sesión</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Por favor, inicia sesión para proceder con el pago.</p>
                <a href="{{ route('login') }}" class="btn btn-primary">Iniciar Sesión</a>
            </div>
        </div>
    </div>
</div>
<br>
@include('layoutsprincipal.footer')

<script>
    function toggleDeliveryDetails(method) {
        const deliveryDetails = document.getElementById('deliveryDetails');
        const pickupDetails = document.getElementById('pickupDetails');
        
        if (method === 'delivery') {
            deliveryDetails.style.display = 'block';
            pickupDetails.style.display = 'none';
        } else {
            deliveryDetails.style.display = 'none';
            pickupDetails.style.display = 'block';
        }
    }

    function togglePickupOption(option) {
        const pickupOtherDetails = document.getElementById('pickupOtherDetails');
        
        if (option === 'other') {
            pickupOtherDetails.style.display = 'block';
        } else {
            pickupOtherDetails.style.display = 'none';
        }
    }

    function proceedToCheckout() {
    // Validar los campos del formulario antes de enviar
    if (!validateForm()) {
        return;
    }

    // Rellenar los campos del formulario con los valores del usuario o los valores introducidos
    document.getElementById('paymentFirstName').value = document.getElementById('firstName').value;
    document.getElementById('paymentLastName').value = document.getElementById('lastName').value;
    document.getElementById('paymentEmail').value = document.getElementById('email').value;
    document.getElementById('paymentRut').value = document.getElementById('rut').value;
    document.getElementById('paymentPhone').value = document.getElementById('phone').value;

    const deliveryMethod = document.querySelector('input[name="delivery"]:checked').value;
    document.getElementById('paymentDeliveryMethod').value = deliveryMethod;

    let deliveryDetails = {};
    if (deliveryMethod === 'domicilio') {
        deliveryDetails = {
            pais: document.getElementById('country').value,
            direccion: document.getElementById('address').value,
            casa_apartamento: document.getElementById('apartment').value,
            comuna: document.getElementById('commune').value,
            region: document.getElementById('region').value
        };
    } else {
        deliveryDetails = {
            pickupStore: document.getElementById('pickupStore').value
        };

        const pickupOption = document.querySelector('input[name="pickupOption"]:checked').value;
        if (pickupOption === 'other') {
            document.getElementById('paymentReceiverName').value = document.getElementById('receiverName').value;
            document.getElementById('paymentReceiverRut').value = document.getElementById('receiverRut').value;
        }
    }

    document.getElementById('paymentDeliveryDetails').value = JSON.stringify(deliveryDetails);
    document.getElementById('paymentPickupStore').value = document.getElementById('pickupStore').value;

    // Solicitud al servidor para recalcular el total
    fetch('{{ route('checkout.recalculate') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            cart: @json($cart)
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('paymentTotal').value = data.total;
            document.getElementById('paymentForm').submit();
        } else {
            showModal(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showModal('Ocurrió un error al procesar el pago. Por favor, inténtalo de nuevo.');
    });
}


    function validateForm() {
        const requiredFields = [
            'firstName',
            'lastName',
            'phone',
            'rut',
            'email'
        ];

        for (let field of requiredFields) {
            const element = document.getElementById(field);
            if (!element.value.trim()) {
                showModal(`El campo ${field} es obligatorio.`);
                element.focus();
                return false;
            }
        }

        return true;
    }

    function showModal(message) {
        const alertModalElement = document.getElementById('alertModal');
        if (!alertModalElement) {
            console.error('Alert modal element not found');
            return;
        }

        const alertModal = new bootstrap.Modal(alertModalElement, {});
        document.getElementById('alertModalBody').innerText = message;
        alertModal.show();
    }

    function showLoginModal() {
        const loginModalElement = document.getElementById('loginModal');
        if (!loginModalElement) {
            console.error('Login modal element not found');
            return;
        }

        const loginModal = new bootstrap.Modal(loginModalElement, {});
        loginModal.show();
    }

    function applyBirthdayDiscount(mascotaNombre) {
        fetch('{{ route('checkout.applyBirthdayDiscount') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                showModal(data.message);
                // Actualizar el total y los detalles del descuento en la vista
                document.getElementById('checkoutTotal').innerText = new Intl.NumberFormat('es-CL').format(data.total);
                document.getElementById('paymentTotal').value = data.total;
                document.getElementById('checkoutDiscount').innerText = '10% Descuento de Cumpleaños para ' + mascotaNombre;
                // Ocultar el botón de descuento de cumpleaños
                document.getElementById('birthdayDiscountButton').style.display = 'none';
            } else {
                showModal(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showModal('Ocurrió un error al aplicar el descuento de cumpleaños. Por favor, inténtalo de nuevo.');
        });
    }

    function applyDiscount() {
        const discountCode = document.getElementById('discountCode').value.trim();

        if (!discountCode) {
            showModal('Por favor, introduce un código de descuento válido.');
            return;
        }

        fetch('{{ route('checkout.applyDiscount') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ discountCode: discountCode })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showModal(data.message);
                // Actualizar el total y los detalles del descuento en la vista
                document.getElementById('checkoutTotal').innerText = new Intl.NumberFormat('es-CL').format(data.total);
                document.getElementById('paymentTotal').value = data.total;
            } else {
                showModal(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showModal('Ocurrió un error al aplicar el descuento. Por favor, inténtalo de nuevo.');
        });
    }
</script>

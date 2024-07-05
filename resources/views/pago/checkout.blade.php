@include('layoutsprincipal.header')




    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="#">Home</a>
                    <a class="breadcrumb-item text-dark" href="#">Shop</a>
                    <span class="breadcrumb-item active">Checkout</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->


    <!-- Checkout Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-8">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Billing Address</span></h5>
                <div class="bg-light p-30 mb-5">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>First Name</label>
                            <input class="form-control" type="text" placeholder="John">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Last Name</label>
                            <input class="form-control" type="text" placeholder="Doe">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>E-mail</label>
                            <input class="form-control" type="text" placeholder="example@email.com">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Mobile No</label>
                            <input class="form-control" type="text" placeholder="+123 456 789">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Address Line 1</label>
                            <input class="form-control" type="text" placeholder="123 Street">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Address Line 2</label>
                            <input class="form-control" type="text" placeholder="123 Street">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Country</label>
                            <select class="custom-select">
                                <option selected>United States</option>
                                <option>Afghanistan</option>
                                <option>Albania</option>
                                <option>Algeria</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>City</label>
                            <input class="form-control" type="text" placeholder="New York">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>State</label>
                            <input class="form-control" type="text" placeholder="New York">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>ZIP Code</label>
                            <input class="form-control" type="text" placeholder="123">
                        </div>
                        <div class="col-md-12 form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="newaccount">
                                <label class="custom-control-label" for="newaccount">Create an account</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="shipto">
                                <label class="custom-control-label" for="shipto"  data-toggle="collapse" data-target="#shipping-address">Ship to different address</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="collapse mb-5" id="shipping-address">
                    <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Shipping Address</span></h5>
                    <div class="bg-light p-30">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>First Name</label>
                                <input class="form-control" type="text" placeholder="John">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Last Name</label>
                                <input class="form-control" type="text" placeholder="Doe">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>E-mail</label>
                                <input class="form-control" type="text" placeholder="example@email.com">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Mobile No</label>
                                <input class="form-control" type="text" placeholder="+123 456 789">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Address Line 1</label>
                                <input class="form-control" type="text" placeholder="123 Street">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Address Line 2</label>
                                <input class="form-control" type="text" placeholder="123 Street">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Country</label>
                                <select class="custom-select">
                                    <option selected>United States</option>
                                    <option>Afghanistan</option>
                                    <option>Albania</option>
                                    <option>Algeria</option>
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>City</label>
                                <input class="form-control" type="text" placeholder="New York">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>State</label>
                                <input class="form-control" type="text" placeholder="New York">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>ZIP Code</label>
                                <input class="form-control" type="text" placeholder="123">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Order Total</span></h5>
                <div class="bg-light p-30 mb-5">
                    <div class="border-bottom">
                        <h6 class="mb-3">Products</h6>
                        <div class="d-flex justify-content-between">
                            <p>Product Name 1</p>
                            <p>$150</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p>Product Name 2</p>
                            <p>$150</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p>Product Name 3</p>
                            <p>$150</p>
                        </div>
                    </div>
                    <div class="border-bottom pt-3 pb-2">
                        <div class="d-flex justify-content-between mb-3">
                            <h6>Subtotal</h6>
                            <h6>$150</h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Shipping</h6>
                            <h6 class="font-weight-medium">$10</h6>
                        </div>
                    </div>
                    <div class="pt-2">
                        <div class="d-flex justify-content-between mt-2">
                            <h5>Total</h5>
                            <h5>$160</h5>
                        </div>
                    </div>
                </div>
                <div class="mb-5">
                    <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Payment</span></h5>
                    <div class="bg-light p-30">
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" name="payment" id="paypal">
                                <label class="custom-control-label" for="paypal">Paypal</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" name="payment" id="directcheck">
                                <label class="custom-control-label" for="directcheck">Direct Check</label>
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" name="payment" id="banktransfer">
                                <label class="custom-control-label" for="banktransfer">Bank Transfer</label>
                            </div>
                        </div>
                        <button class="btn btn-block btn-primary font-weight-bold py-3">Place Order</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Checkout End -->
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

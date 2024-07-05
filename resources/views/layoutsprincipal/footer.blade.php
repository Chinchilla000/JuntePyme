<!-- Footer Start -->
<div class="container-fluid bg-dark text-secondary mt-5 pt-5">
    <div class="row px-xl-5 pt-5">
        <div class="col-lg-4 col-md-12 mb-5 pr-3 pr-xl-5">
            <h5 class="text-secondary text-uppercase mb-4">Contacta con Nosotros</h5>
            <p class="mb-4">Visítanos en nuestra tienda o contáctanos a través de los siguientes medios. Estamos para servirte.</p>
            <p class="mb-2"><i class="fa fa-map-marker-alt text-danger mr-3"></i>Esquina freire poniente 415, Dalcahue, Chiloé</p>
            <p class="mb-2"><i class="fa fa-envelope text-danger mr-3"></i>info@ferreteriaelmartillo.cl</p>
            <p class="mb-0"><i class="fa fa-phone-alt text-danger mr-3"></i>+56 9 8869 6580</p>
        </div>
        <div class="col-lg-8 col-md-12">
            <div class="row">
                <div class="col-md-4 mb-5">
                    <h5 class="text-secondary text-uppercase mb-4">Tienda Rápida</h5>
                    <div class="d-flex flex-column justify-content-start">
                        <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right text-danger mr-2"></i>Inicio</a>
                        <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right text-danger mr-2"></i>Nuestra Tienda</a>
                        <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right text-danger mr-2"></i>Detalle del Producto</a>
                        <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right text-danger mr-2"></i>Carrito de Compras</a>
                        <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right text-danger mr-2"></i>Checkout</a>
                        <a class="text-secondary" href="#"><i class="fa fa-angle-right text-danger mr-2"></i>Contáctanos</a>
                    </div>
                </div>
                <div class="col-md-4 mb-5">
                    <h5 class="text-secondary text-uppercase mb-4">Mi Cuenta</h5>
                    <div class="d-flex flex-column justify-content-start">
                        <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right text-danger mr-2"></i>Inicio</a>
                        <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right text-danger mr-2"></i>Nuestra Tienda</a>
                        <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right text-danger mr-2"></i>Detalle del Producto</a>
                        <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right text-danger mr-2"></i>Carrito de Compras</a>
                        <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right text-danger mr-2"></i>Checkout</a>
                        <a class="text-secondary" href="#"><i class="fa fa-angle-right text-danger mr-2"></i>Contáctanos</a>
                    </div>
                </div>
                <div class="col-md-4 mb-5">
                    <h5 class="text-secondary text-uppercase mb-4">Newsletter</h5>
                    <p>Suscríbete para recibir las últimas novedades y ofertas.</p>
                    <form action="">
                        <div class="input-group">
                            <input type="email" class="form-control" placeholder="Tu Email">
                            <div class="input-group-append">
                                <button class="btn btn-danger">Suscribirse</button>
                            </div>
                        </div>
                    </form>
                    <h6 class="text-secondary text-uppercase mt-4 mb-3">Síguenos</h6>
                    <div class="d-flex">
                        <a class="btn btn-danger btn-square mr-2" href="#"><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-danger btn-square mr-2" href="#"><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-danger btn-square mr-2" href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a class="btn btn-danger btn-square" href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row border-top mx-xl-5 py-4" style="border-color: rgba(256, 256, 256, .1) !important;">
        <div class="col-md-6 px-xl-0">
            <p class="mb-md-0 text-center text-md-left text-secondary">
                <img src="img/logoelmartillo.png" alt="Ferretería El Martillo" style="width: 30px; vertical-align: middle; margin-right: 10px;">
                &copy; <a class="text-danger" href="#">Ferretería El Martillo</a>. Todos los derechos reservados. Diseñado por
                <a class="text-danger" href="https://codecrafters.cl">CodeCrafters</a>.
            </p>
        </div>
        <div class="col-md-6 px-xl-0 text-center text-md-right">
            <img class="img-fluid" src="img/payments.png" alt="Métodos de Pago">
        </div>
    </div>
</div>
<!-- Footer End -->

<!-- Back to Top -->
<a href="#" class="btn btn-danger back-to-top"><i class="fa fa-angle-double-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Contact Javascript File -->
    <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>

    
    
    </main>
    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->
    <!-- Scripts -->
   
    <!-- Scripts cargados asíncronamente al final del cuerpo para mejorar la carga -->
    @vite('resources/js/app.js')
    <script src="{{ asset('vendors/@popperjs/popper.min.js') }}" defer></script>
    <script src="{{ asset('vendors/bootstrap/bootstrap.min.js') }}" defer></script>
    <script src="{{ asset('vendors/is/is.min.js') }}" defer></script>
    <script src="{{ asset('vendors/fontawesome/all.min.js') }}" defer></script>
    <script src="{{ asset('assets/js/theme.js') }}" defer></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var cartButton = document.querySelector('.cart-button');
            var cartModalElement = document.getElementById('cartModal');
            var confirmDeleteModalElement = document.getElementById('confirmDeleteModal');
            var alertModalElement = document.getElementById('alertModal');

            if (cartModalElement) {
                var cartModal = new bootstrap.Modal(cartModalElement, {});
            }
            if (confirmDeleteModalElement) {
                var confirmDeleteModal = new bootstrap.Modal(confirmDeleteModalElement, {});
            }
            if (alertModalElement) {
                var alertModal = new bootstrap.Modal(alertModalElement, {});
            }

            if (cartButton) {
                cartButton.addEventListener('click', function() {
                    if (cartModal) {
                        cartModal.show();
                    }
                });
            }

            document.addEventListener('click', function(event) {
                if (!event.target.closest('.modal-dialog') && !event.target.closest('.cart-button')) {
                    if (cartModal) {
                        cartModal.hide();
                    }
                }
            });

            if (cartModalElement) {
                cartModalElement.addEventListener('hidden.bs.modal', function() {
                    var backdrop = document.querySelector('.modal-backdrop');
                    if (backdrop) {
                        backdrop.remove();
                    }
                    document.body.classList.remove('modal-open');
                    document.body.style.removeProperty('padding-right');
                });
            }

            if (alertModalElement) {
                alertModalElement.addEventListener('hidden.bs.modal', function() {
                    window.location.reload();
                });
            }

            if (confirmDeleteModalElement) {
                confirmDeleteModalElement.addEventListener('hidden.bs.modal', function() {
                    window.location.reload();
                });
            }

            loadCart();
            updateCart();
            if (document.getElementById('checkoutItems')) {
                updateCheckout();
            }
        });

        let cart = [];
        let currentProductoId = null;
        let productToRemoveId = null;
        const productos = window.productos && Array.isArray(window.productos) ? window.productos : [];

        console.log('Productos:', productos); // Log para verificar productos

        function openQuantityModal(productoId) {
            console.log('Open modal for product ID:', productoId); // Log de depuración
            currentProductoId = productoId;
            if (!productos || !Array.isArray(productos)) {
                console.error('Productos no está definido o no es un array');
                return;
            }
            const producto = productos.find(p => p.id === productoId);
            console.log('Producto encontrado:', producto); // Log para verificar el producto encontrado

            if (!producto) {
                console.error('Producto no encontrado'); // Log de error
                return;
            }

            document.getElementById('modalProductName').innerText = producto.nombre;
            document.getElementById('modalProductQuantity').value = 1;
            const quantityModalElement = document.getElementById('quantityModal');
            if (quantityModalElement) {
                const quantityModal = new bootstrap.Modal(quantityModalElement, {});
                quantityModal.show();
            }
        }

        function addToCartFromModal() {
    const producto = productos.find(p => p.id === currentProductoId);
    const quantity = parseInt(document.getElementById('modalProductQuantity').value);
    if (producto) {
        const cartProducto = cart.find(item => item.id === currentProductoId);
        if (cartProducto) {
            cartProducto.quantity += quantity;
        } else {
            let discount = 0;
            let discountType = '';
            if (producto.descuento) {
                if (producto.descuento.porcentaje) {
                    discount = Math.trunc(producto.descuento.porcentaje);
                    discountType = 'porcentaje';
                } else if (producto.descuento.monto) {
                    discount = Math.trunc(producto.descuento.monto);
                    discountType = 'monto';
                }
            }
            cart.push({
                ...producto,
                quantity: quantity,
                discount: discount,
                discountType: discountType
            });
        }
        saveCart();
        updateCart();
        if (document.getElementById('checkoutItems')) {
            updateCheckout();
        }
    }
    const quantityModalElement = document.getElementById('quantityModal');
    if (quantityModalElement) {
        const quantityModal = bootstrap.Modal.getInstance(quantityModalElement);
        quantityModal.hide();
    }
}

        function showDeleteConfirmModal(productId) {
            productToRemoveId = productId;
            const confirmDeleteModalElement = document.getElementById('confirmDeleteModal');
            if (confirmDeleteModalElement) {
                const confirmDeleteModal = new bootstrap.Modal(confirmDeleteModalElement, {});
                confirmDeleteModal.show();
            }
        }

        document.getElementById('confirmDeleteButton')?.addEventListener('click', function() {
            removeFromCart(productToRemoveId);
            const confirmDeleteModalElement = document.getElementById('confirmDeleteModal');
            if (confirmDeleteModalElement) {
                const confirmDeleteModal = bootstrap.Modal.getInstance(confirmDeleteModalElement);
                confirmDeleteModal.hide();
            }
            window.location.reload();
        });

       function removeFromCart(productoId) {
        cart = cart.filter(item => item.id !== productoId);
        saveCart();
        updateCart();
    }

        function saveCart() {
            sessionStorage.setItem('cart', JSON.stringify(cart));
            fetch('/guardar-carrito', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ cart: cart })
            }).catch(error => {
                console.error('Error al guardar el carrito en la sesión:', error);
            });
        }

        function loadCart() {
            const savedCart = sessionStorage.getItem('cart');
            if (savedCart) {
                cart = JSON.parse(savedCart);
            } else {
                fetch('/cargar-carrito')
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok.');
                        }
                        return response.json();
                    })
                    .then(data => {
                        cart = data.cart || [];
                        updateCart();
                        if (document.getElementById('checkoutItems')) {
                            updateCheckout();
                        }
                    })
                    .catch(error => {
                        console.error('Error al cargar el carrito:', error);
                    });
            }
        }

        function updateCart() {
        const cartItems = document.getElementById('cartItems');
        const cartTotal = document.getElementById('cartTotal');
        const cartItemCount = document.getElementById('cartItemCount');
        if (!cartItems || !cartTotal || !cartItemCount) return;

        cartItems.innerHTML = '';
        let total = 0;
        let itemCount = 0;

        const formatter = new Intl.NumberFormat('es-CL');

        cart.forEach(item => {
            let discountAmount = 0;
            let priceAfterDiscount = parseFloat(item.precio_venta_bruto);
            let originalPrice = priceAfterDiscount;
            
            if (item.descuento && item.descuento.porcentaje) {
                const discountPercentage = Math.floor(item.descuento.porcentaje); // Tomar la parte entera del porcentaje
                discountAmount = priceAfterDiscount * (discountPercentage / 100); // Calcular el descuento
                priceAfterDiscount = priceAfterDiscount - discountAmount;
            } else if (item.descuento && item.descuento.monto) {
                discountAmount = item.descuento.monto; // Usar el monto del descuento tal cual
                priceAfterDiscount = priceAfterDiscount - discountAmount;
            }

            // Asegurarse de que el precio final no tenga decimales
            priceAfterDiscount = Math.floor(priceAfterDiscount);

            const totalPrice = priceAfterDiscount * item.quantity;
            total += totalPrice;
            itemCount += item.quantity;

            let itemName = item.nombre;
            if (itemName.length > 20) {
                itemName = itemName.substring(0, 20) + '...';
            }

            const cartItem = `
            <li class="list-group-item d-flex justify-content-between align-items-center ${item.descuento ? 'discounted' : ''}">
                <img src="${item.imagen_producto ? '/storage/imagenes_productos/' + item.imagen_producto : '/assets/img/gallery/default.jpg'}" alt="${item.nombre}" class="cart-item-img" loading="lazy">
                <span class="item-name">${itemName}</span>
                <span class="item-price">
                    ${item.descuento ? `<del class="text-muted">$${formatter.format(originalPrice)}</del> <span class="text-danger">$${formatter.format(priceAfterDiscount)}</span>` : `$${formatter.format(originalPrice)}`}
                </span>
                <span class="badge bg-primary rounded-pill item-quantity">${item.quantity}</span>
                <span class="text-danger remove-icon" onclick="showDeleteConfirmModal(${item.id})">
                    <i class='bx bxs-trash'></i>
                </span>
            </li>
            `;
            cartItems.insertAdjacentHTML('beforeend', cartItem);
        });

        cartTotal.innerText = formatter.format(total);
        cartItemCount.innerText = itemCount;
        cartItemCount.style.display = itemCount > 0 ? 'inline' : 'none';
    }

        function handleKeyPress(event) {
            if (event.key === 'Enter') {
                applyDiscount();
            }
        }

        function applyDiscount() {
            const discountCode = document.getElementById('discountCode').value.trim();

            if (discountCode === '') {
                showModal('Por favor, introduce un código de descuento válido.');
                return;
            }

            fetch('{{ route('aplicar-codigo-promocional') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ codigo_promocional: discountCode })
            }).then(response => {
                if (!response.ok) {
                    return response.json().then(error => {
                        throw new Error(error.error);
                    });
                }
                return response.json();
            }).then(data => {
                showModal(data.success);
            }).catch(error => showModal(error.message));
        }

        function removeDiscount() {
            fetch('{{ route('eliminar-codigo-promocional') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            }).then(response => {
                if (!response.ok) {
                    return response.json().then(error => {
                        throw new Error(error.error);
                    });
                }
                return response.json();
            }).then(data => {
                showModal(data.success);
            }).catch(error => showModal(error.message));
        }

        function showModal(message) {
            const alertModal = new bootstrap.Modal(document.getElementById('alertModal'), {});
            document.getElementById('alertModalBody').innerText = message;
            alertModal.show();

            document.getElementById('alertModalButton').addEventListener('click', function() {
                window.location.reload();
            });
        }

        function updateCheckout() {
        const checkoutItems = document.getElementById('checkoutItems');
        const checkoutSubtotal = document.getElementById('checkoutSubtotal');
        const checkoutDiscount = document.getElementById('checkoutDiscount');
        const checkoutTotal = document.getElementById('checkoutTotal');
        const discountInfo = document.getElementById('discountInfo');
        const discountDetails = document.getElementById('discountDetails');
        if (!checkoutItems || !checkoutSubtotal || !checkoutDiscount || !checkoutTotal || !discountInfo || !discountDetails) return;

        checkoutItems.innerHTML = '';
        discountInfo.innerHTML = '';

        let subtotal = 0;
        let appliedDiscounts = [];
        const discountType = '{{ session('discount_type', '') }}';
        const discountValue = parseFloat('{{ session('discount_amount', 0) }}');
        const discountCode = '{{ session('discount_code', '') }}';

        const formatter = new Intl.NumberFormat('es-CL');

        cart.forEach(item => {
            const price = parseFloat(item.precio_venta_bruto);
            let discountAmountItem = 0;
            let priceAfterDiscount = price;

            if (item.descuento && item.descuento.porcentaje) {
                const discountPercentage = Math.trunc(item.descuento.porcentaje); // Usar la parte entera del porcentaje
                discountAmountItem = price * (discountPercentage / 100); // Calcular el descuento
                priceAfterDiscount = price - discountAmountItem;
            } else if (item.descuento && item.descuento.monto) {
                discountAmountItem = item.descuento.monto; // Usar el monto del descuento tal cual
                priceAfterDiscount = price - discountAmountItem;
            }

            // Asegurarse de que el precio final no tenga decimales
            priceAfterDiscount = Math.trunc(priceAfterDiscount);

            subtotal += priceAfterDiscount * item.quantity;

            let itemName = item.nombre;
            if (itemName.length > 20) {
                itemName = itemName.substring(0, 20) + '...';
            }

            const checkoutItem = `
            <li class="list-group-item d-flex justify-content-between align-items-center ${item.descuento ? 'discounted' : ''}">
                <img src="${item.imagen_producto ? '/storage/imagenes_productos/' + item.imagen_producto : '/assets/img/gallery/default.jpg'}" alt="${item.nombre}" class="cart-item-img" loading="lazy">
                <span class="item-name">${itemName}</span>
                <span>
                    ${item.descuento ? `<del class="text-muted">$${formatter.format(price)}</del> <span class="text-danger">$${formatter.format(priceAfterDiscount)}</span>` : `<span>$${formatter.format(price)}</span>`}
                </span>
                <span class="badge bg-primary rounded-pill item-quantity">${item.quantity}</span>
                <button class="btn btn-danger btn-sm" onclick="showDeleteConfirmModal(${item.id})">Eliminar</button>
            </li>
            `;
            checkoutItems.insertAdjacentHTML('beforeend', checkoutItem);

            if (item.descuento) {
                const discountDescription = item.descuento.porcentaje ? `${item.descuento.porcentaje}%` : `$${formatter.format(item.descuento.monto)}`;
                appliedDiscounts.push(`${itemName}: $${formatter.format(Math.trunc(discountAmountItem) * item.quantity)} (${discountDescription})`);
            }
        });

        let promotionalDiscountAmount = 0;
        let promotionalDiscountText = '';
        if (discountType && discountValue) {
            if (discountType === 'porcentaje') {
                promotionalDiscountAmount = Math.trunc(subtotal * (discountValue / 100));
                promotionalDiscountText = `Código promocional (${discountCode}): $${formatter.format(promotionalDiscountAmount)} (${discountValue}%)`;
            } else {
                promotionalDiscountAmount = Math.trunc(discountValue);
                promotionalDiscountText = `Código promocional (${discountCode}): $${formatter.format(promotionalDiscountAmount)}`;
            }
            appliedDiscounts.push(promotionalDiscountText);
        }

        const totalDiscountAmount = promotionalDiscountAmount;
        let total = Math.trunc(subtotal - totalDiscountAmount);

        // Asegurarse de que el total no sea negativo, estableciéndolo a 1 si es menor que 1
        if (total < 1 && subtotal > 0) {
            total = 1;
        } else if (subtotal === 0) {
            total = 0;
        }

        checkoutSubtotal.innerText = formatter.format(subtotal);
        checkoutTotal.innerText = formatter.format(total);

        if (appliedDiscounts.length > 0) {
            discountInfo.innerHTML = `
            <div class="card mt-3">
                <ul class="list-group list-group-flush">
                    ${appliedDiscounts.map(discount => `<li class="list-group-item">${discount}</li>`).join('')}
                </ul>
            </div>`;
        }

        if (discountCode) {
            checkoutDiscount.innerText = `Descuento Código: $${formatter.format(totalDiscountAmount)}`;
        } else {
            checkoutDiscount.innerText = '';
        }

        discountDetails.classList.add('show');
    }

        document.addEventListener('DOMContentLoaded', function() {
            updateCheckout();
        });

        function proceedToCheckout() {
            const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
            if (!csrfTokenMeta) {
                console.error('CSRF token not found');
                return;
            }

            const csrfTokenValue = csrfTokenMeta.getAttribute('content');

            if (window.location.pathname !== '/checkout') {
                fetch('/guardar-carrito', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfTokenValue
                    },
                    body: JSON.stringify({ cart: cart })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error al guardar el carrito en la sesión');
                    }
                    return response.json();
                })
                .then(data => {
                    window.location.href = '/checkout';
                })
                .catch(error => {
                    console.error('Error en el proceso de guardar el carrito:', error);
                    showModal('Error en el proceso de guardar el carrito: ' + error.message);
                });
            } else {
                const totalValueElement = document.getElementById('checkoutTotal');

                if (!totalValueElement) {
                    console.error('Total value element not found');
                    showModal('Error: No se encontró el elemento de valor total.');
                    return;
                }

                const totalValue = parseInt(totalValueElement.innerText.replace(/[^\d]/g, ''));

                if (isNaN(totalValue)) {
                    console.error('Invalid total value');
                    showModal('Error: Valor total inválido.');
                    return;
                }

                fetch('/guardar-carrito', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfTokenValue
                    },
                    body: JSON.stringify({ cart: cart, total: totalValue })
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(errorData => {
                            throw new Error(errorData.message || 'Error al guardar el carrito en la sesión');
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    window.location.href = `/payment/create?total=${totalValue}`;
                })
                .catch(error => {
                    console.error('Error en el proceso de checkout:', error);
                    showModal('Error en el proceso de checkout: ' + error.message);
                });
            }
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
    </script>
</body>
</html>
<!-- ============================================-->
<!-- <section> begin ============================-->
    <section class="py-0 pt-7 bg-1000">
        <div class="container">
            <div class="row justify-content-lg-between">
                <h5 class="lh-lg fw-bold text-white">NUESTRAS SUCURSALES</h5>
                <div class="col-6 col-md-4 col-lg-auto mb-3">
                    <ul class="list-unstyled mb-md-4 mb-lg-0">
                        <li class="lh-lg"><a class="text-200 text-decoration-none"
                                href="https://maps.app.goo.gl/spuWaxAfmJv5Reac6" target="_blank"><i
                                    class="fas fa-map-marker-alt text-warning mx-2"></i>Sucursal Castro: Ignacio
                                Serrano 531</a></li>
                        <li class="lh-lg"><a class="text-200 text-decoration-none"
                                href="https://maps.app.goo.gl/iNLiH7Ce9SLmPFxZ7" target="_blank"><i
                                    class="fas fa-map-marker-alt text-warning mx-2"></i>Sucursal Quellón: Av. la
                                paz 423</a></li>
                    </ul>
                </div>
            </div>
            <hr class="text-900" />
            <div class="row">
                <div class="col-6 col-md-4 col-lg-3 col-xxl-2 mb-3">
                    <h5 class="lh-lg fw-bold text-white">CONTACTO</h5>
                    <ul class="list-unstyled mb-md-4 mb-lg-0">
                        <li class="lh-lg">
                            <a class="text-200 text-decoration-none" href="mailto:fullmascotaschiloe@gmail.com"
                                target="_blank">
                                <i class="fas fa-envelope text-warning mx-2"></i>fullmascotaschiloe@gmail.com
                            </a>
                        </li>
                        <li class="lh-lg">
                            <a class="text-200 text-decoration-none"
                                href="https://wa.me/56971772430?text=Hola!%20Estoy%20interesado%20en%20saber%20más%20sobre%20los%20productos."
                                target="_blank">
                                <i class="fab fa-whatsapp text-warning mx-2"></i>+56 9 7177 2430
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-6 col-md-4 col-lg-3 col-xxl-2 mb-3">
                    <h5 class="lh-lg fw-bold text-white">SIGUENOS</h5>
                    <div class="text-start my-3">
                        <a class="text-200 text-decoration-none" href="https://www.instagram.com/fullbigoteschiloe/"
                            target="_blank">
                            <i class="fab fa-instagram text-warning mx-2"></i>fullbigoteschiloe
                        </a>
                    </div>
    
                </div>
                <div class="col-12 col-md-8 col-lg-6 col-xxl-4">
                    <h5 class="lh-lg fw-bold text-500">RECIBE OFERTAS EXCLUSIVAS</h5>
                    <div class="row input-group-icon mb-5">
                        <div class="col-auto">
                            <i class="fas fa-envelope input-box-icon text-500 ms-3"></i>
                            <input class="form-control input-box bg-800 border-0" type="email"
                                placeholder="Ingresa tu email" aria-label="email" />
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-primary" type="submit">Suscribirse</button>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="border border-800" />
            <div class="row flex-center pb-3">
                <div class="col-md-6 order-0">
                    <p class="text-200 text-center text-md-start">Todos los derechos reservados &copy; Full
                        Bigotes, 2024</p>
                </div>
                <div class="col-md-6 order-1">
                    <p class="text-200 text-center text-md-end"> Creado&nbsp;<i class="bi bi-suit-heart-fill"
                            style="color: #FFB30E;"></i>&nbsp;por&nbsp;<a class="text-200 fw-bold"
                            href="https://www.codecrafters.cl" target="_blank">CodeCrafters</a>
                    </p>
                </div>
            </div>
        </div><!-- end of .container-->
    </section>
    <!-- <section> close ============================-->
    <!-- ============================================-->
    
    
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
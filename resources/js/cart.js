let cart = [];
let currentProductoId = null;
let productToRemoveId = null;
let productos = [];

function openQuantityModal(productoId) {
    currentProductoId = productoId;
    const producto = productos.find(p => p.id === productoId);
    if (!producto) return;
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
            const discount = producto.descuento ? (producto.descuento.porcentaje || 0) : 0;
            cart.push({
                ...producto,
                quantity: quantity,
                discount: discount
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
    window.location.reload(); // Recargar la página para reflejar los cambios
});

function removeFromCart(productoId) {
    cart = cart.filter(item => item.id !== productoId);
    saveCart();
    updateCart();
    if (document.getElementById('checkoutItems')) {
        updateCheckout();
    }
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
            .then(response => response.json())
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
        const discountAmount = parseFloat(item.precio_venta_bruto) * (item.discount / 100);
        const priceAfterDiscount = parseFloat(item.precio_venta_bruto) - discountAmount;
        const totalPrice = priceAfterDiscount * item.quantity;
        total += totalPrice;
        itemCount += item.quantity;

        let itemName = item.nombre;
        if (itemName.length > 20) {
            itemName = itemName.substring(0, 20) + '...';
        }

        const cartItem = `
            <li class="list-group-item d-flex justify-content-between align-items-center ${item.discount ? 'discounted' : ''}">
                <img src="${item.imagen_producto ? '/storage/imagenes_productos/' + item.imagen_producto : '/assets/img/gallery/default.jpg'}" alt="${item.nombre}" class="cart-item-img" loading="lazy">
                <span class="item-name">${itemName}</span>
                <span class="item-price">$${formatter.format(totalPrice)}</span>
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

    fetch('{{ route("aplicar-codigo-promocional") }}', {        method: 'POST',
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
    fetch('{{ route("eliminar-codigo-promocional") }}', {
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
    const alertModalElement = document.getElementById('alertModal');
    if (!alertModalElement) {
        console.error('Alert modal element not found');
        return;
    }

    const alertModal = new bootstrap.Modal(alertModalElement, {});
    document.getElementById('alertModalBody').innerText = message;
    alertModal.show();
}

function updateCheckout() {
    const checkoutItems = document.getElementById('checkoutItems');
    const checkoutSubtotal = document.getElementById('checkoutSubtotal');
    const checkoutDiscount = document.getElementById('checkoutDiscount');
    const checkoutTotal = document.getElementById('checkoutTotal');
    const discountInfo = document.getElementById('discountInfo');
    const discountDetails = document.getElementById('discountDetails');
    if (!checkoutItems || !checkoutSubtotal || !checkoutDiscount || !checkoutTotal || !discountInfo || !discountDetails) return;

    // Limpia el contenido previo
    checkoutItems.innerHTML = '';
    discountInfo.innerHTML = '';

    // Variables para calcular el total y el descuento
    let subtotal = 0;
    let individualDiscountsTotal = 0;
    let appliedDiscounts = [];
    const discountType = "{{ session('discount_type', '') }}";
    const discountValue = parseFloat("{{ session('discount_amount', 0) }}");
    const discountCode = "{{ session('discount_code', '') }}";
    

    // Formateador de números
    const formatter = new Intl.NumberFormat('es-CL');

    cart.forEach(item => {
        const price = parseFloat(item.precio_venta_bruto);
        const discount = item.discount || 0;
        const discountAmountItem = price * (discount / 100);
        const priceAfterDiscount = price - discountAmountItem;
        subtotal += priceAfterDiscount * item.quantity;

        // Limitar el nombre del producto a 20 caracteres
        let itemName = item.nombre;
        if (itemName.length > 20) {
            itemName = itemName.substring(0, 20) + '...';
        }

        // Añadir item al resumen del pedido
        const checkoutItem = `
            <li class="list-group-item d-flex justify-content-between align-items-center ${discount ? 'discounted' : ''}">
                <img src="${item.imagen_producto ? '/storage/imagenes_productos/' + item.imagen_producto : '/assets/img/gallery/default.jpg'}" alt="${item.nombre}" class="cart-item-img" loading="lazy">
                <span class="item-name">${itemName}</span>
                <span>
                    ${discount > 0 ? `<del class="text-muted">$${formatter.format(price)}</del> <span class="text-danger">$${formatter.format(priceAfterDiscount)}</span>` : `<span>$${formatter.format(price)}</span>`}
                </span>
                <span class="badge bg-primary rounded-pill item-quantity">${item.quantity}</span>
                <button class="btn btn-danger btn-sm" onclick="showDeleteConfirmModal(${item.id})">Eliminar</button>
            </li>
        `;
        checkoutItems.insertAdjacentHTML('beforeend', checkoutItem);

        // Añadir descuento aplicado al listado
        if (discount > 0) {
            appliedDiscounts.push(`${itemName}: $${formatter.format(discountAmountItem * item.quantity)} (${discount}%)`);
        }
    });

    // Calcular el descuento promocional sobre el subtotal con descuentos aplicados
    let promotionalDiscountAmount = 0;
    let promotionalDiscountText = '';
    if (discountType && discountValue) {
        if (discountType === 'porcentaje') {
            promotionalDiscountAmount = subtotal * (discountValue / 100);
            promotionalDiscountText = `Código promocional (${discountCode}): $${formatter.format(promotionalDiscountAmount)} (${discountValue}%)`;
        } else {
            promotionalDiscountAmount = discountValue;
            promotionalDiscountText = `Código promocional (${discountCode}): $${formatter.format(promotionalDiscountAmount)}`;
        }
        appliedDiscounts.push(promotionalDiscountText);
    }

    const totalDiscountAmount = promotionalDiscountAmount;
    const total = subtotal - totalDiscountAmount;

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

    // Abrir la sección de descuentos aplicados por defecto
    discountDetails.classList.add('show');
}

function proceedToCheckout() {
    const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
    if (!csrfTokenMeta) {
        console.error('CSRF token not found');
        return;
    }

    const csrfTokenValue = csrfTokenMeta.getAttribute('content');

    if (window.location.pathname !== '/checkout') {
        // Si no estamos en la vista de checkout, guardar el carrito y redirigir a checkout
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
            console.log('Carrito guardado, redirigiendo a la página de checkout...');
            window.location.href = '/checkout';
        })
        .catch(error => {
            console.error('Error en el proceso de guardar el carrito:', error);
            showModal('Error en el proceso de guardar el carrito: ' + error.message);
        });
    } else {
        // Si estamos en la vista de checkout, proceder con el checkout
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

        console.log('Proceeding to checkout with total value:', totalValue);

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
            console.log('Carrito y total guardados en la sesión, procesando pago...');
            fetch('/procesar-pago', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfTokenValue
                },
                body: JSON.stringify({ total: totalValue })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error al procesar el pago');
                }
                return response.json();
            })
            .then(paymentData => {
                console.log('Pago procesado con éxito:', paymentData);
                showModal('Pago procesado con éxito. Gracias por su compra.');
                window.location.href = '/order-confirmation';
            })
            .catch(paymentError => {
                console.error('Error al procesar el pago:', paymentError);
                showModal('Error al procesar el pago: ' + paymentError.message);
            });
        })
        .catch(error => {
            console.error('Error al guardar el carrito en la sesión:', error);
            showModal('Error al guardar el carrito en la sesión: ' + error.message);
        });
    }
}

document.addEventListener('DOMContentLoaded', function() {
    loadCart();
    const productosElement = document.getElementById('productos');
    if (productosElement) {
        productos = JSON.parse(productosElement.dataset.productos);
    }
    document.querySelectorAll('.cart-button, .btn-close').forEach(btn => {
        btn.addEventListener('click', () => {
            updateCart();
        });
    });
    if (document.getElementById('checkoutItems')) {
        updateCheckout();
    }
    document.getElementById('confirmDeleteButton')?.addEventListener('click', function() {
        removeFromCart(productToRemoveId);
        const confirmDeleteModalElement = document.getElementById('confirmDeleteModal');
        if (confirmDeleteModalElement) {
            const confirmDeleteModal = bootstrap.Modal.getInstance(confirmDeleteModalElement);
            confirmDeleteModal.hide();
        }
        window.location.reload(); // Recargar la página para reflejar los cambios
    });
});



<!-- resources/views/components/cart.blade.php -->
<button class="cart-button" data-bs-toggle="modal" data-bs-target="#cartModal">
    <i class="fas fa-shopping-cart" style="color: #40E0D0;"></i>
    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="cartItemCount">0</span>
</button>

<div class="modal fade" id="quantityModal" tabindex="-1" aria-labelledby="quantityModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="quantityModalLabel">Añadir al Carrito</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Producto: <span id="modalProductName"></span></p>
                <div class="mb-3">
                    <label for="modalProductQuantity" class="form-label">Cantidad</label>
                    <input type="number" class="form-control" id="modalProductQuantity" min="1" value="1">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="addToCartFromModal()">Añadir</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true" style="z-index: 1050;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cartModalLabel">Carrito de Compras</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group" id="cartItems"></ul>
            </div>
            <div class="modal-footer">
                <h5>Total: $<span id="cartTotal">0.00</span></h5>
                <button type="button" id="proceedToCheckoutButton" class="btn btn-primary" onclick="proceedToCheckout()">Proceder al Pago</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Confirmar Eliminación de Producto -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar Eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="confirmDeleteModalBody">
                ¿Estás seguro de que deseas eliminar este producto?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteButton">Eliminar</button>
            </div>
        </div>
    </div>
</div>

<!-- CSS Adicional -->
<style>
    /* Para dispositivos móviles, los submenús deben ser desplegables al hacer clic */
    @media (max-width: 991px) {
        .dropdown-submenu .dropdown-menu {
            display: none;
        }

        .dropdown-submenu.show .dropdown-menu {
            display: block;
        }
    }

    /* Para escritorio, mostrar submenús al pasar el mouse */
    @media (min-width: 992px) {
        .dropdown-submenu:hover .dropdown-menu {
            display: block;
        }
    }
</style>

<!-- JavaScript Adicional -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var categoriasToggleMobile = document.querySelector('#categoriasDropdownMobile');
        var categoriasToggleDesktop = document.querySelector('#categoriasDropdownDesktop');
        var submenus = document.querySelectorAll('.dropdown-submenu');
    
        // Manejador para el toggle de Categorías en móvil
        categoriasToggleMobile.addEventListener('click', function (e) {
            e.stopPropagation();
            var parentMenu = categoriasToggleMobile.closest('.dropdown');
            var dropdownMenu = categoriasToggleMobile.nextElementSibling;
    
            // Cerrar cualquier otro menú abierto
            var openMenus = document.querySelectorAll('.navbar-collapse .dropdown.show');
            openMenus.forEach(function (menu) {
                if (menu !== parentMenu) {
                    menu.classList.remove('show');
                    var submenu = menu.querySelector('.dropdown-menu');
                    if (submenu) {
                        submenu.classList.remove('show');
                    }
                }
            });
    
            // Asegura que el menú se abre o se cierra con un solo clic
            var isOpen = dropdownMenu.classList.contains('show');
            dropdownMenu.classList.toggle('show', !isOpen);
            parentMenu.classList.toggle('show', !isOpen);
            categoriasToggleMobile.setAttribute('aria-expanded', !isOpen);
        });
    
        // Manejador para el toggle de Categorías en escritorio
        categoriasToggleDesktop.addEventListener('click', function (e) {
            e.stopPropagation();
            var parentMenu = categoriasToggleDesktop.closest('.dropdown');
            var dropdownMenu = categoriasToggleDesktop.nextElementSibling;
    
            // Cerrar cualquier otro menú abierto
            var openMenus = document.querySelectorAll('.navbar-nav .dropdown.show');
            openMenus.forEach(function (menu) {
                if (menu !== parentMenu) {
                    menu.classList.remove('show');
                    var submenu = menu.querySelector('.dropdown-menu');
                    if (submenu) {
                        submenu.classList.remove('show');
                    }
                }
            });
    
            // Asegura que el menú se abre o se cierra con un solo clic
            var isOpen = dropdownMenu.classList.contains('show');
            dropdownMenu.classList.toggle('show', !isOpen);
            parentMenu.classList.toggle('show', !isOpen);
            categoriasToggleDesktop.setAttribute('aria-expanded', !isOpen);
        });
    
        // Manejadores para los submenús en móvil
        submenus.forEach(function (submenu) {
            submenu.querySelector('.dropdown-item').addEventListener('click', function (e) {
                if (window.innerWidth <= 991) {
                    e.preventDefault();
                    e.stopPropagation();
    
                    // Cerrar otros submenús
                    submenus.forEach(function (otherSubmenu) {
                        if (otherSubmenu !== submenu) {
                            otherSubmenu.classList.remove('show');
                            var otherDropdownMenu = otherSubmenu.querySelector('.dropdown-menu');
                            if (otherDropdownMenu) {
                                otherDropdownMenu.classList.remove('show');
                            }
                        }
                    });
    
                    submenu.classList.toggle('show');
                    var dropdownMenu = submenu.querySelector('.dropdown-menu');
                    dropdownMenu.classList.toggle('show');
                }
            });
        });
    
        // Cerrar los menús cuando se hace clic fuera de ellos en móvil
        document.addEventListener('click', function (e) {
            if (window.innerWidth <= 991) {
                var dropdowns = document.querySelectorAll('.navbar-collapse .dropdown');
                dropdowns.forEach(function (dropdown) {
                    if (!dropdown.contains(e.target)) {
                        dropdown.classList.remove('show');
                        var dropdownMenu = dropdown.querySelector('.dropdown-menu');
                        if (dropdownMenu) {
                            dropdownMenu.classList.remove('show');
                        }
                    }
                });
            }
        });
    
        // Abrir submenús al pasar el mouse en escritorio
        var desktopDropdowns = document.querySelectorAll('.navbar-nav .dropdown');
        desktopDropdowns.forEach(function (dropdown) {
            dropdown.addEventListener('mouseenter', function () {
                if (window.innerWidth > 991) {
                    var submenu = dropdown.querySelector('.dropdown-menu');
                    submenu.classList.add('show');
                }
            });
            dropdown.addEventListener('mouseleave', function () {
                if (window.innerWidth > 991) {
                    var submenu = dropdown.querySelector('.dropdown-menu');
                    submenu.classList.remove('show');
                }
            });
        });
    });
    </script>
    

<!-- Topbar Start -->
<div class="container-fluid">
    <div class="row align-items-center bg-white py-2 px-xl-5 d-none d-lg-flex">
        <div class="col-lg-2 d-flex align-items-center">
            <a href="#" class="text-decoration-none d-flex align-items-center">
                <img src="img/logoelmartillo.png" alt="Ferretería El Martillo" style="max-width: 80px;">
                <span class="h5 text-dark ml-3 mb-0">Ferretería El Martillo</span>
            </a>
        </div>
        <div class="col-lg-4 col-6 text-left">
            <form action="">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Buscar productos">
                    <div class="input-group-append">
                        <span class="input-group-text bg-transparent text-danger">
                            <i class="fa fa-search"></i>
                        </span>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-4 col-6">
            <div class="d-flex flex-column">
                <p class="m-0">
                    <i class="fas fa-map-marker-alt text-danger"></i>
                    <a href="https://www.google.com/maps/search/?api=1&query=Esquina+Freire+Poniente+415" target="_blank" class="text-dark">Dirección: Esquina freire poniente 415, Dalcahue, Chiloé</a>
                </p>
                <p class="m-0">
                    <i class="fas fa-clock text-danger"></i>
                    Horario: 8:30 a 12:30 y 14:00 a 18:30 hrs
                </p>
                <p class="m-0">
                    <i class="fas fa-calendar-alt text-danger"></i>
                    Lunes a viernes
                </p>
            </div>
        </div>
        <div class="col-lg-2 col-6 text-right">
            <p class="m-0">Atención al cliente</p>
            <a href="https://wa.me/56988696580" class="btn btn-success mb-0 rounded-pill shadow">
                <i class="fab fa-whatsapp"></i> WhatsApp
            </a>
        </div>
    </div>
</div>
<!-- Topbar End -->

<style>
    .container-fluid .row .col-lg-4 .d-flex {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
</style>


<!-- Navbar Start -->
<div class="container-fluid bg-dark mb-30">
    <div class="row px-xl-5">
        <div class="col-lg-3 d-none d-lg-block">
            <a class="btn d-flex align-items-center justify-content-between bg-danger w-100" data-toggle="collapse" href="#navbar-vertical" style="height: 65px; padding: 0 30px;">
                <h6 class="text-white m-0"><i class="fa fa-bars mr-2"></i>Categorías</h6>
                <i class="fa fa-angle-down text-white"></i>
            </a>
            <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 bg-light" id="navbar-vertical" style="width: calc(100% - 30px); z-index: 999;">
                <div class="navbar-nav w-100">
                    <div class="nav-item dropdown dropright">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Herramientas Eléctricas <i class="fa fa-angle-right float-right mt-1"></i></a>
                        <div class="dropdown-menu position-absolute rounded-0 border-0 m-0">
                            <a href="#" class="dropdown-item">Taladros</a>
                            <a href="#" class="dropdown-item">Sierras</a>
                            <a href="#" class="dropdown-item">Lijadoras</a>
                        </div>
                    </div>
                    <a href="#" class="nav-item nav-link">Herramientas Manuales</a>
                    <a href="#" class="nav-item nav-link">Materiales de Construcción</a>
                    <a href="#" class="nav-item nav-link">Pinturas</a>
                    <a href="#" class="nav-item nav-link">Electricidad</a>
                    <a href="#" class="nav-item nav-link">Plomería</a>
                    <a href="#" class="nav-item nav-link">Ferretería</a>
                    <a href="#" class="nav-item nav-link">Jardinería</a>
                    <a href="#" class="nav-item nav-link">Automotriz</a>
                </div>
            </nav>
        </div>
        <div class="col-lg-9">
            <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-3 py-lg-0 px-0">
                <a href="" class="text-decoration-none d-block d-lg-none">
                    <img src="img/logoelmartillo.png" alt="Ferretería El Martillo" style="max-width: 80px;">
                    <span class="h4 text-white ml-2">Ferretería El Martillo</span>
                </a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                    <div class="navbar-nav d-none d-lg-flex">
                        <a href="{{ route('welcome') }}" class="nav-item nav-link active text-white">Inicio</a>
                        <a href="{{ url('productosVentas') }}" class="nav-item nav-link text-white">Productos</a>
                        <a href="{{ url('productodetalle') }}" class="nav-item nav-link text-white">Detalle de Producto</a>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle text-white" data-toggle="dropdown">Páginas <i class="fa fa-angle-down mt-1"></i></a>
                            <div class="dropdown-menu bg-light rounded-0 border-0 m-0">
                                <a href="cart.html" class="dropdown-item text-dark">Carrito de Compras</a>
                                <a href="{{ url('checkout') }}" class="dropdown-item text-dark">Checkout</a>
                            </div>
                        </div>
                        <a href="{{ url('contacto') }}" class="nav-item nav-link text-white">Contacto</a>
                    </div>
                    <div class="navbar-nav ml-auto py-0 d-none d-lg-block">
                        <a href="" class="btn px-0">
                            <i class="fas fa-heart text-danger"></i>
                            <span class="badge text-secondary border border-secondary rounded-circle" style="padding-bottom: 2px;">0</span>
                        </a>
                        <a href="" class="btn px-0 ml-3">
                            <i class="fas fa-shopping-cart text-danger"></i>
                            <span class="badge text-secondary border border-secondary rounded-circle" style="padding-bottom: 2px;">0</span>
                        </a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>
<!-- Navbar End -->

<!-- Mobile Sidebar Menu -->
<div class="offcanvas-backdrop" id="offcanvas-backdrop"></div>
<div class="offcanvas-menu" id="offcanvas-menu">
    <button type="button" class="btn close-btn" data-dismiss="offcanvas-menu">
        <span aria-hidden="true">&times;</span>
    </button>
    <div class="offcanvas-menu-content">
        <div class="offcanvas-menu-header">
            <img src="img/logoelmartillo.png" alt="Ferretería El Martillo" style="max-width: 100px;">
            <h5 class="mt-2">Ferretería El Martillo</h5>
        </div>
        <div class="offcanvas-menu-body">
            <ul class="navbar-nav">
                <li class="nav-item"><a href="{{ route('welcome') }}" class="nav-link">Inicio</a></li>
                <li class="nav-item"><a href="{{ url('productosVentas') }}" class="nav-link">Productos</a></li>
                <li class="nav-item"><a href="{{ url('productodetalle') }}" class="nav-link">Detalle de Producto</a></li>
                <li class="nav-item"><a href="{{ url('contacto') }}" class="nav-link">Contacto</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Login/Register</a></li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Páginas</a>
                    <ul class="dropdown-menu">
                        <li><a href="cart.html" class="dropdown-item">Carrito de Compras</a></li>
                        <li><a href="{{ url('checkout') }}" class="dropdown-item">Checkout</a></li>
                    </ul>
                </li>
            </ul>
            <div class="sidebar-extra-info mt-4">
                <h6 class="text-uppercase">Dirección</h6>
                <p><i class="fa fa-map-marker-alt text-danger"></i> Esquina freire poniente 415, Dalcahue, Chiloé</p>
                <a href="https://www.google.com/maps/place/42%C2%B022'46.4%22S+73%C2%B039'10.8%22W/@-42.3795512,-73.6555699,17z/data=!3m1!4b1!4m4!3m3!8m2!3d-42.3795512!4d-73.652995?hl=es&entry=ttu" class="text-dark" target="_blank">Ver en Google Maps</a>
                <h6 class="text-uppercase mt-3">Horario</h6>
                <p><i class="fa fa-clock text-danger"></i> Lunes - Viernes: 8:30 - 12:30 (colación) 14:00 - 18:30 hrs</p>
                <div class="d-flex flex-column align-items-center mt-3">
                    <h6 class="text-uppercase">Atención al Cliente</h6>
                    <a href="https://wa.me/56988696580" class="btn btn-success mb-2 rounded-pill shadow" target="_blank">
                        <i class="fab fa-whatsapp"></i> WhatsApp
                    </a>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .offcanvas-menu {
        position: fixed;
        top: 0;
        left: 0;
        width: 300px;
        height: 100%;
        background-color: #fff;
        box-shadow: 0 2px 5px rgba(0,0,0,.5);
        transform: translateX(-100%);
        transition: transform .3s ease;
        z-index: 1050;
    }
    .offcanvas-menu.open {
        transform: translateX(0);
    }
    .offcanvas-menu .close-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 30px;
        cursor: pointer;
    }
    .offcanvas-menu .offcanvas-menu-content {
        padding: 20px;
    }
    .offcanvas-menu .offcanvas-menu-header {
        text-align: center;
        margin-bottom: 20px;
    }
    .offcanvas-menu .offcanvas-menu-body {
        overflow-y: auto;
    }
    .offcanvas-menu .navbar-nav {
        list-style: none;
        padding: 0;
    }
    .offcanvas-menu .navbar-nav .nav-item {
        margin: 0;
    }
    .offcanvas-menu .navbar-nav .nav-link {
        display: block;
        padding: 10px 15px;
        color: #000;
        text-decoration: none;
    }
    .offcanvas-menu .navbar-nav .dropdown-menu {
        background: #f8f9fa;
        border: none;
        box-shadow: none;
    }
    .offcanvas-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1040;
        display: none;
    }
    .offcanvas-backdrop.show {
        display: block;
    }
    .sidebar-extra-info {
        padding: 10px;
        background-color: #f8f9fa;
        border-radius: 5px;
    }
    .sidebar-extra-info h6 {
        margin-top: 15px;
        font-size: 14px;
        font-weight: bold;
    }
    .sidebar-extra-info p {
        font-size: 14px;
        margin: 5px 0;
    }
    .sidebar-extra-info a {
        text-decoration: none;
    }
</style>

<script>
    document.querySelector('.navbar-toggler').addEventListener('click', function() {
        document.getElementById('offcanvas-menu').classList.add('open');
        document.getElementById('offcanvas-backdrop').classList.add('show');
    });
    document.querySelector('.close-btn').addEventListener('click', function() {
        document.getElementById('offcanvas-menu').classList.remove('open');
        document.getElementById('offcanvas-backdrop').classList.remove('show');
    });
    document.getElementById('offcanvas-backdrop').addEventListener('click', function() {
        document.getElementById('offcanvas-menu').classList.remove('open');
        document.getElementById('offcanvas-backdrop').classList.remove('show');
    });
</script>
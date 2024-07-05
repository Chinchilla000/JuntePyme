@include('layoutsprincipal.header')
<script>
    window.productos = @json($productos);
</script>
<script src="{{ asset('js/app.js') }}" defer></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<!-- Shop Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <!-- Shop Sidebar Start -->
        <div class="col-lg-3 col-md-4">
            <!-- Category Start -->
            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filtrar por Categoría</span></h5>
            <div class="bg-light p-4 mb-30">
                <form>
                    @foreach($categorias as $categoria)
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="category-{{ $categoria->id }}">
                            <label class="custom-control-label" for="category-{{ $categoria->id }}">{{ $categoria->nombre }}</label>
                        </div>
                    @endforeach
                </form>
            </div>
            <!-- Category End -->

            <!-- Price Start -->
            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filtrar por Precio</span></h5>
            <div class="bg-light p-4 mb-30">
                <form>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" checked id="price-all">
                        <label class="custom-control-label" for="price-all">Todos los Precios</label>
                        <span class="badge border font-weight-normal">1000</span>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" id="price-1">
                        <label class="custom-control-label" for="price-1">$0 - $100</label>
                        <span class="badge border font-weight-normal">150</span>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" id="price-2">
                        <label class="custom-control-label" for="price-2">$100 - $200</label>
                        <span class="badge border font-weight-normal">295</span>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" id="price-3">
                        <label class="custom-control-label" for="price-3">$200 - $300</label>
                        <span class="badge border font-weight-normal">246</span>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" id="price-4">
                        <label class="custom-control-label" for="price-4">$300 - $400</label>
                        <span class="badge border font-weight-normal">145</span>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between">
                        <input type="checkbox" class="custom-control-input" id="price-5">
                        <label class="custom-control-label" for="price-5">$400 - $500</label>
                        <span class="badge border font-weight-normal">168</span>
                    </div>
                </form>
            </div>
            <!-- Price End -->

            <!-- Tool Type Start -->
            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filtrar por Tipo de Herramienta</span></h5>
            <div class="bg-light p-4 mb-30">
                <form>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" checked id="tool-all">
                        <label class="custom-control-label" for="tool-all">Todas las Herramientas</label>
                        <span class="badge border font-weight-normal">1000</span>
                    </div>
                    
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="">
                            <label class="custom-control-label" for=""></label>
                            <span class="badge border font-weight-normal"></span>
                        </div>
                </form>
            </div>
            <!-- Tool Type End -->

            <!-- Brand Start -->
            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filtrar por Marca</span></h5>
            <div class="bg-light p-4 mb-30">
                <form>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" checked id="brand-all">
                        <label class="custom-control-label" for="brand-all">Todas las Marcas</label>
                        <span class="badge border font-weight-normal">1000</span>
                    </div>
                 
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" >
                            <label class="custom-control-label" for=""></label>
                            <span class="badge border font-weight-normal"></span>
                        </div>
                  
                </form>
            </div>
            <!-- Brand End -->
        </div>
        <!-- Shop Sidebar End -->

        <!-- Shop Product Start -->
        <div class="col-lg-9 col-md-8">
            <div class="row pb-3">
                <div class="col-12 pb-1">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div>
                            <button class="btn btn-sm btn-light" onclick="toggleView('grid')"><i class="fa fa-th-large"></i></button>
                            <button class="btn btn-sm btn-light ml-2" onclick="toggleView('list')"><i class="fa fa-bars"></i></button>
                        </div>
                        <div class="ml-2">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">Ordenar</button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#">Últimos</a>
                                    <a class="dropdown-item" href="#">Popularidad</a>
                                    <a class="dropdown-item" href="#">Mejor Calificación</a>
                                </div>
                            </div>
                            <div class="btn-group ml-2">
                                <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">Mostrar</button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#">10</a>
                                    <a class="dropdown-item" href="#">20</a>
                                    <a class="dropdown-item" href="#">30</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @foreach ($productos as $producto)
                    <div class="col-lg-4 col-md-6 col-sm-6 pb-1 product-item">
                        <div class="product-item bg-light mb-4">
                            <div class="product-img position-relative overflow-hidden">
                                <img class="img-fluid w-100" src="{{ $producto->imagen_producto ? asset('storage/imagenes_productos/' . $producto->imagen_producto) : asset('assets/img/gallery/default.jpg') }}" alt="Producto {{ $producto->nombre }}">
                                <div class="product-action">
                                    <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                                    <a class="btn btn-outline-dark btn-square" href=""><i class="far fa-heart"></i></a>
                                    <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-sync-alt"></i></a>
                                    <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-search"></i></a>
                                </div>
                            </div>
                            <div class="text-center py-4">
                                <a class="h6 text-decoration-none text-truncate" href="">{{ $producto->nombre }}</a>
                                <div class="d-flex align-items-center justify-content-center mt-2">
                                    <h5>${{ number_format($producto->precio_final, 0, ',', '.') }}</h5>
                                    @if($producto->precio_final != $producto->precio_venta_bruto)
                                        <h6 class="text-muted ml-2"><del>${{ number_format($producto->precio_venta_bruto, 0, ',', '.') }}</del></h6>
                                    @endif
                                </div>
                               
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="col-12">
                    <nav>
                        <ul class="pagination justify-content-center">
                            <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">Next</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Shop Product End -->
    </div>
</div>
<!-- Shop End -->

@include('layoutsprincipal.footer')

<style>
    .custom-control-input:checked ~ .custom-control-label::before {
        background-color: red;
        border-color: red;
    }

    .page-item.active .page-link {
        background-color: red;
        border-color: red;
    }

    .page-link {
        color: red;
    }

    .page-item.disabled .page-link {
        color: #ddd;
    }
</style>

<script>
    function toggleView(viewType) {
        const productItems = document.querySelectorAll('.product-item');
        productItems.forEach(item => {
            if (viewType === 'list') {
                item.classList.add('col-12');
                item.classList.remove('col-lg-4', 'col-md-6', 'col-sm-6');
            } else {
                item.classList.add('col-lg-4', 'col-md-6', 'col-sm-6');
                item.classList.remove('col-12');
            }
        });
    }
</script>

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
                <img src="{{ asset('img/logoelmartillo.png') }}" alt="Ferretería El Martillo" style="width: 30px; vertical-align: middle; margin-right: 10px;">
                &copy; <a class="text-danger" href="#">Ferretería El Martillo</a>. Todos los derechos reservados. Diseñado por
                <a class="text-danger" href="https://codecrafters.cl">CodeCrafters</a>.
            </p>
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
   
</body>
</html> 
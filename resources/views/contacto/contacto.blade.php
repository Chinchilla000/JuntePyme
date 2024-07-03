@include('layoutsprincipal.header')
@include('layoutsprincipal.nav')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<section class="py-4 bg-primary-gradient">
    <br>
    <div class="container">
        <div class="row text-center">
            <!-- Detalles de contacto -->
            <div class="col-md-6 mb-4 mb-md-0">
                <div class="card">
                    <div class="card-body">
                        <h4 class="fw-bold text-center mb-4">Información de Contacto</h4>
                        <p><a href="https://wa.me/56987654321?text=Hola!%20Estoy%20interesado%20en%20saber%20más%20sobre%20los%20productos." class="text-decoration-none"><i class="fab fa-whatsapp me-2"></i>+56 9 8765 4321</a></p>
                        <p><a href="mailto:fullmascotaschiloe@gmail.com" class="text-decoration-none"><i class="fas fa-envelope me-2"></i>fullmascotaschiloe@gmail.com</a></p>
                        <p><a href="https://maps.google.com/?q=Ignacio Serrano 531, Castro" target="_blank"><i class="fas fa-map-marker-alt me-2"></i>Sucursal Castro: Ignacio Serrano 531, Castro</a></p>
                        <p><a href="https://maps.google.com/?q=Av. la paz 423, Quellón" target="_blank"><i class="fas fa-map-marker-alt me-2"></i>Sucursal Quellón: Av. la paz 423</a></p>
                        <h5 class="mt-4">Redes Sociales</h5>
                        <p><a href="https://www.instagram.com/fullbigoteschiloe" target="_blank" class="me-2"><i class="fab fa-instagram"></i> Instagram</a></p>
                    </div>
                </div>
            </div>
            
            <!-- Formulario de contacto -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="fw-bold text-center mb-4">Contáctanos</h4>
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <form method="POST" action="{{ route('contacto.send') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="contactName" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="contactName" name="contactName" placeholder="Tu nombre completo" required>
                            </div>
                            <div class="mb-3">
                                <label for="contactEmail" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" id="contactEmail" name="contactEmail" placeholder="tu@ejemplo.com" required>
                            </div>
                            <div class="mb-3">
                                <label for="contactPhone" class="form-label">Teléfono</label>
                                <div class="input-group">
                                    <span class="input-group-text">+569</span>
                                    <input type="text" class="form-control" id="contactPhone" name="contactPhone" placeholder="87654321" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="contactMessage" class="form-label">Mensaje</label>
                                <textarea class="form-control" id="contactMessage" name="contactMessage" rows="4" placeholder="Escribe tu mensaje aquí..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Enviar Mensaje</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mapa con tabs para las sucursales -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#castro" role="tab" aria-controls="castro" aria-selected="true">Sucursal Castro</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#quellon" role="tab" aria-controls="quellon" aria-selected="false">Sucursal Quellón</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body tab-content">
                        <div class="tab-pane fade show active" id="castro" role="tabpanel">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d735.6321310344664!2d-73.7618465!3d-42.4803152!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x962219e4f2416ad5%3A0x90ddb58057b92f6e!2sIgnacio%20Serrano%20531%2C%205700278%20Castro%2C%20Los%20Lagos!5e0!3m2!1sen!2scl!4v1715217454957!5m2!1sen!2scl" width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                        </div>
                        <div class="tab-pane fade" id="quellon" role="tabpanel">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2912.4357565222317!2d-73.6197981!3d-43.1163714!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9621d1bce0a435d9%3A0x7374c21884d7efe7!2sAv.%20la%20Paz%20423%2C%20Quell%C3%B3n%2C%20Los%20Lagos!5e0!3m2!1sen!2scl!4v1715217362383!5m2!1sen!2scl" width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('layoutsprincipal.footer')

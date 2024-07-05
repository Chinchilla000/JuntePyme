@include('layoutsprincipal.header')

<!-- Contacto Start -->
<div class="container-fluid">
    <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4">
        <span class="bg-secondary pr-3">Contáctenos</span>
    </h2>
    <div class="row px-xl-5">
        <div class="col-lg-7 mb-5">
            <div class="contact-form bg-light p-30">
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
                    <button type="submit" class="btn btn-danger w-100">Enviar Mensaje</button>
                </form>
            </div>
        </div>
        <div class="col-lg-5 mb-5">
            <div class="bg-light p-30 mb-30" style="height: 300px;">
                <iframe src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d2947.2626412599857!2d-73.6555699238897!3d-42.37955117119099!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zNDLCsDIyJzQ2LjQiUyA3M8KwMzknMTAuOCJX!5e0!3m2!1ses!2scl!4v1720120854249!5m2!1ses!2scl" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <div class="bg-light p-30 mb-3">
                <p class="mb-2"><i class="fa fa-map-marker-alt text-danger mr-3"></i>Esquina freire poniente 415, Dalcahue, Chiloé</p>
                <p class="mb-2"><i class="fa fa-envelope text-danger mr-3"></i>info@ferreteriaelmartillo.com</p>
                <p class="mb-2"><i class="fa fa-phone-alt text-danger mr-3"></i>+569 8869 6580</p>
            </div>
        </div>
    </div>
</div>
<!-- Contacto End -->

@include('layoutsprincipal.footer')

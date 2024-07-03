@include('layoutsprincipal.header')
@include('layoutsprincipal.nav')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<style>
    .text-orange {
        color: #FFA500;
    }

    .text-turquoise {
        color: #40E0D0;
    }

    .text-white {
        color: white;
    }

    .card-span {
        transition: box-shadow .3s ease-in-out, transform .3s ease-in-out;
        cursor: pointer;
    }

    .card-span:hover {
        transform: scale(1.05);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.19), 0 6px 6px rgba(0, 0, 0, 0.23);
    }

    .service-card {
        margin-bottom: 30px;
    }

    .service-card img {
        max-height: 200px;
        object-fit: cover;
        border-radius: 10px;
    }

    .service-card .content {
        padding: 15px;
    }

    .mixed-color-title span {
        display: inline-block;
    }

    @media (max-width: 576px) {
        .service-card .content {
            padding: 10px;
        }

        .service-card img {
            max-height: 150px;
        }

        .card-title {
            font-size: 1.25rem;
        }

        .fs-4 {
            font-size: 1rem;
        }
    }

    @media (min-width: 1200px) {
        .card-title {
            font-size: 1.5rem;
        }

        .fs-4 {
            font-size: 1.125rem;
        }
    }
</style>

<section id="services-list" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center mb-5">
                <h1 class="fw-bold fs-3 fs-lg-5 lh-sm">
                    <span class="text-orange">Apartado</span>
                    <span class="text-turquoise">Informativo</span>
                </h1>
            </div>
        </div>
        <div class="row">
            @foreach ($informaciones as $informacion)
                @if ($informacion->tipo == 'informativo')
                    <div class="col-12 col-md-6 col-lg-4 service-card">
                        <div class="card card-span shadow-lg">
                            <img class="img-fluid w-100" src="{{ asset($informacion->imagen) }}" alt="{{ $informacion->titulo }}">
                            <div class="content">
                                <h5 class="card-title mixed-color-title">
                                    <span class="text-orange">{{ explode(' ', $informacion->titulo)[0] }}</span>
                                    <span class="text-turquoise">{{ implode(' ', array_slice(explode(' ', $informacion->titulo), 1)) }}</span>
                                </h5>
                                <p class="fs-2">{{ Str::limit($informacion->descripcion, 100, '...') }}</p>
                                <a href="{{ route('servicios.ver', $informacion->id) }}" class="btn btn-primary">Ver más</a>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</section>

@include('layoutsprincipal.footer')

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
    .content-section {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        margin-top: 30px;
    }
    .content-section img {
        width: 100%;
        height: auto;
        border-radius: 10px 10px 0 0;
        object-fit: cover;
    }
    .content-section .content {
        padding: 14px;
    }
    .title-combined {
        font-size: 2.5rem;
    }
    .title-combined .text-orange,
    .title-combined .text-turquoise {
        display: inline-block;
    }
    .btn-container {
        text-align: center;
        margin-top: 20px;
    }
</style>

<br>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <div class="content-section">
                <img src="{{ asset($informacion->imagen) }}" alt="{{ $informacion->titulo }}">
                <div class="content">
                    <h1 class="fw-bold title-combined">
                        @php
                            $tituloPartes = explode(' ', $informacion->titulo, 2);
                        @endphp
                        <span class="text-orange">{{ $tituloPartes[0] }}</span>
                        @if (isset($tituloPartes[1]))
                            <span class="text-turquoise">{{ $tituloPartes[1] }}</span>
                        @endif
                    </h1>
                    <p class="fs-2" style="color: {{ $informacion->color }}">{{ $informacion->descripcion }}</p>
                    <p class="fs-2">{{ $informacion->contenido }}</p>
                    <p><strong>Etiquetas:</strong> {{ $informacion->tags }}</p>
                    <p><strong>Autor:</strong> {{ $informacion->autor }}</p>
                    <div class="btn-container">
                        <a href="{{ url('/') }}" class="btn btn-primary">Volver al Inicio</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('layoutsprincipal.footer')

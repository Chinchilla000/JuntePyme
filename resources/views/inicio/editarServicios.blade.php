@extends('layouts.header')

@section('title', 'Agregar Información Detallada')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">Agregar Información Detallada</h4>

    <!-- Mensaje de éxito -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Mostrar errores de validación -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Contenedor para el formulario y la vista previa -->
    <div class="row">
        <!-- Formulario para agregar información detallada -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <form id="informacionForm" action="{{ route('informacion.guardarDetallada') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $informacion->id }}">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="titulo" class="form-label">Título:</label>
                                <input type="text" name="titulo" id="titulo" class="form-control" value="{{ old('titulo', $informacion->titulo) }}" maxlength="255" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="descripcion" class="form-label">Descripción:</label>
                                <textarea class="form-control" id="descripcion" name="descripcion" rows="2" maxlength="500" required>{{ old('descripcion', $informacion->descripcion) }}</textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="contenido" class="form-label">Contenido:</label>
                                <textarea class="form-control" id="contenido" name="contenido" rows="3" maxlength="2000" required>{{ old('contenido', $informacion->contenido) }}</textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="autor" class="form-label">Autor:</label>
                                <input type="text" name="autor" id="autor" class="form-control" maxlength="255" required value="{{ old('autor', $informacion->autor) }}">
                            </div>
                            <div class="col-md-6">
                                <label for="tags" class="form-label">Etiquetas:</label>
                                <input type="text" name="tags" id="tags" class="form-control" maxlength="255" value="{{ old('tags', $informacion->tags) }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="imagen">Seleccionar Imagen:</label>
                                <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Agregar</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Vista previa de la sección informativa -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="card-title" id="preview-titulo">{{ $informacion->titulo }}</h5>
                            <p class="card-text" id="preview-descripcion">{{ $informacion->descripcion }}</p>
                            <p class="card-text" id="preview-contenido">{{ $informacion->contenido }}</p>
                            <p class="card-text" id="preview-autor">Autor: {{ $informacion->autor }}</p>
                            <p class="card-text" id="preview-tags">Etiquetas: {{ $informacion->tags }}</p>
                        </div>
                        <div class="col-md-6">
                            <div id="preview-imagen-container">
                                <img class="img-fluid w-100" id="preview-imagen" src="{{ asset($informacion->imagen) }}" alt="Imagen">
                            </div>
                            <p class="text-muted" id="preview-no-imagen" style="display: none;">Aún no se ha ingresado imagen.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript para actualizar la vista previa en tiempo real -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('titulo').addEventListener('input', function() {
            document.getElementById('preview-titulo').innerText = this.value;
        });

        document.getElementById('descripcion').addEventListener('input', function() {
            document.getElementById('preview-descripcion').innerText = this.value;
        });

        document.getElementById('contenido').addEventListener('input', function() {
            document.getElementById('preview-contenido').innerText = this.value;
        });

        document.getElementById('autor').addEventListener('input', function() {
            document.getElementById('preview-autor').innerText = 'Autor: ' + this.value;
        });

        document.getElementById('tags').addEventListener('input', function() {
            document.getElementById('preview-tags').innerText = 'Etiquetas: ' + this.value;
        });

        document.getElementById('imagen').addEventListener('change', function() {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-imagen').src = e.target.result;
                document.getElementById('preview-no-imagen').style.display = 'none';
            };
            reader.readAsDataURL(this.files[0]);
        });
    });
</script>
@endsection

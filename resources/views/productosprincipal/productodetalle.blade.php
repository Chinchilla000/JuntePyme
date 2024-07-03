@include('layoutsprincipal.header')
@include('layoutsprincipal.nav')
<script>
    window.productos = @json([$producto]);
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<br><br>
<section class="py-4 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                @if ($producto->imagen_producto)
                    <img src="{{ asset('storage/imagenes_productos/' . $producto->imagen_producto) }}" class="img-fluid" alt="{{ $producto->nombre }}">
                @else
                    <img src="{{ asset('assets/img/gallery/default.jpg') }}" class="img-fluid" alt="Default Image">
                @endif
            </div>
            <div class="col-md-6">
                <h2 class="fw-bold">{{ $producto->nombre }}</h2>
                <p class="text-muted">{{ $producto->descripcion }}</p>
            
                @if($producto->descuento)
                    @if($producto->descuento->monto)
                        <h3 class="text-danger">
                            <del class="precio-tachado">${{ number_format($producto->precio_venta_bruto, 0) }}</del>
                            ${{ number_format($producto->precio_venta_bruto - $producto->descuento->monto, 0) }}
                        </h3>
                        <span class="badge bg-success">Descuento: ${{ number_format($producto->descuento->monto, 0) }}</span>
                    @elseif($producto->descuento->porcentaje)
                        <h3 class="text-danger">
                            <del class="precio-tachado">${{ number_format($producto->precio_venta_bruto, 0) }}</del>
                            ${{ number_format($producto->precio_venta_bruto * (1 - $producto->descuento->porcentaje / 100), 0) }}
                        </h3>
                        <span class="badge bg-success">Descuento: {{ $producto->descuento->porcentaje }}%</span>
                    @endif
                @else
                    <h3 class="text-success">${{ number_format($producto->precio_venta_bruto, 0) }}</h3>
                @endif
            
                <hr>
                <h5>Especificaciones:</h5>
                <ul>
                    @if ($especificaciones->isEmpty())
                        <li>No hay especificaciones para este producto.</li>
                    @else
                        @foreach ($especificaciones as $especificacion)
                            <li>{{ $especificacion->clave }}: {{ $especificacion->valor }}</li>
                        @endforeach
                    @endif
                </ul>
            
                <!-- Botón para añadir al carrito -->
                <button class="btn btn-primary btn-sm mt-2 w-100 w-sm-auto" onclick="openQuantityModal({{ $producto->id }})">
                    <i class="fas fa-cart-plus"></i> Añadir al carrito
                </button>
            </div>
            <style>
                .precio-tachado {
                    color: grey;
                }
            </style>
            
        </div>
        <!-- Sección de detalles adicionales del producto -->
        <div class="row mt-4">
            <div class="col-12">
                <h4 class="text-center mb-4">Detalles del Producto</h4>
                @if ($detalles->isEmpty())
                    <p class="text-center">Aún no se han agregado datos.</p>
                @else
                    <div class="accordion" id="productDetailsAccordion">
                        @foreach ($detalles as $index => $detalle)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading{{ $detalle->id }}">
                                    <button class="accordion-button {{ $index == 0 ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $detalle->id }}" aria-expanded="{{ $index == 0 ? 'true' : 'false' }}" aria-controls="collapse{{ $detalle->id }}">
                                        {{ $detalle->titulo }}
                                    </button>
                                </h2>
                                <div id="collapse{{ $detalle->id }}" class="accordion-collapse collapse {{ $index == 0 ? 'show' : '' }}" aria-labelledby="heading{{ $detalle->id }}" data-bs-parent="#productDetailsAccordion">
                                    <div class="accordion-body">
                                        {!! $detalle->contenido !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
        <!-- Sección de comentarios y valoraciones -->
        <div class="row mt-4">
            <div class="col-12">
                <h4 class="text-center mb-4">Comentarios de Clientes</h4>
                <div class="row">
                    @forelse($comentarios as $comentario)
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title text-primary">{{ $comentario->nombre }}</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">{{ \Carbon\Carbon::parse($comentario->fecha)->locale('es')->diffForHumans() }}</h6>
                                    <p class="card-text">{{ $comentario->descripcion }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center">No hay comentarios para este producto.</p>
                    @endforelse
                </div>
                <!-- Enlaces de paginación -->
                <div class="d-flex justify-content-center">
                    {{ $comentarios->links() }}
                </div>
            </div>
        </div>
        <!-- Formulario para nuevo comentario -->
        <h4 class="text-center mb-4">Escribe un Comentario</h4>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('comentarios.store', $producto->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="correo" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="correo" name="correo" required>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Comentario</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Enviar Comentario</button>
                </form>
            </div>
        </div>
    </div>
</section>
<script>
    function openQuantityModal(productoId) {
        console.log("ID solicitado:", productoId);
        // Aquí puedes agregar la lógica para abrir el modal de cantidad y añadir al carrito
        console.log(`Abrir modal para el producto con ID ${productoId}`);
        // Suponemos que tienes una función para mostrar el modal
        const modalElement = document.getElementById('quantityModal'); // Asegúrate de que el ID corresponde a tu modal
        if (modalElement) {
            const modal = new bootstrap.Modal(modalElement);
            modal.show();
        }
    }
    </script>
    
@include('layoutsprincipal.footer')
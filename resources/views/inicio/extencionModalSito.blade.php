<!-- Estos modals son para editar el sitio web--->
<!-- Modal para agregar nuevo contenido -->
<div class="modal fade" id="agregarModal" tabindex="-1" aria-labelledby="agregarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="agregarModalLabel">Agregar Nuevo Contenido</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Formulario para agregar contenido -->
                <form action="{{ route('gestionSitio.agregarContenido') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- Campos para agregar imagen, texto y color -->
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título:</label>
                        <input type="text" name="titulo" id="titulo" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion">Descripción:</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="imagen">Seleccionar Imagen:</label>
                        <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*" required>
                    </div>
                    <!-- Botón para enviar el formulario -->
                    <button type="submit" class="btn btn-primary">Agregar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal para editar la información -->
<div class="modal fade" id="editarModal" tabindex="-1" aria-labelledby="editarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarModalLabel">Editar Información</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Formulario para editar la información -->
                <form action="" method="POST">
                    @csrf
                    <!-- Campo oculto para almacenar el ID del elemento a editar -->
                    <input type="hidden" id="elemento_id" name="elemento_id">
                    <!-- Campos para editar la información -->
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título:</label>
                        <input type="text" name="titulo" id="titulo" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion">Descripción:</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="imagen">Seleccionar Imagen:</label>
                        <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </div>
</div>
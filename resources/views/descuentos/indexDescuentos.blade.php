@extends('layouts.header')

@section('title', 'Gestión de Descuentos')

@section('content')
    <style>
        @media (max-width: 768px) {
            .container {
                padding: 0 15px;
            }
            .card {
                margin-bottom: 20px;
            }
            .card-header, .card-body, .modal-content {
                padding: 10px;
            }
            .btn, .form-control, .pagination, .modal-dialog {
                width: 100%;
                margin-bottom: 10px;
            }
            .input-group {
                flex-direction: column;
            }
            .mobile-table th:not(:first-child), .mobile-table td:not(:first-child) {
                display: none;
            }
            .mobile-table th:first-child, .mobile-table td:first-child {
                display: table-cell;
            }
        }
    </style>

    <div class="container mt-4">
        <div class="mb-4">
            <form method="GET" action="{{ route('descuentos.indexDescuentos') }}" class="input-group">
                <input type="text" name="searchTerm" class="form-control" placeholder="Buscar por nombre, descripción..." id="searchTerm" value="{{ request('searchTerm') }}">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Buscar
                </button>
            </form>
        </div>

        <div>
            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#crearDescuentoModal">Ingresar Descuento</button>
        </div>

        <div class="modal fade" id="crearDescuentoModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('descuentos.store') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Ingresar Descuento</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre del Descuento</label>
                                <input type="text" name="nombre" id="nombre" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="tipo_descuento" class="form-label">Tipo de Descuento</label>
                                <select name="tipo_descuento" id="tipo_descuento" class="form-control" onchange="toggleDiscountType(this.value)">
                                    <option value="">Seleccione el tipo</option>
                                    <option value="monto">Monto Fijo</option>
                                    <option value="porcentaje">Porcentaje</option>
                                    <option value="codigo">Código Promocional</option>
                                </select>
                            </div>

                            <div class="mb-3" id="monto_field" style="display: none;">
                                <label for="monto" class="form-label">Monto</label>
                                <input type="number" name="monto" id="monto" class="form-control">
                            </div>

                            <div class="mb-3" id="porcentaje_field" style="display: none;">
                                <label for="porcentaje" class="form-label">Porcentaje</label>
                                <input type="number" name="porcentaje" id="porcentaje" class="form-control" step="0.01">
                            </div>

                            <div id="codigo_field" style="display: none;">
                                <div class="mb-3">
                                    <label for="codigo_promocional" class="form-label">Código Promocional</label>
                                    <input type="text" name="codigo_promocional" id="codigo_promocional" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label for="tipo_descuento_codigo" class="form-label">Tipo de Descuento para el Código</label>
                                    <select name="tipo_descuento_codigo" id="tipo_descuento_codigo" class="form-control" onchange="toggleCodigoDescuento(this.value)">
                                        <option value="">Seleccione el tipo</option>
                                        <option value="monto_codigo">Monto Fijo</option>
                                        <option value="porcentaje_codigo">Porcentaje</option>
                                    </select>
                                </div>
                                <div class="mb-3" id="monto_codigo_field" style="display: none;">
                                    <label for="monto_codigo" class="form-label">Monto del Código</label>
                                    <input type="number" name="monto_codigo" id="monto_codigo" class="form-control">
                                </div>
                                <div class="mb-3" id="porcentaje_codigo_field" style="display: none;">
                                    <label for="porcentaje_codigo" class="form-label">Porcentaje del Código</label>
                                    <input type="number" name="porcentaje_codigo" id="porcentaje_codigo" class="form-control" step="0.01">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="inicio" class="form-label">Inicio</label>
                                <input type="datetime-local" name="inicio" id="inicio" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="fin" class="form-label">Fin</label>
                                <input type="datetime-local" name="fin" id="fin" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                Lista de Descuentos
            </div>
            <div class="table-responsive">
                <table class="table w-100">
                    <thead>
                        <tr>
                        <tr>
                            <th>Nombre</th>
                            <th>Tipo Descuento</th>
                            <th>Total/Código</th>
                            <th>Inicio</th>
                            <th>Fin</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($descuentos as $descuento)
                            <tr>
                                <td>{{ $descuento->nombre }}</td>
                                <td>
                                    @if ($descuento->monto && !$descuento->codigo_promocional)
                                        Monto
                                    @elseif ($descuento->porcentaje && !$descuento->codigo_promocional)
                                        Porcentaje
                                    @elseif ($descuento->codigo_promocional && $descuento->monto)
                                        Código - Monto:<br>{{ $descuento->codigo_promocional }}
                                    @elseif ($descuento->codigo_promocional && $descuento->porcentaje)
                                        Código - Porcentaje:<br>{{ $descuento->codigo_promocional }}
                                    @elseif ($descuento->codigo_promocional)
                                        Código<br>{{ $descuento->codigo_promocional }}
                                    @else
                                        No definido
                                    @endif
                                </td>

                                <td>
                                    @if ($descuento->monto)
                                        ${{ number_format($descuento->monto, 2) }}
                                    @elseif ($descuento->porcentaje)
                                        {{ $descuento->porcentaje }}%
                                    @else
                                        {{ $descuento->codigo_promocional ? 'Código: ' . $descuento->codigo_promocional : 'N/A' }}
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($descuento->inicio)->format('d/m/Y H:i') }}</td>
                                <td>{{ \Carbon\Carbon::parse($descuento->fin)->format('d/m/Y H:i') }}</td>
                                <td>
                                    <button class="btn btn-warning"
                                        onclick="setupEditModal('{{ $descuento->id }}', '{{ $descuento->tipo_descuento }}', '{{ $descuento->monto ? 'true' : 'false' }}', '{{ $descuento->porcentaje ? 'true' : 'false' }}', '{{ $descuento->codigo_promocional ? 'true' : 'false' }}')"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editarDescuentoModal{{ $descuento->id }}">Editar</button>
                                    <button class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#eliminarDescuentoModal{{ $descuento->id }}">Eliminar</button>
                                    <a href="{{ route('descuentos.detalleDescuentos', $descuento->id) }}" class="btn btn-info">Detalles</a>
                                </td>
                            </tr>
                            <!-- Modal Editar Descuento -->
    <div class="modal fade" id="editarDescuentoModal{{ $descuento->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('descuentos.update', $descuento->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Descuento</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nombre{{ $descuento->id }}" class="form-label">Nombre del Descuento</label>
                            <input type="text" name="nombre" id="nombre{{ $descuento->id }}" class="form-control" value="{{ $descuento->nombre }}" required>
                        </div>

                        @if ($descuento->monto)
                            <div class="mb-3">
                                <label for="monto{{ $descuento->id }}" class="form-label">Monto</label>
                                <input type="number" name="monto" id="monto{{ $descuento->id }}" class="form-control" value="{{ $descuento->monto }}">
                            </div>
                        @endif

                        @if ($descuento->porcentaje)
                            <div class="mb-3">
                                <label for="porcentaje{{ $descuento->id }}" class="form-label">Porcentaje</label>
                                <input type="number" name="porcentaje" id="porcentaje{{ $descuento->id }}" class="form-control" value="{{ $descuento->porcentaje }}">
                            </div>
                        @endif

                        @if ($descuento->codigo_promocional)
                            <div class="mb-3">
                                <label for="codigo_promocional{{ $descuento->id }}" class="form-label">Código Promocional</label>
                                <input type="text" name="codigo_promocional" id="codigo_promocional{{ $descuento->id }}" class="form-control" value="{{ $descuento->codigo_promocional }}">
                            </div>
                        @endif

                        <div class="mb-3">
                            <label for="inicio{{ $descuento->id }}" class="form-label">Inicio</label>
                            <input type="datetime-local" name="inicio" id="inicio{{ $descuento->id }}" class="form-control" value="{{ \Carbon\Carbon::parse($descuento->inicio)->format('Y-m-d\TH:i') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="fin{{ $descuento->id }}" class="form-label">Fin</label>
                            <input type="datetime-local" name="fin" id="fin{{ $descuento->id }}" class="form-control" value="{{ \Carbon\Carbon::parse($descuento->fin)->format('Y-m-d\TH:i') }}" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

                            <!-- Modal Eliminar Descuento -->
                            <div class="modal fade" id="eliminarDescuentoModal{{ $descuento->id }}" tabindex="-1"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <form action="{{ route('descuentos.destroy', $descuento->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <div class="modal-header">
                                                <h5 class="modal-title">Confirmar Eliminación</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>¿Estás seguro de que deseas eliminar el descuento
                                                    <strong>{{ $descuento->nombre }}</strong>?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn btn-danger">Eliminar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        @empty
                            <tr>
                                <td colspan="5">No hay descuentos registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
            <div class="d-flex justify-content-center">
                {{ $descuentos->links() }}
                <!-- Asegúrate de tener una paginación personalizada o la predeterminada de Laravel -->
            </div>
        </div>
    </div>
    </div>

    <script>
        function toggleDiscountType(type) {
            document.getElementById('monto_field').style.display = type === 'monto' ? 'block' : 'none';
            document.getElementById('porcentaje_field').style.display = type === 'porcentaje' ? 'block' : 'none';
            document.getElementById('codigo_field').style.display = type === 'codigo' ? 'block' : 'none';
        }

        function toggleCodigoDescuento(type) {
            document.getElementById('monto_codigo_field').style.display = type === 'monto_codigo' ? 'block' : 'none';
            document.getElementById('porcentaje_codigo_field').style.display = type === 'porcentaje_codigo' ? 'block' : 'none';
        }
    </script>

@endsection

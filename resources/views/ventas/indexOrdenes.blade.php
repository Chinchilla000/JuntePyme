@extends('layouts.header')

@section('title', 'Gestión de Órdenes')

@section('content')
<div class="container mt-4">
    <!-- Barra de búsqueda -->
    <div class="mb-4">
        <form method="GET" action="{{ route('ordenes.index') }}" class="input-group">
            <input type="text" name="searchTerm" class="form-control" placeholder="Buscar por referencia, nombre de cliente..." value="{{ request('searchTerm') }}">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i> Buscar
            </button>
        </form>
    </div>

    <!-- Lista de órdenes -->
    <div class="card">
        <div class="card-header">
            Lista de Órdenes
        </div>
        <div class="table-responsive">
            <table class="table w-100">
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Tipo Retiro</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ordenes as $orden)
                    <tr>
                        <td>
                            @if($orden->detalleOrden)
                                {{ $orden->detalleOrden->first_name }} {{ $orden->detalleOrden->last_name }}
                            @else
                                Sin nombre
                            @endif
                        </td>
                        <td>$ {{ number_format($orden->total, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge @if($orden->status == 'pending') bg-warning @elseif($orden->status == 'completed') bg-success @elseif($orden->status == 'rejected') bg-danger @endif">
                                @if($orden->status == 'pending')
                                    Pendiente
                                @elseif($orden->status == 'completed')
                                    Completada
                                @elseif($orden->status == 'rejected')
                                    Rechazada
                                @else
                                    {{ ucfirst($orden->status) }}
                                @endif
                            </span>
                        </td>
                        <td>
                            @if($orden->detalleOrden)
                            {{ $orden->detalleOrden->tipo_retiro == 'retiro' ? 'Retiro en tienda' : 'Envío a domicilio' }}
                        @else
                            Sin tipo de retiro
                        @endif
                        
                        </td>
                        <td>
                            <a href="{{ route('ordenes.show', $orden->id) }}" class="btn btn-info">Ver</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">No hay órdenes registradas.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <br>
            <div class="d-flex justify-content-center">
                {{ $ordenes->links('pagination.custom') }}
            </div>
            <br>
        </div>
    </div>
</div>
@endsection

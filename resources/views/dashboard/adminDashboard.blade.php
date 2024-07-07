@extends('layouts.header')

@section('title', 'FullBigotes Administrador')

@section('content')
    <style>
        .badge-success {
            background-color: rgb(125, 255, 125);
            color: white;
        }

        .badge-warning {
            background-color: orange;
            color: white;
        }

        .badge-danger-light {
            background-color: rgb(249, 69, 69);
            color: white;
        }
    </style>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-lg-8 mb-4 order-0">
                    <div class="card">
                        <div class="d-flex align-items-end row">
                            <div class="col-sm-7">
                                <div class="card-body">
                                    <h5 class="card-title text-primary">Bienvenido a tu espacio Fullbigotes</h5>
                                    <p class="mb-4">
                                        Aquí puedes gestionar y monitorear fácilmente tus productos, categorías y ventas.
                                        Mantén un seguimiento de las ventas completadas y en curso, y analiza métricas de
                                        rendimiento.
                                    </p>
                                    <a href="" class="btn btn-sm btn-outline-primary">Ver Ordenes</a>
                                </div>
                            </div>
                            <div class="col-sm-5 text-center text-sm-left">
                                <div class="card-body pb-0 px-0 px-md-4">
                                    <!-- Aquí podrías agregar una imagen si lo deseas -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 order-1">
                    <div class="row">
                        <div class="col-lg-6 col-md-12 col-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title d-flex align-items-start justify-content-between">
                                        <div class="avatar flex-shrink-0">
                                            <!-- Aquí podrías agregar un icono si lo deseas -->
                                        </div>
                                        <div class="dropdown">
                                            <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#ordenesTotalModal">Total</a>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="fw-semibold d-block mb-1">Ordenes del día</span>
                                    <h3 class="card-title mb-2">{{ $ordenesCompletadasHoy }}</h3>
                                    <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i>
                                        {{ number_format($porcentajeOrdenes, 2) }}%</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title d-flex align-items-start justify-content-between">
                                        <div class="avatar flex-shrink-0">
                                        </div>
                                        <div class="dropdown">
                                            <button class="btn p-0" type="button" id="cardOpt6" data-bs-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#comentariosModal">Ver Comentario</a>
                                            </div>
                                        </div>
                                    </div>
                                    <span>Comentarios del día</span>
                                    <h3 class="card-title text-nowrap mb-1">{{ $comentarios->count() }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Total Revenue -->
                <div class="col-12 col-lg-8 order-2 order-md-3 order-lg-2 mb-4">
                    <div class="card">
                        <div class="row row-bordered g-0">
                            <div class="col-md-12">
                                <h5 class="card-header m-0 me-2 pb-3">Últimas órdenes de venta</h5>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Cliente</th>
                                                <th>Total</th>
                                                <th>Fecha</th>
                                                <th>Estado</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($recentOrders as $order)
                                                <tr>
                                                    <td>
                                                        {{ $order->detalleOrden->first_name }} {{ $order->detalleOrden->last_name }}
                                                    </td>
                                                    <td>${{ number_format($order->total, 0, ',', '.') }}</td>
                                                    <td>{{ $order->created_at->format('d-m-Y') }}</td>
                                                    <td>
                                                        <span class="badge 
                                                            @if ($order->status == 'completed') badge-success
                                                            @elseif($order->status == 'pending') badge-warning
                                                            @elseif($order->status == 'rejected') badge-danger-light 
                                                            @endif">
                                                            @if ($order->status == 'completed')
                                                                Completado
                                                            @elseif($order->status == 'pending')
                                                                Pendiente
                                                            @elseif($order->status == 'rejected')
                                                                Rechazado
                                                            @endif
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('ordenes.show', $order->id) }}" class="btn btn-info btn-sm">Ver</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ Total Revenue -->
                <div class="col-12 col-md-8 col-lg-4 order-3 order-md-2">
                    <div class="row">
                        <div class="col-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title d-flex align-items-start justify-content-between">
                                        <div class="avatar flex-shrink-0">
                                        </div>
                                        <div class="dropdown">
                                            <button class="btn p-0" type="button" id="cardOpt4" data-bs-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt4">
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#totalComprasModal">Ver Más</a>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="d-block mb-1">Total compras hoy</span>
                                    <h3 class="card-title text-nowrap mb-2">${{ number_format($montoTotalHoy, 0) }}</h3>
                                    <small class="{{ $porcentajeMontoTotal >= 0 ? 'text-success' : 'text-danger' }}">
                                        {{ number_format($porcentajeMontoTotal, 2) }}%
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 mb-4">
                            @if(isset($productoMasComprado) && !empty($productoMasComprado))
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-title d-flex align-items-start justify-content-between">
                                            <div class="avatar flex-shrink-0">
                                            </div>
                                            <div class="dropdown">
                                                <button class="btn p-0" type="button" id="cardOpt1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="cardOpt1">
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#productoMasCompradoModal">Ver Más</a>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="fw-semibold d-block mb-1">Producto más comprado</span>
                                        <h3 class="card-title mb-2">{{ $productoMasComprado->nombre }}</h3>
                                        <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +28.14%</small>
                                    </div>
                                </div>
                            @else
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-title d-flex align-items-start justify-content-between">
                                            <div class="avatar flex-shrink-0">
                                            </div>
                                            <div class="dropdown">
                                                <button class="btn p-0" type="button" id="cardOpt1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <span class="fw-semibold d-block mb-1">Producto más comprado</span>
                                        <h3 class="card-title mb-2">Aún no hay productos</h3>
                                        <small class="text-muted fw-semibold">Sin datos</small>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <!-- </div>
                                <div class="row"> -->
                        <div class="col-12 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                                        <div
                                            class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                                            <div class="card-title">
                                                <h5 class="text-nowrap mb-2">Productos activos en venta</h5>
                                                <span class="badge bg-label-warning rounded-pill"> Numero de activos en
                                                    pagina {{ $productosActivos }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- Order Statistics -->
                <div class="col-md-6 col-lg-4 col-xl-4 order-0 mb-4">
                    <div class="col-12 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-header m-0 me-2 pb-3">Gráfico en base a productos comprados</h5>
                                <div id="comprasSemanalesChart" style="width:100%; height:400px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ Order Statistics -->

                <!-- Expense Overview -->
                <div class="col-md-6 col-lg-4 order-1 mb-4">
                  <!-- Gráfico de ventas por categoría -->
                <div class="col-12 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-header m-0 me-2 pb-3">Distribución de Ventas por Categoría</h5>
                            <div id="ventasPorCategoriaChart" style="width:100%; height:400px;"></div>
                        </div>
                    </div>
                </div>
                </div>
                <!--/ Expense Overview -->

                <!-- Transactions -->
                <div class="col-md-6 col-lg-4 order-2 mb-4">
                  <!-- Gráfico de ventas por categoría anual -->
                <div class="col-12 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-header m-0 me-2 pb-3">Ventas por Categoría Anual</h5>
                            <div id="ventasPorCategoriaAnualChart" style="width:100%; height:400px;"></div>
                        </div>
                    </div>
                </div>
                </div>
                <!--/ Transactions -->
              </div>
            
        </div>
    </div>
    <!-- Modal para Órdenes del Día -->
    <div class="modal fade" id="ordenesTotalModal" tabindex="-1" aria-labelledby="ordenesTotalModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ordenesTotalModalLabel">Total Órdenes del Día</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Monto total de órdenes completadas hoy:</p>
                    <h3>${{ number_format($montoTotalHoy, 0) }}</h3>
                    <p>Porcentaje de órdenes completadas hoy en comparación con el día anterior:</p>
                    <h3>{{ $ordenesCompletadasHoy }} / {{ $ordenesCompletadasAyer }}</h3>
                    <p>Cambio porcentual: {{ number_format($porcentajeOrdenes, 2) }}%</p>
                    <p>Este porcentaje indica el cambio en el número de órdenes completadas hoy en comparación con el día
                        anterior.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Comentarios del Día -->
    <div class="modal fade" id="comentariosModal" tabindex="-1" aria-labelledby="comentariosModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="comentariosModalLabel">Comentarios del Día</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul>
                        @foreach ($comentarios as $comentario)
                            <li>
                                {{ $comentario->nombre }}: {{ $comentario->descripcion }} <br>
                                <strong>Producto:</strong> {{ $comentario->producto->nombre }}
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Total Compras -->
    <div class="modal fade" id="totalComprasModal" tabindex="-1" aria-labelledby="totalComprasModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="totalComprasModalLabel">Total Compras del Día</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Monto total de compras hoy:</p>
                    <h3>${{ number_format($montoTotalHoy, 0) }}</h3>
                    <p>Monto total de compras ayer:</p>
                    <h3>${{ number_format($montoTotalAyer, 0) }}</h3>
                    <p>Cambio porcentual:</p>
                    <h3 class="{{ $porcentajeMontoTotal >= 0 ? 'text-success' : 'text-danger' }}">
                        {{ number_format($porcentajeMontoTotal, 2) }}%
                    </h3>
                    <p>
                        Este porcentaje indica el cambio en el monto total de las compras completadas hoy en comparación con
                        el día anterior.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Producto Más Comprado del Día -->
    <div class="modal fade" id="productoMasCompradoModal" tabindex="-1" aria-labelledby="productoMasCompradoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productoMasCompradoModalLabel">Producto Más Comprado del Día</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if ($productoMasComprado)
                        <p>Producto más comprado hoy:</p>
                        <h3>{{ $productoMasComprado->nombre }}</h3>
                        <p>Cantidad comprada hoy:</p>
                        <h3>{{ $cantidadCompradaHoy }}</h3>
                    @else
                        <p>No se encontraron compras para el día de hoy.</p>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Content wrapper -->

@section('footer')
    {{-- El contenido del footer, si es necesario personalizarlo --}}
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Highcharts.chart('comprasSemanalesChart', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Compras Semanales'
            },
            xAxis: {
                categories: {!! json_encode($comprasSemanales['labels']) !!},
                title: {
                    text: 'Día de la Semana'
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Monto Total de Compras ($)'
                }
            },
            series: [{
                name: 'Total Compras :$',
                data: {!! json_encode(array_map('floatval', $comprasSemanales['data'])) !!}
            }]
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Highcharts.chart('ventasPorCategoriaChart', {
            chart: {
                type: 'pie'
            },
            title: {
                text: 'Distribución de Ventas por Categoría'
            },
            series: [{
                name: 'Total en ventas :$',
                colorByPoint: true,
                data: {!! json_encode($ventasPorCategoria) !!}
            }]
        });
    });
</script>
<script src="https://code.highcharts.com/modules/annotations.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Highcharts.chart('ventasPorCategoriaAnualChart', {
            chart: {
                type: 'scatter'
            },
            title: {
                text: 'Ventas por Categoría Anual'
            },
            xAxis: {
                title: {
                    enabled: true,
                    text: 'Mes'
                },
                categories: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic']
            },
            yAxis: {
                title: {
                    text: 'Ventas ($)'
                }
            },
            plotOptions: {
                scatter: {
                    marker: {
                        radius: 5,
                        states: {
                            hover: {
                                enabled: true,
                                lineColor: 'rgb(100,100,100)'
                            }
                        }
                    },
                    states: {
                        hover: {
                            marker: {
                                enabled: false
                            }
                        }
                    },
                    tooltip: {
                        headerFormat: '<b>{series.name}</b><br>',
                        pointFormat: '{point.x} mes, ${point.y} ventas'
                    }
                }
            },
            series: {!! json_encode($ventasPorCategoriaAnual) !!}
        });
    });
</script>
@endsection


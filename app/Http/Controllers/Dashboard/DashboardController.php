<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Comentario;
use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Orden;
use App\Models\User;
use App\Models\Venta;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        // Obtener estadísticas
        $totalOrders = Orden::count();
        $totalUsers = User::count();
        $totalProducts = Producto::count();
        $totalCategories = Categoria::count();

        // Obtener órdenes recientes y estadísticas de pagos y transacciones
        $recentOrders = Orden::with('user')->orderBy('created_at', 'desc')->take(5)->get();
        $pagos = Orden::sum('total');  // Suponiendo que el modelo Orden tiene un campo 'total'
        $transacciones = Orden::where('status', 'completed')->count(); // Ejemplo de transacciones completadas

        // Obtener órdenes completadas hoy y ayer
        $ordenesCompletadasHoy = Orden::whereDate('created_at', Carbon::today())->where('status', 'completed')->count();
        $ordenesCompletadasAyer = Orden::whereDate('created_at', Carbon::yesterday())->where('status', 'completed')->count();
        $porcentajeOrdenes = $this->calcularPorcentaje($ordenesCompletadasHoy, $ordenesCompletadasAyer);

        // Calcular el monto total de las órdenes completadas hoy
        $montoTotalHoy = Orden::whereDate('created_at', Carbon::today())->where('status', 'completed')->sum('total');
        $montoTotalAyer = Orden::whereDate('created_at', Carbon::yesterday())->where('status', 'completed')->sum('total');
        $porcentajeMontoTotal = $this->calcularPorcentaje($montoTotalHoy, $montoTotalAyer);

        // Obtener comentarios del día con información del producto
        $comentarios = Comentario::with('producto')->whereDate('created_at', Carbon::today())->get();

        // Obtener el producto más comprado del día
        $productoMasComprado = $this->productoMasCompradoDelDia();

        // Calcular la cantidad total comprada del producto más comprado hoy
        $cantidadCompradaHoy = $productoMasComprado ? $productoMasComprado->total_cantidad : 0;

        // Obtener la cantidad de productos activos en venta
        $productosActivos = Producto::where('estado', 1)->count();

        // Obtener datos del gráfico de compras semanales
        $comprasSemanales = $this->obtenerComprasSemanales();

        // Obtener datos de ventas por categoría
        $ventasPorCategoria = $this->obtenerVentasPorCategoria();

         // Obtener datos de ventas por categoría anual
        $ventasPorCategoriaAnual = $this->obtenerVentasPorCategoriaAnual();

        return view('dashboard.AdminDashboard', compact(
            'totalOrders', 
            'totalUsers', 
            'totalProducts', 
            'totalCategories', 
            'recentOrders', 
            'pagos', 
            'transacciones', 
            'ordenesCompletadasHoy', 
            'ordenesCompletadasAyer', 
            'comentarios',
            'porcentajeOrdenes',
            'montoTotalHoy',
            'montoTotalAyer',
            'porcentajeMontoTotal',
            'productoMasComprado',
            'cantidadCompradaHoy',
            'productosActivos',
            'comprasSemanales',
            'ventasPorCategoria',
            'ventasPorCategoriaAnual'
        ));
    }

    private function calcularPorcentaje($hoy, $ayer)
    {
        if ($ayer == 0) {
            return $hoy > 0 ? 100 : 0;
        }
        return (($hoy - $ayer) / $ayer) * 100;
    }

    private function productoMasCompradoDelDia()
    {
        return Producto::select('productos.id', 'productos.nombre', DB::raw('SUM(orden_producto.cantidad) as total_cantidad'))
            ->join('orden_producto', 'productos.id', '=', 'orden_producto.producto_id')
            ->join('ordens', 'orden_producto.orden_id', '=', 'ordens.id')
            ->whereDate('ordens.created_at', Carbon::today())
            ->groupBy('productos.id', 'productos.nombre')
            ->orderBy('total_cantidad', 'desc')
            ->first();
    }

    private function obtenerComprasSemanales()
    {
        // Obtener compras completadas durante la semana actual
        $compras = Orden::select(DB::raw('DAYOFWEEK(created_at) as dia_semana'), DB::raw('SUM(total) as total_compras'))
            ->where('status', 'completed')
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->groupBy(DB::raw('DAYOFWEEK(created_at)'))
            ->get();

        $diasSemana = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
        $comprasSemanales = array_fill(0, 7, 0);

        foreach ($compras as $compra) {
            $comprasSemanales[$compra->dia_semana - 1] = $compra->total_compras;
        }

        // Registrar los datos de compras semanales para depuración
        Log::info('Compras semanales:', ['compras' => $compras, 'comprasSemanales' => $comprasSemanales]);

        return [
            'labels' => $diasSemana,
            'data' => $comprasSemanales
        ];
    }
    private function obtenerVentasPorCategoria()
    {
        $categorias = Categoria::with('productos.ordenes')
            ->get()
            ->map(function ($categoria) {
                $totalVentas = $categoria->productos->reduce(function ($carry, $producto) {
                    return $carry + $producto->ordenes->where('status', 'completed')->sum('total');
                }, 0);

                return [
                    'name' => $categoria->nombre,
                    'y' => (float) $totalVentas
                ];
            })
            ->filter(function ($categoria) {
                return $categoria['y'] > 0;
            })
            ->values();

        return $categorias;
    }
    private function obtenerVentasPorCategoriaAnual()
    {
        $categorias = Categoria::with(['productos.ordenes' => function($query) {
            $query->where('status', 'completed')
                ->whereYear('ordens.created_at', Carbon::now()->year);  // Especifica la tabla para created_at
        }])->get();

        $data = $categorias->map(function ($categoria) {
            $ventasMensuales = $categoria->productos->flatMap(function ($producto) {
                return $producto->ordenes;
            })->groupBy(function ($date) {
                return Carbon::parse($date->created_at)->format('m');
            })->map(function ($month) {
                return $month->sum('total');
            });

            return [
                'name' => $categoria->nombre,
                'data' => $ventasMensuales->map(function ($total, $month) {
                    return [(int)$month, (float)$total];
                })->values()->all()
            ];
        });

        return $data;
    }
}
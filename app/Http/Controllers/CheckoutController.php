<?php

namespace App\Http\Controllers;

use App\Models\BirthdayDiscount;
use App\Models\Carrito;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Producto;
use App\Models\Descuento;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $sessionId = session()->getId();

        // Recuperar los datos del carrito desde la base de datos usando la sesión del usuario
        $carritoItems = Carrito::where('session_id', $sessionId)->get();

        $carritoProductos = [];
        $subtotal = 0;

        foreach ($carritoItems as $item) {
            $producto = Producto::find($item->producto_id);
            if ($producto) {
                $precioFinal = $producto->precio_venta_bruto;

                // Aplicar descuento si existe
                if ($item->descuento_id) {
                    $descuento = Descuento::find($item->descuento_id);
                    if ($descuento) {
                        $precioFinal = $precioFinal - ($precioFinal * ($descuento->porcentaje / 100));
                    }
                }

                $totalItem = $precioFinal * $item->cantidad;
                $subtotal += $totalItem;

                $carritoProductos[] = (object)[
                    'producto_id' => $item->producto_id,
                    'nombre' => $producto->nombre,
                    'cantidad' => $item->cantidad,
                    'precio_final' => $precioFinal,
                    'total' => $totalItem,
                    'descuento' => $item->descuento_id ? true : false,
                    'precio_venta_bruto' => $producto->precio_venta_bruto,
                    'imagen_producto' => $producto->imagen_producto
                ];
            }
        }

        return view('pago.checkout', compact('carritoProductos', 'subtotal'));
    }

    public function processCheckout(Request $request)
    {
        $carritoProductos = json_decode($request->input('carrito'), true);
        $request->session()->put('carritoProductos', $carritoProductos);

        return redirect()->route('checkout.index');
    }

    
    

}

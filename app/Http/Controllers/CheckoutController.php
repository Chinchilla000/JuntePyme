<?php

namespace App\Http\Controllers;

use App\Models\Orden;
use App\Models\Carrito;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Producto;
use App\Models\Descuento;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\DetalleOrden;

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
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'rut' => 'required|string|max:255',
            'telefono' => 'required|string|max:255',
            'correo' => 'nullable|email|max:255',
            'metodo_entrega' => 'required|string|in:retiro,envio',
            'direccion' => 'nullable|string|max:255',
            'ciudad' => 'nullable|string|max:255',
        ]);

        $sessionId = session()->getId();
        $carritoItems = Carrito::where('session_id', $sessionId)->get();

        if ($carritoItems->isEmpty()) {
            return redirect()->route('checkout.index')->withErrors('No hay productos en el carrito.');
        }

        $subtotal = 0;
        foreach ($carritoItems as $item) {
            $producto = Producto::find($item->producto_id);
            if ($producto) {
                $precioFinal = $producto->precio_venta_bruto;

                if ($item->descuento_id) {
                    $descuento = Descuento::find($item->descuento_id);
                    if ($descuento) {
                        $precioFinal = $precioFinal - ($precioFinal * ($descuento->porcentaje / 100));
                    }
                }

                $subtotal += $precioFinal * $item->cantidad;
            }
        }

        $orden = Orden::create([
            'user_id' => Auth::id(),
            'total' => $subtotal,
            'status' => 'pending',
            'session_id' => $sessionId,
        ]);

        DetalleOrden::create([
            'orden_id' => $orden->id,
            'rut' => $validated['rut'],
            'phone' => $validated['telefono'],
            'first_name' => $validated['nombre'],
            'last_name' => $validated['apellido'],
            'email' => $validated['correo'],
            'tipo_retiro' => $validated['metodo_entrega'],
            'direccion' => $validated['direccion'],
            'ciudad' => $validated['ciudad'],
        ]);

        foreach ($carritoItems as $item) {
            $producto = Producto::find($item->producto_id);
            $precioFinal = $producto->precio_venta_bruto;

            if ($item->descuento_id) {
                $descuento = Descuento::find($item->descuento_id);
                if ($descuento) {
                    $precioFinal = $precioFinal - ($precioFinal * ($descuento->porcentaje / 100));
                }
            }

            $orden->productos()->attach($item->producto_id, [
                'cantidad' => $item->cantidad,
                'precio' => $precioFinal,
                'descuento' => $item->descuento_id,
            ]);
        }
// Vaciar el carrito de la sesión
Carrito::where('session_id', $sessionId)->delete();

        $orden->load('detalleOrden'); // Cargar la relación detalleOrden

        return redirect()->route('payment.result', ['order_id' => $orden->id]);
    }

    public function paymentResult($order_id)
    {
        $order = Orden::with('detalleOrden', 'productos')->findOrFail($order_id);
        return view('pago.paymentResult', ['order' => $order]);
    }
}

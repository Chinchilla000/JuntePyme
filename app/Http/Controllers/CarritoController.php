<?php

namespace App\Http\Controllers;

use App\Models\Carrito;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CarritoController extends Controller
{
    public function index()
    {
        $sessionId = session()->getId();
        $carritoProductos = Carrito::where('session_id', $sessionId)
            ->with(['producto', 'producto.descuento'])
            ->get();

        // Calcular el precio final y el subtotal
        $subtotal = 0;
        foreach ($carritoProductos as $item) {
            $producto = $item->producto;
            $producto->precio_final = $producto->precio_venta_bruto;
            if ($producto->descuento) {
                if ($producto->descuento->porcentaje) {
                    $producto->precio_final = $producto->precio_venta_bruto * (1 - $producto->descuento->porcentaje / 100);
                } elseif ($producto->descuento->monto) {
                    $producto->precio_final = $producto->precio_venta_bruto - $producto->descuento->monto;
                }
            }
            $item->total = $producto->precio_final * $item->cantidad;
            $subtotal += $item->total;
        }

        $total = $subtotal; // Eliminamos el envío

        return view('pago.carrito', compact('carritoProductos', 'subtotal', 'total'));
    }
    
    public function agregarAlCarrito(Request $request)
    {
        $producto = Producto::findOrFail($request->input('producto_id'));
        $session_id = Session::getId();
        $cantidad = $request->input('cantidad', 1);

        // Buscar si el producto ya está en el carrito de la sesión actual
        $carrito = Carrito::where('session_id', $session_id)
            ->where('producto_id', $producto->id)
            ->first();

        if ($carrito) {
            // Si el producto ya está en el carrito, actualizar la cantidad
            $carrito->cantidad += $cantidad;
            if ($producto->descuento) {
                $carrito->descuento_id = $producto->descuento->id;
            }
            $carrito->save();
        } else {
            // Si el producto no está en el carrito, agregarlo
            $carrito = new Carrito();
            $carrito->session_id = $session_id;
            $carrito->producto_id = $producto->id;
            $carrito->cantidad = $cantidad;

            if ($producto->descuento) {
                $carrito->descuento_id = $producto->descuento->id;
            }

            $carrito->save();
        }

        return redirect()->back()->with('success', 'Producto agregado al carrito');
    }

    public function agregarAlCarritoAjax(Request $request)
    {
        $producto = Producto::findOrFail($request->input('producto_id'));
        $session_id = Session::getId();
        $cantidad = $request->input('cantidad', 1);

        // Buscar si el producto ya está en el carrito de la sesión actual
        $carrito = Carrito::where('session_id', $session_id)
            ->where('producto_id', $producto->id)
            ->first();

        if ($carrito) {
            // Si el producto ya está en el carrito, actualizar la cantidad
            $carrito->cantidad += $cantidad;
            if ($producto->descuento) {
                $carrito->descuento_id = $producto->descuento->id;
            }
            $carrito->save();
        } else {
            // Si el producto no está en el carrito, agregarlo
            $carrito = new Carrito();
            $carrito->session_id = $session_id;
            $carrito->producto_id = $producto->id;
            $carrito->cantidad = $cantidad;

            if ($producto->descuento) {
                $carrito->descuento_id = $producto->descuento->id;
            }

            $carrito->save();
        }

        return response()->json(['success' => true, 'count' => Carrito::where('session_id', $session_id)->count()]);
    }

    public function eliminar($id)
    {
        $session_id = Session::getId();
        $carrito = Carrito::where('session_id', $session_id)->where('id', $id)->firstOrFail();

        $carrito->delete();

        return redirect()->back()->with('success', 'Producto eliminado del carrito');
    }

    public function actualizarCantidad(Request $request)
    {
        $session_id = Session::getId();
        $carrito = Carrito::where('session_id', $session_id)->where('producto_id', $request->producto_id)->firstOrFail();
        
        $carrito->cantidad = $request->cantidad;
        $carrito->save();

        return response()->json(['success' => true]);
    }


    public function eliminarProducto(Request $request)
    {
        $session_id = Session::getId();
        $carrito = Carrito::where('session_id', $session_id)->where('producto_id', $request->producto_id)->firstOrFail();

        $carrito->delete();

        return response()->json(['success' => true]);
    }

    public function obtenerProductosDelCarrito()
    {
        $sessionId = session()->getId();
        $carritoProductos = Carrito::where('session_id', $sessionId)
            ->with('producto')
            ->get();

        return $carritoProductos;
    }
}

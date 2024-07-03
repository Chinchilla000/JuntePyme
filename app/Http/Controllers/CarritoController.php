<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Descuento;

class CarritoController extends Controller
{
    public function guardarCarrito(Request $request)
    {
        session(['cart' => $request->cart]);
        session(['total' => $request->total]);

        return response()->json(['message' => 'Carrito guardado en la sesión']);
    }

    public function aplicarDescuento(Request $request)
    {
        $codigo = $request->input('codigo');
        $cart = session('cart', []);
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['precio_venta_bruto'] * $item['quantity'];
        }

        if (empty($cart)) {
            session()->forget(['discount_amount', 'discount_code']);
            return response()->json(['message' => 'El carrito está vacío. No se puede aplicar un descuento.', 'total' => 0, 'discountAmount' => 0]);
        }

        $descuento = Descuento::where('codigo_promocional', $codigo)
            ->where('inicio', '<=', now())
            ->where('fin', '>=', now())
            ->first();

        if ($descuento) {
            $discountAmount = 0;
            if ($descuento->porcentaje) {
                $discountAmount = $total * ($descuento->porcentaje / 100);
            } else if ($descuento->monto) {
                $discountAmount = $descuento->monto;
            }

            $total -= $discountAmount;
            $total = max($total, 0);

            session(['discount_amount' => $discountAmount, 'discount_code' => $codigo]);

            return response()->json(['message' => 'Descuento aplicado correctamente', 'total' => $total, 'discountAmount' => $discountAmount]);
        } else {
            return response()->json(['message' => 'Código de descuento inválido o expirado'], 400);
        }
    }

    public function index()
    {
        $cart = session('cart', []);
        $total = session('total', 0);
        $discountAmount = session('discount_amount', 0);
        $user = Auth::user();

        if (empty($cart)) {
            session()->forget(['discount_amount', 'discount_code']);
            $discountAmount = 0;
        }

        $total -= $discountAmount;
        $total = max($total, 0);

        return view('pago.checkout', compact('cart', 'total', 'discountAmount', 'user'));
    }

    public function finalizarCompra(Request $request)
    {
        // Lógica para finalizar la compra
        
        session()->forget(['cart', 'discount_amount', 'discount_code']);

        return response()->json(['message' => 'Compra finalizada correctamente']);
    }

    public function vaciarCarrito()
    {
        session()->forget(['cart', 'discount_amount', 'discount_code']);
        return response()->json(['message' => 'Carrito vaciado correctamente']);
    }
    public function cargarCarrito()
    {
        try {
            // Suponiendo que los datos del carrito están almacenados en la sesión
            $cart = session('cart', []);
            return response()->json(['cart' => $cart]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
}

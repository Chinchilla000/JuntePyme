<?php

namespace App\Http\Controllers;

use App\Models\BirthdayDiscount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Producto;
use App\Models\Descuento;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        $user = Auth::user();
        $mascotaDeCumpleanos = null;
        $birthdayDiscountUsed = false;

        if ($user) {
            // Verificar si el usuario tiene una mascota de cumpleaños hoy
            $mascotaDeCumpleanos = $user->mascotas()->whereDate('fecha_cumpleanos', today())->first();
            if ($mascotaDeCumpleanos) {
                $birthdayDiscountUsed = BirthdayDiscount::where('user_id', $user->id)
                    ->where('fecha_uso', today())
                    ->exists();

                if (!$birthdayDiscountUsed) {
                    // Aplicar descuento del 10%
                    session()->put('discount_code', 'BIRTHDAY');
                    session()->put('discount_amount', 10); // 10%
                    session()->put('discount_type', 'porcentaje');

                    // Guardar el uso del descuento de cumpleaños
                    BirthdayDiscount::create([
                        'user_id' => $user->id,
                        'mascota_id' => $mascotaDeCumpleanos->id,
                        'fecha_uso' => today()
                    ]);
                }
            }
        }

        $total = $this->calculateTotal($cart);

        return view('pago.checkout', compact('cart', 'total', 'mascotaDeCumpleanos', 'birthdayDiscountUsed'));
    }

    public function recalculate(Request $request)
    {
        $cart = $request->input('cart', []);
        $total = $this->calculateTotal($cart);

        return response()->json([
            'success' => true,
            'total' => $total
        ]);
    }

    private function calculateTotal($cart)
    {
        $total = 0;
        $discountAmount = session('discount_amount', 0);
        $discountType = session('discount_type', null);

        foreach ($cart as $item) {
            $product = Producto::find($item['id']);
            if ($product) {
                $price = $product->precio_venta_bruto;

                // Aplicar descuentos específicos del producto si existen y son válidos
                if ($product->descuento) {
                    $now = now();
                    if ($product->descuento->inicio <= $now && $product->descuento->fin >= $now) {
                        if ($product->descuento->porcentaje) {
                            $price = $price * (1 - $product->descuento->porcentaje / 100);
                        } elseif ($product->descuento->monto) {
                            $price = $price - $product->descuento->monto;
                        }
                    }
                }

                $price = floor($price); // Asegurarse de que el precio no tenga decimales
                $total += $price * $item['quantity'];
            }
        }

        // Aplicar el descuento global si existe
        if ($discountType === 'porcentaje') {
            $total = $total * (1 - $discountAmount / 100);
        } elseif ($discountType === 'monto') {
            $total = $total - $discountAmount;
        }

        return $total;
    }

    public function create(Request $request)
    {
        $cart = session()->get('cart', []);
        $total = $this->calculateTotal($cart);

        // Convertir ambos valores a enteros antes de comparar
        $totalServidor = (int) $total;
        $totalCliente = (int) $request->total;

        // Log para comparar totales
        Log::info('Total calculado en el servidor:', ['total' => $totalServidor]);
        Log::info('Total enviado desde el cliente:', ['total' => $totalCliente]);

        // Verificar si el total enviado por el formulario coincide con el calculado en el servidor
        if ($totalServidor !== $totalCliente) {
            Log::error('El total del pedido ha sido modificado.', ['total_servidor' => $totalServidor, 'total_cliente' => $totalCliente]);
            return back()->with('error', 'El total del pedido ha sido modificado. Por favor, revisa tu carrito e inténtalo de nuevo.');
        }

        // Redirigir al controlador de pagos con los datos necesarios
        return redirect()->route('payment.create', [
            'total' => $total,
            'firstName' => $request->input('firstName'),
            'lastName' => $request->input('lastName'),
            'email' => $request->input('email'),
            'rut' => $request->input('rut'),
            'phone' => $request->input('phone'),
            'deliveryMethod' => $request->input('deliveryMethod'),
            'deliveryDetails' => json_encode($request->input('deliveryDetails')),
            'receiverName' => $request->input('receiverName'),
            'receiverRut' => $request->input('receiverRut'),
            'pickupStore' => $request->input('pickupStore')
        ]);
    }

    public function applyDiscount(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Debes iniciar sesión para aplicar un código de descuento.']);
        }

        Log::info('Usuario autenticado:', ['user_id' => $user->id]);

        try {
            $discountCode = $request->input('discountCode');
            Log::info('Código de descuento recibido antes de codificación:', ['discountCode' => $discountCode]);

            // Verificar si se ingresó un código de descuento
            if (empty($discountCode)) {
                return response()->json(['success' => false, 'message' => 'Por favor, introduce un código de descuento.']);
            }

            // Codificar el código de descuento
            $discountCode = mb_convert_encoding($discountCode, 'UTF-8', 'UTF-8');
            Log::info('Código de descuento después de codificación:', ['discountCode' => $discountCode]);

            $descuento = Descuento::where('codigo_promocional', $discountCode)->first();
            Log::info('Descuento encontrado:', ['descuento' => $descuento]);

            // Código de descuento promocional
            if ($descuento && $descuento->inicio <= now() && $descuento->fin >= now()) {
                Log::info('Descuento válido encontrado:', ['descuento_id' => $descuento->id]);

                // Verificar si el usuario ha usado este código de descuento antes
                if ($user->usedDiscounts()->where('descuento_id', $descuento->id)->exists()) {
                    Log::info('Descuento promocional ya utilizado');
                    return response()->json(['success' => false, 'message' => 'Ya has utilizado este código de descuento.']);
                }

                session()->put('discount_code', $discountCode);
                session()->put('discount_amount', $descuento->porcentaje ? $descuento->porcentaje : $descuento->monto);
                session()->put('discount_type', $descuento->porcentaje ? 'porcentaje' : 'monto');

                Log::info('Descuento promocional aplicado');

                // Recalcular el total después de aplicar el descuento
                $cart = session('cart', []);
                $total = $this->calculateTotal($cart);

                $response = [
                    'success' => true,
                    'message' => 'Descuento aplicado exitosamente',
                    'total' => $total
                ];

                // Convertir todos los valores a UTF-8
                array_walk_recursive($response, function(&$item, $key) {
                    if (is_string($item)) {
                        $item = mb_convert_encoding($item, 'UTF-8', 'UTF-8');
                    }
                });

                Log::info('Respuesta JSON antes de codificación:', ['response' => $response]);

                return response()->json($response, 200, [], JSON_UNESCAPED_UNICODE);
            }

            Log::info('Código de descuento no válido o expirado');
            return response()->json(['success' => false, 'message' => 'El código de descuento no es válido o ha expirado']);
        } catch (\Exception $e) {
            Log::error('Error en applyDiscount', ['exception' => $e]);
            return response()->json(['success' => false, 'message' => 'Ocurrió un error al aplicar el descuento. Por favor, inténtalo de nuevo.']);
        }
    }

    public function applyBirthdayDiscount(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Debes iniciar sesión para aplicar un descuento de cumpleaños.']);
        }

        Log::info('Usuario autenticado para descuento de cumpleaños:', ['user_id' => $user->id]);

        $mascotaDeCumpleanos = $user->mascotas()->whereDate('fecha_cumpleanos', today())->first();
        Log::info('Mascota de cumpleaños:', ['mascotaDeCumpleanos' => $mascotaDeCumpleanos]);

        if ($mascotaDeCumpleanos) {
            $birthdayDiscountUsed = BirthdayDiscount::where('user_id', $user->id)
                ->where('fecha_uso', Carbon::today()->toDateString())
                ->exists();
            Log::info('Descuento de cumpleaños usado:', ['birthdayDiscountUsed' => $birthdayDiscountUsed]);

            if ($birthdayDiscountUsed) {
                Log::info('Descuento de cumpleaños ya utilizado hoy');
                return response()->json(['success' => false, 'message' => 'Ya has utilizado tu descuento de cumpleaños hoy.']);
            }

            // Aplicar descuento del 10%
            session()->put('discount_code', 'BIRTHDAY');
            session()->put('discount_amount', 10); // 10%
            session()->put('discount_type', 'porcentaje');

            // Guardar la información del descuento de cumpleaños en la sesión para su uso posterior
            session()->put('birthday_discount_applied', [
                'user_id' => utf8_encode($user->id),
                'mascota_id' => utf8_encode($mascotaDeCumpleanos->id)
            ]);
            Log::info('Descuento de cumpleaños preparado para aplicar');

            // Recalcular el total después de aplicar el descuento
            $cart = session('cart', []);
            $total = $this->calculateTotal($cart);

            return response()->json(['success' => true, 'message' => 'Descuento de cumpleaños aplicado exitosamente', 'total' => utf8_encode($total)]);
        }

        return response()->json(['success' => false, 'message' => 'No hay mascotas de cumpleaños hoy.']);
    }
}

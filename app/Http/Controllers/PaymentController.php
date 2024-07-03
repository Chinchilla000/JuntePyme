<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Facades\GetNet;
use App\Mail\OrderDetailsMail;
use App\Models\BirthdayDiscount;
use App\Models\Descuento;
use App\Models\DetalleOrden;
use App\Models\Orden;
use App\Models\PaymentNotification;
use App\Models\Producto;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use Exception;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    private function generateAuth()
    {
        $login = config('services.getnet.login');
        $secretKey = config('services.getnet.secret_key');
        $nonce = bin2hex(random_bytes(16)); // Valor aleatorio para cada solicitud
        $seed = now()->toIso8601String(); // Fecha actual en formato ISO 8601
        $tranKey = base64_encode(hash('sha256', $nonce . $seed . $secretKey, true)); // Clave transaccional en Base64
    
        Log::info('Generated Auth Data', [
            'login' => $login,
            'tranKey' => $tranKey,
            'nonce' => base64_encode($nonce),
            'seed' => $seed,
        ]);
    
        return [
            'login' => $login,
            'tranKey' => $tranKey,
            'nonce' => base64_encode($nonce), // El nonce debe estar codificado en Base64
            'seed' => $seed,
        ];
    }
    private function descontarCantidadProductos($order)
{
    foreach ($order->productos as $producto) {
        $producto->cantidad_disponible -= $producto->pivot->cantidad;
        $producto->save();
    }
}


    public function createTransaction(Request $request)
    {
        $placetopay = GetNet::getFacadeRoot();

        // Obtención de datos del formulario
        $totalAmount = $request->input('total', 0);
        $buyerName = $request->input('firstName', 'Test');
        $buyerSurname = $request->input('lastName', 'Test');
        $buyerEmail = $request->input('email', 'test@test.com');
        $buyerDocument = $request->input('rut', '11111111-9');
        $buyerMobile = $request->input('phone', '3006108300');

        // Log de los datos recibidos del formulario
        Log::info('Datos del comprador recibidos del formulario:', [
            'firstName' => $buyerName,
            'lastName' => $buyerSurname,
            'email' => $buyerEmail,
            'rut' => $buyerDocument,
            'phone' => $buyerMobile
        ]);

        // Crear referencia de la orden
        $orderReference = uniqid('Order_');

        // Log de la solicitud de pago
        Log::info('Datos de la solicitud de pago:', [
            'locale' => 'es_CL',
            'buyer' => [
                'name' => $buyerName,
                'surname' => $buyerSurname,
                'email' => $buyerEmail,
                'document' => $buyerDocument,
                'documentType' => 'CLRUT',
                'mobile' => $buyerMobile,
            ],
            'payment' => [
                'reference' => $orderReference,
                'description' => 'Pago de prueba',
                'amount' => [
                    'currency' => 'CLP',
                    'total' => $totalAmount,
                ],
            ],
            'expiration' => now()->addMinutes(15)->toIso8601String(),
            'ipAddress' => $request->ip(),
            'returnUrl' => route('payment.result', ['orderId' => $orderReference]),
            'callbackUrl' => route('payment.notification'),
            'userAgent' => $request->header('User-Agent'),
        ]);

        // Realizar la solicitud de pago
        $response = $placetopay->request([
            'locale' => 'es_CL',
            'buyer' => [
                'name' => $buyerName,
                'surname' => $buyerSurname,
                'email' => $buyerEmail,
                'document' => $buyerDocument,
                'documentType' => 'CLRUT',
                'mobile' => $buyerMobile,
            ],
            'payment' => [
                'reference' => $orderReference,
                'description' => 'Pago de prueba',
                'amount' => [
                    'currency' => 'CLP',
                    'total' => $totalAmount,
                ],
            ],
            'expiration' => now()->addMinutes(15)->toIso8601String(),
            'ipAddress' => $request->ip(),
            'returnUrl' => route('payment.result', ['orderId' => $orderReference]),
            'callbackUrl' => route('payment.notification'),
            'userAgent' => $request->header('User-Agent'),
        ]);

        // Log de la respuesta de PlaceToPay
        Log::info('Respuesta de PlaceToPay:', ['response' => $response]);

        if ($response->isSuccessful()) {
            $userId = Auth::id() ?? null; // Verificar si el usuario está autenticado y asignar null si no lo está.
            $discountCode = session('discount_code', null);
            $order = Orden::create([
                'user_id' => $userId,
                'total' => $totalAmount,
                'status' => 'pending',
                'reference' => $orderReference,
                'session_id' => $response->requestId(),
                'discount_code' => $discountCode
            ]);

            // Log de la orden creada
            Log::info('Orden creada:', ['order' => $order]);

            // Almacenar el ID de la orden en la sesión
            session()->put('order_id', $order->id);

            $cart = session('cart', []);
            foreach ($cart as $item) {
                $producto = Producto::with('descuento')->find($item['id']);
                $descuento = 0;

                if ($producto && $producto->descuento) {
                    Log::info('Producto encontrado con descuento:', ['producto_id' => $producto->id, 'descuento' => $producto->descuento]);

                    if (!is_null($producto->descuento->porcentaje)) {
                        $descuento = $producto->precio_venta_bruto * ($producto->descuento->porcentaje / 100);
                    } elseif (!is_null($producto->descuento->monto)) {
                        $descuento = $producto->descuento->monto;
                    }

                    Log::info('Descuento calculado:', ['descuento' => $descuento]);
                } else {
                    Log::warning('Producto sin descuento o no encontrado:', ['producto_id' => $item['id']]);
                }

                $order->productos()->attach($item['id'], [
                    'cantidad' => $item['quantity'],
                    'precio' => $item['precio_venta_bruto'],
                    'descuento' => $descuento
                ]);

                Log::info('Producto añadido a la orden:', ['producto_id' => $item['id'], 'cantidad' => $item['quantity'], 'precio' => $item['precio_venta_bruto'], 'descuento' => $descuento]);
            }

            $deliveryMethod = $request->input('deliveryMethod');
            $deliveryDetails = json_decode($request->input('deliveryDetails'), true);
            $receiverName = $request->input('receiverName');
            $receiverRut = $request->input('receiverRut');
            $pickupStore = $request->input('pickupStore');

            // Log de los detalles del pedido
            Log::info('Datos del método de entrega y detalles del pedido:', [
                'deliveryMethod' => $deliveryMethod,
                'deliveryDetails' => $deliveryDetails,
                'receiverName' => $receiverName,
                'receiverRut' => $receiverRut,
                'pickupStore' => $pickupStore,
            ]);

            // Crear el detalle de la orden
            DetalleOrden::create([
                'orden_id' => $order->id,
                'rut' => $buyerDocument,
                'phone' => $buyerMobile,
                'first_name' => $buyerName,
                'last_name' => $buyerSurname,
                'email' => $buyerEmail,
                'tipo_retiro' => $deliveryMethod,
                'pais' => $deliveryDetails['pais'] ?? null,
                'direccion' => $deliveryDetails['direccion'] ?? null,
                'casa_apartamento' => $deliveryDetails['casa_apartamento'] ?? null,
                'comuna' => $deliveryDetails['comuna'] ?? null,
                'region' => $deliveryDetails['region'] ?? null,
                'sucursal_retiro' => $pickupStore,
                'nombre_receptor' => $receiverName,
                'rut_receptor' => $receiverRut,
                'listo_para_retiro' => false, // o true dependiendo de tu lógica
                'retirado' => false,
                'numero_seguimiento' => '', // Puedes llenarlo más tarde si tienes este dato
                'proveedor' => '' // Puedes llenarlo más tarde si tienes este dato
            ]);

            // Log de la creación del detalle de la orden
            Log::info('Detalle de la orden creado:', [
                'orden_id' => $order->id,
                'rut' => $buyerDocument,
                'phone' => $buyerMobile,
                'first_name' => $buyerName,
                'last_name' => $buyerSurname,
                'email' => $buyerEmail,
            ]);

            session()->put('birthday_discount_applied', session('birthday_discount_applied', null));

            return redirect($response->processUrl());
        }

        return redirect()->back()->withErrors(['error' => 'No se pudo procesar la transacción.']);
    }

    public function handlePaymentNotification(Request $request)
{
    Log::info('Notification received', $request->all());

    $requestId = $request->input('requestId');
    $status = $request->input('status.status');
    $message = $request->input('status.message');
    $date = $request->input('status.date');
    $signature = $request->input('signature');

    Log::info('Notification details', [
        'requestId' => $requestId,
        'status' => $status,
        'message' => $message,
        'date' => $date,
        'signature' => $signature,
    ]);

    $order = Orden::where('session_id', $requestId)->first();

    if (!$order) {
        Log::error('Order not found for requestId: ' . $requestId);
        return response()->json(['error' => 'Order not found'], 404);
    }

    Log::info('Order found', ['order_id' => $order->id]);

    $computedSignature = sha1($requestId . $status . $date . config('services.getnet.secret_key'));
    Log::info('Computed signature', ['computedSignature' => $computedSignature]);

    if ($computedSignature !== $signature) {
        Log::error('Invalid signature for requestId: ' . $requestId);
        return response()->json(['error' => 'Invalid signature'], 403);
    }

    PaymentNotification::create([
        'status' => $status,
        'message' => $message,
        'reason' => $request->input('status.reason'),
        'date' => $date,
        'request_id' => $requestId,
        'reference' => $order->reference,
        'signature' => $signature,
        'orden_id' => $order->id
    ]);

    if ($status === 'APPROVED') {
        $order->update(['status' => 'completed']);
        $this->descontarCantidadProductos($order); // Llamar al método para descontar la cantidad de productos
        Log::info('Order completed and stock updated', ['order_id' => $order->id]);

        $this->sendOrderDetailsMail($order); // Enviar correo de detalles de la orden

        $user = $order->user;
        if ($user) {
            Log::info('User authenticated', ['user_id' => $user->id]);
            if ($order->discount_code) {
                $descuento = Descuento::where('codigo_promocional', $order->discount_code)->first();
                Log::info('Descuento encontrado', ['descuento' => $descuento]);
                if ($descuento && !$user->usedDiscounts()->where('descuento_id', $descuento->id)->exists()) {
                    $user->usedDiscounts()->attach($descuento->id, ['orden_id' => $order->id]);
                    Log::info('Discount registered for user', ['user_id' => $user->id, 'descuento_id' => $descuento->id, 'orden_id' => $order->id]);
                } else {
                    Log::info('Discount already used or not found', ['user_id' => $user->id, 'descuento_id' => $descuento->id]);
                }
            } else {
                Log::info('No discount code found for the order', ['order_id' => $order->id]);
            }
        } else {
            Log::info('No user associated with the order', ['order_id' => $order->id]);
        }

        // Aplicar y registrar el descuento de cumpleaños si existe en la sesión
        if (session()->has('birthday_discount_applied')) {
            $birthdayDiscount = session('birthday_discount_applied');
            BirthdayDiscount::create([
                'user_id' => $birthdayDiscount['user_id'],
                'mascota_id' => $birthdayDiscount['mascota_id'],
                'fecha_uso' => $order->created_at->toDateString(),
                'orden_id' => $order->id,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            Log::info('Birthday discount applied and registered', ['order_id' => $order->id, 'birthday_discount' => $birthdayDiscount]);
        }

        session()->forget(['discount_code', 'discount_amount', 'discount_type', 'birthday_discount_applied']);
        session()->forget('cart');

        return response()->json(['status' => 'success']);
    } elseif ($status === 'REJECTED') {
        $order->update(['status' => 'rejected']);
        Log::info('Order rejected', ['order_id' => $order->id]);

        return response()->json(['status' => 'rejected']);
    }

    return response()->json(['status' => 'pending']);
}


public function handlePaymentResult(Request $request)
{
    $client = new Client();
    $data = $request->all();

    Log::info('Solicitud de pago recibida:', ['data' => $data]);

    $orderReference = $request->query('orderId', $data['reference'] ?? null);
    Log::info('Referencia de la orden:', ['orderReference' => $orderReference]);

    $order = Orden::where('reference', $orderReference)->first();
    if (!$order) {
        Log::error('Orden no encontrada para la referencia:', ['reference' => $orderReference]);
        return response()->json(['message' => 'Orden no encontrada'], 404);
    }

    $sessionId = $order->session_id ?? null;

    $auth = $this->generateAuth();

    if (isset($data['status'])) {
        Log::info('Notificación de pago recibida:', $data);

        try {
            $notification = PaymentNotification::create([
                'status' => $data['status']['status'],
                'message' => $data['status']['message'],
                'reason' => $data['status']['reason'],
                'date' => $data['status']['date'],
                'request_id' => $data['requestId'],
                'reference' => $data['reference'],
                'signature' => $data['signature'],
                'orden_id' => $order->id
            ]);

            Log::info('Notificación guardada correctamente en la base de datos:', $notification->toArray());

            switch ($data['status']['status']) {
                case 'APPROVED':
                    if ($order->status !== 'completed') {
                        $order->update(['status' => 'completed']);
                        $this->descontarCantidadProductos($order); // Descontar la cantidad de productos
                        $this->sendOrderDetailsMail($order); // Enviar correo de detalles de la orden
                    }

                    // (Resto de tu lógica para manejar descuentos, etc.)

                    return view('pago.paymentResult', compact('order'));
                case 'REJECTED':
                    if ($order->status !== 'rejected') {
                        $order->update(['status' => 'rejected']);
                    }
                    break;
                default:
                    if ($order->status !== 'pending') {
                        $order->update(['status' => 'pending']);
                    }
                    break;
            }

            return view('pago.paymentResult', compact('order'));
        } catch (Exception $e) {
            Log::error('Error al procesar la notificación de pago:', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Error al procesar la notificación'], 500);
        }
    } elseif ($sessionId) {
        try {
            $baseUrl = config('services.getnet.base_url');
            $url = $baseUrl . '/api/session/' . $sessionId;
            Log::info('URL for GetNet API request: ' . $url);

            $response = $client->post($url, [
                'json' => [
                    'auth' => $auth,
                ]
            ]);

            $responseBody = json_decode($response->getBody(), true);
            Log::info('Respuesta del API de GetNet:', ['responseBody' => $responseBody]);

            if (isset($responseBody['status']['status'])) {
                switch ($responseBody['status']['status']) {
                    case 'APPROVED':
                        if ($order->status !== 'completed') {
                            $order->update(['status' => 'completed']);
                            $this->descontarCantidadProductos($order); // Descontar la cantidad de productos
                            $this->sendOrderDetailsMail($order); // Enviar correo de detalles de la orden
                        }

                        // (Resto de tu lógica para manejar descuentos, etc.)

                        return view('pago.paymentResult', compact('order'));
                    case 'REJECTED':
                        if ($order->status !== 'rejected') {
                            $order->update(['status' => 'rejected']);
                        }
                        break;
                    default:
                        if ($order->status !== 'pending') {
                            $order->update(['status' => 'pending']);
                        }
                        break;
                }

                PaymentNotification::create([
                    'status' => $responseBody['status']['status'],
                    'message' => $responseBody['status']['message'],
                    'reason' => $responseBody['status']['reason'],
                    'date' => $responseBody['status']['date'],
                    'request_id' => $responseBody['requestId'],
                    'reference' => $orderReference,
                    'signature' => '',
                    'orden_id' => $order->id
                ]);

                return view('pago.paymentResult', compact('order'));
            } else {
                Log::error('Estado de respuesta no válido:', ['response' => $responseBody]);
                return view('pago.paymentResult', ['order' => $order, 'error' => 'Estado de respuesta no válido']);
            }
        } catch (Exception $e) {
            Log::error('Error al obtener la información del pago:', ['error' => $e->getMessage()]);
            $error = 'No se pudo obtener la información del pago.';
            return view('pago.paymentResult', compact('order', 'error'));
        }
    } else {
        Log::error('Datos incompletos o no válidos');
        return response()->json(['message' => 'Datos incompletos o no válidos'], 400);
    }
}



    public function orderConfirmation($orderId)
    {
        $order = Orden::where('reference', $orderId)->firstOrFail();
        // Obtener los descuentos de cumpleaños usados en esta orden
        $birthdayDiscounts = BirthdayDiscount::where('user_id', $order->user_id)
            ->where('orden_id', $order->id)
            ->get();
    
        return view('pago.paymentResult', compact('order', 'birthdayDiscounts'));
    }
    
    public function orderFailed($orderId)
    {
        $order = Orden::where('reference', $orderId)->firstOrFail();
        // Obtener los descuentos de cumpleaños usados en esta orden
        $birthdayDiscounts = BirthdayDiscount::where('user_id', $order->user_id)
            ->where('orden_id', $order->id)
            ->get();
    
        return view('pago.paymentResult', compact('order', 'birthdayDiscounts'));
    }


    public function testCallback(Request $request)
    {
        return response()->json(['received' => $request->all()]);
    }

    private function sendOrderDetailsMail($order)
    {
        try {
            if ($order->user && $order->user->email) {
                Mail::to($order->user->email)->send(new OrderDetailsMail($order));
                Log::info('Correo de detalles de la orden enviado con éxito.');
            } else if ($order->detallesOrden && $order->detallesOrden->email) {
                Mail::to($order->detallesOrden->email)->send(new OrderDetailsMail($order));
                Log::info('Correo de detalles de la orden enviado con éxito a invitado.');
            }
        } catch (\Exception $e) {
            Log::error('Error al enviar correo de detalles de la orden: ' . $e->getMessage());
        }
    }
}

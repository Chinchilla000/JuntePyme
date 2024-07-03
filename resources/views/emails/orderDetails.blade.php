<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Full Bigotes | La Mejor Tienda de Accesorios para tus Mascotas en Chiloé</title>
    
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/gallery/iconof.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/gallery/iconof.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/gallery/iconof.png') }}">

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            background-color: #ffffff;
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: left;
        }
        .logo {
            display: block;
            margin: 0 auto 20px;
            text-align: center;
        }
        .logo img {
            width: 100px;
            height: auto;
        }
        h1 {
            color: #333;
            text-align: center;
        }
        h2, h3 {
            color: #333;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            margin-bottom: 10px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
            text-align: center;
        }
        .alert-success {
            background-color: #dff0d8;
            border-color: #d6e9c6;
            color: #3c763d;
        }
        .alert-danger {
            background-color: #f2dede;
            border-color: #ebccd1;
            color: #a94442;
        }
        .alert-warning {
            background-color: #fcf8e3;
            border-color: #faebcc;
            color: #8a6d3b;
        }
        footer {
            text-align: center;
            font-size: 0.8em;
            color: #777;
            margin-top: 20px;
        }
        .section-title {
            margin-top: 20px;
            font-size: 1.2em;
            border-bottom: 2px solid #ddd;
            padding-bottom: 5px;
        }
        .section-content {
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="{{ asset('assets/img/gallery/iconof.png') }}" alt="FullBigotes Logo">
        </div>
        <h1>Resultado de la Transacción</h1>
        <div class="alert {{ $order->status == 'completed' ? 'alert-success' : ($order->status == 'rejected' ? 'alert-danger' : 'alert-warning') }}">
            <h2>{{ $order->status == 'completed' ? '¡Pago aprobado!' : ($order->status == 'rejected' ? 'Pago rechazado' : 'Pago pendiente') }}</h2>
            <p>Gracias por tu compra. Aquí están los detalles de tu orden:</p>
        </div>
        @php
            $totalConDescuento = 0;
            foreach ($order->productos as $producto) {
                $descuento = $producto->pivot->descuento ?? 0;
                $precioConDescuento = $producto->pivot->precio - $descuento;
                $totalConDescuento += $precioConDescuento * $producto->pivot->cantidad;
            }
        @endphp
        <div class="section-content">
            <ul>
                <li><strong>ID de Orden:</strong> {{ $order->reference }}</li>
                <li><strong>Total (con descuentos):</strong> ${{ number_format($totalConDescuento, 0) }}</li>
                <li><strong>Estado:</strong> {{ $order->status == 'completed' ? 'Completa' : ($order->status == 'rejected' ? 'Rechazada' : 'Pendiente') }}</li>
            </ul>
        </div>
        <div class="section-title">Detalles del Comprador:</div>
        <div class="section-content">
            <ul>
                <li><strong>Nombre:</strong> {{ $order->detallesOrden->first_name }} {{ $order->detallesOrden->last_name }}</li>
                <li><strong>Email:</strong> {{ $order->detallesOrden->email }}</li>
                <li><strong>Teléfono:</strong> {{ $order->detallesOrden->phone ?? 'N/A' }}</li>
            </ul>
        </div>
        <div class="section-title">Detalles del Pedido:</div>
        <div class="section-content">
            <ul>
                @if($order->detallesOrden->tipo_retiro == 'domicilio')
                    <li><strong>Tipo de Retiro:</strong> Domicilio</li>
                    <li><strong>País:</strong> {{ $order->detallesOrden->pais ?? 'vacío' }}</li>
                    <li><strong>Dirección:</strong> {{ $order->detallesOrden->direccion ?? 'vacío' }}</li>
                    <li><strong>Casa/Apartamento:</strong> {{ $order->detallesOrden->casa_apartamento ?? 'vacío' }}</li>
                    <li><strong>Comuna:</strong> {{ $order->detallesOrden->comuna ?? 'vacío' }}</li>
                    <li><strong>Región:</strong> {{ $order->detallesOrden->region ?? 'vacío' }}</li>
                @elseif($order->detallesOrden->tipo_retiro == 'retiro')
                    <li><strong>Tipo de Retiro:</strong> Retiro</li>
                    <li><strong>Sucursal de Retiro:</strong> {{ $order->detallesOrden->sucursal_retiro ?? 'vacío' }}</li>
                    <li><strong>Nombre del Receptor:</strong> {{ $order->detallesOrden->nombre_receptor ?? 'vacío' }}</li>
                    <li><strong>RUT del Receptor:</strong> {{ $order->detallesOrden->rut_receptor ?? 'vacío' }}</li>
                @endif
            </ul>
        </div>
        <div class="section-title">Productos:</div>
        <div class="section-content">
            <ul>
                @foreach($order->productos as $producto)
                    @php
                        $precioFinal = $producto->pivot->precio - ($producto->pivot->descuento ?? 0);
                    @endphp
                    <li>{{ $producto->pivot->cantidad }} x {{ $producto->nombre }} - ${{ number_format($precioFinal, 0) }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    <footer>
        <p>Gracias por elegirnos. ¡Esperamos verte pronto!</p>
        <p>Atentamente,<br>El equipo de FullBigotes.cl</p>
    </footer>
</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pedido Listo para Retirar</title>
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
        }
        .logo {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo img {
            width: 100px;
            height: auto;
        }
        h1, h2 {
            color: #333;
            text-align: center;
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
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="{{ asset('images/logoelmartillo.png') }}" alt="El Martillo Logo">
        </div>
        <h1>Pedido Listo para Retirar</h1>
        <p>Estimado {{ $order->detalleOrden->first_name }},</p>
        <p>Nos complace informarte que tu pedido con ID <strong>{{ $order->id }}</strong> está listo para retirar en nuestra sucursal de Dalcahue.</p>

        <div class="section-title">Detalles del Pedido:</div>
        <ul>
            <li><strong>ID de Orden:</strong> {{ $order->id }}</li>
            <li><strong>Total:</strong> ${{ number_format($order->total, 0, ',', '.') }}</li>
        </ul>

        <div class="section-title">Productos:</div>
        <ul>
            @foreach ($order->productos as $producto)
            <li>{{ $producto->nombre }} - Cantidad: {{ $producto->pivot->cantidad }}</li>
            @endforeach
        </ul>

        <p>Te esperamos en la sucursal de Dalcahue.</p>

        <p>Saludos,</p>
        <p>El equipo de Ferreteria El Martillo</p>
    </div>
</body>
</html>

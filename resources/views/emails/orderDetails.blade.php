<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalles de tu Orden</title>
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
        .section-title {
            margin-top: 20px;
            font-size: 1.2em;
            border-bottom: 2px solid #ddd;
            padding-bottom: 5px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .table th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="{{ asset('images/logoelmartillo.png') }}" alt="El Martillo Logo">
                </div>
        <h1>Detalles de tu Orden</h1>
        <p>Gracias por tu compra. Aquí están los detalles de tu orden:</p>

        <div class="section-content">
            <ul>
                <li><strong>ID de Orden:</strong> {{ $order->id }}</li>
                <li><strong>Total (con descuentos):</strong> ${{ number_format($totalConDescuento, 0) }}</li>
                <li><strong>Estado:</strong> {{ $order->status == 'completed' ? 'Completa' : ($order->status == 'rejected' ? 'Rechazada' : 'Pendiente') }}</li>
            </ul>
        </div>
        <div class="section-title">Detalles del Comprador:</div>
        <div class="section-content">
            <ul>
                <li><strong>Nombre:</strong> {{ $order->detalleOrden->first_name }} {{ $order->detalleOrden->last_name }}</li>
                <li><strong>Email:</strong> {{ $order->detalleOrden->email }}</li>
                <li><strong>Teléfono:</strong> {{ $order->detalleOrden->phone ?? 'N/A' }}</li>
            </ul>
        </div>
        <div class="section-title">Detalles del Pedido:</div>
        <div class="section-content">
            <ul>
                @if($order->detalleOrden->tipo_retiro == 'envio')
                    <li><strong>Tipo de Retiro:</strong> Envío</li>
                    <li><strong>Dirección:</strong> {{ $order->detalleOrden->direccion ?? 'N/A' }}</li>
                    <li><strong>Ciudad:</strong> {{ $order->detalleOrden->ciudad ?? 'N/A' }}</li>
                @else
                    <li><strong>Tipo de Retiro:</strong> Retiro en Sucursal</li>
                @endif
            </ul>
        </div>
        <div class="section-title">Productos:</div>
        <div class="section-content">
            <table class="table">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Descuento</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->productos as $producto)
                    @php
                        $precioFinal = $producto->pivot->precio - ($producto->pivot->descuento ?? 0);
                    @endphp
                    <tr>
                        <td>{{ $producto->nombre }}</td>
                        <td>{{ $producto->pivot->cantidad }}</td>
                        <td>${{ number_format($precioFinal * $producto->pivot->cantidad, 0, ',', '.') }}</td>
                        <td>${{ number_format($producto->pivot->descuento * $producto->pivot->cantidad, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="section-title">Total Compra</div>
        <div class="section-content">
            <ul>
                <li><strong>Total:</strong> ${{ number_format($order->total, 0, ',', '.') }}</li>
            </ul>
        </div>
    </div>
</body>
</html>

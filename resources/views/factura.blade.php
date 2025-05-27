<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura #{{ $order->id }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 14px; }
        .header { text-align: center; margin-bottom: 30px; }
        .datos { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background: #f4f4f4; }
        .total { text-align: right; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Bodyquick</h2>
        <h4>Factura #{{ $order->id }}</h4>
    </div>
    <div class="datos">
        <strong>Cliente:</strong> {{ $user->name }}<br>
        <strong>Email:</strong> {{ $user->email }}<br>
        <strong>Fecha:</strong> {{ $order->created_at->format('d/m/Y H:i') }}
    </div>
    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Precio unitario</th>
                <th>Cantidad</th>
                <th>IVA</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>{{ $item->nombre }}</td>
                <td>{{ number_format($item->precio_unitario, 2) }} €</td>
                <td>{{ $item->cantidad }}</td>
                <td>{{ $item->iva }} %</td>
                <td>{{ number_format($item->subtotal, 2) }} €</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="total">
        Total: {{ number_format($order->total, 2) }} €
    </div>
</body>
</html>

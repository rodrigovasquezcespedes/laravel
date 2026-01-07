<html>
<body>
    <h1>Factura #{{ $order->id }}</h1>
    <p>Cliente: {{ $order->user->name ?? 'N/A' }}</p>
    <p>Monto: ${{ $order->amount }}</p>
    <p>Fecha: {{ $order->created_at }}</p>
    <p>Estado: {{ $order->status }}</p>
</body>
</html>

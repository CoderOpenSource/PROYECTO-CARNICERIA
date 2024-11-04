<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura #{{ $factura->id }}</title>
    <style>
        /* Estilos básicos para el PDF */
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #333;
        }
        .container {
            width: 90%;
            margin: auto;
        }
        .header, .footer {
            text-align: center;
            margin: 20px 0;
        }
        .header h2 {
            margin: 0;
        }
        .details, .items {
            margin: 20px 0;
        }
        .items th, .items td {
            border: 1px solid #333;
            padding: 5px;
            text-align: left;
        }
        .items {
            border-collapse: collapse;
            width: 100%;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h2>Factura #{{ $factura->id }}</h2>
        <p>Fecha de Emisión: {{ $factura->fecha_emision }}</p>
    </div>

    <div class="details">
        <p><strong>Cliente:</strong> {{ $factura->cliente->nombre }}</p>
        <p><strong>CI/NIT:</strong> {{ $factura->ci_nit }}</p>
    </div>

    <table class="items">
        <thead>
        <tr>
            <th>Descripción</th>
            <th>Cantidad</th>
            <th>Precio</th>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>
        @foreach($factura->venta->detalles as $detalle)
            <tr>
                <td>{{ $detalle->producto->nombre }}</td>
                <td>{{ $detalle->peso_vendido }} {{ $detalle->producto->unidad_medida }}</td>
                <td>{{ number_format($detalle->producto->precio_por_unidad, 2) }}</td>
                <td>{{ number_format($detalle->precio_venta, 2) }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="3"><strong>Monto Total:</strong></td>
            <td><strong>{{ number_format($factura->monto_total, 2) }}</strong></td>
        </tr>
        <tr>
            <td colspan="3"><strong>IVA:</strong></td>
            <td><strong>{{ number_format($factura->iva, 2) }}</strong></td>
        </tr>
        </tbody>
    </table>

    <div class="footer">
        <p>Gracias por su compra.</p>
    </div>
</div>
</body>
</html>

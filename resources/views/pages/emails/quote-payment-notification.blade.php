<!-- resources/views/emails/quote-payment-notification.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago de Cotización Recibido - El Roble</title>
    <style>
        /* Reset CSS */
        body, html {
            margin: 0;
            padding: 0;
            width: 100%;
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #eac896;
        }

        .wrapper {
            width: 100%;
            table-layout: fixed;
            padding: 20px 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .header {
            text-align: center;
            padding: 20px 0;
            border-bottom: 2px solid #eac896;
        }

        .logo {
            width: 150px;
            height: auto;
            margin-bottom: 15px;
        }

        .content {
            padding: 20px 0;
        }

        .details {
            background-color: #f8f9fa;
            padding: 20px;
            margin: 20px 0;
            border-radius: 4px;
        }

        h1 {
            color: #333;
            font-size: 24px;
            margin: 0 0 10px;
        }

        h3 {
            color: #198754;
            font-size: 18px;
            margin: 0 0 15px;
        }

        p {
            margin: 8px 0;
            color: #555;
        }

        .payment-info {
            background-color: #e8f5e9;
            padding: 15px;
            border-radius: 4px;
            margin: 20px 0;
        }

        .cta-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #198754;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin: 20px 0;
        }

        .footer {
            text-align: center;
            padding-top: 20px;
            border-top: 2px solid #eac896;
            color: #666;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <div class="header">
                <img src="{{ $message->embed(public_path('images/logo.png')) }}" alt="El Roble" class="logo">
                <h1>¡Nueva Cotización Pagada!</h1>
                <p>Se ha recibido un nuevo pago para una cotización</p>
            </div>

            <div class="content">
                <div class="payment-info">
                    <h3>Información del Pago</h3>
                    <p><strong>Tipo de Pago:</strong> {{ $isAdvancePayment ? 'Anticipo' : 'Pago Total' }}</p>
                    <p><strong>Monto Pagado:</strong> ${{ number_format($paymentAmount, 2) }}</p>
                    @if($isAdvancePayment)
                        <p><strong>Monto Pendiente:</strong> ${{ number_format($quote->estimated_price - $paymentAmount, 2) }}</p>
                    @endif
                </div>

                <div class="details">
                    <h3>Detalles de la Cotización #{{ $quote->id }}</h3>
                    <p><strong>Cliente:</strong> {{ $quote->user->person->first_name }} {{ $quote->user->person->last_name }}</p>
                    <p><strong>Email del Cliente:</strong> {{ $quote->user->email }}</p>
                    <p><strong>Fecha del Evento:</strong> {{ \Carbon\Carbon::parse($quote->date)->format('d/m/Y') }}</p>
                    <p><strong>Lugar:</strong> {{ $quote->place->name }}</p>
                    <p><strong>Horario:</strong> {{ $quote->start_time }} - {{ $quote->end_time }}</p>
                    <p><strong>Tipo de Evento:</strong> {{ $quote->type_event }}</p>
                    <p><strong>Número de Invitados:</strong> {{ $quote->guest_count }}</p>
                </div>

                <div style="text-align: center;">
                    <a href="https://elroble.store/" class="cta-button">
                        Ir al Dashboard
                    </a>
                </div>
            </div>

            <div class="footer">
                <p>Este es un correo automático del sistema de El Roble</p>
                <p>&copy; {{ date('Y') }} El Roble. Todos los derechos reservados.</p>
            </div>
        </div>
    </div>
</body>
</html>
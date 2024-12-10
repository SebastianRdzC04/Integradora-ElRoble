<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cotización Realizada - El Roble</title>
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

        /* Container styles */
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

        /* Header styles */
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

        /* Content styles */
        .content {
            padding: 20px 0;
        }

        .details {
            background-color: #f8f9fa;
            padding: 20px;
            margin: 20px 0;
            border-radius: 4px;
        }

        .services {
            padding: 20px 0;
        }

        .services ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .services li {
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }

        /* Typography */
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

        /* Footer styles */
        .footer {
            text-align: center;
            padding-top: 20px;
            border-top: 2px solid #eac896;
            color: #666;
            font-size: 14px;
        }

        .contact-info {
            margin: 15px 0;
        }

        @media screen and (max-width: 600px) {
            .container {
                width: 100%;
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <div class="header">
                <img src="{{ $message->embed(public_path('images/logo.png')) }}" alt="El Roble" class="logo">
                <h1>¡Cotización Realizada!</h1>
                <p>Gracias por confiar en El Roble para tu evento especial</p>
            </div>

            <div class="content">
                <div class="details">
                    <h3>Detalles de tu Cotización</h3>
                    <p><strong>Número de Cotización:</strong> #{{ $quote->id }}</p>
                    <p><strong>Fecha del Evento:</strong> {{ \Carbon\Carbon::parse($quote->date)->format('d/m/Y') }}</p>
                    <p><strong>Lugar:</strong> {{ $quote->place->name }}</p>
                    <p><strong>Horario:</strong> {{ $quote->start_time }} - {{ $quote->end_time }}</p>
                    <p><strong>Tipo de Evento:</strong> {{ $quote->type_event }}</p>
                    <p><strong>Número de Invitados:</strong> {{ $quote->guest_count }}</p>
                </div>

                <div class="services">
                    <h3>Servicios Incluidos</h3>
                    <ul>
                        @foreach($quote->services as $service)
                        <li>
                            <strong>{{ $service->name }}</strong> 
                            <br>
                            {{ $service->description }}
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="footer">
                <div class="contact-info">
                    <p>Si tienes alguna pregunta, no dudes en contactarnos:</p>
                    <p>Teléfono: 871-151-5134</p>
                    <p>Email: elrobleeventos@gmail.com</p>
                </div>
                <p>&copy; {{ date('Y') }} El Roble. Todos los derechos reservados.</p>
            </div>
        </div>
    </div>
</body>
</html>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Evento</title>
    <!-- Agregar los enlaces a los estilos de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <h2>Detalles del Evento</h2>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Evento para el {{ $event->date }}</h5>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Campo</th>
                            <th>Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>ID</strong></td>
                            <td>{{ $event->id }}</td>
                        </tr>
                        <tr>
                            <td><strong>Quote ID</strong></td>
                            <td>{{ $event->quote_id ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td><strong>User ID</strong></td>
                            <td>{{ $event->user_id }}</td>
                        </tr>
                        <tr>
                            <td><strong>Fecha</strong></td>
                            <td>{{ $event->date }}</td>
                        </tr>
                        <tr>
                            <td><strong>Estado</strong></td>
                            <td>{{ $event->status }}</td>
                        </tr>
                        <tr>
                            <td><strong>Hora Estimada de Inicio</strong></td>
                            <td>{{ $event->estimated_start_time }}</td>
                        </tr>
                        <tr>
                            <td><strong>Hora Real de Inicio</strong></td>
                            <td>{{ $event->start_time }}</td>
                        </tr>
                        <tr>
                            <td><strong>Hora Estimada de Fin</strong></td>
                            <td>{{ $event->estimated_end_time }}</td>
                        </tr>
                        <tr>
                            <td><strong>Hora Real de Fin</strong></td>
                            <td>{{ $event->end_time }}</td>
                        </tr>
                        <tr>
                            <td><strong>Duración (en horas)</strong></td>
                            <td>{{ $event->duration }}</td>
                        </tr>
                        <tr>
                            <td><strong>Cantidad de Sillas</strong></td>
                            <td>{{ $event->chair_count }}</td>
                        </tr>
                        <tr>
                            <td><strong>Cantidad de Mesas</strong></td>
                            <td>{{ $event->table_count }}</td>
                        </tr>
                        <tr>
                            <td><strong>Cantidad de Manteles</strong></td>
                            <td>{{ $event->table_cloth_count }}</td>
                        </tr>
                        <tr>
                            <td><strong>Precio Total</strong></td>
                            <td>{{ $event->total_price }}</td>
                        </tr>
                        <tr>
                            <td><strong>Pago Anticipado</strong></td>
                            <td>{{ $event->advance_payment }}</td>
                        </tr>
                        <tr>
                            <td><strong>Pago Restante</strong></td>
                            <td>{{ $event->remaining_payment }}</td>
                        </tr>
                        <tr>
                            <td><strong>Horas Extra</strong></td>
                            <td>{{ $event->extra_hours }}</td>
                        </tr>
                        <tr>
                            <td><strong>Precio por Hora Extra</strong></td>
                            <td>{{ $event->extra_hour_price }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Incluir sidebar -->
@include('pages.people.employee.layout.sidebar')


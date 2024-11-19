@php
    use Carbon\Carbon;

    $timeToStart = '00:00:00';
    if ($event) {
        $timeToStart = Carbon::now()->diff(Carbon::parse($event->estimated_start_time));
    }

@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <title>Document</title>
</head>

<body>
    <header>
        <h3>Esta ocurriendo un evento hoy!!!!</h3>
    </header>
    <main>
        <div class="container">
            <div class="row">
                <div class="col-5">
                    <div>
                        <h4>Datos Generales</h4>
                    </div>
                    <div>
                        <p> {{ $event->quote->type_event }} para {{ $event->quote->user->person->firstName }} </p>
                        @if (Carbon::now()->lessThan(Carbon::parse($event->estimated_start_time)))
                            @if ($timeToStart->h > 1)
                                <p class="text-end"> Faltan {{ $timeToStart->h }} horas </p>
                            @elseif ($timeToStart->h == 1)
                                <p class="text-end"> Falta {{ $timeToStart->h }} hora y
                                    {{ $timeToStart->i }}
                                    minutos </p>
                            @else
                                <p class="text-end"> Faltan {{ $timeToStart->i }} minutos </p>
                            @endif
                        @else
                            <p class="text-end"> ya paso la hora carnal</p>

                        @endif
                        <p>Lugar: {{ $event->quote->place->name }} </p>
                    </div>
                    <div>
                        <p> Sillas: {{ $event->chair_count }} </p>
                        <p> Mesas: {{ $event->table_count }} </p>
                        <p> Manteles: {{ $event->table_cloth_count }} </p>
                        <p>Se espera que termine a las {{ Carbon::parse($event->estimated_end_time)->format('h:i A') }}
                        </p>

                    </div>
                    <div>
                        <p>Precio del evento: {{ $event->total_price }} </p>
                        <p>Anticipo: {{ $event->advance_payment }} </p>
                        <p>Monto Faltante: {{ $event->remaining_payment }} </p>
                        <p>Precio por hora extra:
                            {{ $event->extra_hour_price == 0 ? 'Sin definir' : $event->extra_hour_price }} </p>
                    </div>
                </div>
                <div class="col-7">
                    <div class="border">
                        <h3>Servicios incluidos: </h3>
                        <div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Descripcion</th>
                                        <th>Precio</th>
                                        <th>Costo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($event->quote->package->services as $service)
                                        <tr>
                                            <td> {{ $service->name }} </td>
                                            <td> {{ $service->pivot->description }} </td>
                                            <td> {{ $service->pivot->price }} </td>
                                            <td> {{ $service->pivot->cost }} </td>
                                        </tr>
                                    @endforeach
                                    @foreach ($event->quote->services as $service)
                                        <tr>
                                            <td> {{ $service->name }} </td>
                                            <td> {{ $service->description }} </td>
                                            <td> {{ $service->price }} </td>
                                            <td> {{ $service->cost }} </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div>
                        <h3>Consumibles</h3>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Cantidad</th>
                                    <th>Estado</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($event->consumables as $consumable)
                                    <tr>
                                        <td> {{ $consumable->name }} </td>
                                        <td> {{ $consumable->pivot->quantity }}{{ $consumable->unit }} </td>
                                        <td> {{ $consumable->pivot->ready }} </td>
                                        <td class="text-center">
                                            <form
                                                action="{{ route('dashboard.event.consumable', $consumable->pivot->id) }}"
                                                method="POST">
                                                @csrf
                                                <button
                                                    class="btn btn-outline-{{ $consumable->pivot->ready ? 'danger' : 'success' }} py-0 px-1"
                                                    type="submit">
                                                    @if ($consumable->pivot->ready)
                                                        <i class="fs-4 bi bi-x-circle-fill"></i>
                                                    @else
                                                        <i class="fs-4 bi bi-check-circle-fill "></i>
                                                    @endif
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer>

    </footer>
</body>

</html>

@php
    use Carbon\Carbon;

    $timeToStart = '00:00:00';
    if ($event) {
        $timeToStart = Carbon::now()->diff(Carbon::parse($event->estimated_start_time));
    }

    $data = session('consumible');

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
    </header>
    <main>
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-5 border">
                    <div>
                        <h4>{{ $event->quote->type_event }} para {{ $event->quote->user->person->firstName }}</h4>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div>
                            <p>Lugar: {{ $event->quote->place ? $event->quote->place->name : $event->quote->package->place->name }} </p>
                        </div>
                        <!-- Calcula el tiempo que falta para que inicie el evento -->
                        <div>
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
                        </div>
                        <!-- Aqui termina esa seccion -->
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

                        <div class="mb-3 d-flex justify-content-between">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#modal1">Mostrar
                                Servicios</button>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#modal2">Mostrar
                                Consumibles</button>
                        </div>
                        <div class="modal fade" id="modal1" aria-labelledby="modalLabel1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4>Servicios Incluidos</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
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
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="modal2" aria-labelledby="modalLabel2" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4>Consumibles incluidos</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
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
                                                        <td> {{ $consumable->pivot->quantity }}{{ $consumable->unit }}
                                                        </td>
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
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer>

    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    @if ($data)
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var modal = new bootstrap.Modal(document.getElementById('modal2'));
                modal.show();
            });
        </script>
    @endif
</body>

</html>

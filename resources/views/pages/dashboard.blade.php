@php
    use Carbon\Carbon;

    $timeToStart = '00:00:00';
    if ($currentEvent) {
        $timeToStart = Carbon::now()->diff(Carbon::parse($currentEvent->estimated_start_time));
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
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.15/index.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/web-component@6.1.15/index.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.15/index.global.min.js'></script>


    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

    <title>Document</title>
</head>

<body>
    <header>
        <h1 class="text-center">Dashboard</h1>
    </header>

    <main>
        <div>
            <div class="d-flex justify-content-between flex-column">
                <div>
                    <h2 class="h4">Bienvenido {{ auth()->user() }}</h2>
                    <p>Fecha: {{ Carbon::now()->format('d-m-Y') }}</p>
                </div>
                <div class="mb-3">
                    <h2 class="h4"><a href="">Dashboard</a></h2>
                </div>
                <div class="mb-3">
                    <h2 class="h4">Tablas</h2>
                </div>
                
            </div>
        </div>
        <div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-4">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex">
                                        <i class="bi bi-calendar-event"></i>
                                        <h2 class="h4">Eventos</h2>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <p class="p-0 m-0">Eventos Pendientes</p>
                                        <p class="p-0 m-0 text-center"> 5</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                mas eventos que el mes pasado
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex">
                                        <i class="bi bi-calendar-event h-35 w-35"></i>
                                        <h2 class="h4">Cotizaciones</h2>
                                    </div>
                                    <div>
                                        <p class="p-0 m-0">Pendiente a Cotizar</p>
                                        <p class="p-0 m-0"> 4 </p>
                                    </div>

                                </div>
                            </div>
                            <div class="card-footer">
                                <p>Pendientes por usuario</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="35px" height="35px"
                                            viewBox="0 0 32 32">
                                            <g fill="currentColor">
                                                <path
                                                    d="M15.84 19.345h.07c1.5.04 2.7 1.26 2.7 2.76c0 1.28-.87 2.35-2.05 2.67v1.12c0 .4-.32.72-.72.72s-.72-.32-.72-.72v-1.12a2.77 2.77 0 0 1-2.05-2.67c0-.4.32-.72.72-.72s.72.32.72.72c0 .74.59 1.33 1.32 1.33s1.33-.6 1.33-1.33s-.6-1.33-1.33-1.33h-.07a2.765 2.765 0 0 1-2.69-2.76c0-1.28.87-2.35 2.05-2.67v-1.12c0-.4.32-.72.72-.72s.72.32.72.72v1.12c1.18.32 2.05 1.39 2.05 2.67c0 .4-.32.72-.72.72s-.72-.32-.72-.72c0-.73-.6-1.33-1.33-1.33s-1.33.6-1.33 1.33s.6 1.33 1.33 1.33" />
                                                <path
                                                    d="m10.532 5.1l2.786 3.26l-.301.336C7.283 9.982 3 15.103 3 21.225c0 5.382 4.368 9.75 9.75 9.75h6.17c5.382 0 9.75-4.367 9.75-9.749c.01-6.123-4.273-11.244-10.007-12.53a1.1 1.1 0 0 0-.11-.615l2.37-2.713l.153-.236a1.956 1.956 0 0 0-2.892-2.423l-.843-1a2.02 2.02 0 0 0-3.008-.005l-.883.986a1.96 1.96 0 0 0-2.918 2.41m3.799 1.385l-1.696-1.96a1.98 1.98 0 0 0 2.365-.5l.8-1.038l.888 1.052a1.97 1.97 0 0 0 2.3.513L17.3 6.485zM5 21.225c0-5.988 4.852-10.84 10.84-10.84s10.84 4.852 10.83 10.838v.002a7.753 7.753 0 0 1-7.75 7.75h-6.17A7.753 7.753 0 0 1 5 21.225" />
                                            </g>
                                        </svg>
                                        <p>Ganancias</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <p> 35% mas ingresos que el mes pasado</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="card border shadow mb-4">
                            <div id="calendar"></div>
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

    @php
        $eventos = [];
        $daysOcupedQuotes = [];
        foreach ($events as $event) {
            $eventos[] = [
                'title' => $event->quote->type_event . ' de ' .  $event->quote->user->person->firstName,
                'start' => $event->date,
                'color' => 'blue',
            ];
        }
        foreach ($fullQuoteDates as $date) {
            $daysOcupedQuotes[] = [
                'title' => 'Limite de cotizaciones',
                'start' => $date,
                'color' => 'red',
            ];
        }

        
    @endphp

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let events = @json($eventos);
            let daysOcupedQuotes = @json($daysOcupedQuotes);

            let calendarEl = document.getElementById('calendar');
            let calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: [...events, ...daysOcupedQuotes]
            });
            calendar.render();
        });
    </script>


</body>

</html>

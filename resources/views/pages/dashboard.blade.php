<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset('css/calendar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <title>Document</title>
</head>

<body>
    <header>
        <h1 class="text-center">Dashboard</h1>
    </header>
    <main>
        <div class="container">
            <div class="row">
                <div class="col border">1</div>
                <div class="col border">2</div>
                <div class="col border">3</div>
                <div class="col border">4</div>
                <div class="col border">5</div>
                <div class="col border">6</div>
                <div class="col border">7</div>
                <div class="col border">8</div>
                <div class="col border">9</div>
                <div class="col border">10</div>
                <div class="col border">11</div>
                <div class="col border">12</div>
            </div>
            <div class="row">
                <div class="col-3 mb-3 border px-2">
                    <div class="card">
                        <div class="card-body">

                        </div>
                    </div>
                </div>
                <div class="col-3 mb-3 border px-2">Pru</div>
                <div class="col-3 mb-3 border px-2">Pru</div>
                <div class="col-3 mb-3 border px-2">Pru</div>
            </div>
            <div class="row">
                <div class="col-12 border col-md-6 col-xl-4">
                    Eventos
                </div>
                <div class="col-12 border col-md-6 col-xl-5">
                    <div class="row">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="h4">Cotizaciones Pendientes</h2>
                            </div>
                            <div class="card-body">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-6 card">
                                            <div class="card-header mb-2">
                                                <h6>{{ $quote->type_event . ' de ' . $quote->user->person->firstName }}
                                                </h6>
                                            </div>
                                            <div class="quotes container-fluid">
                                                <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-house" viewBox="0 0 16 16">
                                                        <path
                                                            d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z" />
                                                    </svg>  {{ $quote->place->name }}</p>
                                                <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-calendar-x"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M6.146 7.146a.5.5 0 0 1 .708 0L8 8.293l1.146-1.147a.5.5 0 1 1 .708.708L8.707 9l1.147 1.146a.5.5 0 0 1-.708.708L8 9.707l-1.146 1.147a.5.5 0 0 1-.708-.708L7.293 9 6.146 7.854a.5.5 0 0 1 0-.708" />
                                                        <path
                                                            d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z" />
                                                    </svg> {{ substr($quote->date->date, 5) }}</p>
                                                <h6 class="text-center">Servicios</h6>
                                                <div class="row">
                                                    @foreach ($quote->services as $service)
                                                        <div class="col border">
                                                            <p> {{ $service->name }} </p>
                                                            <p> {{ $service->pivot->quantity }} </p>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <p>{{ $quote->status }}</p>
                                            </div>
                                        </div>
                                        <div class="col-6 card">
                                            <div class="card-header">
                                                <h6>fiesta de juan</h6>
                                            </div>
                                            <div class="card-body"></div>
                                        </div>
                                        <div class="col-6 card">
                                            <div class="card-header">
                                                <h6>fiesta de juan</h6>
                                            </div>
                                            <div class="card-body"></div>
                                        </div>
                                        <div class="col-6 card">
                                            <div class="card-header">
                                                <h6>fiesta de juan</h6>
                                            </div>
                                            <div class="card-body"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-8 border d-inline-flex col-xl-3 col-md-4">
                    <div class="container-fluid align-items-center d-inline-flex border" id="calendar-container">
                        <div class="row justify-content-center align-items-center">
                            <div class="col">
                                <button class="btn" id="prev">
                                    < </button>
                            </div>
                            <div class="col">
                                <h1 class="text-center grande" id="calendar-month"></h1>
                            </div>
                            <div class="col">
                                <button class="btn" id="next">></button>
                            </div>
                        </div>
                        <div id="days">
                            <div class="day">Lun</div>
                            <div class="day">Mar</div>
                            <div class="day">Mier</div>
                            <div class="day">Jue</div>
                            <div class="day">Vie</div>
                            <div class="day">Sab</div>
                            <div class="day">Dom</div>

                        </div>
                        <div class="border" id="calendar"></div>
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
    <script>
        const fechas = [@json($quote->date->date)];
    </script>
    <script src="{{ asset('js/calendar.js') }}"></script>
</body>

</html>

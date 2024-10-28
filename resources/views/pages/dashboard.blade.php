@php
    use Carbon\Carbon;
@endphp

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
                                        @foreach ($quotes as $quote)
                                            @if ($quote->package_id === null)
                                                @php
                                                    $qServices = $quote->services()->paginate(2);
                                                @endphp
                                                <div class="col-6 card">
                                                    <div class="card-header mb-2">
                                                        <h6>{{ $quote->type_event . ' de ' . $quote->user->person->firstName }}
                                                        </h6>
                                                    </div>
                                                    <div class="quotes container-fluid">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <p><svg xmlns="http://www.w3.org/2000/svg"
                                                                        width="16" height="16"
                                                                        fill="currentColor" class="bi bi-house"
                                                                        viewBox="0 0 16 16">
                                                                        <path
                                                                            d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z" />
                                                                    </svg> {{ $quote->place->name }}
                                                                </p>
                                                            </div>
                                                            <div class="col-6">
                                                                <p class="text-end">
                                                                    {{ Carbon::parse($quote->date->date)->format('d/m') }}
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        width="16" height="16"
                                                                        fill="currentColor" class="bi bi-calendar-x"
                                                                        viewBox="0 0 16 16">
                                                                        <path
                                                                            d="M6.146 7.146a.5.5 0 0 1 .708 0L8 8.293l1.146-1.147a.5.5 0 1 1 .708.708L8.707 9l1.147 1.146a.5.5 0 0 1-.708.708L8 9.707l-1.146 1.147a.5.5 0 0 1-.708-.708L7.293 9 6.146 7.854a.5.5 0 0 1 0-.708" />
                                                                        <path
                                                                            d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z" />
                                                                    </svg>
                                                                </p>
                                                            </div>
                                                            <div class="col-6">
                                                                <p class="text-start">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        width="16" height="16"
                                                                        fill="currentColor"
                                                                        class="bi bi-person-standing"
                                                                        viewBox="0 0 16 16">
                                                                        <path
                                                                            d="M8 3a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3M6 6.75v8.5a.75.75 0 0 0 1.5 0V10.5a.5.5 0 0 1 1 0v4.75a.75.75 0 0 0 1.5 0v-8.5a.25.25 0 1 1 .5 0v2.5a.75.75 0 0 0 1.5 0V6.5a3 3 0 0 0-3-3H7a3 3 0 0 0-3 3v2.75a.75.75 0 0 0 1.5 0v-2.5a.25.25 0 0 1 .5 0" />
                                                                    </svg>
                                                                    50
                                                                </p>
                                                            </div>
                                                            <div class="col-6">
                                                                <p class="text-end">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        width="16" height="16"
                                                                        fill="currentColor" class="bi bi-clock-history"
                                                                        viewBox="0 0 16 16">
                                                                        <path
                                                                            d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022zm2.004.45a7 7 0 0 0-.985-.299l.219-.976q.576.129 1.126.342zm1.37.71a7 7 0 0 0-.439-.27l.493-.87a8 8 0 0 1 .979.654l-.615.789a7 7 0 0 0-.418-.302zm1.834 1.79a7 7 0 0 0-.653-.796l.724-.69q.406.429.747.91zm.744 1.352a7 7 0 0 0-.214-.468l.893-.45a8 8 0 0 1 .45 1.088l-.95.313a7 7 0 0 0-.179-.483m.53 2.507a7 7 0 0 0-.1-1.025l.985-.17q.1.58.116 1.17zm-.131 1.538q.05-.254.081-.51l.993.123a8 8 0 0 1-.23 1.155l-.964-.267q.069-.247.12-.501m-.952 2.379q.276-.436.486-.908l.914.405q-.24.54-.555 1.038zm-.964 1.205q.183-.183.35-.378l.758.653a8 8 0 0 1-.401.432z" />
                                                                        <path
                                                                            d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0z" />
                                                                        <path
                                                                            d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5" />
                                                                    </svg>
                                                                    {{ Carbon::parse($quote->start_time)->format('g:i A') . ' - ' . Carbon::parse($quote->end_time)->format('g:i A') }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <h6 class="text-start">Servicios:</h6>
                                                        <div class="row align-items-center ms-0">
                                                            <div class="list-group d-flex justify-content-center w-100"
                                                                style="height: 90px">
                                                                @foreach ($qServices as $service)
                                                                    <div
                                                                        class="list-group-item d-flex justify-content-center align-items-center text-center">
                                                                        {{ $service->name }}
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div>
                                                                {{ $qServices->links('pagination::simple-bootstrap-5') }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                @php
                                                    $qPackagesS = $quote->package->services()->paginate(2);
                                                @endphp
                                                <div class="col-6 card">
                                                    <div class="card-header mb-2">
                                                        <h6>{{ $quote->type_event . ' de ' . $quote->user->person->firstName }}
                                                        </h6>
                                                    </div>
                                                    <div class="quotes container-fluid">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <p><svg xmlns="http://www.w3.org/2000/svg"
                                                                        width="16" height="16"
                                                                        fill="currentColor" class="bi bi-house"
                                                                        viewBox="0 0 16 16">
                                                                        <path
                                                                            d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z" />
                                                                    </svg> {{ $quote->package->place->name }}
                                                                </p>
                                                            </div>
                                                            <div class="col-6">
                                                                <p class="text-end">
                                                                    {{ Carbon::parse($quote->date->date)->format('d/m') }}
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        width="16" height="16"
                                                                        fill="currentColor" class="bi bi-calendar-x"
                                                                        viewBox="0 0 16 16">
                                                                        <path
                                                                            d="M6.146 7.146a.5.5 0 0 1 .708 0L8 8.293l1.146-1.147a.5.5 0 1 1 .708.708L8.707 9l1.147 1.146a.5.5 0 0 1-.708.708L8 9.707l-1.146 1.147a.5.5 0 0 1-.708-.708L7.293 9 6.146 7.854a.5.5 0 0 1 0-.708" />
                                                                        <path
                                                                            d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z" />
                                                                    </svg>
                                                                </p>
                                                            </div>
                                                            <div class="col-6">
                                                                <p class="text-start">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        width="16" height="16"
                                                                        fill="currentColor"
                                                                        class="bi bi-person-standing"
                                                                        viewBox="0 0 16 16">
                                                                        <path
                                                                            d="M8 3a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3M6 6.75v8.5a.75.75 0 0 0 1.5 0V10.5a.5.5 0 0 1 1 0v4.75a.75.75 0 0 0 1.5 0v-8.5a.25.25 0 1 1 .5 0v2.5a.75.75 0 0 0 1.5 0V6.5a3 3 0 0 0-3-3H7a3 3 0 0 0-3 3v2.75a.75.75 0 0 0 1.5 0v-2.5a.25.25 0 0 1 .5 0" />
                                                                    </svg>
                                                                    50
                                                                </p>
                                                            </div>
                                                            <div class="col-6">
                                                                <p class="text-end">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        width="16" height="16"
                                                                        fill="currentColor"
                                                                        class="bi bi-clock-history"
                                                                        viewBox="0 0 16 16">
                                                                        <path
                                                                            d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022zm2.004.45a7 7 0 0 0-.985-.299l.219-.976q.576.129 1.126.342zm1.37.71a7 7 0 0 0-.439-.27l.493-.87a8 8 0 0 1 .979.654l-.615.789a7 7 0 0 0-.418-.302zm1.834 1.79a7 7 0 0 0-.653-.796l.724-.69q.406.429.747.91zm.744 1.352a7 7 0 0 0-.214-.468l.893-.45a8 8 0 0 1 .45 1.088l-.95.313a7 7 0 0 0-.179-.483m.53 2.507a7 7 0 0 0-.1-1.025l.985-.17q.1.58.116 1.17zm-.131 1.538q.05-.254.081-.51l.993.123a8 8 0 0 1-.23 1.155l-.964-.267q.069-.247.12-.501m-.952 2.379q.276-.436.486-.908l.914.405q-.24.54-.555 1.038zm-.964 1.205q.183-.183.35-.378l.758.653a8 8 0 0 1-.401.432z" />
                                                                        <path
                                                                            d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0z" />
                                                                        <path
                                                                            d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5" />
                                                                    </svg>
                                                                    {{ Carbon::parse($quote->start_time)->format('g:i A') . ' - ' . Carbon::parse($quote->end_time)->format('g:i A') }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <h6 class="text-start">Servicios:</h6>
                                                        <div class="row align-items-center ms-0">
                                                            <div class="list-group d-flex justify-content-center w-100"
                                                                style="height: 90px">
                                                                @foreach ($qPackagesS as $service)
                                                                    <div
                                                                        class="list-group-item d-flex justify-content-center align-items-center text-center">
                                                                        {{ $service->name }}
                                                                    </div>
                                                                @endforeach
                                                                <div>
                                                            </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
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
        const fechas = @json($quotes->pluck('date.date'));
    </script>
    <script src="{{ asset('js/calendar.js') }}"></script>
</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset('css/calendar.css') }}">
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
                <div class="col-5 border">
                    Eventos
                </div>
                <div class="col-4 border">
                    <div class="row">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="h4">Cotizaciones Pendientes</h2>
                            </div>
                            <div class="card-body">
                                <div class="container-fluid">
                                    <div class="row">
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
                <div class="col-8 border d-inline-flex col-xl-3">
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
        const fechas = []
    </script>
    <script src="{{ asset('js/calendar.js') }}"></script>
</body>

</html>

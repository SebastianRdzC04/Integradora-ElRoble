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
        <div class="container d-flex justify-content-center align-items-center">
            <h2 class="text-center">Calendario</h2>
        </div>
    </header>
    <main class="container d-flex justify-content-center align-items-center">
        <div class="container justify-content-center align-items-center">
            <div class="row">
                <div class="col">
                    
                </div>
            </div>
            <div class="row justify-content-center align-items-center">
                <div class="col-6 col-xl-3 col-md-4 justify-content-center align-items-center">
                    <div class="container-fluid justify-content-center align-items-center" id="calendar-container">
                        <div class="row justify-content-center align-items-center">
                            <div class="col">
                                <button class="btn" id="prev"><</button>
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
                        <div id="calendar"></div>
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
        const fechas = ['2024-05-05']
    </script>
    <script src="{{ asset('js/calendar.js') }}"></script>
</body>

</html>

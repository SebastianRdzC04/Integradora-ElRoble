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
        <h3>Aqui iran las cotizaciones</h3>
    </header>
    <main>
        <div class="container">
            <div class="row">
                <div class="col-5">
                    <div class="card-body border">
                        <h5 class="card-title text-center">Detalles Generales</h5>
                        <div class="d-flex justify-content-between">
                            <div>
                                <p> {{ $quote->type_event }} </p>
                                <p>Lugar: {{ $quote->place->name }} </p>
                                <p>Invitados: {{ $quote->guest_count }} </p>
                                <p> {{ $quote->user_id ? $quote->user->person->firstName : $quote->owner_name }} </p>
                            </div>
                            <div>
                                <p> {{ $quote->date }} </p>
                                <p> {{ $quote->start_time }} - {{ $quote->end_time }} </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-7">
                    <div class="card-body border">
                        <h5 class="card-title text-center">Servicios Incluidos</h5>
                        <div class="d-flex justify-content-between">
                            <div>
                                <p>Serivios Interesados:
                                    {{ $quote->package->services->count() + $quote->services->count() }} </p>
                            </div>
                        </div>
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
                                    @if ($quote->package)
                                        @foreach ($quote->package->services as $service)
                                            <tr>
                                                <td>{{ $service->name }}</td>
                                                <td>{{ $service->pivot->description }}</td>
                                                <td>{{ $service->pivot->price }}</td>
                                                <td>{{ $service->pivot->cost }}</td>
                                            </tr>
                                            
                                        @endforeach
                                    @endif
                                    @if ($quote->services)
                                        @foreach ($quote->services as $service)
                                            <tr>
                                                <td>{{ $service->name }}</td>
                                                <td>{{ $service->description }}</td>
                                                <td>{{ $service->price }}</td>
                                                <td>{{ $service->cost }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
    </main>

</body>

</html>

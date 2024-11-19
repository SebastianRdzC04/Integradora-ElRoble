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
                                    {{ ($quote->package ? $quote->package->services->count() : 0) + $quote->services->count() }}
                                </p>
                            </div>
                        </div>
                        <div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Descripcion</th>
                                        <th>Cantidad</th>
                                        <th>Precio</th>
                                        <th>Costo</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($quote->package)
                                        @foreach ($quote->package->services as $service)
                                            <tr>
                                                <td>{{ $service->name }}</td>
                                                <td>{{ $service->pivot->description }}</td>
                                                <td> {{ $service->pivot->quantity ? $service->pivot->quantity : 'norelevante' }}
                                                </td>
                                                <td>{{ $service->pivot->price }}</td>
                                                <td>{{ $service->pivot->cost }}</td>
                                                <td>Incluido con paquete</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    @if ($quote->services)
                                        @foreach ($quote->services as $service)
                                            <tr>
                                                <td>{{ $service->name }}</td>
                                                <td>{{ $service->pivot->description }}</td>
                                                <td> {{ $service->pivot->quantity ? $service->pivot->quantity : 'norelevante' }}
                                                </td>
                                                <td>{{ $service->pivot->price }}</td>
                                                <td>{{ $service->pivot->cost }}</td>
                                                <td>
                                                    <div>
                                                        <button data-bs-toggle="modal"
                                                            data-bs-target="#modal{{ $service->pivot->id }}">cambiar</button>
                                                    </div>
                                                    <div class="modal fade" id="modal{{ $service->pivot->id }}"
                                                        aria-labelledby="modalLabel{{ $service->pivot->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">

                                                                </div>
                                                                <div class="modal-body">
                                                                    <h3>Aqui ira el formulario</h3>
                                                                    <div>
                                                                        <form action="">
                                                                            @csrf
                                                                            <div>
                                                                                <label for="cantidad" class="form-label">Cantidad</label>
                                                                                <input type="number" name="cantidad" value="0">
                                                                            </div>
                                                                            <div>
                                                                                <label for="precio">Cuanto Vas a
                                                                                    cobrar?</label>
                                                                                <input type="number" name="precio">
                                                                            </div>
                                                                            <div>
                                                                                <label for="costo">Cuanto te cuesta a
                                                                                    ti? </label>
                                                                                <input type="number" name="costo">
                                                                            </div>
                                                                            <div>
                                                                                <button>Enviar</button>
                                                                            </div>

                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

</body>

</html>

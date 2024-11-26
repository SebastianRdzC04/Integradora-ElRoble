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
                    <div class="card">
                        <div class="card-header text-center">
                            <h2 class="mb-0">Cotizacion Evento</h2>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="">Estado:</div>
                                <div> {{ $quote->status }} </div>
                            </div>
                            <div class="row mb-3">
                                <div class="">Nombre del Interesado:</div>
                                <div> {{ $quote->user->person->firstName }} </div>
                            </div>
                            <div class="row mb-3">
                                <div>Tipo de Evento:</div>
                                <div> {{ $quote->type_event }} </div>
                            </div>
                            <div class="row mb-3">
                                <div>Lugar:</div>
                                <div> {{ $quote->package ? $quote->package->place->name : $quote->place->name }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div>Fecha:</div>
                                <div> {{ $quote->date }} </div>
                            </div>
                            <div class="row mb-3">
                                <div>Hora:</div>
                                <div> {{ $quote->start_time }} - {{ $quote->end_time }} </div>
                            </div>
                            <div class="row mb-3">
                                <div>Numero de invitados:</div>
                                <div> {{ $quote->guest_count }} </div>
                            </div>
                            <div class="row mb-3">
                                <div>Precio de la cotizacion:</div>
                                <div> ${{ $quote->estimated_price }} <i data-bs-toggle="modal"
                                        data-bs-target="#quoteModal" class="text-end bi bi-pencil"></i></div>
                                <div class="modal fade" id="quoteModal">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">

                                            </div>
                                            <div class="modal-body">
                                                <div>
                                                    <form action="{{ route('dashboard.quote.price', $quote->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <div class="row mb-3">
                                                            <label class="form-label" for="precio">Precio de la
                                                                cotizacion</label>
                                                            <input step="0.01" min="0" class="form-control" type="number" name="precio"
                                                                value="{{ $quote->estimated_price }}">
                                                        </div>
                                                        <div>
                                                            <button class="btn btn-primary">Enviar</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div>Anticipo:</div>
                                <div> ${{ $quote->espected_advance }} <i data-bs-toggle="modal"
                                        data-bs-target="#quoteAdvanceModal" class="text-end bi bi-pencil"></i></div>
                                <div class="modal fade" id="quoteAdvanceModal">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h3>Anticipo</h3>
                                            </div>
                                            <div class="modal-body">
                                                <div>
                                                    <form action="{{ route('dashboard.quote.advance', $quote->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <div class="row mb-3">
                                                            <label class="form-label" for="precio">Precio de la
                                                                cotizacion</label>
                                                            <input step="0.01" min="0" class="form-control" type="number" name="anticipo"
                                                                value="{{ $quote->espected_advance }}">
                                                        </div>
                                                        <div>
                                                            <button class="btn btn-primary">Enviar</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="text-end">
                                    @if ($quote->status == 'pendiente')
                                        <form action="{{ route('dashboard.quote.payment', $quote->id) }}"
                                            method="POST">
                                            @csrf
                                            <button class="btn btn-primary">Confirmar y crear evento</button>
                                        </form>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-7">
                    <div class="card">
                        <div class="card-header text-center">
                            <h2 class="mb-0">Servicios Interesados:
                                {{ ($quote->package ? $quote->package->services->count() : 0) + $quote->services->count() }}
                            </h2>
                        </div>
                        <div class="card-body">
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
                                                    <td>{{ $service->pivot->coast }}</td>
                                                    <td class="text-center">
                                                        <div class="justify-content-center">
                                                            <button class="btn btn-outline-primary text-center"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#modal{{ $service->pivot->id }}"><i
                                                                    class="bi bi-pen"></i></button>
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
                                                                            <form method="POST"
                                                                                action="{{ route('dashboard.quote.status', $service->pivot->id) }}">
                                                                                @csrf
                                                                                <div class="row mb-3">
                                                                                    <label for="cantidad"
                                                                                        class="form-label">Cantidad</label>
                                                                                    <input type="number"
                                                                                        name="cantidad" value="0">
                                                                                </div>
                                                                                <div class="row mb-3">
                                                                                    <label for="precio">Cuanto Vas
                                                                                        a
                                                                                        cobrar?</label>
                                                                                    <input type="number"
                                                                                        name="precio">
                                                                                </div>
                                                                                <div class="row mb-3">
                                                                                    <label for="costo">Cuanto te
                                                                                        cuesta a
                                                                                        ti? </label>
                                                                                    <input type="number"
                                                                                        name="costo">
                                                                                </div>
                                                                                <div class="row mb-3">
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


        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script></script>

</body>

</html>

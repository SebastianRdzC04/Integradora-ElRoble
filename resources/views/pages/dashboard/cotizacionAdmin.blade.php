@extends('layouts.dashboardAdmin')

@php
    use Carbon\Carbon;
    Carbon::setLocale('es');
@endphp

@section('title', 'Cotizacion')

@section('styles')

@endsection

@section('content')
    <main>
        <div class="container">
            <div class="row">
                <div class="col-5">
                    <div class="card shadow">
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
                                @if ($quote->owner_name)
                                    <div> {{ $quote->owner_name }} <i data-bs-toggle="modal" data-bs-target="#dataModal"
                                            class="bi bi-three-dots"></i> </div>
                                @else
                                    <div> {{ $quote->user ? $quote->user->person->first_name : $quote->owner_name }} <i
                                            data-bs-toggle="modal" data-bs-target="#dataModal" class="bi bi-three-dots"></i>
                                    </div>
                                @endif
                                <div class="modal fade" id="dataModal">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1>Datos del Cliente</h1>
                                            </div>
                                            <div class="modal-body">
                                                <div>
                                                    <h6>Nombre:</h6>
                                                    <p> {{ $quote->owner_name ? $quote->owner_name : $quote->user->person->first_name }}
                                                        {{ $quote->owner_name ? '' : $quote->user->person->last_name }} </p>
                                                </div>
                                                <div>
                                                    <h6>Telefono:</h6>
                                                    <p> {{ $quote->owner_phone ? $quote->owner_phone : $quote->user->person->phone }}
                                                    </p>
                                                </div>
                                                <div>
                                                    <h6>Correo:</h6>
                                                    <p> {{ $quote->owner_name ? '' : $quote->user->email }} </p>
                                                </div>
                                            </div>
                                            @if (!$quote->owner_name)
                                                <div class="modal-footer">
                                                    <h6>El usuario se registro
                                                        {{ Carbon::parse($quote->user->created_at)->diffForHumans() }} </h6>
                                                </div>
                                            @endif

                                        </div>
                                    </div>
                                </div>
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
                                <div> ${{ $quote->estimated_price }} <i data-bs-toggle="modal" data-bs-target="#quoteModal"
                                        class="text-end bi bi-pencil"></i></div>
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
                                                            <input step="0.01" min="0" class="form-control"
                                                                type="number" name="precio"
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
                                                            <input step="0.01" min="0" class="form-control"
                                                                type="number" name="anticipo"
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
                                        <form action="{{ route('dashboard.quote.payment', $quote->id) }}" method="POST">
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
                    <div class="card shadow">
                        <div class="card-header text-center">
                            <h2 class="mb-0">Servicios Interesados:
                                {{ ($quote->package ? $quote->package->services->count() : 0) + $quote->services->count() }}
                            </h2>
                        </div>
                        <div class="card-body">
                            <div class="">
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
                                                    <td>{{ $service->pivot->description ? $service->pivot->description : 'Sin especificar' }}
                                                    </td>
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
                                                                                <div class="mb-3">
                                                                                    <label for="cantidad"
                                                                                        class="form-label">Cantidad</label>
                                                                                    <input class="form-control"
                                                                                        type="number" name="cantidad"
                                                                                        value="0">
                                                                                </div>
                                                                                <div class="mb-3">
                                                                                    <label class="form-label"
                                                                                        for="precio">Cuanto Vas
                                                                                        a
                                                                                        cobrar?</label>
                                                                                    <input class="form-control"
                                                                                        type="number" name="precio">
                                                                                </div>
                                                                                <div class=" mb-3">
                                                                                    <label class="form-label"
                                                                                        for="costo">Cuanto te
                                                                                        cuesta a
                                                                                        ti? </label>
                                                                                    <input class="form-control"
                                                                                        type="number" name="costo">
                                                                                </div>
                                                                                <div class="mb-3">
                                                                                    <button
                                                                                        class="btn btn-primary">Enviar</button>
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
                                            <tr>
                                                <td colspan="2"></td>
                                                <td>Total: </td>
                                                <td>Precio: ${{ $quote->services->sum('pivot.price') }}</td>
                                                <td>Costo: ${{ $quote->services->sum('pivot.coast') }} </td>
                                                <td></td>
                                            </tr>
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
@endsection

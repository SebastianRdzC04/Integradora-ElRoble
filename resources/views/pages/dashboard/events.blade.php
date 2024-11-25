@extends('layouts.dashboardAdmin')

@section('styles')

    <link rel="stylesheet" href="{{ asset('css/dashboard/events.css') }}">

@endsection

@section('title', 'Events')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-10 ">
                <div class="table-responsive ">
                    <table class="table shadow" id="event-table">
                        <thead>
                            <tr>
                                <th>Cliente</th>
                                <th>Lugar</th>
                                <th>T.Evento</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                                <th>Servicios</th>
                                <th>Precio T</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($events as $event)
                                <tr>
                                    <td>{{ $event->quote->user ? $event->quote->user->person->first_name : $event->quote->owner_name }}
                                    </td>
                                    <td>{{ $event->quote->package ? $event->quote->package->place->name : $event->quote->place->name }}
                                    </td>
                                    <td>{{ $event->quote->type_event }}</td>
                                    <td>{{ $event->date }}</td>
                                    <td>{{ $event->status }}</td>
                                    <td>{{ $event->services->count() + $event->quote->services->count() + ($event->quote->package ? $event->quote->package->services->count() : 0) }}
                                    </td>
                                    <td>{{ $event->total_price }}</td>
                                    <td>
                                        <div>
                                            <a class="btn btn-outline-primary p-1 m-0" href=""><i
                                                    class="bi bi-pencil-square"></i></a>
                                            <a class="btn btn-outline-danger p-1 m-0" href=""><i
                                                    class="bi bi-trash3"></i></a>
                                            <button type="button" class="btn btn-outline-primary p-1 m-0"
                                                data-bs-toggle="modal" data-bs-target="#modal{{ $event->id }}">
                                                <i class="bi bi-three-dots"></i>
                                            </button>

                                            <!-- Modal Structure -->
                                            <div class="modal fade" id="modal{{ $event->id }}" tabindex="-1"
                                                aria-labelledby="modalLabel{{ $event->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modalLabel{{ $event->id }}">
                                                                Detalles del evento</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div>
                                                                <h3>Servicios incluidos</h3>
                                                            </div>
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Nombre</th>
                                                                        <th>Descripcion</th>
                                                                        <th>Cantidad</th>
                                                                        <th>Costo</th>
                                                                        <th>Detalles</th>
                                                                        <th>Acciones</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @if ($event->services)
                                                                        @foreach ($event->services as $service)
                                                                            <tr>
                                                                                <td> {{ $service->name }} </td>
                                                                                <td> {{ $service->description }} </td>
                                                                                <td> {{ $service->pivot->quantity }} </td>
                                                                                <td> {{ $service->pivot->price }} </td>
                                                                                <td> {{ $service->pivot->description }}
                                                                                </td>
                                                                                <td>
                                                                                    <div>
                                                                                        <a class="btn btn-outline-primary p-1 m-0"
                                                                                            href=""><i
                                                                                                class="bi bi-pencil-square"></i></a>
                                                                                        <a class="btn btn-outline-danger p-1 m-0"
                                                                                            href=""><i
                                                                                                class="bi bi-trash3"></i></a>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    @endif
                                                                    @if ($event->quote->services)
                                                                        @foreach ($event->quote->services as $service)
                                                                            <tr>
                                                                                <td> {{ $service->name }} </td>
                                                                                <td> {{ $service->description }} </td>
                                                                                <td> {{ $service->pivot->quantity }} </td>
                                                                                <td> {{ $service->pivot->price }} </td>
                                                                                <td> {{ $service->pivot->description }}
                                                                                </td>
                                                                                <td>
                                                                                    <div>
                                                                                        <a class="btn btn-outline-primary p-1 m-0"
                                                                                            href=""><i
                                                                                                class="bi bi-pencil-square"></i></a>
                                                                                        <a class="btn btn-outline-danger p-1 m-0"
                                                                                            href=""><i
                                                                                                class="bi bi-trash3"></i></a>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    @endif
                                                                    @if ($event->quote->package)
                                                                        @foreach ($event->quote->package->services as $service)
                                                                            <tr>
                                                                                <td> {{ $service->name }} </td>
                                                                                <td> {{ $service->description }} </td>
                                                                                <td> {{ $service->pivot->quantity }} </td>
                                                                                <td> {{ $service->pivot->price }} </td>
                                                                                <td> {{ $service->pivot->description }}
                                                                                </td>
                                                                                <td>
                                                                                    <div>
                                                                                        <a class="btn btn-outline-primary p-1 m-0"
                                                                                            href=""><i
                                                                                                class="bi bi-pencil-square"></i></a>
                                                                                        <a class="btn btn-outline-danger p-1 m-0"
                                                                                            href=""><i
                                                                                                class="bi bi-trash3"></i></a>
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
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

    <script src="{{ asset('js/dashboard/events.js') }}"></script>

@endsection

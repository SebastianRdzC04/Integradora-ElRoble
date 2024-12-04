@php
    use Carbon\Carbon;

@endphp

@extends('layouts.dashboardAdmin')

@section('styles')

    <link rel="stylesheet" href="{{ asset('css/dashboard/events.css') }}">

@endsection

@section('title', 'Events')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="table-responsive ">
                    <table class="table shadow" id="event-table">
                        <thead>
                            <tr>
                                <th>Cliente</th>
                                <th>Lugar</th>
                                <th>T.Evento</th>
                                <th>Fecha</th>
                                <th>Horario</th>
                                <th>Estado</th>
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
                                    <td>{{ Carbon::parse($event->estimated_start_time)->format('h:iA')}} - {{ Carbon::parse($event->estimated_end_time)->format('h:iA') }}
                                    </td>
                                    <td>{{ $event->status }}</td>
                                    <td>{{ $event->total_price }}</td>
                                    <td>
                                        <select class="form-select" name="" id="">
                                            <option value="">Opciones</option>
                                            <option value="{{ route('dashboard.event.view', $event->id) }}">Ver Detalles
                                            </option>
                                            <option value="" data-bs-toggle="modal"
                                                data-bs-target="#modal{{ $event->id }}">Ver Servicios</option>
                                            <option value="">Eliminar</option>
                                        </select>
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
                                                                            <td> {{ $service->pivot->description }} </td>
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
    <script>
        const selects = document.querySelectorAll('.form-select');

        selects.forEach(select => {
            select.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const optionValue = selectedOption.value;

                if (optionValue && optionValue.includes('dashboard/event')) {
                    window.location.href = optionValue;
                    return;
                }

                if (selectedOption.value === 'editar') {

                }
                const modalId = selectedOption.getAttribute('data-bs-target');

                if (modalId) {
                    const modal = new bootstrap.Modal(document.querySelector(modalId));
                    modal.show();
                }

                // Resetear el select después de abrir el modal
                this.selectedIndex = 0;
            });
        });
    </script>

    <script src="{{ asset('js/dashboard/events.js') }}"></script>

@endsection

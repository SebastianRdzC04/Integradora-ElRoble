@extends('layouts.dashboardAdmin')

@section('styles')

    <link rel="stylesheet" href="{{ asset('css/dashboard/quotes.css') }}">

@endsection

@section('title', 'Quotes')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table shadow" id="quote-table">
                        <thead>
                            <tr>
                                <th>Cliente</th>
                                <th>Tipo de Evento</th>
                                <th>Lugar</th>
                                <th>__Fecha__</th>
                                <th>Horario</th>
                                <th>Paquete</th>
                                <th>Estado</th>
                                <th>No.Personas</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($quotes as $quote)
                                <tr>
                                    @if ($quote->owner_name)
                                        <td> {{ $quote->owner_name }} </td>
                                    @else
                                        <td> {{ $quote->user ? $quote->user->person->first_name : $quote->owner_name }}
                                        </td>
                                    @endif
                                    <td> {{ $quote->type_event }} </td>
                                    <td> {{ $quote->package ? $quote->package->place->name : $quote->place->name }} </td>
                                    <td class="text-start"> {{ $quote->date }} </td>
                                    <td> {{ date('h:ia', strtotime($quote->start_time)) }}
                                        {{ date('h:ia', strtotime($quote->end_time)) }} </td>
                                    <td> {{ $quote->package ? $quote->package->name : 'Sin paquete' }} </td>
                                    <td> {{ $quote->status }} </td>
                                    <td> {{ $quote->guest_count }} </td>
                                    </td>
                                    <td>
                                        <select class="form-select" name="" id="">
                                            <option value="">Opciones</option>
                                            @if ($quote->status == 'pendiente' || $quote->status == 'pendiente cotizacion')
                                                <option value="{{ route('dashboard.quote', $quote->id) }}">Ver Detalles
                                                </option>
                                            @endif
                                            <option data-bs-toggle="modal" data-bs-target="#modal{{ $quote->id }}"
                                                value="">Ver Servicios</option>
                                            <option value="">Eliminar</option>
                                        </select>
                                        <div class="">
                                            <div class="modal fade" id="modal{{ $quote->id }}" tabindex="-1"
                                                aria-labelledby="modalLabel{{ $quote->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modalLabel{{ $quote->id }}">
                                                                Detalles del Cotizacion</h5>
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
                                                                    @if ($quote->services)
                                                                        @foreach ($quote->services as $service)
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
                                                                    @if ($quote->package)
                                                                        @foreach ($quote->package->services as $service)
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
    <script>
        const selects = document.querySelectorAll('.form-select');

        selects.forEach(select => {
            select.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const optionValue = selectedOption.value;

                if (optionValue && optionValue.includes('dashboard/quotes')) {
                    window.location.href = optionValue;
                    return;
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

    <script src="{{ asset('js/dashboard/quotes.js') }}"></script>

@endsection

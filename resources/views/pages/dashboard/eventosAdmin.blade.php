@php
    use Carbon\Carbon;

    $timeToStart = '00:00:00';
    if ($event) {
        $timeToStart = Carbon::now()->diff(Carbon::parse($event->estimated_start_time));
    }

    $data = session('consumible');

    $data2 = session('stock');

@endphp

@extends('layouts.dashboardAdmin')

@section('title', 'Evento')

@section('content')
    <aside>
        <a href="{{ route('dashboard.events') }}" class="btn btn-primary">Ir a Eventos</a>
    </aside>
    <main>
        <div class="container mt-4">
            <div class="row justify-content-center">
                <div class="col-5 border shadow">
                    <div class="d-flex">
                        <div>
                            <h4>{{ $event->quote->type_event }} para
                                {{ $event->quote->owner_name ? $event->quote->owner_name : $event->quote->user->person->first_name }}
                            </h4>
                        </div>
                        <div class="ms-auto">
                            <select class="ms-auto form-select" name="" id="">
                                <option value="">Opciones</option>
                                @if ($event->status == 'En espera')
                                    <option data-bs-toggle="modal" data-bs-target="#startEvent" value="">Comenzar
                                        evento
                                    </option>
                                @endif
                                @if ($event->status == 'En proceso')
                                    <option data-bs-toggle="modal" data-bs-target="#endEvent" value="">Terminar
                                        evento
                                    </option>
                                @endif
                                <option data-bs-toggle="modal" data-bs-target="#modal1" value="">Ver Servicios
                                </option>
                                <option data-bs-toggle="modal" data-bs-target="#modal2" value="">Ver Consumibles
                                </option>
                                <option value="">Incidencias</option>
                            </select>
                            <div class="modal fade" id="endEvent">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3>Terminar Evento</h3>
                                        </div>
                                        <div class="modal-body">
                                            <p>Estas seguro de terminar el evento?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <form action="{{ route('dashboard.end.event', $event->id) }}" method="POST">
                                                @csrf
                                                <button class="btn btn-primary">Terminar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="startEvent">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3>Comenzar Evento</h3>
                                        </div>
                                        <div class="modal-body">
                                            <p>Listo para comenzar el evento?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-primary">Comenzar</button>
                                            <form action="{{ route('dashboard.start.event', $event->id) }}" method="POST">
                                                @csrf
                                                <button class="btn btn-primary">Empezar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="modal2" aria-labelledby="modalLabel2" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4>Consumibles incluidos</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <h3>Consumibles</h3>
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Nombre</th>
                                                        <th>Cantidad</th>
                                                        <th>Estado</th>
                                                        @if ($event->status == 'Pendiente' || $event->status == 'En espera' || $event->status == 'En proceso')
                                                            <th class="text-center">Acciones</th>
                                                        @endif
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($event->consumables as $consumable)
                                                        <tr>
                                                            <td> {{ $consumable->name }} </td>
                                                            <td> {{ $consumable->pivot->quantity }}{{ $consumable->unit }}
                                                            </td>
                                                            <td>
                                                                <p style="display: {{ $consumable->pivot->ready ? 'block' : 'none' }}"
                                                                    class="estadoL">Listo</p>
                                                                <p style="display: {{ !$consumable->pivot->ready ? 'block' : 'none' }}"
                                                                    class="estadoNL">No listo</p>
                                                            </td>
                                                            @if ($event->status == 'Pendiente' || $event->status == 'En espera' || $event->status == 'En proceso')
                                                                <td class="text-center">
                                                                    <div class="d-flex justify-content-center">
                                                                        @if ($event->status == 'Pendiente' || $event->status == 'En espera')
                                                                            <form
                                                                                action="{{ route('dashboard.event.consumable', $consumable->pivot->id) }}"
                                                                                method="POST"
                                                                                onsubmit="updateStatus(this); return false;">
                                                                                @csrf
                                                                                <button
                                                                                    class="btn btn-outline-{{ $consumable->pivot->ready ? 'danger' : 'success' }} py-0 px-1"
                                                                                    type="submit">
                                                                                    <i style="display: {{ $consumable->pivot->ready ? 'block' : 'none' }}"
                                                                                        class="fs-4 bi bi-x-circle-fill listo seleccionado"></i>
                                                                                    <i style="display: {{ !$consumable->pivot->ready ? 'block' : 'none' }}"
                                                                                        class="fs-4 bi bi-check-circle-fill no-listo no-seleccionado"></i>
                                                                                </button>
                                                                            </form>
                                                                        @endif
                                                                        <button class="btn btn-outline-danger py-0 px-2"><i
                                                                                class="bi bi-trash3"></i></button>
                                                                    </div>
                                                                </td>
                                                            @endif
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="modal1" aria-labelledby="modalLabel1" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4>Servicios Incluidos</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
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
                                                        @if ($event->quote->package)
                                                            @foreach ($event->quote->package->services as $service)
                                                                <tr>
                                                                    <td> {{ $service->name }} </td>
                                                                    <td> {{ $service->pivot->description }} </td>
                                                                    <td> {{ $service->pivot->price }} </td>
                                                                    <td> {{ $service->pivot->cost }} </td>
                                                                    
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                        @if ($event->quote->services)
                                                            @foreach ($event->quote->services as $service)
                                                                <tr>
                                                                    <td> {{ $service->name }} </td>
                                                                    <td> {{ $service->pivot->description }} </td>
                                                                    <td> {{ $service->pivot->price }} </td>
                                                                    <td> {{ $service->pivot->cost }} </td>
                                                                
                                                                </tr>
                                                                <div class="modal fade" id="modal{{ $service->pivot->id }}"
                                                                    aria-labelledby="modalLabel{{ $service->pivot->id }}"
                                                                    aria-hidden="true">
                                                                    <div
                                                                        class="modal-dialog modal-lg modal-dialog-centered">
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
                                                                                                type="number"
                                                                                                name="cantidad"
                                                                                                value="0">
                                                                                        </div>
                                                                                        <div class="mb-3">
                                                                                            <label class="form-label"
                                                                                                for="precio">Cuanto Vas
                                                                                                a
                                                                                                cobrar?</label>
                                                                                            <input class="form-control"
                                                                                                type="number"
                                                                                                name="precio">
                                                                                        </div>
                                                                                        <div class=" mb-3">
                                                                                            <label class="form-label"
                                                                                                for="costo">Cuanto te
                                                                                                cuesta a
                                                                                                ti? </label>
                                                                                            <input class="form-control"
                                                                                                type="number"
                                                                                                name="costo">
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

                    </div>

                    <div class="d-flex justify-content-between">
                        <div>
                            <p>Lugar:
                                {{ $event->quote->place ? $event->quote->place->name : $event->quote->package->place->name }}
                            </p>
                        </div>
                        @if ($event->status == 'En espera')
                            <div>
                                @if (Carbon::now()->lessThan(Carbon::parse($event->estimated_start_time)))
                                    @if ($timeToStart->h > 1)
                                        <p class="text-end"> Faltan {{ $timeToStart->h }} horas </p>
                                    @elseif ($timeToStart->h == 1)
                                        <p class="text-end"> Falta {{ $timeToStart->h }} hora y
                                            {{ $timeToStart->i }}
                                            minutos </p>
                                    @else
                                        <p class="text-end"> Faltan {{ $timeToStart->i }} minutos </p>
                                    @endif
                                @else
                                    <p class="text-end"> ya paso la hora carnal</p>
                                @endif
                            </div>
                        @endif
                        @if ($event->status == 'Pendiente')
                            <div>
                                <p>Fecha: {{ Carbon::parse($event->date)->format('d/m/Y') }} </p>
                            </div>
                        @endif
                    </div>
                    <div>
                        <div style="width: 140px">
                            <div class="d-flex">
                                <p> Sillas:</p>
                                <p class="ms-auto"> {{ $event->chair_count }}
                                    @if ($event->status == 'Pendiente' || $event->status == 'En espera')
                                        <a data-bs-toggle="modal" data-bs-target="#modalSillas" href=""><i
                                                class="bi bi-pencil-fill"></i>
                                        </a>
                                    @endif
                                </p>
                            </div>
                            <div class="modal fade" id="modalSillas">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3>Sillas</h3>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('dashboard.event.chairs', $event->id) }}"
                                                method="POST">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="sillas" class="form-label">Cantidad de sillas</label>
                                                    <input type="number" class="form-control" id="sillas"
                                                        name="sillas" value="{{ $event->chair_count }}">
                                                </div>
                                                <button type="submit" class="btn btn-primary">Guardar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex">
                                <p> Mesas:</p>
                                <p class="ms-auto"> {{ $event->table_count }}
                                    @if ($event->status == 'Pendiente' || $event->status == 'En espera')
                                        <i data-bs-toggle="modal" data-bs-target="#modalMesas"
                                            class="bi bi-pencil-fill"></i>
                                    @endif
                                </p>
                            </div>
                            <div class="modal fade" id="modalMesas">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3>Mesas</h3>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('dashboard.event.tables', $event->id) }}"
                                                method="POST">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="mesas" class="form-label">Cantidad de mesas</label>
                                                    <input type="number" class="form-control" id="mesas"
                                                        name="mesas" value="{{ $event->table_count }}">
                                                </div>
                                                <button type="submit" class="btn btn-primary">Guardar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex">
                                <p> Manteles:</p>
                                <p class="ms-auto">{{ $event->table_cloth_count }}
                                    @if ($event->status == 'Pendiente' || $event->status == 'En espera')
                                        <i data-bs-toggle="modal" data-bs-target="#modalMantel"
                                            class="bi bi-pencil-fill"></i>
                                    @endif
                                </p>
                            </div>
                            <div class="modal fade" id="modalMantel">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3>Manteles</h3>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('dashboard.event.tablecloths', $event->id) }}"
                                                method="POST">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="manteles" class="form-label">Cantidad de manteles</label>
                                                    <input type="number" class="form-control" id="manteles"
                                                        name="manteles" value="{{ $event->table_cloth_count }}">
                                                </div>
                                                <button type="submit" class="btn btn-primary">Guardar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if ($event->status == 'Pendiente')
                            <p>Se espera que empiece a las
                                {{ Carbon::parse($event->estimated_start_time)->format('h:i A') }} </p>
                            <p>Se espera que termine a las
                                {{ Carbon::parse($event->estimated_end_time)->format('h:i A') }}
                            </p>
                        @endif
                        @if ($event->status == 'Finalizado')
                            <p>Empezo a las {{ Carbon::parse($event->start_time)->format('h:i A') }} </p>
                            <p>Termino a las {{ Carbon::parse($event->end_time)->format('h:i A') }} </p>
                        @endif
                        @if ($event->status == 'En espera')
                            <p>Se espera que empiece a las
                                {{ Carbon::parse($event->estimated_start_time)->format('h:i A') }} </p>
                            <p>Se espera que termine a las
                                {{ Carbon::parse($event->estimated_end_time)->format('h:i A') }}
                            </p>
                        @endif
                        @if ($event->status == 'En proceso')
                            <p>Empezo a las {{ Carbon::parse($event->start_time)->format('h:i A') }} </p>
                            <p>Se espera que termine a las
                                {{ Carbon::parse($event->estimated_end_time)->format('h:i A') }}
                            </p>
                        @endif
                    </div>
                    <div>
                        <p>Precio del evento: {{ $event->total_price }} </p>
                        <p>Anticipo: {{ $event->advance_payment }} </p>
                        @if ($event->status != 'Finalizado')
                            <p>Monto Faltante: {{ $event->remaining_payment }} </p>
                            <p>Precio por hora extra:
                                {{ $event->extra_hour_price == 0 ? 'Sin definir' : '$' . $event->extra_hour_price }}
                                @if ($event->status == 'Pendiente' || $event->status == 'En espera' || $event->status == 'En proceso')
                                    <i data-bs-toggle="modal" data-bs-target="#modalHx" class="bi bi-pencil-fill"></i>
                                @endif
                            </p>
                            <div class="modal fade" id="modalHx">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3>Precio por hora extra</h3>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('dashboard.event.extra.hour.price', $event->id) }}"
                                                method="POST">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="hx" class="form-label">Precio por hora extra</label>
                                                    <input type="number" class="form-control" id="precio"
                                                        name="precio" value="{{ $event->extra_hour_price }}">
                                                </div>
                                                <button type="submit" class="btn btn-primary">Guardar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="mb-3 d-flex justify-content-between gap-1">
                            @if ($event->status == 'En proceso')
                                <form action="{{ route('dashboard.end.event', $event->id) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-primary">Terminar</button>
                                </form>
                            @endif
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#modal1">Servicios</button>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#modal2">Consumibles</button>
                            <a href="{{ route('incident.create') }}" class="btn btn-primary">Incidencia</a>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection

@section('scripts')
    @if ($data || $data2)
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var modal = new bootstrap.Modal(document.getElementById('modal2'));
                modal.show();
            });
        </script>
    @endif
    <script>
        const selects = document.querySelectorAll('.form-select');

        selects.forEach(select => {
            select.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
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
    <script>
        function updateStatus(form) {
            event.preventDefault();
            let currentRow = form.closest('tr');
            let estadoListo = currentRow.querySelector('.estadoL');
            let estadoNoListo = currentRow.querySelector('.estadoNL');
            let botonForm = currentRow.querySelector('button[type="submit"]');
            let iconoListo = botonForm.querySelector('.listo');
            let iconoNoListo = botonForm.querySelector('.no-listo');
            /*
            if (iconoListo.style.display === 'none') {
                iconoListo.style.display = 'block';
                iconoNoListo.style.display = 'none';
                botonForm.classList.remove('btn-outline-success');
                botonForm.classList.add('btn-outline-danger')
            } else {
                botonForm.classList.remove('btn-outline-danger');
                botonForm.classList.add('btn-outline-success')
                iconoListo.style.display = 'none';
                iconoNoListo.style.display = 'block';
            }

            if (estadoListo.style.display === 'none') {
                estadoListo.style.display = 'block';
                estadoNoListo.style.display = 'none';
            } else {
                estadoListo.style.display = 'none';
                estadoNoListo.style.display = 'block';
            }
            */
            $.post($(form).attr('action'), $(form).serialize(), function(respuesta) {
                if (respuesta.status === 'success') {
                    estadoListo.style.display = estadoListo.style.display === 'none' ? 'block' : 'none';
                    estadoNoListo.style.display = estadoNoListo.style.display === 'block' ? 'none' : 'block';
                    iconoListo.style.display = iconoListo.style.display === 'none' ? 'block' : 'none';
                    iconoNoListo.style.display = iconoNoListo.style.display === 'block' ? 'none' : 'block';
                    botonForm.classList.toggle('btn-outline-danger');
                    botonForm.classList.toggle('btn-outline-success');
                }
            });
        }
    </script>
@endsection

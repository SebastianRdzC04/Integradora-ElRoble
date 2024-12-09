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
        <div class="container mt-2">
            <div class="row justify-content-center">
                <div class="col-5 border shadow">
                    <div class="d-flex">
                        <div>
                            <h4>{{ $event->quote->type_event }} para
                                {{ $event->quote->owner_name ? $event->quote->owner_name : $event->quote->user->person->first_name }}
                            </h4>
                        </div>
                        <div class="ms-auto">
                            <select class="ms-auto form-select alv" name="" id="">
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
                                @if ($event->status == 'En proceso')
                                    <option value="{{ route('incident.create') }}">Incidencia</option>
                                @endif
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
                                            <button data-bs-toggle="modal" data-bs-target="#modalAggCons" type="button"
                                                class="btn btn-primary ms-auto">Agregar</button>
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
                                                        @if ($event->status == 'Pendiente' || $event->status == 'En espera')
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
                                                            @if ($event->status == 'Pendiente' || $event->status == 'En espera')
                                                                <td class="text-start" style="width: 150px">
                                                                    <div class="d-inline-flex justify-content-center">
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


                                                                        <button
                                                                            class="btn btn-outline-danger eliminar py-0 px-2"><i
                                                                                class="bi bi-trash3"></i></button>

                                                                        <button style="display: none"
                                                                            class="btn btn-outline-warning arrepentir py-0 px-2"><i
                                                                                class="bi bi-x-circle"></i></button>

                                                                        <form
                                                                            action="{{ route('dashboard.consumable.event.delete', $consumable->pivot->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <button style="display: none"
                                                                                class="btn btn-outline-primary confirmar px-2"><i
                                                                                    class="bi bi-check2"></i></button>
                                                                        </form>


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
                                                            @if ($event->status == 'Pendiente' || $event->status == 'En espera')
                                                                <th>Acciones</th>
                                                            @endif
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
                                                                    @if ($event->status == 'Pendiente' || $event->status == 'En espera')
                                                                        <td>
                                                                            <p>Servicios incluidos con paquete</p>
                                                                        </td>
                                                                    @endif
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                        @if ($event->quote->services)
                                                            @foreach ($event->quote->services as $service)
                                                                <tr>
                                                                    <td> {{ $service->name }} </td>
                                                                    <td> {{ $service->pivot->description }} </td>
                                                                    <td> {{ $service->pivot->price }} </td>
                                                                    <td> {{ $service->pivot->coast }} </td>
                                                                    @if ($event->status == 'Pendiente' || $event->status == 'En espera')
                                                                        <td>
                                                                            <select name="" id=""
                                                                                class="form-select alv">
                                                                                <option value="">
                                                                                    opciones</option>
                                                                                <option data-bs-toggle="modal"
                                                                                    data-bs-target="#modalEditS{{ $service->pivot->id }}"
                                                                                    value="">Editar</option>
                                                                                <option data-bs-toggle="modal"
                                                                                    data-bs-target="#deleteService{{ $service->pivot->id }}"
                                                                                    value="">Eliminar</option>
                                                                            </select>
                                                                        </td>
                                                                    @endif

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

                    </div>
                    @foreach ($event->quote->services as $service)
                        <div class="modal fade" id="modalEditS{{ $service->pivot->id }}"
                            aria-labelledby="modalLabel{{ $service->pivot->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">

                                    </div>
                                    <div class="modal-body">
                                        <h3>{{ $service->name }}</h3>
                                        <div>
                                            <form method="POST"
                                                action="{{ route('dashboard.quote.status', $service->pivot->id) }}">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="cantidad" class="form-label">Cantidad</label>
                                                    <input class="form-control" type="number" name="cantidad"
                                                        value="{{ $service->pivot->quantity }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="precio">Cuanto Vas
                                                        a
                                                        cobrar?</label>
                                                    <input class="form-control" type="number" name="precio"
                                                        value="{{ $service->pivot->price }}">
                                                </div>
                                                <div class=" mb-3">
                                                    <label class="form-label" for="costo">Cuanto te
                                                        cuesta a
                                                        ti? </label>
                                                    <input class="form-control" type="number" name="costo"
                                                        value="{{ $service->pivot->coast }}">
                                                </div>
                                                <div class="mb-3">
                                                    <button class="btn btn-primary">Enviar</button>
                                                </div>

                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal fade" id="deleteService{{ $service->pivot->id }}"
                            aria-labelledby="papa{{ $service->pivot->id }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3>Eliminar Servicio</h3>
                                    </div>
                                    <div class="modal-body">
                                        <p>Estas seguro de eliminar
                                            {{ $service->name }} del evento?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-danger">Eliminar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="modal fade" id="modalAggCons" aria-hidden="true"
                        aria-labelledby="modalLabel{{ $service->pivot->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3>Hola que rollo</h3>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('dashboard.event.consumable.add', $event->id) }}"
                                        method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="consumible" class="form-label">Consumible</label>
                                            <select name="consumible" id="consumible" class="form-select">
                                                <option value="">Selecciona un consumible</option>
                                                @foreach ($consumables as $consumable)
                                                    @if ($event->consumables->contains($consumable))
                                                        @continue
                                                    @endif
                                                    <option value="{{ $consumable->id }}">{{ $consumable->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="cantidad" class="form-label">Cantidad</label>
                                            <input type="number" class="form-control" name="cantidad">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Agregar</button>
                                    </form>
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
                                <p><i data-bs-toggle="modal" data-bs-target="#editarFecha"
                                        class="text-end bi bi-pencil"></i>Fecha:
                                    {{ Carbon::parse($event->date)->format('d/m/Y') }} </p>
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
                        @if ($event->status == 'Pendiente' || $event->status == 'En espera')
                            <p>Horario estimado: {{ Carbon::parse($event->estimated_start_time)->format('h:i A') }} -
                                {{ Carbon::parse($event->estimated_end_time)->format('h:i A') }} <i data-bs-toggle="modal"
                                    data-bs-target="#horarioModal" class="text-end bi bi-pencil"></i>
                            </p>
                        @endif
                        @if ($event->status == 'Finalizado')
                            <p>Empezo a las {{ Carbon::parse($event->start_time)->format('h:i A') }} </p>
                            <p>Termino a las {{ Carbon::parse($event->end_time)->format('h:i A') }} </p>
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
                        <div class="mb-3 d-flex justify-content-end">
                            @if ($event->status == 'En proceso')
                                <button data-bs-toggle="modal" data-bs-target="#endEvent"
                                    class="btn btn-primary">Terminar</button>
                            @endif
                        </div>


                    </div>
                    <div class="modal fade" id="editarFecha">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3>Editar Fecha</h3>
                                </div>
                                <div class="modal-body">
                                    <form action="" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="fecha" class="form-label">Fecha</label>
                                            <input type="date" class="form-control" id="fecha" name="fecha">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                    </form>
                                </div>
                            </div>
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


    @if ($errors->any())
        <script>
            $(document).ready(function() {
                @foreach ($errors->all() as $error)
                    toastr.error('{{ $error }}');
                @endforeach

                // Reabrir el modal si hay errores
                var modal = new bootstrap.Modal(document.getElementById('modalAggCons'));
                modal.show();
            });
        </script>
    @endif

    @if (session('success'))
        <script>
            $(document).ready(function() {
                toastr.success('{{ session('success') }}');
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            $(document).ready(function() {
                toastr.error('{{ session('error') }}');
            });
        </script>
    @endif

    <script>
        const selects = document.querySelectorAll('.alv');

        selects.forEach(select => {
            select.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const optionValue = selectedOption.value;
                if (optionValue && optionValue.includes('/incident')) {
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
    <script>
        let eliminarBtns = document.querySelectorAll('.eliminar');
        eliminarBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                let currentRow = this.closest('tr');
                let confirmarBtn = currentRow.querySelector('.confirmar');
                let arrepentirBtn = currentRow.querySelector('.arrepentir');
                this.style.display = 'none';
                arrepentirBtn.style.display = 'block';
                confirmarBtn.style.display = 'block';
                confirmarBtn.addEventListener('click', function() {
                    let form = currentRow.querySelector('form');
                    form.submit();
                });
                arrepentirBtn.addEventListener('click', function() {
                    this.style.display = 'none';
                    confirmarBtn.style.display = 'none';
                    currentRow.querySelector('.eliminar').style.display = 'block';
                });

            });
        });

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
                    toastr.success('Estado actualizado correctamente');
                } else {
                    toastr.error('No tienes suficiente stock para marcar este consumible como listo');
                }
            });
        }
    </script>
@endsection

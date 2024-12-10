@php
    use Carbon\Carbon;
    Carbon::setLocale('es');
@endphp

@extends('layouts.dashboardAdmin')

@section('styles')

    <link rel="stylesheet" href="{{ asset('css/dashboard/packages.css') }}">
@endsection

@section('title', 'Packages')

@section('content')


    <div class="container">
        <div class="row">
            <div class="col-12 d-flex justify-content-end">
                <a href="{{ route('dashboard.crear.paquetes') }}" class="text-end btn btn-primary">Crear Paquete</a>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="table-responsive pack-table">
                    <table class="table shadow" id="tabla-paquetes">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Estado</th>
                                <th>Duracion</th>
                                <th>Costo</th>
                                <th>Lugar</th>
                                <th>Servicios</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($packages as $package)
                                <tr class="parent-row">
                                    <td>{{ $package->name }}</td>
                                    <td>{{ $package->is_active ? 'Activo' : 'Inactivo' }}</td>
                                    <td>{{ Carbon::parse($package->start_date)->format('d-m-Y') }} ->
                                        {{ Carbon::parse($package->end_date)->format('d-m-Y') }} </td>
                                    <td class="text-center">${{ $package->price }}</td>
                                    <td>{{ $package->place->name }}</td>
                                    <td class="text-center">
                                        {{ $package->services->count() }}
                                    </td>
                                    <td>
                                        <div>
                                            <select class="form-select alv" name="" id="">
                                                <option value="">Selecciona una opcion</option>
                                                <option data-bs-toggle="modal"
                                                    data-bs-target="#editarPack{{ $package->id }}" value="1">Editar
                                                </option>
                                                <option data-bs-toggle="modal" data-bs-target="#modal{{ $package->id }}"
                                                    value="2">Ver servicios</option>
                                                <option data-bs-toggle="modal"
                                                    data-bs-target="#agregarServicio{{ $package->id }}" value="">
                                                    Agregar Servicio</option>
                                                <option value="">Cambiar estado</option>
                                                <option data-bs-toggle="modal"
                                                    data-bs-target="#eliminarPack{{ $package->id }}" value="">
                                                    Eliminar</option>
                                            </select>

                                            <div class="modal fade" id="agregarServicio{{ $package->id }}">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">

                                                        </div>
                                                        <div class="modal-body">
                                                            <form
                                                                action="{{ route('dashboard.package.add.service', $package->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                <div class="mb-3">
                                                                    <label for="servicio">Servicio</label>
                                                                    <select name="servicio" class="form-select"
                                                                        id="">
                                                                        <option value="">Selecciona un Servico
                                                                        </option>
                                                                        @foreach ($services as $service)
                                                                            @if (!$package->services->contains($service->id))
                                                                                <option value="{{ $service->id }}">
                                                                                    {{ $service->name }}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="cantidad">Cantidad</label>
                                                                    <input type="number" class="form-control"
                                                                        name="cantidad">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="precio">Precio</label>
                                                                    <input type="number" class="form-control"
                                                                        name="precio">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="costo">Costo</label>
                                                                    <input type="number" class="form-control"
                                                                        name="costo">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="descripcion">Descripcion</label>
                                                                    <textarea name="descripcion" id="" cols="30" rows="7" class="form-control"></textarea>
                                                                </div>
                                                                <div class="mb-3 d-flex justify-content-end">
                                                                    <button class="btn btn-primary">Enviar</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal fade" id="eliminarPack{{ $package->id }}">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4>Eliminar Paquete</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Seguro de eliminar el paquete?</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="btn btn-danger">Eliminar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal fade" id="editarPack{{ $package->id }}">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4>Editar Paquete</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form
                                                                action="{{ route('dashboard.edit.package', $package->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                <div class="mb-3">
                                                                    <label for="lugar">Lugar</label>
                                                                    <select name="lugar" class="form-select"
                                                                        id="">
                                                                        @foreach ($places as $place)
                                                                            <option value="{{ $place->id }}"
                                                                                {{ $place->id == $package->place_id ? 'selected' : '' }}>
                                                                                {{ $place->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="nombre" class="form-label">Nombre</label>
                                                                    <input type="text" class="form-control"
                                                                        name="nombre" value="{{ $package->name }}">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="precio"
                                                                        class="form-label">Precio</label>
                                                                    <input type="number" class="form-control"
                                                                        name="precio" value="{{ $package->price }}">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="afore">Maximo de Personas</label>
                                                                    <input type="number" class="form-control"
                                                                        name="afore"
                                                                        value="{{ $package->max_people }}">
                                                                </div>
                                                                <div class="mb-3 d-flex">
                                                                    <div class="col-6">
                                                                        <label for="fechaInicio" class="form-label">Fecha
                                                                            de
                                                                            Inicio</label>
                                                                        <input type="date" class="form-control"
                                                                            name="fechaInicio"
                                                                            value="{{ \Carbon\Carbon::parse($package->start_date)->format('Y-m-d') }}">
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label for="fechaFin" class="form-label">Fecha de
                                                                            Fin</label>
                                                                        <input type="date" class="form-control"
                                                                            name="fechaFin"
                                                                            value="{{ \Carbon\Carbon::parse($package->end_date)->format('Y-m-d') }}">
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="descripcion"
                                                                        class="form-label">Descripcion</label>
                                                                    <textarea name="descripcion" id="" cols="30" rows="7" class="form-control">{{ $package->description }}</textarea>
                                                                </div>
                                                                <div class="mb-3 d-flex justify-content-end">
                                                                    <button class="btn btn-primary">Enviar</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Modal Structure -->
                                            <div class="modal fade" id="modal{{ $package->id }}" tabindex="-1"
                                                aria-labelledby="modalLabel{{ $package->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-xl">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modalLabel{{ $package->id }}">
                                                                Servicios Incluidos</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Nombre</th>
                                                                        <th>Descripcion</th>
                                                                        <th>Cantidad</th>
                                                                        <th>Precio</th>
                                                                        <th>Costo</th>
                                                                        <th>Detalles</th>
                                                                        <th>Acciones</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($package->services as $service)
                                                                        <tr>
                                                                            <td> {{ $service->name }} </td>
                                                                            <td> {{ $service->description }} </td>
                                                                            <td> {{ $service->pivot->quantity }} </td>
                                                                            <td>{{$service->pivot->price}}</td>
                                                                            <td> {{ $service->pivot->coast }} </td>
                                                                            <td> {{ $service->pivot->description }}
                                                                            </td>
                                                                            <td>
                                                                                <div>
                                                                                    <select name="" id=""
                                                                                        class="form-select">
                                                                                        <option value="">Selecciona
                                                                                            una
                                                                                            opcion</option>
                                                                                        <option value="editar">Editar
                                                                                        </option>
                                                                                        <option value="eliminar">Eliminar
                                                                                        </option>
                                                                                    </select>
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
        const selects = document.querySelectorAll('.alv');

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
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <script>
                toastr.error("{{ $error }}");
            </script>
        @endforeach
    @endif

    @if (session('success'))
        <script>
            toastr.success("{{ session('success') }}");
        </script>
    @endif

    @if (session('error'))
        <script>
            toastr.error("{{ session('error') }}");
        </script>
    @endif

    <script src="{{ asset('js/dashboard/packages.js') }}"></script>

@endsection

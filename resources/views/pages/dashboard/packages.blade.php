@extends('layouts.dashboardAdmin')

@section('styles')

    <link rel="stylesheet" href="{{ asset('css/dashboard/packages.css') }}">
@endsection

@section('title', 'Packages')

@section('content')

    <div class="container">
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
                                    <td>{{ $package->status }}</td>
                                    <td>{{ $package->start_date }} - {{ $package->end_date }} </td>
                                    <td>{{ $package->price }}</td>
                                    <td>{{ $package->place->name }}</td>
                                    <td class="text-center">
                                        {{ $package->services->count() }}
                                    </td>
                                    <td>
                                        <div>
                                            <a class="btn btn-outline-primary p-1 m-0" href=""><i
                                                    class="bi bi-pencil-square"></i></a>
                                            <a class="btn btn-outline-danger p-1 m-0" href=""><i
                                                    class="bi bi-trash3"></i></a>
                                            <button type="button" class="btn btn-outline-primary p-1 m-0"
                                                data-bs-toggle="modal" data-bs-target="#modal{{ $package->id }}">
                                                <i class="bi bi-three-dots"></i>
                                            </button>

                                            <!-- Modal Structure -->
                                            <div class="modal fade" id="modal{{ $package->id }}" tabindex="-1"
                                                aria-labelledby="modalLabel{{ $package->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modalLabel{{ $package->id }}">
                                                                Detalles del {{ $package->name }}</h5>
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
                                                                    @foreach ($package->services as $service)
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
    <script src="{{ asset('js/dashboard/packages.js') }}"></script>

@endsection

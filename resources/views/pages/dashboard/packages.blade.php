@extends('layouts.dashboardAdmin')

@section('styles')

    <link rel="stylesheet" href="{{ asset('css/dashboard/packages.css') }}">
@endsection

@section('title', 'Packages')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-10">
                <div class="table">
                    <h2> Paquetes </h2>
                    <div class="table-responsive pack-table">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th></th>
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
                                    <tr>
                                        <td><svg xmlns="http://www.w3.org/2000/svg" data-bs-toggle="collapse"
                                                data-bs-target="#package{{ $package->id }}" width="1em" height="1em"
                                                viewBox="0 0 24 24">
                                                <path fill="none" stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="1.5"
                                                    d="M13.5 4.5a1.5 1.5 0 1 0-3 0a1.5 1.5 0 0 0 3 0m0 7.5a1.5 1.5 0 1 0-3 0a1.5 1.5 0 0 0 3 0m0 7.5a1.5 1.5 0 1 0-3 0a1.5 1.5 0 0 0 3 0"
                                                    color="currentColor" />
                                            </svg></td>
                                        <td>{{ $package->name }}</td>
                                        <td>{{ $package->status }}</td>
                                        <td>{{ $package->start_date }} - {{ $package->end_date }} </td>
                                        <td>{{ $package->price }}</td>
                                        <td>{{ $package->place->name }}</td>
                                        <td class="d-flex justify-content-between" aria-expanded="false"
                                            aria-controls="package{{ $package->id }}">
                                            {{ $package->services->count() }}
                                        </td>
                                        <td>
                                            <div>
                                                <a class="btn btn-outline-primary p-1 m-0 d-inline-flex align-items-center justify-content-center"
                                                    href=""><svg xmlns="http://www.w3.org/2000/svg" width="20px"
                                                        height="20px" viewBox="0 0 24 24">
                                                        <path fill="currentColor"
                                                            d="M5 3c-1.11 0-2 .89-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7h-2v7H5V5h7V3zm12.78 1a.7.7 0 0 0-.48.2l-1.22 1.21l2.5 2.5L19.8 6.7c.26-.26.26-.7 0-.95L18.25 4.2c-.13-.13-.3-.2-.47-.2m-2.41 2.12L8 13.5V16h2.5l7.37-7.38z" />
                                                    </svg></a>
                                                <a class="btn btn-outline-danger p-1 m-0 d-inline-flex align-items-center justify-content-center"
                                                    href=""><svg xmlns="http://www.w3.org/2000/svg" width="20px"
                                                        height="20px" viewBox="0 0 24 24">
                                                        <path fill="currentColor" fill-rule="evenodd"
                                                            d="m18.412 6.5l-.801 13.617A2 2 0 0 1 15.614 22H8.386a2 2 0 0 1-1.997-1.883L5.59 6.5H3.5v-1A.5.5 0 0 1 4 5h16a.5.5 0 0 1 .5.5v1zM10 2.5h4a.5.5 0 0 1 .5.5v1h-5V3a.5.5 0 0 1 .5-.5M9 9l.5 9H11l-.4-9zm4.5 0l-.5 9h1.5l.5-9z" />
                                                    </svg></a>
                                            </div>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td colspan="8" class="p-0">
                                            <div class="collapse tabla-pivote pb-3" id="package{{ $package->id }}">
                                                <h6 class="text-center">Servicios Inlcuidos</h6>
                                                <table class="table table-sm mb-0 border">
                                                    <thead>
                                                        <tr>
                                                            <th>Nombre</th>
                                                            <th>Precio</th>
                                                            <th>Cantidad</th>
                                                            <th>Detalles</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($package->services as $service)
                                                            <tr>
                                                                <td>{{ $service->name }}</td>
                                                                <td>{{ $service->pivot->price }}</td>
                                                                <td>{{ $service->pivot->quantity }}</td>
                                                                <td> {{ $service->pivot->description }} </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                    <div>
                        <h4>Aqui va la paginacion</h4>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{ asset('js/packages.js') }}"></script>

@endsection

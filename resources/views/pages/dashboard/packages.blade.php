@extends('layouts.dashboardAdmin')

@section('styles')
    
        <link rel="stylesheet" href="{{ asset('css/dashboard/packages.css') }}">
@endsection

@section('title', 'Packages')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-7">
                <div class="table">
                    <h2> Paquetes </h2>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Estado</th>
                                <th>Duracion</th>
                                <th>Costo</th>
                                <th>Lugar</th>
                                <th>No.Servicios</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($packages as $package)
                                <tr>
                                    <td>{{ $package->name }}</td>
                                    <td>{{ $package->status }}</td>
                                    <td>{{ $package->start_date }} - {{ $package->end_date }} </td>
                                    <td>{{ $package->price }}</td>
                                    <td>{{ $package->place->name }}</td>
                                    <td data-bs-toggle="collapse" data-bs-target="#package{{ $package->id }}"
                                        aria-expanded="false" aria-controls="package{{ $package->id }}">
                                        {{ $package->services->count() }}</td>
                                </tr>
                                <tr>
                                    <td colspan="6" class="p-0">
                                        <div class="collapse tabla-pivote pb-3" id="package{{ $package->id }}">
                                            <h6 class="text-center">Servicios por paquete</h6>
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
            </div>
        </div>
    </div>

@endsection

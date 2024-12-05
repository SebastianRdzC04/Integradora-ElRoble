@extends('layouts.dashboardAdmin')

@section('styles')

    <link rel="stylesheet" href="{{ asset('css/dashboard/services.css') }}">

@endsection

@section('title', 'Services')

@section('content')

    <div class="container">
        <div class="d-flex justify-content-end mb-1">
            <a href="{{route('dashboard.crear.servicios')}}" class="btn btn-primary">Crear Servicio</a>
        </div>
        <div class="row justify-content-center">
            <div class="col-12">
                    <div class="table-responsive">
                        <table class="table mb-0 shadow" id="servicios-table">
                            <thead>
                                <tr>
                                    <th class="text-center">Nombre</th>
                                    <th class="text-center">Descripcion</th>
                                    <th class="text-center">Categoria</th>
                                    <th class="text-center">Precio aprox</th>
                                    <th class="text-center">N.Personas aprox</th>
                                    <th class="text-center">Costo</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($services as $service)
                                    <tr>
                                        <td>{{ $service->name }}</td>
                                        <td>{{ $service->description }}</td>
                                        <td>{{ $service->serviceCategory->name }}</td>
                                        <td class="text-center">{{ $service->price }}</td>
                                        <td class="text-center">{{ $service->people_quantity }}</td>
                                        <td class="text-center">{{ $service->coast }}</td>
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
                                @endforeach

                            </tbody>

                        </table>
                    </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

    <script src="{{ asset('js/dashboard/services.js') }}"></script>

@endsection

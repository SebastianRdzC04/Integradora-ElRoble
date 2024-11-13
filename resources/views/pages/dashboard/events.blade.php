@extends('layouts.dashboardAdmin')

@section('styles')

    <link rel="stylesheet" href="{{ asset('css/dashboard/events.css') }}">

@endsection

@section('title', 'Events')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-10">
                <div class="table-responsive">
                    <table class="table">
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
                                    <td>{{ $event->quote->user ? $event->quote->user->person->firstName : $event->quote->owner_name }}
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

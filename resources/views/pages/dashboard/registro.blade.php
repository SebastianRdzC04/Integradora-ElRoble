@extends('layouts.dashboardAdmin')

@section('title', 'Registro')

@section('content')
    <div class="container">
        <div class="row">
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
        <div class="row">
            <div class="col-5">
                <div class="table-resposive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Cantidad</th>
                                <th>Fecha</th>
                                <th>Precio</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($consumableRecords as $consumable )
                            <tr>
                                <td>{{$consumable->consumable->name}}</td>
                                <td> {{$consumable->quantity}} </td>
                                <td>{{$consumable->created_at}} </td>
                                <td> {{$consumable->price}} </td>
                            </tr>
                            @endforeach

                        </tbody>

                    </table>
                </div>
            </div>
            <div class="col-5">
                <div class="table-resposive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No.Serie</th>
                                <th>Nombre</th>
                                <th>Cantidad</th>
                                <th>Categoria</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inventory as $item )
                            <tr>
                                <td>{{strtoupper($item->serial_number)}}</td>
                                <td> {{$item->name}} </td>
                                <td>{{$item->total}} </td>
                                <td> {{$item->inventoryCategory->name}} </td>
                            </tr>
                            @endforeach

                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

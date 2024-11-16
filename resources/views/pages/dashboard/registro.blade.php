@extends('layouts.dashboardAdmin')

@section('title', 'Registro')

@section('content')
    <div class="container">
        <div class="row">
            
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
                                <td>{{$item->SerialType->code}}</td>
                                <td> {{$item->SerialType->name}} </td>
                                <td>{{$item->total}}</td>
                                <td> {{$item->SerialType->category->name}} </td>
                       
                            </tr>
                            @endforeach

                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@extends('layouts.dashboardAdmin')

@section('styles')

    <link rel="stylesheet" href="{{ asset('css/dashboard/consumables.css') }}">

@endsection

@section('title', 'Consumables')

@section('content')
    <div class="container">
        <div class="row">
        </div>
        <div class="row justify-content-center">
            <div class="col-10">
                <div class="table-resposive">
                    <table class="table shadow" id="consumables-table">
                        <thead>
                            <tr>
                                <th class="text-center">Nombre</th>
                                <th class="text-center">Descripcion</th>
                                <th class="text-center">Stock Minimo</th>
                                <th class="text-center">Stock Actual</th>
                                <th class="text-center">Stock Maximo</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($consumables as $item)
                                <tr>
                                    <td class="text-center">{{ $item->name }}</td>
                                    <td class="text-center"> {{ $item->description }} </td>
                                    <td class="text-center"> {{ $item->minimum_stock }}{{$item->unit}} </td>
                                    <td class="text-center"> {{ $item->stock }}{{$item->unit}} </td>
                                    <td class="text-center"> {{ $item->maximum_stock }}{{$item->unit}} </td>
                                    <td class="text-center">
                                        <div>
                                            <a class="btn btn-outline-primary p-1 m-0" href=""><i
                                                    class="bi bi-pencil-square"></i></a>
                                            <a class="btn btn-outline-danger p-1 m-0" href=""><i
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


@endsection

@section('scripts')
    <script src="{{ asset('js/dashboard/consumables.js') }}"></script>

@endsection
@extends('layouts.dashboardAdmin')

@section('styles')

    <link rel="stylesheet" href="{{ asset('css/dashboard/inventory.css') }}">

@endsection

@section('title', 'Inventory')

@section('content')
    <div class="container">
        <div class="row">
        </div>
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="table-resposive">
                    <table class="table shadow" id="inventory-table">
                        <thead>
                            <tr>
                                <th class="text-center">No.Serie</th>
                                <th class="text-center">Descripcion</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center">Detalles</th>
                                <th class="text-center">Precio</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inventory as $item)
                                <tr>
                                    <td class="text-center">{{ $item->SerialType->code }}-{{ $item->number }}</td>
                                    <td class="text-center"> {{ $item->description }} </td>
                                    <td class="text-center"> {{ $item->status }} </td>
                                    <td class="text-center"> {{ $item->details }} </td>
                                    <td class="text-center">${{ $item->price }}</td>
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
    <script src="{{ asset('js/dashboard/inventory.js') }}"></script>

@endsection

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
            <div class="col-10">
                <div class="table-resposive" id="inventory-table">
                    <table class="table">
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
                                    <td class="text-center">{{ $item->SerialType->code }}-{{$item->number}}</td>
                                    <td class="text-center"> {{ $item->description }} </td>
                                    <td class="text-center"> {{ $item->status }} </td>
                                    <td class="text-center"> {{ $item->details }} </td>
                                    <td class="text-center">${{ $item->price }}</td>
                                    <td class="text-center">
                                        <div>
                                            <a class="btn btn-outline-success p-1 m-0 d-inline-flex align-items-center justify-content-center"
                                                href=""><svg xmlns="http://www.w3.org/2000/svg" width="20px"
                                                    height="20px" fill="currentColor" class="bi bi-plus-lg"
                                                    viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd"
                                                        d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2" />
                                                </svg></a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>

                    </table>
                </div>
                <div class="paginate">
                    {{ $inventory->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>

@endsection

@extends('layouts.dashboardAdmin')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard/graphs.css') }}">
@endsection

@section('title', 'Graficos')


@section('content')

    <div class="container">
        <div class="row">
            <div class="col-6 border">
                <h2 class="text-center">Rentas por lugar</h2>
                <div class="justify-content-center align-content-center" id="grafico1"></div>
            </div>
            <div class="col-6 border">
                <h2 class="text-center">Paquetes por Evento</h2>
                <div id="grafico2"></div>
            </div>
            <div class="col-6 border">
                <h2 class="text-center">Paquetes por lugar</h2>
                <div id="grafico3"></div>
            </div>
        </div>
    </div>


@endsection

@php
    use Carbon\Carbon;

    $datos = [];

    foreach ($places as $place) {
        $datos[] = [
            'name' => $place->name,
            'value' => $place->quotes->count(),
        ];
    }
@endphp


@section('scripts')

    <script src="https://cdn.jsdelivr.net/npm/echarts@5.5.1/dist/echarts.min.js"></script>

    <script>
        let datos = @json($datos);
        let datos2 = @json($datos2);
        console.log(datos2);
    </script>

    <script src="{{ asset('js/dashboard/graphs.js') }}"></script>
@endsection

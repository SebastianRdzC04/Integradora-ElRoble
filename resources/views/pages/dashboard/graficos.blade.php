@extends('layouts.dashboardAdmin')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard/graphs.css') }}">
@endsection

@section('title', 'Graficos')


@section('content')
    <div>
        <h3>Aqui iran los graficos</h3>
    </div>
    <div id="grafico1"></div>
@endsection

@php

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
    </script>

    <script src="{{ asset('js/graphs.js') }}"></script>
@endsection

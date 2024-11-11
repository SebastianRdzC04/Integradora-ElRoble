@extends('layouts.dashboardAdmin')

@section('styles')
    <link rel="stylesheet" href="{{asset('css/dashboard/graphs.css')}}">
@endsection

@section('title', 'Graficos')


@section('content')
    <div>
        <h3>Aqui iran los graficos</h3>
    </div>
    <div id="grafico1"></div>
@endsection


@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/echarts@5.5.1/dist/echarts.min.js"></script>
    <script src="{{ asset('js/graphs.js') }}"></script>
@endsection
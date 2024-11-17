@extends('layouts.dashboardAdmin')

@section('styles')

    <link rel="stylesheet" href="{{ asset('css/dashboard/dashboard.css') }}">

@endsection

@section('title', 'Dashboard')

@section('content')
    <div class="container">
        <div class="row mb-4 mt-4">
            <div class="col-4">
                <div class="card shadow">
                    <div class="card-body py-4 px-2">
                        <div class="d-flex">
                            <div class="d-flex iconos me-3 align-content-center justify-content-center">
                                <i class="fs-1 bi bi-cup-straw"></i>
                            </div>
                            <div>
                                <h5>Eventos</h5>
                                <p class="small">{{ $porcentaje }}% del mes pasado </p>
                            </div>
                            <div class="ms-auto">
                                <h4 class="text-center mb-0">{{ $events->count() }}</h4>
                                <p class="small">pendientes</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card shadow">
                    <div class="card-body py-4 px-2">
                        <div class="d-flex">
                            <div class="d-flex iconos me-3 align-content-center justify-content-center">
                                <i class="fs-2 bi bi-journal-bookmark"></i>
                            </div>
                            <div>
                                <h5>Cotizaciones</h5>
                                <p class="small">{{ $porcentaje }}% del mes pasado </p>
                            </div>
                            <div class="ms-auto">
                                <h4 class="text-center mb-0">{{ $events->count() }}</h4>
                                <p class="small">pendientes</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card shadow">
                    <div class="card-body py-4 px-2">
                        <div class="d-flex">
                            <div class="d-flex iconos me-3 align-content-center justify-content-center">
                                <i class="fs-1 bi bi-wallet"></i>
                            </div>
                            <div class="align-content-center">
                                <h5>Ingresos</h5>
                                <p class="small">{{ $porcentaje }}% del mes pasado </p>
                            </div>
                            <div class="ms-auto">
                                <h4 class="text-center mb-0">{{ $events->count() }}</h4>
                                <p class="small">pendientes</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-8">
                <div class="card border shadow mb-4">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    @php
        $eventos = [];
        $daysOcupedQuotes = [];
        foreach ($events as $event) {
            $eventos[] = [
                'title' => $event->quote->type_event . ' de ' . $event->quote->user->person->firstName,
                'start' => $event->date,
                'color' => 'blue',
            ];
        }
        foreach ($fullQuoteDates as $date) {
            $daysOcupedQuotes[] = [
                'title' => 'Limite de cotizaciones',
                'start' => $date,
                'color' => 'red',
            ];
        }

    @endphp

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let events = @json($eventos);
            let daysOcupedQuotes = @json($daysOcupedQuotes);

            let calendarEl = document.getElementById('calendar');
            let calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'es',
                events: [...events, ...daysOcupedQuotes]
            });
            calendar.render();
        });
    </script>
@endsection

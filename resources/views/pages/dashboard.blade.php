@php
    use Carbon\Carbon;

    $timeToStart = '00:00:00';
    if ($currentEvent) {
        $timeToStart = Carbon::now()->diff(Carbon::parse($currentEvent->estimated_start_time));
    }

@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset('css/calendar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <title>Document</title>
</head>

<body>
    <header>
        <h1 class="text-center">Dashboard</h1>
    </header>
    <main>
        <div class="container">
            <div class="row">
                <div class="col border">1</div>
                <div class="col border">2</div>
                <div class="col border">3</div>
                <div class="col border">4</div>
                <div class="col border">5</div>
                <div class="col border">6</div>
                <div class="col border">7</div>
                <div class="col border">8</div>
                <div class="col border">9</div>
                <div class="col border">10</div>
                <div class="col border">11</div>
                <div class="col border">12</div>
            </div>
            <div class="row mb-3">
                @foreach ($consumables as $consumable)
                    <div class="col-3">
                        <div class="card shadow consumibles">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-6 d-flex align-items-center mb-0">
                                        <h5 class="consumable-name"> {{ $consumable->name }} </h5>
                                    </div>
                                    <div
                                        class="col-6 consumable-stock d-flex align-items-center mb-0 justify-content-end">
                                        <h6 class="text-end">
                                            {{ $consumable->stock . '/' . $consumable->maximum_stock }} </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-12 col-md-6 col-xl-4">
                    <div class="card first-row shadow">
                        <div class="card-header">
                            <h2 class="h4">Eventos</h2>
                        </div>
                        <div class="card-body">
                            <div class="events-container">
                                @if ($currentEvent)
                                    <div class="row">
                                        <h2 class="text-center">
                                            {{ $currentEvent->quote->type_event . ' de ' . $currentEvent->quote->user->person->firstName }}
                                        </h2>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <p> <svg fill="#000000" viewBox="0 0 512.00 512.00"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    transform="matrix(-1, 0, 0, 1, 0, 0)" width="16" height="16">
                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke="#CCCCCC" stroke-width="2.048">
                                                    </g>
                                                    <g id="SVGRepo_iconCarrier">
                                                        <path
                                                            d="M384 432c0 8.8-7.2 16-16 16h-32c-8.78 0-16-7.2-16-16V288l-64 32v176c0 8.8-7.2 16-16 16h-32c-8.8 0-16-7.2-16-16V320H64v176c0 8.8-7.2 16-16 16H16c-8.8 0-16-7.2-16-16V288c0-16 0-16 15.85-23.93L128 208V64c0-35.2 28.8-64 64-64h128c35.2 0 64 28.8 64 64v368z">
                                                        </path>
                                                    </g>
                                                </svg> {{ $currentEvent->chair_count }} </p>
                                            <p> <svg xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000"
                                                    width="16" height="16" viewBox="0 0 50 50">
                                                    <path
                                                        d="M10.585938 11L0.5859375 21L49.414062 21L39.414062 11L10.585938 11 z M 0 22L0 28L50 28L50 22L0 22 z M 3 29L3 50L9 50L9 29L3 29 z M 11 29L11 43L17 43L17 29L11 29 z M 33 29L33 43L39 43L39 29L33 29 z M 41 29L41 50L47 50L47 29L41 29 z" />
                                                </svg> {{ $currentEvent->table_count }} </p>
                                            <p> <svg fill="#000000" height="20" width="20" version="1.1"
                                                    id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                    viewBox="-48 -48 576.00 576.00" xml:space="preserve"
                                                    transform="rotate(0)matrix(1, 0, 0, 1, 0, 0)">
                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                        stroke-linejoin="round"></g>
                                                    <g id="SVGRepo_iconCarrier">
                                                        <g id="XMLID_1044_">
                                                            <path id="XMLID_1045_"
                                                                d="M0,0v480h480V0H0z M460,76.667h-56.667V20H460V76.667z M240,338.425 c-54.271,0-98.425-44.153-98.425-98.425s44.153-98.425,98.425-98.425s98.425,44.153,98.425,98.425S294.271,338.425,240,338.425z M250,122.001V96.667h56.667v45.508C290.255,130.955,270.891,123.757,250,122.001z M230,122.001 c-20.891,1.755-40.255,8.954-56.667,20.173V96.667H230V122.001z M122.001,230H96.667v-56.667h45.508 C130.955,189.745,123.757,209.109,122.001,230z M122.001,250c1.755,20.891,8.954,40.255,20.173,56.667H96.667V250H122.001z M230,357.999v25.335h-56.667v-45.508C189.745,349.045,209.109,356.243,230,357.999z M250,357.999 c20.891-1.755,40.255-8.954,56.667-20.173v45.508H250V357.999z M357.999,250h25.335v56.667h-45.508 C349.045,290.255,356.243,270.891,357.999,250z M357.999,230c-1.755-20.891-8.954-40.255-20.173-56.667h45.508V230H357.999z M326.667,153.333V96.667h56.667v56.667H326.667z M326.667,76.667V20h56.667v56.667H326.667z M306.667,76.667H250V20h56.667V76.667 z M230,76.667h-56.667V20H230V76.667z M153.333,76.667H96.667V20h56.667V76.667z M153.333,96.667v56.667H96.667V96.667H153.333z M76.667,153.333H20V96.667h56.667V153.333z M76.667,173.333V230H20v-56.667H76.667z M76.667,250v56.667H20V250H76.667z M76.667,326.667v56.667H20v-56.667H76.667z M96.667,326.667h56.667v56.667H96.667V326.667z M153.333,403.333V460H96.667v-56.667 H153.333z M173.333,403.333H230V460h-56.667V403.333z M250,403.333h56.667V460H250V403.333z M326.667,403.333h56.667V460h-56.667 V403.333z M326.667,383.333v-56.667h56.667v56.667H326.667z M403.333,326.667H460v56.667h-56.667V326.667z M403.333,306.667V250 H460v56.667H403.333z M403.333,230v-56.667H460V230H403.333z M403.333,153.333V96.667H460v56.667H403.333z M76.667,20v56.667H20V20 H76.667z M20,403.333h56.667V460H20V403.333z M403.333,460v-56.667H460V460H403.333z">
                                                            </path>
                                                            <path id="XMLID_1080_"
                                                                d="M240,171.575c-37.729,0-68.425,30.695-68.425,68.425s30.695,68.425,68.425,68.425 s68.425-30.695,68.425-68.425S277.729,171.575,240,171.575z M240,288.425c-26.702,0-48.425-21.723-48.425-48.425 s21.723-48.425,48.425-48.425s48.425,21.723,48.425,48.425S266.702,288.425,240,288.425z">
                                                            </path>
                                                        </g>
                                                    </g>
                                                </svg> {{ $currentEvent->table_cloth_count }} </p>
                                        </div>
                                        <div class="col-6">
                                            <p class="text-end"> {{ $currentEvent->quote->people_count }} <svg
                                                    xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-person-standing"
                                                    viewBox="0 0 16 16">
                                                    <path
                                                        d="M8 3a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3M6 6.75v8.5a.75.75 0 0 0 1.5 0V10.5a.5.5 0 0 1 1 0v4.75a.75.75 0 0 0 1.5 0v-8.5a.25.25 0 1 1 .5 0v2.5a.75.75 0 0 0 1.5 0V6.5a3 3 0 0 0-3-3H7a3 3 0 0 0-3 3v2.75a.75.75 0 0 0 1.5 0v-2.5a.25.25 0 0 1 .5 0" />
                                                </svg> </p>
                                            <p class="text-end"> {{ $currentEvent->estimated_start_time }} -
                                                {{ $currentEvent->estimated_end_time }} <svg
                                                    xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-clock-history"
                                                    viewBox="0 0 16 16">
                                                    <path
                                                        d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022zm2.004.45a7 7 0 0 0-.985-.299l.219-.976q.576.129 1.126.342zm1.37.71a7 7 0 0 0-.439-.27l.493-.87a8 8 0 0 1 .979.654l-.615.789a7 7 0 0 0-.418-.302zm1.834 1.79a7 7 0 0 0-.653-.796l.724-.69q.406.429.747.91zm.744 1.352a7 7 0 0 0-.214-.468l.893-.45a8 8 0 0 1 .45 1.088l-.95.313a7 7 0 0 0-.179-.483m.53 2.507a7 7 0 0 0-.1-1.025l.985-.17q.1.58.116 1.17zm-.131 1.538q.05-.254.081-.51l.993.123a8 8 0 0 1-.23 1.155l-.964-.267q.069-.247.12-.501m-.952 2.379q.276-.436.486-.908l.914.405q-.24.54-.555 1.038zm-.964 1.205q.183-.183.35-.378l.758.653a8 8 0 0 1-.401.432z" />
                                                    <path
                                                        d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0z" />
                                                    <path
                                                        d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5" />
                                                </svg> </p>
                                            @if (Carbon::now()->lessThan(Carbon::parse($currentEvent->estimated_start_time)))
                                                @if ($timeToStart->h > 1)
                                                    <p class="text-end"> Faltan {{ $timeToStart->h }} horas </p>
                                                @elseif ($timeToStart->h == 1)
                                                    <p class="text-end"> Falta {{ $timeToStart->h }} hora y
                                                        {{ $timeToStart->i }}
                                                        minutos </p>
                                                @else
                                                    <p class="text-end"> Faltan {{ $timeToStart->i }} minutos </p>
                                                @endif
                                            @else
                                                <p class="text-end"> ya paso la hora carnal</p>

                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <h4 class="text-center">Servicios:</h4>
                                        <div class="col-12  event-services list-group">
                                            @if ($currentEvent->quote->package_id)
                                                @foreach ($currentEvent->quote->package->services as $pServices)
                                                    <div class="list-group-item"> {{ $pServices->name }} </div>
                                                @endforeach
                                            @endif
                                            @if ($currentEvent->quote->services)
                                                @foreach ($currentEvent->quote->services as $qServices)
                                                    <div> {{ $qServices->name }} </div>
                                                @endforeach

                                            @endif
                                            @if ($currentEvent->services)
                                                @foreach ($currentEvent->services as $services)
                                                    <div> {{ $services->name }} </div>
                                                @endforeach

                                            @endif
                                        </div>
                                    </div>
                                @else
                                    @foreach ($events as $event)
                                        <div class="container-fluid  mb-4 border shadow events">
                                            <div class="row">
                                                <div class="col-6">
                                                    <h6> {{ $event->quote->type_event . ' de ' . $event->quote->user->person->firstName }}
                                                    </h6>

                                                </div>
                                                <div class="col-6">
                                                    <h6 class="text-end">
                                                        {{ Carbon::parse($event->date)->format('d/m') }} <svg
                                                            xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="16" fill="currentColor"
                                                            class="bi bi-calendar-x" viewBox="0 0 16 16">
                                                            <path
                                                                d="M6.146 7.146a.5.5 0 0 1 .708 0L8 8.293l1.146-1.147a.5.5 0 1 1 .708.708L8.707 9l1.147 1.146a.5.5 0 0 1-.708.708L8 9.707l-1.146 1.147a.5.5 0 0 1-.708-.708L7.293 9 6.146 7.854a.5.5 0 0 1 0-.708" />
                                                            <path
                                                                d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z" />
                                                        </svg> </h6>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <p>
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000"
                                                            width="16" height="16" viewBox="0 0 50 50">
                                                            <path
                                                                d="M10.585938 11L0.5859375 21L49.414062 21L39.414062 11L10.585938 11 z M 0 22L0 28L50 28L50 22L0 22 z M 3 29L3 50L9 50L9 29L3 29 z M 11 29L11 43L17 43L17 29L11 29 z M 33 29L33 43L39 43L39 29L33 29 z M 41 29L41 50L47 50L47 29L41 29 z" />
                                                        </svg>
                                                        {{ $event->table_count }}
                                                    </p>
                                                    <p> <svg fill="#000000" viewBox="0 0 512.00 512.00"
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            transform="matrix(-1, 0, 0, 1, 0, 0)" width="16"
                                                            height="16">
                                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke="#CCCCCC"
                                                                stroke-width="2.048"></g>
                                                            <g id="SVGRepo_iconCarrier">
                                                                <path
                                                                    d="M384 432c0 8.8-7.2 16-16 16h-32c-8.78 0-16-7.2-16-16V288l-64 32v176c0 8.8-7.2 16-16 16h-32c-8.8 0-16-7.2-16-16V320H64v176c0 8.8-7.2 16-16 16H16c-8.8 0-16-7.2-16-16V288c0-16 0-16 15.85-23.93L128 208V64c0-35.2 28.8-64 64-64h128c35.2 0 64 28.8 64 64v368z">
                                                                </path>
                                                            </g>
                                                        </svg>
                                                        {{ $event->chair_count }}
                                                    </p>
                                                    <p><svg fill="#000000" height="20" width="20"
                                                            version="1.1" id="Capa_1"
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink"
                                                            viewBox="-48 -48 576.00 576.00" xml:space="preserve"
                                                            transform="rotate(0)matrix(1, 0, 0, 1, 0, 0)">
                                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                                stroke-linejoin="round"></g>
                                                            <g id="SVGRepo_iconCarrier">
                                                                <g id="XMLID_1044_">
                                                                    <path id="XMLID_1045_"
                                                                        d="M0,0v480h480V0H0z M460,76.667h-56.667V20H460V76.667z M240,338.425 c-54.271,0-98.425-44.153-98.425-98.425s44.153-98.425,98.425-98.425s98.425,44.153,98.425,98.425S294.271,338.425,240,338.425z M250,122.001V96.667h56.667v45.508C290.255,130.955,270.891,123.757,250,122.001z M230,122.001 c-20.891,1.755-40.255,8.954-56.667,20.173V96.667H230V122.001z M122.001,230H96.667v-56.667h45.508 C130.955,189.745,123.757,209.109,122.001,230z M122.001,250c1.755,20.891,8.954,40.255,20.173,56.667H96.667V250H122.001z M230,357.999v25.335h-56.667v-45.508C189.745,349.045,209.109,356.243,230,357.999z M250,357.999 c20.891-1.755,40.255-8.954,56.667-20.173v45.508H250V357.999z M357.999,250h25.335v56.667h-45.508 C349.045,290.255,356.243,270.891,357.999,250z M357.999,230c-1.755-20.891-8.954-40.255-20.173-56.667h45.508V230H357.999z M326.667,153.333V96.667h56.667v56.667H326.667z M326.667,76.667V20h56.667v56.667H326.667z M306.667,76.667H250V20h56.667V76.667 z M230,76.667h-56.667V20H230V76.667z M153.333,76.667H96.667V20h56.667V76.667z M153.333,96.667v56.667H96.667V96.667H153.333z M76.667,153.333H20V96.667h56.667V153.333z M76.667,173.333V230H20v-56.667H76.667z M76.667,250v56.667H20V250H76.667z M76.667,326.667v56.667H20v-56.667H76.667z M96.667,326.667h56.667v56.667H96.667V326.667z M153.333,403.333V460H96.667v-56.667 H153.333z M173.333,403.333H230V460h-56.667V403.333z M250,403.333h56.667V460H250V403.333z M326.667,403.333h56.667V460h-56.667 V403.333z M326.667,383.333v-56.667h56.667v56.667H326.667z M403.333,326.667H460v56.667h-56.667V326.667z M403.333,306.667V250 H460v56.667H403.333z M403.333,230v-56.667H460V230H403.333z M403.333,153.333V96.667H460v56.667H403.333z M76.667,20v56.667H20V20 H76.667z M20,403.333h56.667V460H20V403.333z M403.333,460v-56.667H460V460H403.333z">
                                                                    </path>
                                                                    <path id="XMLID_1080_"
                                                                        d="M240,171.575c-37.729,0-68.425,30.695-68.425,68.425s30.695,68.425,68.425,68.425 s68.425-30.695,68.425-68.425S277.729,171.575,240,171.575z M240,288.425c-26.702,0-48.425-21.723-48.425-48.425 s21.723-48.425,48.425-48.425s48.425,21.723,48.425,48.425S266.702,288.425,240,288.425z">
                                                                    </path>
                                                                </g>
                                                            </g>
                                                        </svg>
                                                        {{ $event->table_cloth_count }}
                                                    </p>
                                                </div>
                                                <div class="col-6">
                                                    @if ($event->quote->place != null)
                                                        <p> {{ $event->quote->place->name }} </p>
                                                    @else
                                                        <p> {{ $event->quote->package->place->name }} </p>
                                                    @endif
                                                    <p> {{ $event->advance_payment . '/' . $event->total_price }} </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-xl-5">
                    <div class="card first-row shadow">
                        <div class="card-header">
                            <h2 class="h4">Cotizaciones Pendientes</h2>
                        </div>
                        <div class="card-body">
                            <div class="container-fluid d-flex flex-column justify-content-between quotes-pages">
                                <div class="row">
                                    @foreach ($quotes as $quote)
                                        @php
                                            $qServices = $quote->services() ? $quote->services()->get() : null;
                                            $pServicesP = $quote->package_id
                                                ? $quote->package->services()->get()
                                                : null;
                                        @endphp
                                        <div class="col-6">
                                            <div class="card mb-4 shadow quote-card">
                                                <div class="card-header">
                                                    <h6>{{ $quote->type_event . ' de ' . $quote->user->person->firstName }}
                                                    </h6>
                                                </div>
                                                <div class="quotes container-fluid pt-1">
                                                    <div class="row">
                                                        <div class="col-5 d-flex">
                                                            <p><svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                    height="16" fill="currentColor"
                                                                    class="bi bi-house" viewBox="0 0 16 16">
                                                                    <path
                                                                        d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z" />
                                                                </svg></p>
                                                            <p>{{ $quote->place ? $quote->place->name : $quote->package->place->name }}
                                                            </p>
                                                        </div>
                                                        <div class="col-7">
                                                            <p class="text-end">
                                                                {{ Carbon::parse($quote->date)->format('d/m') }}
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                    height="16" fill="currentColor"
                                                                    class="bi bi-calendar-x" viewBox="0 0 16 16">
                                                                    <path
                                                                        d="M6.146 7.146a.5.5 0 0 1 .708 0L8 8.293l1.146-1.147a.5.5 0 1 1 .708.708L8.707 9l1.147 1.146a.5.5 0 0 1-.708.708L8 9.707l-1.146 1.147a.5.5 0 0 1-.708-.708L7.293 9 6.146 7.854a.5.5 0 0 1 0-.708" />
                                                                    <path
                                                                        d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z" />
                                                                </svg>
                                                            </p>
                                                        </div>
                                                        <div class="col-4">
                                                            <p class="text-start">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                    height="16" fill="currentColor"
                                                                    class="bi bi-person-standing" viewBox="0 0 16 16">
                                                                    <path
                                                                        d="M8 3a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3M6 6.75v8.5a.75.75 0 0 0 1.5 0V10.5a.5.5 0 0 1 1 0v4.75a.75.75 0 0 0 1.5 0v-8.5a.25.25 0 1 1 .5 0v2.5a.75.75 0 0 0 1.5 0V6.5a3 3 0 0 0-3-3H7a3 3 0 0 0-3 3v2.75a.75.75 0 0 0 1.5 0v-2.5a.25.25 0 0 1 .5 0" />
                                                                </svg>
                                                                {{ $quote->guest_count }}
                                                            </p>
                                                        </div>
                                                        <div class="col-8 d-flex quote-time-container">
                                                            <p><svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                    height="16" fill="currentColor"
                                                                    class="bi bi-clock-history" viewBox="0 0 16 16">
                                                                    <path
                                                                        d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022zm2.004.45a7 7 0 0 0-.985-.299l.219-.976q.576.129 1.126.342zm1.37.71a7 7 0 0 0-.439-.27l.493-.87a8 8 0 0 1 .979.654l-.615.789a7 7 0 0 0-.418-.302zm1.834 1.79a7 7 0 0 0-.653-.796l.724-.69q.406.429.747.91zm.744 1.352a7 7 0 0 0-.214-.468l.893-.45a8 8 0 0 1 .45 1.088l-.95.313a7 7 0 0 0-.179-.483m.53 2.507a7 7 0 0 0-.1-1.025l.985-.17q.1.58.116 1.17zm-.131 1.538q.05-.254.081-.51l.993.123a8 8 0 0 1-.23 1.155l-.964-.267q.069-.247.12-.501m-.952 2.379q.276-.436.486-.908l.914.405q-.24.54-.555 1.038zm-.964 1.205q.183-.183.35-.378l.758.653a8 8 0 0 1-.401.432z" />
                                                                    <path
                                                                        d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0z" />
                                                                    <path
                                                                        d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5" />
                                                                </svg></p>
                                                            <p class="quote-time">
                                                                {{ Carbon::parse($quote->start_time)->format('g:ia') . ' - ' . Carbon::parse($quote->end_time)->format('g:ia') }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="row align-items-center ms-0 mb-3">
                                                        <h6 class="text-start">Servicios:</h6>

                                                        <div class="service-list">
                                                            <div
                                                                class="list-group d-flex justify-content-center w-100 border">
                                                                @if ($qServices)
                                                                    @foreach ($qServices as $service)
                                                                        <div class="list-group list-group-item">
                                                                            {{ $service->name }}</div>
                                                                    @endforeach
                                                                @endif
                                                                @if ($pServicesP)
                                                                    @foreach ($pServicesP as $service)
                                                                        <div class="list-group list-group-item">
                                                                            {{ $service->name }}</div>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div>
                                            {{ $quotes->links('pagination::bootstrap-5') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-8 col-xl-3 col-md-4">
                    <div class="first-row shadow">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="h4">Calendario</h2>
                            </div>
                            <div class="card-body">
                                <div id="calendar-container">
                                    <div class="mt-1 mb-1 d-flex justify-content-between">
                                        <div class="col text-start">
                                            <button class="btn btn-primary" id="prev"> < </button>
                                        </div>
                                        <div class="col">
                                            <h1 class="text-center grande" id="calendar-month"></h1>
                                        </div>
                                        <div class="col text-end">
                                            <button class="btn btn-primary" id="next"> > </button>
                                        </div>
                                    </div>
                                    <div id="calendar-dates" class="">
                                        <div id="days">
                                            <div class="day">Lun</div>
                                            <div class="day">Mar</div>
                                            <div class="day">Mier</div>
                                            <div class="day">Jue</div>
                                            <div class="day">Vie</div>
                                            <div class="day">Sab</div>
                                            <div class="day">Dom</div>
                                        </div>
                                        <div id="calendar"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h4>Hola</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <h6>que es esto</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer>

    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script>
        const quotesDates = @json($fullQuoteDates);
        const eventsDates = @json($events->pluck('date'));
    </script>
    <script src="{{ asset('js/calendar.js') }}"></script>
</body>

</html>

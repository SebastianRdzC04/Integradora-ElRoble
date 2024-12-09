<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Cotización</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/stylescotizacionesnuevas.css') }}">
</head>
<body class="bg-light">
    <div class="container mt-4">
        @if(session('success'))
        <div class="alert alert-success" role="alert" style="background-color: rgb(30, 78, 21); color: white;">
            {{ session('success') }}
        </div>
        @elseif ($errors->has('store_quote_error'))
        <div class="alert alert-danger" role="alert" style="background-color: rgb(189, 18, 18); color: white;">
            {{ $errors->first('store_quote_error') }}
        </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form id="quoteForm" method="POST" action="{{ route('cotizaciones.storeQuoteAdmin') }}">
            @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <h4 id="textoFecha" class="card-title mb-4 text-center">Selecciona una Fecha</h4>
                        <div class="calendar-container" style="padding: 0;">
                            <div id="calendar-controls" class="d-flex justify-content-between mb-2">
                                <button id="prevMonth" style="min-width: 32px; margin: 10px;" class="btn-calendar"> < Anterior</button>
                                <h6 id="calendarMonthYear" style="margin: 10px;"></h6>
                                <button id="nextMonth" style="min-width: 32px; margin: 10px;" class="btn-calendar">Siguiente ></button>
                            </div>
                            <div id="calendar"></div>
                        </div>
                        <div class="mt-3">
                            <p><span class="badge bg-success">Verde</span> - Disponible</p>
                            <p><span style="color: black;" class="badge bg-warning">Amarillo</span> - Más personas cotizando por la misma fecha</p>
                            <p><span class="badge bg-danger">Rojo</span> - No Disponible</p>
                            <p><span class="badge bg-secondary">Gris</span> - Fecha Inaccesible</p>
                        </div>
                        <div class="mt-4">
                            <div class="mb-3">
                                <label for="selectedDate" class="form-label">Fecha Seleccionada:</label>
                                <input type="text" class="form-control" id="selectedDate" placeholder="AAAA-MM-DD" readonly>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-md-6">
                                    <label for="start_time" class="form-label">
                                        <i class="fas fa-clock"></i> Hora de Inicio
                                    </label>
                                    <input type="time" id="start_time" class="form-control" required onblur="roundTime(this)" onchange="updateDurationOptions()" placeholder="XX:XX">
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <label for="duration" class="form-label">
                                        <i class="fas fa-hourglass-half"></i> Duración del Evento (horas)
                                    </label>
                                    <select class="form-select" id="duration">
                                        <option value="">Seleccione duración</option>
                                        <option value="4">4 horas</option>
                                        <option value="5">5 horas</option>
                                        <option value="6">6 horas</option>
                                        <option value="7">7 horas</option>
                                        <option value="8">8 horas</option>
                                        <option value="9">9 horas</option>
                                        <option value="10">10 horas</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <h4 class="card-title mb-4 text-center" style="margin-top: 20px;">Selecciona el Lugar</h4>
                        <div class="row">
                            @foreach($places as $place)
                                @php
                                    $imageUrl = '';
                                    switch ($place->id) {
                                        case 1:
                                            $imageUrl = '/images/imagen2.jpg';
                                            break;
                                        case 2:
                                            $imageUrl = '/images/imagen7.jpg';
                                            break;
                                        case 3:
                                            $imageUrl = '/images/imagen8.jpg';
                                            break;
                                        default:
                                            $imageUrl = '/images/imagen1.jpg';
                                    }
                                @endphp
                                <div class="col-4 col-sm-4 col-md-4 col-lg-4">
                                    <div class="card place-card mb-3" onclick="selectPlace({{ $place->id }})">
                                        <img src="{{ $imageUrl }}" class="card-img-top" alt="{{ $place->name }}" style="max-height: 100px">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $place->name }}</h5>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <h4 class="card-title mb-4 text-center" style="margin-top: 20px;"><i class="fas fa-user" style="margin-right: 10px;"></i>Ingresa datos del Cliente: </h4>
                        <div class="mt-4">
                            <label for="owner_name" class="form-label">Nombre:</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" id="owner_name" name="owner_name" class="form-control" placeholder="Nombre del cliente">
                            </div>
                        </div>
            
                        <div class="mt-4">
                            <label for="owner_phone" class="form-label">Teléfono:</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                <input type="text" id="owner_phone" name="owner_phone" class="form-control" placeholder="Teléfono del cliente">
                            </div>
                        </div>

                        <div class="mt-4">
                            <label class="form-label">Tipo de Evento:</label>
                            <select class="form-select" id="eventType" name="type_event" onchange="toggleOtherEventType()">
                                <option value="">Selecciona el tipo de evento</option>
                                <option value="XV's">XV's</option>
                                <option value="Cumpleaños">Cumpleaños</option>
                                <option value="Graduación">Graduación</option>
                                <option value="Posada">Posada</option>
                                <option value="Boda">Boda</option>
                                <option value="Baby Shower">Baby Shower</option>
                                <option value="Otro">Otro</option>
                            </select>
                            <div id="otherEventTypeContainer" class="mt-3" style="display: none;">
                                <label for="otherEventType" class="form-label">Especificar Tipo de Evento:</label>
                                <input type="text" id="otherEventType" name="other_event_type" class="form-control">
                            </div>
                        </div>
            
                        <div class="mt-4">
                            <label class="form-label">Cantidad de Invitados:</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-users"></i></span>
                                <input type="number" id="guestCount" name="guest_count" class="form-control" placeholder="Cantidad de invitados">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <h4 class="text-center">Servicios Disponibles:</h4>
                        <div class="mt-4">
                            <div class="row">
                                @foreach($categories as $category)
                                    @php
                                        $imageUrl = $category->image_path ?? '/images/imagen6.jpg';
                                    @endphp
                                    <div class="col-6 col-sm-6 col-md-6 col-xl-4 mb-3">
                                        <div class="card category-card" data-category-id="{{ $category->id }}">
                                            <img src="{{ $imageUrl }}" class="card-img-top" alt="{{ $category->name }}" style="aspect-ratio: 4 / 3; object-fit: cover;">
                                            <div class="card-body">
                                                <h5 class="card-title text-center"><strong>{{ $category->name }}</strong></h5>
                                                <p class="card-text text-justify">{{ $category->description }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="mt-4" style="display: flex; justify-content: center;">
                                <button type="button" style="margin-top: -25px;" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmedServicesModal" onclick="updateConfirmedServicesModal()">
                                    Ver Servicios Confirmados
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            
                <div class="card mb-4">
                    <div class="card-body">
                        <h4 class="text-center">Precios de Cotización:</h4>
                        <div class="mt-4">
                            <label for="space_cost" class="form-label">Monto de Espacio:</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                <input type="text" id="space_cost" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="mt-4">
                            <label for="services_cost" class="form-label">Monto de Servicios:</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-concierge-bell"></i></span>
                                <input type="text" id="services_cost" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="mt-4">
                            <label for="total_cost" class="form-label">Monto Total:</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                <input type="text" id="total_cost" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="mt-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="manual_price_checkbox">
                                <label class="form-check-label" for="manual_price_checkbox">
                                    ¿Desea modificar manualmente el Monto Total?
                                </label>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                <input type="text" id="manual_price" class="form-control" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 text-center">
                        <button type="button" class="btn btn-success" style="margin-bottom: 20px; margin-top: -20px;" onclick="submitQuote()">Enviar Cotización</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    </div>
    
    <!-- Modal para Servicios Confirmados -->
    <div class="modal fade" id="confirmedServicesModal" tabindex="-1" aria-labelledby="confirmedServicesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmedServicesModalLabel">Servicios Confirmados</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row" id="confirmedServicesContainer">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Servicios -->
    <div class="modal fade" id="servicesModal" tabindex="-1" aria-labelledby="servicesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="servicesModalLabel">Seleccionar Servicios</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row" id="servicesContainer">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.0.0-beta1/dist/js/tempus-dominus.min.js"></script>
    <script>

window.addEventListener('load', adjustCalendarControls);
window.addEventListener('resize', adjustCalendarControls);

let confirmedServices = [];
const servicesData = @json($services);
const places = @json($places);
const quotes = @json($quotes);

function submitQuote() {
    console.log('submitQuote function called');

    const selectedDateElement = document.getElementById('selectedDate');
    const startTimeElement = document.getElementById('start_time');
    const durationElement = document.getElementById('duration');
    const eventTypeElement = document.getElementById('eventType');
    const otherEventTypeElement = document.getElementById('otherEventType');
    const guestCountElement = document.getElementById('guestCount');
    const placeCard = document.querySelector('.card.place-card.mb-3.selected');
    const ownerNameElement = document.getElementById('owner_name');
    const ownerPhoneElement = document.getElementById('owner_phone');

    const selectedDate = selectedDateElement ? selectedDateElement.value : null;
    const startTime = startTimeElement ? startTimeElement.value : null;
    const duration = durationElement ? durationElement.value : null;
    const eventType = eventTypeElement ? eventTypeElement.value : null;
    const otherEventType = otherEventTypeElement ? otherEventTypeElement.value : null;
    const guestCount = guestCountElement ? guestCountElement.value : null;
    const ownerName = ownerNameElement ? ownerNameElement.value : null;
    const ownerPhone = ownerPhoneElement ? ownerPhoneElement.value : null;
    let placeId = null;

    if (placeCard) {
        const onclickAttr = placeCard.getAttribute('onclick');
        console.log('onclickAttr:', onclickAttr);
        const match = onclickAttr.match(/\d+/);
        console.log('match:', match);
        placeId = match ? match[0] : null;
    }

    if (!selectedDate) {
        console.error('selectedDate is null');
    }
    if (!startTime) {
        console.error('startTime is null');
    }
    if (!duration) {
        console.error('duration is null');
    }
    if (!eventType) {
        console.error('eventType is null');
    }
    if (!guestCount) {
        console.error('guestCount is null');
    }
    if (!placeId) {
        console.error('placeId is null');
    }
    if (!ownerName) {
        console.error('ownerName is null');
    }
    if (!ownerPhone) {
        console.error('ownerPhone is null');
    }

    if (!selectedDate || !startTime || !duration || !eventType || !guestCount || !placeId || !ownerName || !ownerPhone) {
        alert('Por favor, complete todos los campos requeridos.');
        return;
    }

    const [startHour, startMinute] = startTime.split(':').map(Number);
    if (startHour < 11) {
        alert('La hora de inicio no puede ser menor a las 11:00.');
        return;
    }

    const place = places.find(p => p.id == placeId);
    if (place && guestCount > place.max_guest) {
        alert(`La cantidad máxima de invitados para este lugar es ${place.max_guest}.`);
        guestCountElement.value = place.max_guest;
        return;
    }

    const endHour = (startHour + parseInt(duration)) % 24;
    const endTime = `${String(endHour).padStart(2, '0')}:${String(startMinute).padStart(2, '0')}`;

    const form = document.getElementById('quoteForm');

    form.appendChild(generarInputOculto('date', selectedDate));
    form.appendChild(generarInputOculto('start_time', `${selectedDate} ${startTime}`));
    form.appendChild(generarInputOculto('end_time', `${selectedDate} ${endTime}`));
    form.appendChild(generarInputOculto('place_id', placeId));
    form.appendChild(generarInputOculto('guest_count', guestCount));
    form.appendChild(generarInputOculto('type_event', eventType === 'Otro' ? otherEventType : eventType));
    form.appendChild(generarInputOculto('owner_name', ownerName));
    form.appendChild(generarInputOculto('owner_phone', ownerPhone));

    confirmedServices.forEach(service => {
        form.appendChild(generarInputOculto(`services[${service.id}][confirmed]`, true));
        form.appendChild(generarInputOculto(`services[${service.id}][description]`, service.description));
        if (service.quantity) {
            form.appendChild(generarInputOculto(`services[${service.id}][quantity]`, service.quantity));
        }
        form.appendChild(generarInputOculto(`services[${service.id}][coast]`, service.cost));
    });

    form.submit();
}

function generarInputOculto(nombre, valor) {
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = nombre;
    input.value = valor;
    return input;
}

        document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.category-card').forEach(card => {
        card.addEventListener('click', function() {
            const categoryId = this.dataset.categoryId;
            showServicesModal(categoryId);
        });
    });
});

document.getElementById('manual_price_checkbox').addEventListener('change', function(event) {
        const manualPriceInput = document.getElementById('manual_price');
        manualPriceInput.disabled = !event.target.checked;
    });

    function updateCosts() {
        const placeCard = document.querySelector('.card.place-card.mb-3.selected');
        const durationElement = document.getElementById('duration');
        const spaceCostInput = document.getElementById('space_cost');
        const servicesCostInput = document.getElementById('services_cost');
        const totalCostInput = document.getElementById('total_cost');

        let placeId = null;
        if (placeCard) {
            const onclickAttr = placeCard.getAttribute('onclick');
            const match = onclickAttr.match(/\d+/);
            placeId = match ? match[0] : null;
        }

        const duration = durationElement ? durationElement.value : null;
        const place = places.find(p => p.id == placeId);

        let spaceCost = 0;
        if (place && duration) {
            spaceCost = (place.price / 4) * duration;
        }
        spaceCostInput.value = spaceCost.toFixed(2);

        let servicesCost = 0;
        confirmedServices.forEach(service => {
            servicesCost += Number(service.price) * (service.quantity || 1);
        });
        servicesCostInput.value = servicesCost.toFixed(2);

        const totalCost = spaceCost + servicesCost;
        totalCostInput.value = totalCost.toFixed(2);
    }

    document.getElementById('duration').addEventListener('change', updateCosts);
    document.querySelectorAll('.card.place-card.mb-3').forEach(card => {
        card.addEventListener('click', updateCosts);
    });

    document.addEventListener('DOMContentLoaded', function() {
        updateCosts();
    });

function roundTime(input) {
    const time = input.value;
    const [hours, minutes] = time.split(':').map(Number);

    if (isNaN(hours) || isNaN(minutes) || hours < 0 || hours > 23 || minutes < 0 || minutes > 59) {
        input.value = '';
        return;
    }

    let roundedMinutes;
    let newHours = hours;

    if (minutes <= 15) {
        roundedMinutes = '00';
    } else if (minutes <= 45) {
        roundedMinutes = '30';
    } else if (minutes <= 59) {
        roundedMinutes = '00';
        newHours = (hours + 1) % 24;
    }

    input.value = `${String(newHours).padStart(2, '0')}:${roundedMinutes}`;
}

document.addEventListener('DOMContentLoaded', function() {
    const calendar = document.getElementById('calendar');
    const selectedDateInput = document.getElementById('selectedDate');
    const calendarMonthYear = document.getElementById('calendarMonthYear');
    const prevMonthButton = document.getElementById('prevMonth');
    const nextMonthButton = document.getElementById('nextMonth');
    const today = new Date();
    let currentDate = new Date(today.getFullYear(), today.getMonth(), 1);

    prevMonthButton.addEventListener('click', (event) => {
        event.preventDefault();
        changeMonth(-1);
    });
    nextMonthButton.addEventListener('click', (event) => {
        event.preventDefault();
        changeMonth(1);
    });

    function changeMonth(offset) {
        currentDate.setMonth(currentDate.getMonth() + offset);
        generateCalendar();
    }

    function updateCalendarText() {
        calendarMonthYear.innerText = currentDate.toLocaleString('default', { month: 'long', year: 'numeric' });
    }

    function generateCalendar() {
        calendar.innerHTML = '';
        updateCalendarText();

        const minDate = new Date(today.getFullYear(), today.getMonth(), 1);
        const maxDate = new Date(today.getFullYear(), today.getMonth() + 2, 1);

        if (currentDate <= minDate) {
            prevMonthButton.classList.add('btn-disabled');
        } else {
            prevMonthButton.classList.remove('btn-disabled');
        }

        prevMonthButton.disabled = currentDate <= minDate;
        nextMonthButton.disabled = currentDate >= maxDate;

        if (currentDate >= maxDate) {
            nextMonthButton.classList.add('btn-disabled');
        } else {
            nextMonthButton.classList.remove('btn-disabled');
        }

        const daysOfWeek = ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'];
        const daysHeader = document.createElement('div');
        daysHeader.classList.add('days-header', 'd-flex', 'justify-content-between');
        daysOfWeek.forEach(day => {
            const dayElement = document.createElement('div');
            dayElement.classList.add('day-header');
            dayElement.innerText = day;
            daysHeader.appendChild(dayElement);
        });
        calendar.appendChild(daysHeader);

        const firstDayOfMonth = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1).getDay();
        const daysInMonth = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0).getDate();

        let day = 1;
        let row = document.createElement('div');
        row.classList.add('days-row', 'd-flex', 'justify-content-between');

        for (let i = 0; i < firstDayOfMonth; i++) {
            const emptyCell = document.createElement('div');
            emptyCell.classList.add('day', 'empty');
            row.appendChild(emptyCell);
        }

        while (day <= daysInMonth) {
            if (row.children.length === 7) {
                calendar.appendChild(row);
                row = document.createElement('div');
                row.classList.add('days-row', 'd-flex', 'justify-content-between');
            }

            const dayButton = document.createElement('button');
            dayButton.classList.add('day');
            dayButton.innerText = day;
            const date = new Date(currentDate.getFullYear(), currentDate.getMonth(), day);
            dayButton.dataset.date = date.toISOString().split('T')[0];
            dayButton.title = date.toDateString();

            if (date < today) {
                dayButton.classList.add('bg-secondary');
                dayButton.style.color = 'black';
            } else {
                dayButton.classList.add('bg-success');
                dayButton.addEventListener('click', function(event) {
                    event.preventDefault();
                    if (!dayButton.classList.contains('bg-danger')) {
                        selectedDateInput.value = this.dataset.date;

                        document.querySelectorAll('.day.bg-primary').forEach(btn => {
                            btn.classList.remove('bg-primary');
                            const originalClass = btn.dataset.originalClass;
                            if (originalClass) {
                                btn.classList.add(originalClass);
                            } else {
                                btn.classList.add('bg-success');
                            }
                        });

                        dayButton.dataset.originalClass = dayButton.classList.contains('bg-warning') ? 'bg-warning' : 'bg-success';
                        dayButton.classList.remove('bg-success', 'bg-warning', 'bg-danger');
                        dayButton.classList.add('bg-primary');
                    }
                });
            }

            row.appendChild(dayButton);
            day++;
        }

        while (row.children.length < 7) {
            const emptyCell = document.createElement('div');
            emptyCell.classList.add('day', 'empty');
            row.appendChild(emptyCell);
        }

        calendar.appendChild(row);
        updateCalendarWithQuotes();
        adjustDayButtonHeight();
    }

    function updateCalendarWithQuotes() {
        const quoteCounts = {};

        quotes.forEach(quote => {
            const date = quote.date;
            if (!quoteCounts[date]) {
                quoteCounts[date] = { count: 0, status: [] };
            }
            quoteCounts[date].count++;
            quoteCounts[date].status.push(quote.status);
        });

        Object.keys(quoteCounts).forEach(date => {
            const dateButton = document.querySelector(`button[data-date="${date}"]`);
            if (dateButton) {
                const dateInfo = quoteCounts[date];
                if (new Date(date) < today) {
                    dateButton.classList.remove('bg-success', 'bg-warning', 'bg-danger');
                    dateButton.classList.add('bg-secondary');
                    dateButton.style.color = 'black';
                    dateButton.disabled = true;
                } else {
                    if (dateInfo.status.includes('pagada') || dateInfo.count >= 3) {
                        dateButton.classList.remove('bg-success', 'bg-warning');
                        dateButton.classList.add('bg-danger');
                        dateButton.disabled = true;
                    } else if (dateInfo.count >= 1 && dateInfo.count < 3) {
                        dateButton.classList.remove('bg-success');
                        dateButton.classList.add('bg-warning');
                    }
                }
            }
        });
    }

    function adjustDayButtonHeight() {
        const dayButtons = document.querySelectorAll('.day');
        dayButtons.forEach(button => {
            const width = button.offsetWidth;
            button.style.height = `${width}px`;
            button.style.lineHeight = `${width}px`;
        });
    }

    window.addEventListener('resize', adjustDayButtonHeight);

    generateCalendar();
});

function showConfirmedServicesModal() {
    const confirmedServicesContainer = document.getElementById('confirmedServicesContainer');
    confirmedServicesContainer.innerHTML = '';

    if (confirmedServices.length === 0) {
        confirmedServicesContainer.innerHTML = '<div class="alert alert-info">No hay servicios confirmados.</div>';
        return;
    }

    confirmedServices.forEach(service => {
        const serviceCard = document.createElement('div');
        serviceCard.classList.add('col-md-4', 'mb-3');
        const imagePath = service.image_path ? service.image_path : '/images/imagen6.jpg';
        serviceCard.innerHTML = `
            <div class="card service-card confirmed" id="confirmedServiceCard${service.id}">
                <img src="${imagePath}" class="card-img-top" alt="${service.name}">
                <div class="card-body">
                    <h5 class="card-title">${service.name}</h5>
                    <p class="card-text">${service.description}</p>
                    <p class="card-text"><strong><i class="fas fa-dollar-sign"></i> ${service.price}</strong></p>
                    <button type="button" class="btn btn-danger mt-2" onclick="removeConfirmedService(${service.id})">Eliminar</button>
                </div>
            </div>
        `;
        confirmedServicesContainer.appendChild(serviceCard);
    });

    const confirmedServicesModal = new bootstrap.Modal(document.getElementById('confirmedServicesModal'));
    confirmedServicesModal.show();
}

function removeConfirmedService(serviceId) {
    // 1. Eliminar del array de servicios confirmados
    confirmedServices = confirmedServices.filter(service => service.id !== serviceId);
    
    // 2. Eliminar la tarjeta del servicio confirmado del modal
    const confirmedServiceCard = document.getElementById(`confirmedServiceCard${serviceId}`);
    if (confirmedServiceCard) {
        confirmedServiceCard.remove();
    }

    // 3. Restablecer el estado del servicio en el modal de servicios
    const serviceCard = document.getElementById(`serviceCard${serviceId}`);
    if (serviceCard) {
        // Quitar clase y restablecer checkbox
        serviceCard.classList.remove('confirmed');
        const checkbox = serviceCard.querySelector('.form-check-input');
        if (checkbox) {
            checkbox.checked = false;
            checkbox.disabled = false;
        }

        const descriptionContainer = serviceCard.querySelector(`#descriptionContainer${serviceId}`);
        if (descriptionContainer) {
            descriptionContainer.style.display = 'none';
            const inputs = descriptionContainer.querySelectorAll('input');
            inputs.forEach(input => {
                input.value = '';
                input.removeAttribute('readonly');
            });
        }

        const confirmBtn = serviceCard.querySelector(`#confirmBtn${serviceId}`);
        if (confirmBtn) {
            confirmBtn.style.display = 'block';
            confirmBtn.disabled = true;
        }

        const confirmationMessage = serviceCard.querySelector('.alert-success');
        if (confirmationMessage) {
            confirmationMessage.remove();
        }
    }

    updateConfirmedServicesModal();
    updateCosts();
}

function showServicesModal(categoryId) {
    const servicesContainer = document.getElementById('servicesContainer');
    servicesContainer.innerHTML = '';

    const filteredServices = servicesData.filter(service => 
        service.service_category_id == categoryId
    );

    if (filteredServices.length === 0) {
        servicesContainer.innerHTML = '<div class="alert alert-info">No hay servicios disponibles para esta categoría.</div>';
        return;
    }

    filteredServices.forEach(service => {
        const isConfirmed = confirmedServices.some(cs => cs.id === service.id);
        const serviceCard = document.createElement('div');
        serviceCard.classList.add('col-md-4', 'col-sm-6', 'col-6', 'mb-3');
        serviceCard.innerHTML = `
            <div class="card service-card ${isConfirmed ? 'confirmed' : ''}" data-category="${service.service_category_id}" id="serviceCard${service.id}">
                <img src="${service.image_path ?? '/images/imagen6.jpg'}" class="card-img-top" alt="${service.name}">
                <div class="card-body">
                    <h5 class="card-title">${service.name}</h5>
                    <p class="card-text">${service.description}</p>
                    <p class="card-text"><strong> Precio: <i class="fas fa-dollar-sign"></i> ${service.price}</strong></p>
                    <p class="card-text"> Costo: <i class="fas fa-dollar-sign"></i> ${service.coast}</p>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="${service.id}" 
                            id="service${service.id}" 
                            onchange="toggleServiceDescription(${service.id})"
                            ${isConfirmed ? 'checked disabled' : ''}>
                    </div>
                    <div class="mt-3" id="descriptionContainer${service.id}" style="display: none">
                        <input type="text" 
                            id="description${service.id}" 
                            class="form-control" 
                            placeholder="Ingrese una descripción"
                            value="${isConfirmed ? confirmedServices.find(cs => cs.id === service.id).description : ''}">
                        ${service.quantifiable ? `
                        <input type="number" 
                            id="quantity${service.id}" 
                            class="form-control mt-2" 
                            placeholder="Ingrese la cantidad"
                            value="${isConfirmed ? confirmedServices.find(cs => cs.id === service.id).quantity : ''}">
                        ` : ''}
                        <input type="number" 
                            id="cost${service.id}" 
                            class="form-control mt-2" 
                            placeholder="Ingrese el costo"
                            value="${isConfirmed ? confirmedServices.find(cs => cs.id === service.id).cost : ''}">
                        ${!isConfirmed ? `
                            <button type="button" class="btn btn-success mt-2" 
                                onclick="confirmService(${service.id})" 
                                id="confirmBtn${service.id}" 
                                disabled>
                                Confirmar
                            </button>
                        ` : ''}
                    </div>
                </div>
            </div>
        `;
        servicesContainer.appendChild(serviceCard);
    });

    const servicesModal = new bootstrap.Modal(document.getElementById('servicesModal'));
    servicesModal.show();
}

function selectPlace(placeId) {
    document.querySelectorAll('.place-card').forEach(card => {
        card.classList.remove('selected');
    });

    const selectedCard = document.querySelector(`.place-card[onclick="selectPlace(${placeId})"]`);
    if (selectedCard) {
        selectedCard.classList.add('selected');
    }
}

function toggleOtherEventType() {
    const eventType = document.getElementById('eventType').value;
    const otherEventTypeContainer = document.getElementById('otherEventTypeContainer');
    if (eventType === 'Otro') {
        otherEventTypeContainer.style.display = 'block';
    } else {
        otherEventTypeContainer.style.display = 'none';
    }
}

function toggleServiceDescription(serviceId) {
    const descriptionContainer = document.getElementById(`descriptionContainer${serviceId}`);
    const checkbox = document.getElementById(`service${serviceId}`);
    const confirmBtn = document.getElementById(`confirmBtn${serviceId}`);
    const descriptionInput = document.getElementById(`description${serviceId}`);

    if (checkbox.checked) {
        descriptionContainer.style.display = 'block';
        
        descriptionInput.addEventListener('input', function() {
            confirmBtn.disabled = this.value.trim() === '';
        });
    } else {
        descriptionContainer.style.display = 'none';
        confirmBtn.disabled = true;
    }
}

function updateDurationOptions() {
    const startTimeElement = document.getElementById('start_time');
    const durationElement = document.getElementById('duration');
    const startTime = startTimeElement.value;

    if (!startTime) {
        return;
    }

    const [startHour, startMinute] = startTime.split(':').map(Number);
    const maxEndHour = 3;

    while (durationElement.options.length > 1) {
        durationElement.remove(1);
    }

    for (let i = 4; i <= 10; i++) {
        const endHour = (startHour + i) % 24;
        if (endHour <= maxEndHour || endHour >= startHour) {
            const option = document.createElement('option');
            option.value = i;
            option.text = `${i} horas`;
            durationElement.add(option);
        }
    }
}

function confirmService(serviceId) {
    const serviceCard = document.getElementById(`serviceCard${serviceId}`);
    const descriptionInput = document.getElementById(`description${serviceId}`);
    const quantityInput = document.getElementById(`quantity${serviceId}`);
    const costInput = document.getElementById(`cost${serviceId}`);
    const confirmBtn = document.getElementById(`confirmBtn${serviceId}`);
    const checkbox = document.getElementById(`service${serviceId}`);
    const description = descriptionInput.value.trim();
    const quantity = quantityInput ? quantityInput.value : 1;
    const cost = costInput ? costInput.value : 0;
    const service = servicesData.find(s => s.id == serviceId);

    if (description && cost) {
        if (!confirmedServices.some(s => s.id === serviceId)) {
            confirmedServices.push({
                id: serviceId,
                description: description,
                quantity: quantity,
                cost: cost,
                name: service.name,
                price: service.price,
                image_path: service.image_path,
                service_category_id: service.service_category_id
            });
        }

        console.log('Servicios confirmados:', confirmedServices);

        serviceCard.classList.add('confirmed');
        descriptionInput.setAttribute('readonly', true);
        if (quantityInput) {
            quantityInput.setAttribute('readonly', true);
        }
        costInput.setAttribute('readonly', true);
        confirmBtn.style.display = 'none';
        checkbox.disabled = true;

        const confirmationMessage = document.createElement('div');
        confirmationMessage.classList.add('alert', 'alert-success', 'mt-2');
        confirmationMessage.textContent = 'Servicio confirmado';
        serviceCard.querySelector('.card-body').appendChild(confirmationMessage);

        updateConfirmedServicesModal();
        updateCosts();
    }
}

function updateConfirmedServicesModal() {
    const confirmedServicesContainer = document.getElementById('confirmedServicesContainer');
    confirmedServicesContainer.innerHTML = '';

    if (confirmedServices.length === 0) {
        confirmedServicesContainer.innerHTML = '<div class="alert alert-info">No hay servicios confirmados.</div>';
        return;
    }

    confirmedServices.forEach(service => {
        const serviceCard = document.createElement('div');
        serviceCard.classList.add('col-md-4', 'mb-3');
        const imagePath = service.image_path ? service.image_path : '/images/imagen6.jpg';
        serviceCard.innerHTML = `
            <div class="card service-card" id="confirmedServiceCard${service.id}">
                <img src="${imagePath}" class="card-img-top" alt="${service.name}">
                <div class="card-body">
                    <h5 class="card-title">${service.name}</h5>
                    <p class="card-text">${service.description}</p>
                    <p class="card-text"><strong><i class="fas fa-dollar-sign"></i> ${service.price}</strong></p>
                    <button type="button" class="btn btn-danger mt-2" onclick="removeConfirmedService(${service.id})">Eliminar</button>
                </div>
            </div>
        `;
        confirmedServicesContainer.appendChild(serviceCard);
    });
}

function showConfirmedServicesModal() {
    updateConfirmedServicesModal();
    const confirmedServicesModal = new bootstrap.Modal(document.getElementById('confirmedServicesModal'));
    confirmedServicesModal.show();
}

function adjustCalendarControls() {
    const prevMonthButton = document.getElementById('prevMonth');
    const nextMonthButton = document.getElementById('nextMonth');

    if (window.innerWidth < 992) {
        prevMonthButton.textContent = '<';
        nextMonthButton.textContent = '>';
    } else {
        prevMonthButton.textContent = '< Anterior';
        nextMonthButton.textContent = 'Siguiente >';
    }
}
document.getElementById('owner_phone').addEventListener('input', function (event) {
        const input = event.target;
        input.value = input.value.replace(/\D/g, '');
        if (input.value.length > 10) {
            input.value = input.value.slice(0, 10);
        }
    });

    </script>
</body>
</html>
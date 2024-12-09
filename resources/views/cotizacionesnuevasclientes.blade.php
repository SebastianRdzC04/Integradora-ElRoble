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
        <form id="quoteForm" method="POST" action="{{ route('cotizaciones.storeQuote') }}">
            @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <h4 class="card-title mb-4 text-center">Selecciona una Fecha</h4>
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
                            <p><span class="badge bg-warning">Amarillo</span> - Más personas cotizando por la misma fecha</p>
                            <p><span class="badge bg-danger">Rojo</span> - No Disponible</p>
                            <p><span class="badge bg-secondary">Gris</span> - Fecha Inaccesible</p>
                        </div>
                        <div class="mt-4">
                            <div class="mb-3">
                                <label for="selectedDate" class="form-label">Fecha Seleccionada:</label>
                                <input type="text" 
                                       class="form-control @error('date') is-invalid @enderror" 
                                       id="selectedDate" 
                                       name="date"
                                       value="{{ old('date') }}" 
                                       placeholder="AAAA-MM-DD" 
                                       readonly>
                                @error('date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="start_time" class="form-label">
                                        <i class="fas fa-clock"></i> Hora de Inicio
                                    </label>
                                    <input type="time" 
                                           id="start_time" 
                                           name="start_time"
                                           class="form-control @error('start_time') is-invalid @enderror"
                                           value="{{ old('start_time') ? \Carbon\Carbon::parse(old('start_time'))->format('H:i') : '' }}"
                                           onblur="roundTime(this)" 
                                           onchange="updateDurationOptions()"
                                           required>
                                    @error('start_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
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
                                    @error('end_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-body">

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

                        <div class="mt-4" style="display: flex; justify-content: center;">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmedServicesModal" onclick="updateConfirmedServicesModal()">
                                Ver Servicios Confirmados
                            </button>
                        </div>

                        <div class="mt-4">
                            <div class="alert alert-info justified" role="alert">
                                ¡Haz de tu evento un momento aún más especial añadiendo servicios para una mejor experiencia!
                            </div>
                            <h4 class="text-center">Servicios Disponibles:</h4>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-4 text-center">
            <button type="button" class="btn btn-success" style="margin-bottom: 30px; margin-top: -15px;" onclick="submitQuote()">Enviar Cotización</button>
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

    console.log('selectedDateElement:', selectedDateElement);
    console.log('startTimeElement:', startTimeElement);
    console.log('durationElement:', durationElement);
    console.log('eventTypeElement:', eventTypeElement);
    console.log('otherEventTypeElement:', otherEventTypeElement);
    console.log('guestCountElement:', guestCountElement);
    console.log('placeCard:', placeCard);

    const selectedDate = selectedDateElement ? selectedDateElement.value : null;
    const startTime = startTimeElement ? startTimeElement.value : null;
    const duration = durationElement ? durationElement.value : null;
    const eventType = eventTypeElement ? eventTypeElement.value : null;
    const otherEventType = otherEventTypeElement ? otherEventTypeElement.value : null;
    const guestCount = guestCountElement ? guestCountElement.value : null;
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

    if (!selectedDate || !startTime || !duration || !eventType || !guestCount || !placeId) {
        alert('Por favor, complete todos los campos requeridos.');
        return;
    }

    const place = places.find(p => p.id == placeId);
    if (place && guestCount > place.max_guest) {
        alert(`La cantidad máxima de invitados para este lugar es ${place.max_guest}.`);
        guestCountElement.value = place.max_guest;
        return;
    }

    const [startHour, startMinute] = startTime.split(':').map(Number);
    const endHour = (startHour + parseInt(duration)) % 24;
    const endTime = `${String(endHour).padStart(2, '0')}:${String(startMinute).padStart(2, '0')}`;

    const form = document.getElementById('quoteForm');

    form.appendChild(generarInputOculto('date', selectedDate));
    form.appendChild(generarInputOculto('start_time', `${selectedDate} ${startTime}`));
    form.appendChild(generarInputOculto('end_time', `${selectedDate} ${endTime}`));
    form.appendChild(generarInputOculto('place_id', placeId));
    form.appendChild(generarInputOculto('guest_count', guestCount));
    form.appendChild(generarInputOculto('type_event', eventType === 'Otro' ? otherEventType : eventType));

    confirmedServices.forEach(service => {
        form.appendChild(generarInputOculto(`services[${service.id}][confirmed]`, true));
        form.appendChild(generarInputOculto(`services[${service.id}][description]`, service.description));
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

    const oldDate = "{{ old('date') }}";
    if (oldDate) {
        document.getElementById('selectedDate').value = oldDate;
        const dayButton = document.querySelector(`button[data-date="${oldDate}"]`);
        if (dayButton) {
            dayButton.click();
        }
    }

    const oldStartTime = "{{ old('start_time') }}";
    if (oldStartTime) {
        const time = new Date(oldStartTime);
        document.getElementById('start_time').value = 
            `${String(time.getHours()).padStart(2, '0')}:${String(time.getMinutes()).padStart(2, '0')}`;
        updateDurationOptions();
    }

    const oldPlaceId = "{{ old('place_id') }}";
    if (oldPlaceId) {
        selectPlace(oldPlaceId);
    }
});

function roundTime(input) {
    const time = input.value;
    const [hours, minutes] = time.split(':').map(Number);

    if (isNaN(hours) || isNaN(minutes) || hours < 0 || hours > 23 || minutes < 0 || minutes > 59) {
        input.value = '';
        return;
    }

    let roundedMinutes;
    if (minutes <= 15) {
        roundedMinutes = '00';
    } else if (minutes <= 45) {
        roundedMinutes = '30';
    } else {
        roundedMinutes = '00';
        hours = (hours + 1) % 24;
    }

    input.value = `${String(hours).padStart(2, '0')}:${roundedMinutes}`;
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
    confirmedServices = confirmedServices.filter(service => service.id !== serviceId);
    
    const confirmedServicesContainer = document.getElementById('confirmedServicesContainer');
    const serviceCardContainer = document.getElementById(`confirmedServiceCard${serviceId}`);
    if (serviceCardContainer) {
        serviceCardContainer.parentElement.remove();
    }

    if (confirmedServices.length === 0) {
        confirmedServicesContainer.innerHTML = '<div class="alert alert-info">No hay servicios confirmados.</div>';
    }

    const serviceCard = document.getElementById(`serviceCard${serviceId}`);
    if (serviceCard) {
        serviceCard.classList.remove('confirmed');
        const checkbox = serviceCard.querySelector('.form-check-input');
        if (checkbox) {
            checkbox.checked = false;
            checkbox.disabled = false;
        }

        const descriptionContainer = serviceCard.querySelector(`#descriptionContainer${serviceId}`);
        if (descriptionContainer) {
            descriptionContainer.style.display = 'none';
            const descriptionInput = descriptionContainer.querySelector('input');
            if (descriptionInput) {
                descriptionInput.value = '';
                descriptionInput.removeAttribute('readonly');
            }
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
        serviceCard.classList.add('col-md-4', 'mb-3');
        serviceCard.innerHTML = `
            <div class="card service-card ${isConfirmed ? 'confirmed' : ''}" data-category="${service.service_category_id}" id="serviceCard${service.id}">
                <img src="${service.image_path ?? '/images/imagen6.jpg'}" class="card-img-top" alt="${service.name}">
                <div class="card-body">
                    <h5 class="card-title">${service.name}</h5>
                    <p class="card-text">${service.description}</p>
                    <p class="card-text"><strong><i class="fas fa-dollar-sign"></i> ${service.price}</strong></p>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="${service.id}" 
                            id="service${service.id}" 
                            onchange="toggleServiceDescription(${service.id})"
                            ${isConfirmed ? 'checked disabled' : ''}>
                    </div>
                    <div class="mt-3" id="descriptionContainer${service.id}" style="display: none">
                        <label for="description${service.id}" class="form-label">Descripción:</label>
                        <input type="text" 
                            id="description${service.id}" 
                            class="form-control" 
                            placeholder="Ingrese una descripción"
                            value="${isConfirmed ? confirmedServices.find(cs => cs.id === service.id).description : ''}">
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
    const confirmBtn = document.getElementById(`confirmBtn${serviceId}`);
    const checkbox = document.getElementById(`service${serviceId}`);
    const description = descriptionInput.value.trim();
    const service = servicesData.find(s => s.id == serviceId);

    if (description) {
        if (!confirmedServices.some(s => s.id === serviceId)) {
            confirmedServices.push({
                id: serviceId,
                description: description,
                name: service.name,
                price: service.price,
                image_path: service.image_path,
                service_category_id: service.service_category_id
            });
        }

        console.log('Servicios confirmados:', confirmedServices);

        serviceCard.classList.add('confirmed');
        descriptionInput.setAttribute('readonly', true);
        confirmBtn.style.display = 'none';
        checkbox.disabled = true;

        const confirmationMessage = document.createElement('div');
        confirmationMessage.classList.add('alert', 'alert-success', 'mt-2');
        confirmationMessage.textContent = 'Servicio confirmado';
        serviceCard.querySelector('.card-body').appendChild(confirmationMessage);

        updateConfirmedServicesModal();
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

    </script>
</body>
</html>
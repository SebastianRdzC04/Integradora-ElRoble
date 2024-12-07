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
    <style>
        .place-card {
            cursor: pointer;
            transition: transform 0.2s;
            margin-bottom: 15px;
        }
        .place-card:hover {
            transform: scale(1.02);
        }
        .place-card.selected {
            border: 3px solid #198754;
        }
        .card-img-top {
            height: 200px;
            object-fit: cover;
        }
        #calendar {
            max-width: 100%;
            background-color: white;
            padding: 15px;
            border-radius: 8px;
        }
        .days-header {
            display: flex;
            justify-content: space-between;
        }
        .day-header, .day {
            width: 14%;
            text-align: center;
        }
        .days-row {
            display: flex;
            justify-content: space-between;
        }
        .day {
            width: 40px;
            height: 40px;
            line-height: 40px;
            padding: 0;
            margin: 1px;
            cursor: pointer;
            border-radius: 50%;
            transition: background-color 0.3s, color 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .day.empty {
            background-color: #f0f0f0;
        }
        .day.bg-secondary, .day.bg-danger {
            cursor: not-allowed;
            pointer-events: none;
        }
        .day.bg-secondary {
            color: black;
        }
        .day.bg-primary {
            background-color: #007bff;
            color: white;
        }
        .day.bg-success {
            background-color: #28a745;
            color: white;
        }
        .day.bg-warning {
            background-color: #ffc107;
            color: black;
        }
        .day.day.bg-danger {
            color: rgb(160, 160, 160);
        }
        #calendarMonthYear {
            background-color: #1bad16ce;
            color: white;
            padding: 5px 10px;
            border-radius: 45px;
            text-transform: capitalize;
        }
        .btn-calendar {
            background-color: #007bff;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            border: none;
            transition: background-color 0.3s, color 0.3s;
        }
        .btn-calendar:hover {
            background-color: #0056b3;
            color: white;
        }
        @media (max-width: 992px) {
            .btn-calendar, #calendarMonthYear {
                font-size: 0.8rem;
            }
            .card-title {
                font-size: 1rem;
            }
        }
        .calendar-container {
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 15px;
    background-color: white;
}

@media (max-width: 430px) {
    .btn-calendar {
        padding: 5px;
    }
    .btn-calendar::after {
        content: '';
    }
    .btn-calendar span {
        display: none;
    }
    #calendarMonthYear {
        font-size: 0.8rem;
    }
    #calendarMonthYear::after {
        content: '';
    }
}

label[for="selectedDate"]::before {
    content: "\f073"; /* Icono de calendario */
    font-family: "Font Awesome 5 Free";
    font-weight: 900;
    margin-right: 5px;
}

label[for="startTime"]::before {
    content: "\f017"; /* Icono de reloj */
    font-family: "Font Awesome 5 Free";
    font-weight: 900;
    margin-right: 5px;
}
.service-card {
    width: 100%;
    margin-bottom: 15px;
    border: 2px solid rgb(255, 255, 255);
    border-radius: 8px;
    background-color: rgba(21, 80, 21, 0.9);
    color: white;
    text-align: center;
    transition: transform 0.3s;
    margin: 0 auto;
}

.service-card:hover {
    transform: scale(1.05);
}

.service-card img {
    width: 100%;
    height: 150px;
    object-fit: cover;
    border-top-left-radius: 8px;
    border-top-right-radius: 8px;
}

.service-card .card-body {
    padding: 10px;
}

.service-card h5 {
    color: #ffffff;
    margin-bottom: 5px;
}

.service-card p {
    margin: 0;
    font-size: 0.9em;
}

.service-card.expanded {
    width: 75%;
}

.service-card.confirmed {
    opacity: 0.7;
    pointer-events: none;
    background-color: rgba(21, 80, 21, 0.5);
}
.category-card {
    cursor: pointer;
    transition: transform 0.2s;
    margin-bottom: 15px;
}

.category-card:hover {
    transform: scale(1.02);
}

.category-card img {
    width: 100%;
    height: auto;
    object-fit: cover;
}
.service-card.confirmed input,
.service-card.confirmed button,
.service-card.confirmed .form-check {
    pointer-events: none;
    opacity: 0.6;
}
.service-card.confirmed .alert-success {
    opacity: 1;
    margin-top: 10px;
    background-color: rgba(40, 167, 69, 0.8);
    color: white;
}
    </style>
</head>
<body class="bg-light">
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Selecciona una Fecha</h4>
                        <div class="calendar-container">
                            <div id="calendar-controls" class="d-flex justify-content-between mb-2">
                                <button id="prevMonth" class="btn-calendar">&lt; Anterior</button>
                                <h6 id="calendarMonthYear"></h6>
                                <button id="nextMonth" class="btn-calendar">Siguiente &gt;</button>
                            </div>
                            <div id="calendar"></div>
                        </div>
                        <div id="calendar"></div>
                        <div class="mt-3">
                            <p><span class="badge bg-success">Verde</span> - Disponible</p>
                            <p><span class="badge bg-warning">Amarillo</span> - Más personas cotizando por la misma fecha</p>
                            <p><span class="badge bg-danger">Rojo</span> - No Disponible</p>
                            <p><span class="badge bg-secondary">Gris</span> - Fecha Inaccesible</p>
                        </div>
                        <div class="mt-4">
                            <div class="mb-3">
                                <label for="selectedDate" class="form-label">Fecha Seleccionada:</label>
                                <input type="text" class="form-control" id="selectedDate" placeholder="AAAA/MM/DD" readonly>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="start_time" class="form-label">
                                        <i class="fas fa-clock"></i> Hora de Inicio
                                    </label>
                                    <input type="time" id="start_time" class="form-control" required onblur="roundTime(this)" placeholder="XX:XX">
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Selecciona el Lugar</h4>
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
                        <div class="mt-4">
                            <div class="row">
                                @foreach($categories as $category)
                                    @php
                                        $imageUrl = $category->image_path ?? '/images/imagen4.jpg';
                                    @endphp
                                    <div class="col-md-4 mb-3">
                                        <div class="card category-card" data-category-id="{{ $category->id }}">
                                            <img src="{{ $imageUrl }}" class="card-img-top" alt="{{ $category->name }}" style="aspect-ratio: 4 / 3; object-fit: cover;">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $category->name }}</h5>
                                                <p class="card-text">{{ $category->description }}</p>
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
                        <!-- Cards de servicios se llenarán dinámicamente -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.0.0-beta1/dist/js/tempus-dominus.min.js"></script>
    <script>
        let confirmedServices = [];
        const servicesData = @json($services);

        document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.category-card').forEach(card => {
        card.addEventListener('click', function() {
            const categoryId = this.dataset.categoryId;
            showServicesModal(categoryId);
        });
    });
    // Remove localStorage retrieval
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
    const csrfToken = '{{ csrf_token() }}';

    prevMonthButton.addEventListener('click', () => changeMonth(-1));
    nextMonthButton.addEventListener('click', () => changeMonth(1));

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

        prevMonthButton.disabled = currentDate <= minDate;
        nextMonthButton.disabled = currentDate >= maxDate;

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
            dayButton.title = date.toDateString(); // Añadir tooltip

            if (date < today) {
                dayButton.classList.add('bg-secondary');
                dayButton.style.color = 'black';
            } else {
                dayButton.classList.add('bg-success');
                dayButton.addEventListener('click', function() {
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
        fetchCotizations();
        adjustDayButtonHeight();
    }

    function fetchCotizations() {
        fetch('/api/cotizations', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ start_date: new Date(currentDate.getFullYear(), currentDate.getMonth(), 1).toISOString().split('T')[0] })
        })
        .then(response => response.json())
        .then(data => {
            data.forEach(cotization => {
                const dateButton = document.querySelector(`button[data-date="${cotization.date}"]`);
                if (dateButton) {
                    const date = new Date(cotization.date);
                    if (date < today) {
                        dateButton.classList.remove('bg-success', 'bg-warning', 'bg-danger');
                        dateButton.classList.add('bg-secondary');
                        dateButton.style.color = 'black';
                        dateButton.disabled = true;
                    } else {
                        if (cotization.status === 'pagada' || cotization.count >= 3) {
                            dateButton.classList.remove('bg-success', 'bg-warning');
                            dateButton.classList.add('bg-danger');
                            dateButton.disabled = true;
                        } else if (cotization.count >= 1) {
                            dateButton.classList.remove('bg-success');
                            dateButton.classList.add('bg-warning');
                        }
                    }
                }
            });
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

function showServicesModal(categoryId) {
    const servicesContainer = document.getElementById('servicesContainer');
    servicesContainer.innerHTML = '';

    // Filter services by category
    const filteredServices = servicesData.filter(service => 
        service.service_category_id == categoryId
    );

    if (filteredServices.length === 0) {
        servicesContainer.innerHTML = '<div class="alert alert-info">No hay servicios disponibles para esta categoría.</div>';
        return;
    }

    // Generate service cards
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
                        <label class="form-check-label" for="service${service.id}">
                            Seleccionar
                        </label>
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
    // Remover selección previa
    document.querySelectorAll('.place-card').forEach(card => {
        card.classList.remove('selected');
    });

    // Seleccionar nueva card
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
        
        // Habilitar/deshabilitar botón basado en descripción
        descriptionInput.addEventListener('input', function() {
            confirmBtn.disabled = this.value.trim() === '';
        });
    } else {
        descriptionContainer.style.display = 'none';
        confirmBtn.disabled = true;
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
        // Add to confirmedServices array only
        confirmedServices.push({
            id: serviceId,
            description: description,
            name: service.name,
            price: service.price,
            category_id: service.service_category_id
        });

        // Update UI
        serviceCard.classList.add('confirmed');
        descriptionInput.setAttribute('readonly', true);
        confirmBtn.style.display = 'none';
        checkbox.disabled = true;

        const confirmationMessage = document.createElement('div');
        confirmationMessage.classList.add('alert', 'alert-success', 'mt-2');
        confirmationMessage.textContent = 'Servicio confirmado';
        serviceCard.querySelector('.card-body').appendChild(confirmationMessage);
    }
}

function validateForm() {
    const selectedDate = document.getElementById('selectedDate').value;
    const startTime = document.getElementById('start_time').value;
    const duration = document.getElementById('duration').value;
    const eventType = document.getElementById('eventType').value;
    const guestCount = document.getElementById('guestCount').value;

    if (!selectedDate || !startTime || !duration || !eventType || !guestCount) {
        alert('Por favor, complete todos los campos requeridos.');
        return false;
    }

    return true;
}

document.querySelector('form').addEventListener('submit', function(event) {
    if (!validateForm()) {
        event.preventDefault();
    }
});
    </script>
</body>
</html>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Cotización</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.css' rel='stylesheet'>
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
    </style>
</head>
<body class="bg-light">
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Selecciona una Fecha</h4>
                        <div id="calendar"></div>
                        
                        <div class="mt-4">
                            <div class="mb-3">
                                <label class="form-label">Fecha Seleccionada:</label>
                                <input type="text" class="form-control" id="selectedDate" readonly>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Hora de Inicio:</label>
                                <select class="form-select" id="startTime">
                                    <option value="">Seleccione hora de inicio</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Duración del Evento (horas):</label>
                                <select class="form-select" id="duration">
                                    <option value="">Seleccione duración</option>
                                    <option value="4">4 horas</option>
                                    <option value="5">5 horas</option>
                                    <option value="6">6 horas</option>
                                    <option value="7">7 horas</option>
                                    <option value="8">8 horas</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Hora de Finalización:</label>
                                <input type="text" class="form-control" id="endTime" readonly>
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
                            <select class="form-select" id="eventType" name="type_event">
                                <option value="">Selecciona el tipo de evento</option>
                                <option value="XV's">XV's</option>
                                <option value="Cumpleaños">Cumpleaños</option>
                                <option value="Graduación">Graduación</option>
                                <option value="Posada">Posada</option>
                                <option value="Boda">Boda</option>
                                <option value="Baby Shower">Baby Shower</option>
                                <option value="Otro">Otro</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                selectable: true,
                select: function(info) {
                    document.getElementById('selectedDate').value = info.startStr;
                }
            });
            calendar.render();

            // Generar opciones de hora de inicio
            const startTimeSelect = document.getElementById('startTime');
            for (let hour = 12; hour <= 23; hour++) {
                // Agregar hora completa
                startTimeSelect.add(new Option(
                    ${hour}:00,
                    ${hour}:00
                ));
                // Agregar media hora
                startTimeSelect.add(new Option(
                    ${hour}:30,
                    ${hour}:30
                ));
            }

            // Calcular hora de finalización
            function calculateEndTime() {
                const startTime = document.getElementById('startTime').value;
                const duration = document.getElementById('duration').value;
                
                if (startTime && duration) {
                    const [hours, minutes] = startTime.split(':');
                    let endHour = parseInt(hours) + parseInt(duration);
                    const endMinutes = minutes;
                    
                    if (endHour >= 24) {
                        endHour = endHour - 24;
                    }
                    
                    document.getElementById('endTime').value = 
                        ${endHour.toString().padStart(2, '0')}:${endMinutes};
                }
            }

            // Event listeners
            document.getElementById('startTime').addEventListener('change', calculateEndTime);
            document.getElementById('duration').addEventListener('change', calculateEndTime);
        });

        function selectPlace(placeId) {
            // Remover selección previa
            document.querySelectorAll('.place-card').forEach(card => {
                card.classList.remove('selected');
            });

            // Seleccionar nueva card
            const selectedCard = document.querySelector(.place-card[onclick="selectPlace(${placeId})"]);
            if (selectedCard) {
                selectedCard.classList.add('selected');
            }
        }
    </script>
</body>
</html>
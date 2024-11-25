@extends('layouts.formslogin')

@section('title')
    Inicio de sesión
@endsection

@section('link')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('title form')
    Hola Completa tus datos para iniciar sesión
@endsection

@section('subtitle form')
    <h7>Esto es usado para enviar tus cotizaciones</h7>
@endsection

@section('form')
    <form method="POST" action="{{ route('registergoogle.store') }}">
        @csrf
        <div class="form-floating mb-3">
            <input type="text" name="phone" id="phone" class="form-control" maxlength="10" pattern="\d{10}" title="Ingresa un número de 10 dígitos" required>
            <label for="phone">Ingresa tu Teléfono</label>
        </div>
    
        <div class="form-control mb-3">
    <label>Ingresa tu Fecha de cumpleaños</label>
    <div class="row mb-3">
        <div class="col form-control">
            <div class="row-12">
                <label>Dia</label>
            </div>
            <div class="row-12">
                <select name="day" id="day" class="form-control-sm" required>
                    @for ($i = 1; $i <= 31; $i++)
                    <option value="{{ $i }}">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                    @endfor
                </select>
            </div>
        </div>
        
        <!-- Mes -->
        <div class="col form-control">
            <div class="row-12">
                <label>Mes</label>
            </div>
            <div class="row-12">
                <select name="month" id="month" class="form-control-sm" required>
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                    @endfor
                </select>
            </div>
        </div>

        <!-- Año -->
        <div class="col form-control">
            <div class="row-12">
                <label>Año</label>
            </div>
            <div class="row-12">
                <select name="year" id="year" class="form-control-sm" required>
                    @for ($i = date('Y'); $i >= 1900; $i--)
                    <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>
        </div>
    </div>
</div>
    
    <div class="form-floating mb-3">
        <select name="gender" id="gender" class="form-control">
            <option value="Otro">Otro</option>
            <option value="Masculino">Masculino</option>
            <option value="Femenino">Femenino</option>
        </select>
        <label for="gender">Género</label>
    </div>


        <!-- Checkbox para omitir la creación de la contraseña -->
        <div class="form-chec mb-3">
            <input type="checkbox" name="omit_password" id="omit_password" class="form-check-input">
            <label class="form-check-label" for="omit_password">Solo Google para iniciar sesión</label>
        </div>

        <!-- Input para contraseña (solo visible si el checkbox no está marcado) -->
        <div class="input-group">
            <div class="form-floating mb-3" id="passwordField" style="display:true;">
                <input type="password" name="password" id="password" class="form-control" required minlength="8">
                <label for="password">Crea una Contraseña</label>
            </div>
            <button class="input-group-text mb-3" type="button" id="butoneye">
                <svg id="eyeclose" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <g fill="none" stroke="black" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                        <path d="M15 12a3 3 0 1 1-6 0a3 3 0 0 1 6 0"/>
                        <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7s-8.268-2.943-9.542-7"/>
                    </g>
                </svg>
                <svg id="eyeopen" style="display: none;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <path fill="none" stroke="black" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M3 10a13.4 13.4 0 0 0 3 2.685M21 10a13.4 13.4 0 0 1-3 2.685m-8 1.624L9.5 16.5m.5-2.19a10.6 10.6 0 0 0 4 0m-4 0a11.3 11.3 0 0 1-4-1.625m8 1.624l.5 2.191m-.5-2.19a11.3 11.3 0 0 0 4-1.625m0 0l1.5 1.815M6 12.685L4.5 14.5"/>
                </svg>
            </button>

        </div>

        <!-- Modal que aparece si el usuario omite la contraseña -->
        <div class="modal fade" id="omitPasswordModal" tabindex="-1" aria-labelledby="omitPasswordModalLabel" aria-hidden="true">
            <div class="modal-dialog" style="z-index: 4;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="omitPasswordModalLabel">¿Estás seguro de omitir la contraseña?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Si omites la creación de una contraseña, solo podrás iniciar sesión usando tu cuenta de Google en el futuro.
                    </div>
                    <div class="modal-footer d-flex" style="justify-content: center;">
                        <button type="button" class="btn btn-primary" id="acceptbutton">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-success w-100">Registrar</button>
    </form>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
<script>
    // Función para calcular los días máximos en un mes dado el año y el mes seleccionados
    function getDaysInMonth(month, year) {
        return new Date(year, month, 0).getDate();
    }

    // Función para ajustar el día si es necesario
    function adjustDay() {
        const daySelect = document.getElementById('day');
        const monthSelect = document.getElementById('month');
        const yearSelect = document.getElementById('year');
        
        const day = parseInt(daySelect.value, 10);
        const month = parseInt(monthSelect.value, 10);
        const year = parseInt(yearSelect.value, 10);
        
        // Si el mes y el año están definidos
        if (month && year) {
            const maxDays = getDaysInMonth(month, year); // Obtener el máximo de días para el mes/año
            if (day > maxDays) {
                // Si el día seleccionado es mayor al máximo de días, ajustarlo al último día del mes
                daySelect.value = maxDays;
            }

            // Actualizar el rango de días en el select si el mes cambia
            for (let i = 1; i <= 31; i++) {
                const option = daySelect.querySelector(`option[value="${i}"]`);
                if (i <= maxDays) {
                    option.style.display = 'block'; // Mostrar opción
                } else {
                    option.style.display = 'none'; // Ocultar opción
                }
            }
        }
    }

    // Añadir evento para actualizar el día al cambiar el mes o el año
    document.getElementById('month').addEventListener('change', adjustDay);
    document.getElementById('year').addEventListener('change', adjustDay);

    // Ajustar los días al cargar la página si ya hay valores seleccionados
    window.onload = adjustDay;
</script>

    <script>
        document.getElementById('basic-addon1').addEventListener('click', function() {
            var eyeClose = document.getElementById('eyeclose');
            var eyeOpen = document.getElementById('eyeopen');
            
    // Alternar la visibilidad de los iconos
    if (eyeClose.style.display === 'none') {
        eyeClose.style.display = 'block';
        eyeOpen.style.display = 'none';
    } else {
        eyeClose.style.display = 'none';
        eyeOpen.style.display = 'block';
    }
    

    //ocultar y mostrar la contrasena
    var passwordField = document.getElementById('password');
    if (passwordField.type === 'password') {
        passwordField.type = 'text'; 
    } else {
        passwordField.type = 'password';
    }
});

    </script>

    <script>
        // Mostrar u ocultar el campo de la contraseña dependiendo del estado del checkbox
        const omitPasswordCheckbox = document.getElementById('omit_password');
        const passwordField = document.getElementById('passwordField');
        const butoneye = document.getElementById('butoneye')
        const modal = new bootstrap.Modal(document.getElementById('omitPasswordModal'), {
            backdrop: false  // Desactiva el fondo negro predeterminado
        });

        omitPasswordCheckbox.addEventListener('change', function() {
            if (this.checked) {
                // Mostrar el modal si se marca el checkbox
                modal.show();

                // Crear y mover el fondo del modal dentro del formulario
                const backdrop = document.createElement('div');
                backdrop.classList.add('modal-backdrop', 'fade', 'show');
                backdrop.style.setProperty('z-index', '3');
                document.getElementById('omitPasswordModal').appendChild(backdrop);
            } else {
                // Mostrar el campo de la contraseña si se desmarca el checkbox
                passwordField.style.display = 'block';
                butoneye.style.display = 'block';
            }
        });

        // Confirmar omitir la contraseña
        document.getElementById('acceptbutton').addEventListener('click', function() {
            // Ocultar el campo de la contraseña y marcar el checkbox
            passwordField.style.display = 'none';
            butoneye.style.display = 'none';

            omitPasswordCheckbox.checked = true;
            modal.hide();

            // Eliminar el fondo modal después de cerrar
            const backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) {
                backdrop.remove();
            }
        });

        // Eliminar el fondo modal si se cierra el modal por otras razones
        document.querySelectorAll('.btn-close').forEach(btn => {
            btn.addEventListener('click', function() {
                const backdrop = document.querySelector('.modal-backdrop');
                if (backdrop) {
                    backdrop.remove();
                }
            });
        });
    </script>
@endsection

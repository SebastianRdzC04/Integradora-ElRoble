@extends('layouts.formslogin')        
                <button class="btn btn-toolbar" onclick="backStep()" id="btnback" style="display:none; color:brown;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
                    </svg>
                    </button>  
                @section('title form') 
                Crear una Cuenta 
                @endsection

            @section('form')
                    
                <form method="POST" action="{{ route('register.store') }}" id="registrationForm">
                    @csrf

                    <script>
        // Verifica si hay errores de validación
        @if ($errors->any())
            // Itera sobre todos los errores y muestra un mensaje de Toastr
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach

            // Después de mostrar los errores con Toastr, enfoque en el primer campo con error
            @foreach ($errors->keys() as $key)
                var input = document.querySelector('[name="{{ $key }}"]');
                if (input) {
                    input.focus();
                    break; // Solo poner foco en el primer campo con error
                }
            @endforeach
        @endif
    </script>
                    <!-- paso 1 ----------------------------------------------------------- -->
                    <div id="step1">

                    @if (filter_var($phoneoremail, FILTER_VALIDATE_EMAIL))
                        <div class="form-floating mb-3">
                            <input type="email" name="email" id="email" class="form-control" value="{{ old('email',$phoneoremail) }}" readonly>
                            <label for="email">Correo Electrónico</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" name="phone" id="phone" class="form-control" maxlength="10" pattern="\d{10}" title="Ingresa un número de 10 dígitos" value="{{ old('phone') }}" required>
                            <label for="phone">Teléfono</label>
                        </div>
                    @else
                        <div class="form-floating mb-3">
                            <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone',$phoneoremail) }}" readonly>
                            <label for="phone">Teléfono</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control" required>
                            <label for="email">Correo Electrónico</label>
                        </div>
                    @endif

                        <div class="form-floating mb-3">
                            <input type="text" name="first_name" id="firstName" class="form-control" value="{{ old('first_name') }}" required>
                            <label for="first_name">Nombre(s):</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" name="last_name" id="lastName" value="{{ old('last_name') }}" class="form-control" required>
                            <label for="last_name">Apellido(s):</label>
                        </div>

                        <button type="button" class="btn btn-primary w-100" onclick="nextStep()">Siguiente</button>
                    </div>

                    <!-- paso 2 ----------------------------------------------------------- -->
                    <div id="step2" style="display: none;">
                     
                        <!--fecha de cumpleaños-->
                        <div class="form-control mb-3">
                            <label>Ingresa tu Fecha de cumpleaños</label>
                            <div class="row">
                                <div class="col form-control">
                                    <div class="row-12">
                                        <label>Dia</label>
                                    </div>
                                    <div class="row-12">
                                        <select name="day" value="{{ old('day') }}" id="day" class="form-control-sm" required>
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
                                        <select name="month" value="{{ old('month') }}" id="month" class="form-control-sm" required>
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
                                        <select name="year" value="{{ old('year') }}" id="year" class="form-control-sm" required>
                                            @for ($i = date('Y'); $i >= 1900; $i--)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-floating mb-3">
                            <select name="gender" id="gender" value="{{ old('gender') }}" class="form-control">
                                <option value="Otro">Otro</option>
                                <option value="Masculino">Masculino</option>
                                <option value="Femenino">Femenino</option>
                            </select>
                            <label for="gender">Género</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="password" name="password" id="password" class="form-control" required>
                            <label for="password">Contraseña</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required autocomplete="off">
                            <label for="password_confirmation">Confirmar Contraseña</label>
                        </div>

                        <button type="submit" class="btn btn-success w-100">Registrar</button>
                    </div>
                </form>

            @endsection
        

@section('script')
<script>
    // revisar el dia correcto dado el año y el mes
    function getDaysInMonth(month, year) {
        return new Date(year, month, 0).getDate();
    }

    // funcion para adapatar la fecha correcta para ese mes
    function adjustDay() {
        const daySelect = document.getElementById('day');
        const monthSelect = document.getElementById('month');
        const yearSelect = document.getElementById('year');
        
        const day = parseInt(daySelect.value, 10);
        const month = parseInt(monthSelect.value, 10);
        const year = parseInt(yearSelect.value, 10);
        
        if (month && year) {
            // maximo de dias para el mes o año
            const maxDays = getDaysInMonth(month, year); 
            if (day > maxDays) {
                // esto siempre lo regresa al maximo de dias establecidos
                daySelect.value = maxDays;
            }

            // aqui se actualiza el dia si el mes llega a cambiar
            for (let i = 1; i <= 31; i++) {
                const option = daySelect.querySelector(`option[value="${i}"]`);
                if (i <= maxDays) {
                    option.style.display = 'block';
                } else {
                    option.style.display = 'none';
                }
            }
        }
    }

    document.getElementById('month').addEventListener('change', adjustDay);
    document.getElementById('year').addEventListener('change', adjustDay);

    // ajuste de días si ya hay valores seleccionados
    window.onload = adjustDay;
</script>

    <script>
            function backStep() {
            document.getElementById("step1").style.display = "block";
            document.getElementById("step2").style.display = "none";
            document.getElementById("btnback").style.display = "none";
        }
            function nextStep() {
            document.getElementById("step1").style.display = "none";
            document.getElementById("step2").style.display = "block";
            document.getElementById("btnback").style.display = "block";
        }
    </script>
@endsection

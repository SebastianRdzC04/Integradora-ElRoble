@extends('layouts.formslogin')

@section('title')
    Inicio de sesión
@endsection

@section('title form')
    Hola {{$user->user['name']}} completa tus datos para iniciar sesión
@endsection


@section('subtitle form')
    <h7>Esto es usado para enviar tus cotizaciones</h7>
@endsection

@section('form')
    <form method="POST" action="{{ route('registerfacebook.store') }}">
        @csrf
        <div class="form-floating mb-3">
            <input type="text" name="phone" id="phone" class="form-control" maxlength="10" pattern="\d{10}" title="Ingresa un número de 10 dígitos" required autocomplete="off">
            <label for="phone">Ingresa tu Teléfono</label>
        </div>
    <!--fecha de cumpleaños-->
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

        <button type="submit" class="btn btn-success w-100">Registrar</button>
    </form>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
<script>
    function getDaysInMonth(month, year) {
        return new Date(year, month, 0).getDate();
    }

    function adjustDay() {
        const daySelect = document.getElementById('day');
        const monthSelect = document.getElementById('month');
        const yearSelect = document.getElementById('year');
        
        const day = parseInt(daySelect.value, 10);
        const month = parseInt(monthSelect.value, 10);
        const year = parseInt(yearSelect.value, 10);
        
        if (month && year) {
            const maxDays = getDaysInMonth(month, year); 
            if (day > maxDays) {
                daySelect.value = maxDays;
            }

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

    window.onload = adjustDay;
</script>
@endsection

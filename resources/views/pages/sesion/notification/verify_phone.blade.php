@extends('layouts.formslogin')

@section('title')
    Verificación de correo
@endsection

@section('link')
    <style>
        .code-input {
    width: 50px;
    height: 50px;
    text-align: center;
    font-size: 1.5rem;
    margin-right: 5px;
    border: 1px solid #ccc;
}

.d-flex {
    display: flex;
}
    </style>
@endsection

@section('title form')
    Verifica tu Email
@endsection

@section('subtitle form')
        <p>Te hemos enviado un codigo de verificación a tu numero de telefono. Por favor, revisa tu bandeja de entrada.</p>
    
@endsection

@section('form')
<a href="/">Verificar más tarde</a>

<form id="resendForm" action="{{ route('verification.send') }}" method="POST">
    @csrf
    <label for="code">Código de verificación:</label>

        <div class="form-floating mb-3">
            <div class="d-flex">
                <!-- Campo para el primer dígito -->
                <input type="text" name="code1" id="code1" placeholder="#" pattern="\d*" class="form-control code-input" maxlength="1" required autocomplete="off" oninput="moveFocus(1)">
                
                <!-- Campo para el segundo dígito -->
                <input type="text" name="code2" id="code2" pattern="\d*" class="form-control code-input" maxlength="1" required autocomplete="off" oninput="moveFocus(2)">
                
                <!-- Campo para el tercer dígito -->
                <input type="text" name="code3" id="code3" pattern="\d*" class="form-control code-input" maxlength="1" required autocomplete="off" oninput="moveFocus(3)">
                
                <!-- Campo para el cuarto dígito -->
                <input type="text" name="code4" id="code4" pattern="\d*" class="form-control code-input" maxlength="1" required autocomplete="off" oninput="moveFocus(4)">

                <!-- Campo para el quinto dígito -->
                <input type="text" name="code5" id="code5" pattern="\d*" class="form-control code-input" maxlength="1" required autocomplete="off" oninput="moveFocus(5)">

                <!-- Campo para el sexto dígito -->
                <input type="text" name="code6" id="code6" pattern="\d*" class="form-control code-input" maxlength="1" required autocomplete="off" oninput="moveFocus(6)">

            </div>
        </div>
        
        <div class="d-flex col mb-3">
            <div class="col-6">
                <button class="btn">Verificar con email</button>
            </div>
            <div class="col-6">
                <button type="submit" class="btn" id="resendButton" style="background-color: #af6400b3;">
                    <span id="countdownText">Reenviar codigo de verificación</span>
                </button>
            </div>
        </div>
    </form>
@endsection

@section('script')
    <script>
        const waitTime = 60;
        const countdownText = document.getElementById('countdownText');
        const resendForm = document.getElementById('resendForm');
        const resendButton = document.getElementById('resendButton');

        const endTime = localStorage.getItem('endTime') || (Date.now() + waitTime * 1000);
        localStorage.setItem('endTime', endTime);

        function updateCountdown() {
            const now = Date.now();
            const timeLeft = Math.max(0, Math.floor((endTime - now) / 1000));

            if (timeLeft > 0) {
                resendButton.disabled = true;
                countdownText.textContent = `Siguiente reenvio... (${Math.floor(timeLeft / 60)}:${String(timeLeft % 60).padStart(2, '0')})`;
            } else {
                clearInterval(countdownInterval);
                localStorage.removeItem('endTime');
                resendButton.disabled = false;
                countdownText.textContent = 'Reenviar codigo de verificación';
            }
        }

        // Actualizar el contador cada segundo
        const countdownInterval = setInterval(updateCountdown, 1000);
        updateCountdown();
    </script>
@endsection

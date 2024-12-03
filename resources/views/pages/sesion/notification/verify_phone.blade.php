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
    Verifica tu teléfono
@endsection

@section('subtitle form')
    <p>Te hemos enviado un código de verificación a tu número de teléfono. Por favor, revisa tu bandeja de entrada.</p>
@endsection

@section('form')
<a href="/">Verificar más tarde</a>

<form id="resendForm" action="{{ route('verification.send') }}" method="POST">
    @csrf
    <label for="code">Código de verificación:</label>

    <div class="form-floating mb-3">
        <div class="row d-flex">
            <div class="col-2">
                <input type="text" name="code1" id="code1" placeholder="#" pattern="\d*" class="form-control code-input" maxlength="1" required autocomplete="off" oninput="moveFocus(1)">
            </div>
            <div class="col-2">
                <input type="text" name="code2" id="code2" placeholder="#" pattern="\d*" class="form-control code-input" maxlength="1" required autocomplete="off" oninput="moveFocus(2)">
            </div>
            <div class="col-2">
                <input type="text" name="code3" id="code3" placeholder="#" pattern="\d*" class="form-control code-input" maxlength="1" required autocomplete="off" oninput="moveFocus(3)">
            </div>
            <div class="col-2">
                <input type="text" name="code4" id="code4" placeholder="#" pattern="\d*" class="form-control code-input" maxlength="1" required autocomplete="off" oninput="moveFocus(4)">
            </div>
            <div class="col-2">
                <input type="text" name="code5" id="code5" placeholder="#" pattern="\d*" class="form-control code-input" maxlength="1" required autocomplete="off" oninput="moveFocus(5)">
            </div>
            <div class="col-2">
                <input type="text" name="code6" id="code6" placeholder="#" pattern="\d*" class="form-control code-input" maxlength="1" required autocomplete="off" oninput="moveFocus(6)">
            </div>
        </div>
    </div>

    <div class="d-flex col mb-3">
        <div class="col-6">
            <button id="btnVerifyEmail" class="btn">Verificar con email</button>
        </div>
        <div class="col-6">
            <button type="button" class="btn" id="resendButton" style="background-color: #af6400b3;">
                <span id="countdownText">Reenviar código de verificación</span>
            </button>
        </div>
    </div>
</form>
@section('script')
<script>
    const waitTime = 60;

    const resendButton = document.getElementById('resendButton');
    const countdownText = document.getElementById('countdownText');

    // Cargar el tiempo final desde el localStorage
    let savedEndTime = localStorage.getItem('phoneTimerEndTime');

    // Función para iniciar el temporizador
    function startTimer() {
        const endTime = Date.now() + waitTime * 1000;
        localStorage.setItem('phoneTimerEndTime', endTime);
        savedEndTime = endTime;
        updateCountdown();
    }

    // Actualizar el contador
    function updateCountdown() {
        const now = Date.now();
        const timeLeft = Math.max(0, Math.floor((savedEndTime - now) / 1000));

        if (timeLeft > 0) {
            resendButton.disabled = true;
            countdownText.textContent = `Siguiente reenvío... (${Math.floor(timeLeft / 60)}:${String(timeLeft % 60).padStart(2, '0')})`;
        } else {
            clearInterval(countdownInterval);
            resendButton.disabled = false;
            countdownText.textContent = 'Reenviar código de verificación';
            localStorage.removeItem('phoneTimerEndTime');
        }
    }

    resendButton.addEventListener('click', (event) => {
        event.preventDefault();
        if (!localStorage.getItem('phoneTimerEndTime')) {
            startTimer();
        } else {
            console.log("Temporizador ya activo, espera a que termine.");
        }
        document.getElementById('resendForm').submit();
    });

    if (savedEndTime) {
        updateCountdown();
    } else {
        countdownText.textContent = 'Reenviar código de verificación';
    }

    const countdownInterval = setInterval(updateCountdown, 1000);
</script>

        <!--para pegar en los input el codigo-->
<script>
            document.addEventListener('DOMContentLoaded', () => {
            const inputs = document.querySelectorAll('.code-input');
                
            inputs.forEach((input, index) => {
                input.addEventListener('input', (event) => {
                    const value = event.target.value;
                
                    if (value.length > 1) {
                        distributeValue(value, index, inputs);
                        return;
                    }
                
                    if (value !== '' && index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                });
            
                input.addEventListener('keydown', (event) => {
                    if (event.key === 'Backspace' && input.value === '' && index > 0) {
                        inputs[index - 1].focus();
                    }
                });
            });
        
            inputs.forEach((input) => {
                input.addEventListener('paste', (event) => {
                    const pasteData = event.clipboardData.getData('text');
                    distributeValue(pasteData, 0, inputs);
                    event.preventDefault(); 
                });
            });
        
            function distributeValue(value, startIndex, inputs) {
                for (let i = 0; i < value.length; i++) {
                    const currentInput = inputs[startIndex + i];
                    if (currentInput) {
                        currentInput.value = value[i];
                    }
                }
            
                const nextInput = inputs[startIndex + value.length];
                if (nextInput) {
                    nextInput.focus();
                }
            }
        });

</script>
@endsection

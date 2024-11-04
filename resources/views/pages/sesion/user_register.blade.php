<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
    .background-image {
            position: fixed; 
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("{{ asset('js/images/El roble photo1.jpg') }}");
            background-size: cover; 
            background-position: center;
            background-repeat: no-repeat;
            filter: blur(8px);
            z-index: -1; 
        }
</style>

<body class="bg-light d-flex align-items-center justify-content-center" style="min-height: 100vh; ">
<div class="background-image"></div>
    <div class="container d-flex justify-content-center">
        <div class="card shadow-lg border-0 rounded" style="width: 100%; max-width: 400px; background-color: #292005e3;">
            
            <div class="card-body">
                <div >
                <button class="btn btn-toolbar" onclick="backStep()" id="btnback" style="display:none; color:brown;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
                    </svg>
                    </button>  
                <h3 class="text-center mb-4">Crear una Cuenta</h3>

                <form method="POST" action="{{ route('registeruser.store') }}" id="registrationForm">
                    @csrf

                    <!-- paso 1 ----------------------------------------------------------- -->
                    <div id="step1">
                    <form method="POST" action="{{ route('registeruser.store') }}">
                    @csrf

                    @if (filter_var($phoneoremail, FILTER_VALIDATE_EMAIL))
                        <div class="form-floating mb-3">
                            <input type="email" name="email" id="email" class="form-control" value="{{ $phoneoremail }}" readonly>
                            <label for="email">Correo Electrónico</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" name="phone" id="phone" class="form-control" maxlength="10" pattern="\d{10}" title="Ingresa un número de 10 dígitos" required>
                            <label for="phone">Teléfono</label>
                        </div>
                    @else
                        <div class="form-floating mb-3">
                            <input type="text" name="phone" id="phone" class="form-control" value="{{ $phoneoremail }}" readonly>
                            <label for="phone">Teléfono</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="email" name="email" id="email" class="form-control" required>
                            <label for="email">Correo Electrónico</label>
                        </div>
                    @endif

                        <div class="form-floating mb-3">
                            <input type="text" name="firstName" id="firstName" class="form-control" required>
                            <label for="firstName">Nombre(s):</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" name="lastNamepat" id="lastName" class="form-control" required>
                            <label for="lastNamepat">Apellido(s):</label>
                        </div>

                        <button type="button" class="btn btn-primary w-100" onclick="nextStep()">Siguiente</button>
                    </div>

                    <!-- paso 2 ----------------------------------------------------------- -->
                    <div id="step2" style="display: none;">
                     
                        <div class="form-floating mb-3">
                            <input type="date" name="birthdate" id="birthdate" class="form-control" required>
                            <label for="birthdate">Fecha de Nacimiento</label>
                        </div>

                        <div class="form-floating mb-3">
                            <select name="gender" id="gender" class="form-control">
                                <option value="">Selecciona Género (Opcional)</option>
                                <option value="Masculino">Masculino</option>
                                <option value="Femenino">Femenino</option>
                                <option value="Otro">Otro</option>
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
                </div>
                <div>

                </div>
                    
            </div>
        </div>
    </div>

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
</body>



</html>
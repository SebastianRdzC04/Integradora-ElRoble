<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center" style="min-height: 100vh;">
    <div class="container d-flex justify-content-center">
        <div class="card shadow-lg border-0 rounded" style="width: 100%; max-width: 400px; background-color: #0821036b;">
            <div class="card-body">
                <h3 class="text-center mb-4">Crear una Cuenta</h3>
                
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

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
                        <input type="text" name="firstName" id="firstName" class="form-control" maxlength="50" required>
                        <label for="firstName">Nombre</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" name="lastNamemat" id="lastNamemat" class="form-control" maxlength="50" required>
                        <label for="lastNamemat">Apellido Materno</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" name="lastNamepat" id="lastNamepat" class="form-control" maxlength="50" required>
                        <label for="lastNamepat">Apellido Paterno</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="date" name="birthdate" id="birthdate" class="form-control" required>
                        <label for="birthdate">Fecha de Nacimiento</label>
                    </div>

                    <div class="form-floating mb-3">
                        <select name="gender" id="gender" class="form-control" required>
                            <option value="Masculino">Masculino</option>
                            <option value="Femenino">Femenino</option>
                            <option value="Otro">Otro</option>
                        </select>
                        <label for="gender">Género</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" name="userName" id="userName" class="form-control" value="{{ old('userName') }}" required>
                        <label for="userName">Usuario</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" name="password" id="password" class="form-control" required autocomplete="new-password">
                        <label for="password">Contraseña</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required autocomplete="off">
                        <label for="password_confirmation">Confirmar Contraseña</label>
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn" style="background-color: #af6400b3;">Registrar</button>
                    </div>

                    <div class="text-center">
                        <a href="{{ route('login') }}" class="text-decoration-none">¿Ya tienes cuenta? Inicia sesión aquí</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>


<body class="bg-light d-flex align-items-center justify-content-center" style="min-height: 100vh;">
    <div class="container d-flex justify-content-center">
        <div class="card shadow-lg border-0 rounded" style="width: 100%; max-width: 400px; background-color: #0821036b;">
            <div class="card-body">
                <h3 class="text-center mb-4">Crear una Cuenta</h3>

                <form method="POST" action="{{ route('registeruser.store') }}" id="registrationForm">
                    @csrf

                    <!-- Paso 1: Información de Contacto -->
                    <div id="step1">
                        <div class="form-floating mb-3">
                            <input type="email" name="email" id="email" class="form-control" required>
                            <label for="email">Correo Electrónico</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" name="phone" id="phone" class="form-control">
                            <label for="phone">Teléfono (Opcional)</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" name="firstName" id="firstName" class="form-control" required>
                            <label for="firstName">Nombre</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" name="lastNamepat" id="lastNamepat" class="form-control" required>
                            <label for="lastNamepat">Apellido Paterno</label>
                        </div>

                        <button type="button" class="btn btn-primary w-100" onclick="nextStep()">Siguiente</button>
                    </div>

                    <!-- Paso 2: Información Adicional -->
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
                            <input type="text" name="userName" id="userName" class="form-control" required>
                            <label for="userName">Usuario</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="password" name="password" id="password" class="form-control" required>
                            <label for="password">Contraseña</label>
                        </div>

                        <button type="submit" class="btn btn-success w-100">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function nextStep() {
            document.getElementById("step1").style.display = "none";
            document.getElementById("step2").style.display = "block";
        }
    </script>
</body>



</html>
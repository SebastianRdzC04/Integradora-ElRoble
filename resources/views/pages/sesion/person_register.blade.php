<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Registro</title>
</head>
<body>
    <h2>Formulario de Registro</h2>
    <form action="{{route('registerperson.store')}}" method="POST">
        @csrf

        <label for="firstName">Nombre:</label>
        <input type="text" id="firstName" name="firstName" maxlength="50" required>
        <br><br>

        <label for="lastName">Apellido:</label>
        <input type="text" id="lastName" name="lastName" maxlength="50" required>
        <br><br>

        <label for="birthdate">Fecha de Nacimiento:</label>
        <input type="date" id="birthdate" name="birthdate" required>
        <br><br>

        <label for="gender">Género:</label>
        <select id="gender" name="gender" required>
            <option value="Masculino">Masculino</option>
            <option value="Femenino">Femenino</option>
            <option value="Otro">Otro</option>
        </select>
        <br><br>

        <label for="phone">Teléfono:</label>
        <input type="text" id="phone" name="phone" maxlength="10" pattern="\d{10}" title="Ingresa un número de 10 dígitos" required>
        <br><br>

        <label for="age">Edad:</label>
        <input type="number" id="age" name="age" min="18" max="120" required>
        <br><br>

        <button type="submit">Enviar</button>
    </form>
</body>
</html>

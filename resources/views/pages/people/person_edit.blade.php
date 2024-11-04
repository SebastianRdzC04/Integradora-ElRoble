<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Registro</title>
</head>
<body>
    <h2>Formulario de Registro</h2>
    @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <form action="{{ route('person.update',['id' => $person->id]) }}" method="POST">
        @csrf
        @method('PATCH')

        <label for="firstName">Nombre:</label>
        <input type="text" id="firstName" name="firstName" maxlength="50" value="{{$person->firstName}}" required>
        <br><br>

        <label for="lastName">Apellido:</label>
        <input type="text" id="lastName" name="lastName" maxlength="50" value="{{$person->lastName}}" required>
        <br><br>

        <label for="birthdate">Fecha de Nacimiento:</label>
        <input type="date" id="birthdate" name="birthdate" value="{{$person->birthdate}}" required>
        <br><br>

        <label for="gender">Género:</label>
        <select id="gender" name="gender" required>
        <option value="Masculino" @selected($person->gender === "Masculino")>Masculino</option>
        <option value="Femenino" @selected($person->gender === "Femenino")>Femenino</option>
        <option value="Otro" @selected($person->gender === "Otro")>Otro</option>
        </select>

        <br><br>

        <label for="phone">Teléfono:</label>
        <input type="text" id="phone" name="phone" maxlength="10" pattern="\d{10}" value="{{$person->phone}}" title="Ingresa un número de 10 dígitos" required>
        <br><br>

        <button type="submit">Editar</button>
    </form>
    
</body>
</html>

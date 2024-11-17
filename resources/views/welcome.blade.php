<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="{{Route('verification.send')}}" method="Post">
        @csrf
        <button type="submit">Reenviar verificacion de correo</button>
    </form>
<body>
    <form action="{{Route('logout')}}" method="Post">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>
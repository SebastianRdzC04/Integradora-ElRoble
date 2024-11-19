<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <title>Document</title>
</head>
<body>
    <main>
        <div>
            <a href="{{route('dashboard')}}" class="btn btn-primary">Ir a Dashboard</a>
        </div>
        @if (Auth::user())
        <div>
            <form action="{{route('logout')}}" method="post">
                @csrf
                <button type="submit">logoutt</button>
            </form>
        <div>
        @endif
            <a href="login" class="btn btn-primary">login</a>
        </div>
        </div>
    </main>
    <script>
        const dates = []
    </script>

</body>
</html>
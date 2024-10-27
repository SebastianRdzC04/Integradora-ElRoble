<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/calendar.css') }}">
    
    <title>Document</title>
</head>
<body>
    <main>
        <div>
            <div id="montCalendar"></div>
            <div id="calendar"></div>
        </div>
    </main>
    <script>
        const dates = []
    </script>
    <script src="{{ asset('js/calendar.js') }}"></script>

</body>
</html>
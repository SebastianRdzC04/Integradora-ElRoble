<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2>Error</h2>
            </div>
            <div class="card-body">
                @if (session('error'))
                    <div class="alert alert-danger">
                        <strong>Error:</strong> {{ session('error') }}
                    </div>
                @elseif (session('status'))
                    <div class="alert alert-info">
                        <strong>Status:</strong> {{ session('status') }}
                    </div>
                @else
                    <div class="alert alert-warning">
                        <strong>Warning:</strong> Ha ocurrido un error inesperado.
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
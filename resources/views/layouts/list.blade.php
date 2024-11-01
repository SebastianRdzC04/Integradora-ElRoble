<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}"
    @yield('head')
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="text-center mb-4">@yield('tabletitle')</h2>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
        
            @yield('columns')

        
        </table>
    </div>
</div>
@yield('script')
</body>
</html>
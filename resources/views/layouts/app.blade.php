<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta>

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->


    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body style="background-color:rbga(255,255,255,0.9)">
    <center>
        <div id="app " style="height:100px;width:200px;margin-top:10px;">

            <img src="{{ asset('storage/logoMarca/logoTipo.Png') }}" style="width:100%;height:100%; margin-top:10px;">

        </div>
    </center>
    </div>
    <hr>
    <hr>

    <main class="py-4">
        @yield('content')
    </main>

    </div>
    <footer class="container card-footer"> Este Documeto foi processado por SGE Copyright © 2024 Todo
        Direitos Reservado</footer>
</body>

</html>

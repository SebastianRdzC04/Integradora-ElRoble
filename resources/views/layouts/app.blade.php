<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Agregar tu archivo CSS aquí -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet" />

        <style>
            .loader {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(255, 255, 255, 0.8);
                z-index: 9999;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .container {
                width: 100%;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .tree {
                position: relative;
                width: 50px;
                height: 50px;
                transform-style: preserve-3d;
                transform: rotateX(-20deg) rotateY(30deg);
                animation: treeAnimate 5s linear infinite;
            }
            @keyframes treeAnimate {
                0% { transform: rotateX(-20deg) rotateY(360deg); }
                100% { transform: rotateX(-20deg) rotateY(0deg); }
            }
            .tree div {
                position: absolute;
                top: -50px;
                left: 0;
                width: 100%;
                height: 100%;
                transform-style: preserve-3d;
                transform: translateY(calc(25px * var(--x))) translateZ(0px);
            }
            .tree div.branch span {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, #69c069, #77dd77);
                clip-path: polygon(50% 0%, 0% 100%, 100% 100%);
                border-bottom: 5px solid #00000019;
                transform-origin: bottom;
                transform: rotateY(calc(90deg * var(--i))) rotateX(30deg) translateZ(28.5px);
            }
            .tree div.stem span {
                position: absolute;
                top: 110px;
                left: calc(50% - 7.5px);
                width: 15px;
                height: 50%;
                background: linear-gradient(90deg, #bb4622, #df7214);
                border-bottom: 5px solid #00000019;
                transform-origin: bottom;
                transform: rotateY(calc(90deg * var(--i))) translateZ(7.5px);
            }
            .shadow {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.4);
                filter: blur(20px);
                transform-style: preserve-3d;
                transform: rotateX(90deg) translateZ(-65px);
            }
        </style>
    </head>

    <body class="font-sans antialiased">
        <div id="loader" class="loader" style="display: none;">
            <div class="container">
                <div class="tree">
                    <div class="branch" style="--x:0">
                        <span style="--i:0;"></span>
                        <span style="--i:1;"></span>
                        <span style="--i:2;"></span>
                        <span style="--i:3;"></span>
                    </div>
                    <div class="branch" style="--x:1">
                        <span style="--i:0;"></span>
                        <span style="--i:1;"></span>
                        <span style="--i:2;"></span>
                        <span style="--i:3;"></span>
                    </div>
                    <div class="branch" style="--x:2">
                        <span style="--i:0;"></span>
                        <span style="--i:1;"></span>
                        <span style="--i:2;"></span>
                        <span style="--i:3;"></span>
                    </div>
                    <div class="branch" style="--x:3">
                        <span style="--i:0;"></span>
                        <span style="--i:1;"></span>
                        <span style="--i:2;"></span>
                        <span style="--i:3;"></span>
                    </div>
                    <div class="stem">
                        <span style="--i:0;"></span>
                        <span style="--i:1;"></span>
                        <span style="--i:2;"></span>
                        <span style="--i:3;"></span>
                    </div>
                    <span class="shadow"></span>
                </div>
            </div>
        </div>

        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <script>
            // Mostrar el loader cuando la página comienza a cargarse
            window.addEventListener('load', function() {
                const loader = document.getElementById("loader");
                loader.style.display = "flex"; // Mostrar loader al cargar la página
            });

            // Ocultar el loader cuando el contenido se haya cargado completamente
            window.addEventListener('load', function() {
                const loader = document.getElementById("loader");
                setTimeout(() => {
                    loader.style.display = "none"; // Ocultar loader después de que la página se carga
                }, 500); // El valor 500ms es solo un ejemplo, puedes ajustarlo
            });
        </script>
    </body>
</html>

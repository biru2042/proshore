<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Event App</title>
        <link rel="stylesheet" href="{{ asset('build/assets/app.67dcdfd2.css') }}">
        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        {{-- <script src="{{ mix('build/assets/app.8ba70a51.js') }}"></script> --}}

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body>
        <div id="app">
            <event-component></event-component>
        </div>
        @vite('resources/js/app.js')
    </body>
</html>

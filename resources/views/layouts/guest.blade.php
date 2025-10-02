<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link rel="icon" type="image/png" href="{{ asset('images/Foodie.png') }}">
        <link href="https://fonts.bunny.net/css?family=audiowide:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    
    <body class="font-mono">
        <x-theme-switcher>
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 min-h-screen">

            <div>
                <a href="/">
                    <x-application-logo/>
                </a>
            </div>

            <div>
                {{ $slot }}
            </div>
        </div>

        </x-theme-switcher>
    </body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,500;0,9..144,600;0,9..144,700;1,9..144,400&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-ink">
        <div class="min-h-screen bg-white">
            @include('layouts.navigation')

            <!-- Encabezado de página (opcional, más discreto que antes) -->
            @isset($header)
                <header class="border-b border-ink-faint">
                    <div class="max-w-4xl mx-auto py-6 px-4 sm:px-6">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Contenido de la página -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>

r<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @livewireStyles
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased">
    <x-banner />

    <div class="flex min-h-screen">
        <x-sidebar />

        <!-- Contenido principal -->
        <div class="flex-1 ml-64 bg-white">
            <!-- Page Header -->
            @if (isset($header))
                <header class="bg-white border-b border-gray-100">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Contenido de la página -->
            <main class="p-6 bg-gray-100">
                {{ $slot }}
            </main>
        </div>
    </div>

    @livewireScripts
</body>
</html>

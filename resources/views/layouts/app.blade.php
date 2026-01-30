<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    
    <link rel="icon" id="favicon" type="image/png" href="{{ asset('logo-light.png') }}">
    <script>
        function updateFavicon() {
            const isDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const head = document.head || document.getElementsByTagName('head')[0];
            const existingIcons = document.querySelectorAll("link[rel~='icon']");
            existingIcons.forEach(icon => icon.remove());
            const newIcon = document.createElement('link');
            newIcon.rel = 'icon';
            newIcon.type = 'image/png';
            const fileName = isDark ? 'logo-dark.png' : 'logo-light.png';
            newIcon.href = `{{ asset('') }}${fileName}?v=${new Date().getTime()}`;
            head.appendChild(newIcon);
        }
        updateFavicon();
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', updateFavicon);
    </script>
</head>
<body class="font-sans antialiased bg-white dark:bg-gray-900">

    {{-- 🔔 ALERTAS FLOTANTES CORREGIDAS --}}
    {{-- CAMBIO CLAVE: 'top-20' para bajarlo y 'z-[100]' para que salga encima del menú --}}
    <div class="fixed top-20 right-4 z-[100] flex flex-col gap-2 pointer-events-none">
        
        {{-- ÉXITO --}}
        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                 x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-10" x-transition:enter-end="opacity-100 translate-x-0"
                 x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 translate-x-10"
                 class="pointer-events-auto flex items-center p-4 text-sm text-green-800 rounded-xl bg-green-50 dark:bg-gray-800 dark:text-green-400 border border-green-300 dark:border-green-800 shadow-2xl min-w-[300px]" role="alert">
                <svg class="flex-shrink-0 inline w-5 h-5 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                </svg>
                <div><span class="font-bold">¡Éxito!</span> {{ session('success') }}</div>
            </div>
        @endif

        {{-- ERROR --}}
        @if (session('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                 x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-10" x-transition:enter-end="opacity-100 translate-x-0"
                 x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 translate-x-10"
                 class="pointer-events-auto flex items-center p-4 text-sm text-red-800 rounded-xl bg-red-50 dark:bg-gray-800 dark:text-red-400 border border-red-300 dark:border-red-800 shadow-2xl min-w-[300px]" role="alert">
                <svg class="flex-shrink-0 inline w-5 h-5 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z"/>
                </svg>
                <div><span class="font-bold">Error:</span> {{ session('error') }}</div>
            </div>
        @endif
    </div>

    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        @include('layouts.navigation')

        @isset($header)
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <main>
            {{ $slot }}
        </main>
    </div>

    @livewireScripts
</body>
</html>
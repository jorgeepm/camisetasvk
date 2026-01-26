<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        
        {{-- Alertas Bonitas (Opcional, pero recomendado tenerlo instalado) --}}
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
    <body class="font-sans antialiased bg-white dark:bg-black overflow-x-hidden">
        {{-- 🎨 FONDO GLOBAL --}}
        <div class="fixed inset-0 z-0 pointer-events-none">
            <div class="absolute -top-[10%] -left-[10%] w-[60%] h-[50%] rounded-full opacity-30 blur-[100px] bg-[#9cfcff] dark:bg-indigo-600"></div>
            <div class="absolute -top-[5%] -right-[10%] w-[50%] h-[40%] rounded-full opacity-20 blur-[90px] bg-[#9cfcff] dark:bg-indigo-600"></div>
            <div class="absolute -bottom-[15%] -left-[10%] w-[60%] h-[50%] rounded-full opacity-30 blur-[100px] bg-[#9cfcff] dark:bg-indigo-600"></div>
            <div class="absolute -bottom-[10%] -right-[10%] w-[60%] h-[50%] rounded-full opacity-30 blur-[110px] bg-[#9cfcff] dark:bg-indigo-600"></div>
        </div>

        <div class="relative z-10 min-h-screen flex flex-col justify-between">
            <div>
                {{-- 1. NAVEGACIÓN --}}
                <div class="bg-transparent">
                    @include('layouts.navigation')
                </div>

                {{-- 2. HEADER --}}
                @isset($header)
                    <header class="bg-transparent">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                {{-- 3. CONTENIDO --}}
                <main>
                    {{ $slot }}
                </main>
            </div>
            
        </div>

        {{-- Livewire carga Alpine aquí automáticamente --}}
        @livewireScripts
    </body>
</html>
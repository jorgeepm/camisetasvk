<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

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
    <body class="font-sans text-gray-900 antialiased bg-gray-100 dark:bg-black overflow-y-auto">
        
        {{-- 🎨 FONDO GLOBAL (El mismo diseño Pro que el catálogo) --}}
        <div class="fixed inset-0 z-0 pointer-events-none">
            <div class="absolute -top-[10%] -left-[10%] w-[60%] h-[50%] rounded-full opacity-30 blur-[100px] bg-[#9cfcff] dark:bg-indigo-600"></div>
            <div class="absolute -top-[5%] -right-[10%] w-[50%] h-[40%] rounded-full opacity-20 blur-[90px] bg-[#9cfcff] dark:bg-indigo-600"></div>
            <div class="absolute -bottom-[15%] -left-[10%] w-[60%] h-[50%] rounded-full opacity-30 blur-[100px] bg-[#9cfcff] dark:bg-indigo-600"></div>
            <div class="absolute -bottom-[10%] -right-[10%] w-[60%] h-[50%] rounded-full opacity-30 blur-[110px] bg-[#9cfcff] dark:bg-indigo-600"></div>
        </div>

        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative z-10">
            
            {{-- LOGO (Para volver al inicio) --}}
            <div class="mb-6">
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </div>

            <div class="w-full sm:max-w-md px-6 py-8 bg-white/80 dark:bg-gray-800/80 backdrop-blur-md shadow-2xl overflow-hidden sm:rounded-2xl border border-white/20 dark:border-gray-700">
                {{ $slot }}
            </div>
        </div>

        @livewireScripts
    </body>
</html>
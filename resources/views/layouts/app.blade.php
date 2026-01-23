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

        <link rel="icon" id="favicon" type="image/png" href="{{ asset('logo-light.png') }}">

        <script>
            function updateFavicon() {
                const isDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                const head = document.head || document.getElementsByTagName('head')[0];
                
                // 1. Buscamos y borramos CUALQUIER link de icono que exista
                const existingIcons = document.querySelectorAll("link[rel~='icon']");
                existingIcons.forEach(icon => icon.remove());

                // 2. Creamos el nuevo link desde cero
                const newIcon = document.createElement('link');
                newIcon.rel = 'icon';
                newIcon.type = 'image/png';
                
                // 3. Elegimos el archivo y le metemos un "vampiro" de caché (?v=...)
                const fileName = isDark ? 'logo-dark.png' : 'logo-light.png';
                newIcon.href = `{{ asset('') }}${fileName}?v=${new Date().getTime()}`;

                // 4. Lo inyectamos
                head.appendChild(newIcon);
            }

            // Ejecutar al cargar la página
            updateFavicon();

            // Escuchar cuando el usuario cambie el modo del sistema sin cerrar la pestaña
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', updateFavicon);
        </script>
    </head>
    <body class="font-sans antialiased bg-white dark:bg-black overflow-x-hidden">
        {{-- 🎨 FONDO GLOBAL (Manchas #9cfcff) --}}
        <div class="fixed inset-0 z-0 pointer-events-none">
            <div class="absolute -top-[10%] -left-[10%] w-[60%] h-[50%] rounded-full opacity-30 blur-[100px] 
                        bg-[#9cfcff] dark:bg-indigo-600"></div>
            
            <div class="absolute -top-[5%] -right-[10%] w-[50%] h-[40%] rounded-full opacity-20 blur-[90px] 
                        bg-[#9cfcff] dark:bg-indigo-600"></div>
            
            <div class="absolute -bottom-[15%] -left-[10%] w-[60%] h-[50%] rounded-full opacity-30 blur-[100px] 
                        bg-[#9cfcff] dark:bg-indigo-600"></div>
            
            <div class="absolute -bottom-[10%] -right-[10%] w-[60%] h-[50%] rounded-full opacity-30 blur-[110px] 
                        bg-[#9cfcff] dark:bg-indigo-600"></div>
        </div>

        <div class="relative z-10 min-h-screen">
            {{-- 1. NAVEGACIÓN: La hacemos semi-transparente --}}
            <div class="bg-transparent">
                @include('layouts.navigation')
            </div>

            {{-- 2. HEADER: También semi-transparente --}}
            @isset($header)
                <header class="bg-transparent">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            {{-- 3. CONTENIDO (Tu catálogo) --}}
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>

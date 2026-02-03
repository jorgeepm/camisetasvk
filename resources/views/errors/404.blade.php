<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página no encontrada</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-950 text-gray-300 h-screen flex flex-col items-center justify-center font-sans antialiased selection:bg-gray-700 selection:text-white">

    <div class="w-full max-w-lg px-8 text-center flex flex-col items-center">
        
        {{-- ICONO 404 (Ojo/Búsqueda minimalista) --}}
        <svg class="w-12 h-12 text-gray-600 mb-6 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
        </svg>

        <p class="text-sm font-medium text-gray-500 uppercase tracking-widest mb-2">Error 404</p>

        <h1 class="text-3xl md:text-4xl font-light text-white mb-4 tracking-tight">
            Página no encontrada
        </h1>

        <p class="text-gray-400 text-lg font-light leading-relaxed">
            La URL que intentas visitar no existe o ha sido movida a otro lugar del campo.
        </p>

        <div class="w-16 h-px bg-gray-800 my-8"></div>

    </div>

    <div class="absolute bottom-12">
        <a href="{{ url('/') }}" class="group flex items-center gap-2 px-6 py-3 text-sm text-gray-400 transition-all duration-300 border border-gray-800 rounded-full hover:border-gray-600 hover:text-white hover:bg-gray-900">
            <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span>Volver al Inicio</span>
        </a>
    </div>

</body>
</html>
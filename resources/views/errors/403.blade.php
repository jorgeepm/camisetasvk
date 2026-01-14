<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Restringido</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-950 text-gray-300 h-screen flex flex-col items-center justify-center font-sans antialiased selection:bg-gray-700 selection:text-white">

    <div class="w-full max-w-lg px-8 text-center flex flex-col items-center">
        
        <svg class="w-12 h-12 text-gray-600 mb-6 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
        </svg>

        <p class="text-sm font-medium text-gray-500 uppercase tracking-widest mb-2">Error 403</p>

        <h1 class="text-3xl md:text-4xl font-light text-white mb-4 tracking-tight">
            Acceso restringido
        </h1>

        <p class="text-gray-400 text-lg font-light leading-relaxed">
            No tienes los permisos necesarios para visualizar esta sección del panel de administración.
        </p>

        <div class="w-16 h-px bg-gray-800 my-8"></div>

    </div>

    <div class="absolute bottom-12">
        <a href="{{ route('dashboard') }}" class="group flex items-center gap-2 px-6 py-3 text-sm text-gray-400 transition-all duration-300 border border-gray-800 rounded-full hover:border-gray-600 hover:text-white hover:bg-gray-900">
            <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span>Volver al Dashboard</span>
        </a>
    </div>

</body>
</html>
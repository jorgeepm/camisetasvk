<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- 🔙 BOTÓN VOLVER --}}
            <div class="mb-6">
                <a href="{{ route('catalog.all') }}"
                    class="inline-flex items-center text-gray-900 dark:text-gray-200 hover:text-gray-800 dark:hover:text-gray-100 font-medium transition duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Volver al catálogo
                </a>
            </div>

            {{-- BLOQUE DE ERRORES --}}
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 shadow-md rounded-r-lg">
                    <p class="font-bold">Hay errores en la personalización:</p>
                    <ul class="mt-2 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-gray-100 dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-8 grid grid-cols-1 md:grid-cols-2 gap-8">

                {{-- COLUMNA IZQUIERDA: IMAGEN Y DETALLES --}}
                <div class="flex flex-col items-center">
                    
                    {{-- 🖼️ IMAGEN ARREGLADA (Híbrida: Blob + Path) --}}
                    <div class="w-full flex justify-center mb-6">
                        @if($product->image_blob)
                            {{-- 1. Nueva (Base64) --}}
                            <img src="{{ $product->image_blob }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full max-w-sm h-auto object-contain rounded-xl shadow-lg transition-transform hover:scale-105 duration-300">
                        @elseif($product->image_path)
                            {{-- 2. Antigua (Storage) --}}
                            <img src="{{ asset('storage/' . $product->image_path) }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full max-w-sm h-auto object-contain rounded-xl shadow-lg transition-transform hover:scale-105 duration-300">
                        @else
                            {{-- 3. Placeholder --}}
                            <div class="w-full max-w-sm h-64 bg-gray-100 dark:bg-gray-700 rounded-xl flex items-center justify-center shadow-inner">
                                <span class="text-gray-400 font-bold">Sin Imagen</span>
                            </div>
                        @endif
                    </div>

                    <h2 class="mt-4 text-3xl font-extrabold text-gray-900 dark:text-gray-100 tracking-tight text-center">
                        {{ $product->name }}
                    </h2>

                    {{-- 💶 PRECIO EN EUROS --}}
                    <p class="text-2xl text-[#0004ff] dark:text-indigo-400 font-bold mt-2">{{ number_format($product->price, 2) }} €</p>

                    <p class="mt-4 text-gray-600 dark:text-gray-400 text-center leading-relaxed max-w-md">
                        {{ $product->description }}
                    </p>
                </div>

                {{-- COLUMNA DERECHA: FORMULARIO --}}
                <div class="bg-gray-50 dark:bg-gray-900 p-8 rounded-2xl border border-gray-700 dark:border-gray-700 shadow-inner h-fit">
                    <h3 class="text-2xl font-bold mb-6 text-gray-900 dark:text-white flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-[#0004ff] dark:text-indigo-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Personaliza tu Camiseta
                    </h3>

                    <form action="{{ route('products.customize', $product->id) }}" method="POST">
                        @csrf

                        {{-- TALLA --}}
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Selecciona tu
                                Talla:</label>
                            <div class="relative">
                                <select name="size" required
                                    class="block w-full pl-3 pr-10 py-3 text-base border-gray-700 dark:border-gray-600 focus:outline-none focus:ring-[#0004ff] dark:focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md dark:bg-gray-800 dark:text-white shadow-sm">
                                    <option value="S">S - Pequeña</option>
                                    <option value="M">M - Mediana</option>
                                    <option value="L">L - Grande</option>
                                    <option value="XL">XL - Extra Grande</option>
                                </select>
                            </div>
                        </div>

                        {{-- NOMBRE --}}
                        <div class="mb-6">
                            <div class="flex justify-between items-center mb-2">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre en la
                                    espalda:</label>
                                <span id="char-count"
                                    class="text-xs text-gray-500 font-mono bg-gray-200 dark:bg-gray-700 px-2 py-0.5 rounded">0/15</span>
                            </div>
                            <input type="text" id="custom_name" name="custom_name" maxlength="15"
                                placeholder="Ej: MESSI"
                                class="uppercase w-full rounded-lg border-gray-700 dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:ring-2 focus:ring-[#0004ff] dark:focus:ring-indigo-500 focus:border-transparent transition shadow-sm py-3">
                            <p class="mt-1 text-xs text-gray-400">Solo letras y espacios.</p>
                        </div>

                        {{-- NÚMERO --}}
                        <div class="mb-8">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Número
                                (1-99):</label>
                            <input type="number" name="custom_number" min="1" max="99" placeholder="10"
                                class="w-full rounded-lg border-gray-700 dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:ring-2 focus:ring-[#0004ff] dark:focus:ring-indigo-500 focus:border-transparent transition shadow-sm py-3">
                        </div>

                        {{-- BOTÓN COMPRAR --}}
                        <button type="submit"
                            class="w-full bg-[#0004ff] dark:bg-indigo-700 hover:bg-[#0258f7] dark:hover:bg-indigo-500 text-white font-bold py-4 px-6 rounded-xl transition duration-200 shadow-lg transform hover:-translate-y-0.5 flex justify-center items-center">
                            <span>Añadir al Carrito</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Script para el contador de caracteres --}}
    <script>
        const input = document.getElementById('custom_name');
        const count = document.getElementById('char-count');

        if (input && count) {
            input.addEventListener('input', () => {
                // Forzamos mayúsculas visualmente
                input.value = input.value.toUpperCase();

                const length = input.value.length;
                count.textContent = `${length}/15`;

                if (length >= 15) {
                    count.classList.add('text-red-500', 'font-bold');
                    count.classList.remove('text-gray-500');
                } else {
                    count.classList.remove('text-red-500', 'font-bold');
                    count.classList.add('text-gray-500');
                }
            });
        }
    </script>
</x-app-layout>
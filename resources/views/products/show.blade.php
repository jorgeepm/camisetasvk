<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- BLOQUE DE ERRORES: Muestra si el nombre es > 15 o el número > 99 --}}
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

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                
                <div class="flex flex-col items-center">
                    <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="w-full max-w-sm h-auto object-contain rounded-xl shadow-lg">
                    <h2 class="mt-6 text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $product->name }}</h2>
                    <p class="text-xl text-indigo-500 font-semibold mt-2">${{ $product->price }}</p>
                    <p class="mt-4 text-gray-600 dark:text-gray-400 text-center">{{ $product->description }}</p>
                </div>

                <div class="bg-gray-50 dark:bg-gray-900 p-6 rounded-2xl border border-gray-200 dark:border-gray-700">
                    <h3 class="text-2xl font-bold mb-6 text-gray-900 dark:text-white">Personaliza tu Camiseta</h3>

                    <form action="{{ route('products.customize', $product->id) }}" method="POST">
                        @csrf
                        
                        <div class="mb-5">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Selecciona tu Talla:</label>
                            <select name="size" required class="w-full rounded-lg border-gray-300 dark:bg-gray-800 dark:text-white">
                                <option value="S">S - Pequeña</option>
                                <option value="M">M - Mediana</option>
                                <option value="L">L - Grande</option>
                                <option value="XL">XL - Extra Grande</option>
                            </select>
                        </div>

                        <div class="mb-5">
                            <div class="flex justify-between items-center mb-2">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre en la espalda:</label>
                                <span id="char-count" class="text-xs text-gray-500">0/15</span>
                            </div>
                            {{-- Agregamos maxlength="15" para seguridad visual en el front --}}
                            <input type="text" id="custom_name" name="custom_name" maxlength="15" 
                                   placeholder="Ej: MESSI" 
                                   class="w-full rounded-lg border-gray-300 dark:bg-gray-800 dark:text-white focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        <div class="mb-8">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Número (1-99):</label>
                            {{-- Agregamos min y max para el selector de flechas --}}
                            <input type="number" name="custom_number" min="1" max="99" 
                                   placeholder="10" 
                                   class="w-full rounded-lg border-gray-300 dark:bg-gray-800 dark:text-white">
                        </div>

                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-xl transition duration-200 shadow-lg">
                            Añadir al Carrito
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Script para el contador de caracteres en tiempo real --}}
    <script>
        const input = document.getElementById('custom_name');
        const count = document.getElementById('char-count');

        input.addEventListener('input', () => {
            const length = input.value.length;
            count.textContent = `${length}/15`;
            
            // Cambia el color si llega al máximo
            if (length >= 15) {
                count.classList.add('text-red-500', 'font-bold');
            } else {
                count.classList.remove('text-red-500', 'font-bold');
            }
        });
    </script>
</x-app-layout>
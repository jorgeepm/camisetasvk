<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- 🔙 BOTÓN VOLVER --}}
            <div class="mb-8">
                <a href="{{ route('catalog.all') }}"
                    class="group inline-flex items-center text-gray-500 hover:text-indigo-600 font-medium transition duration-200">
                    <div class="w-8 h-8 rounded-full bg-white shadow-sm flex items-center justify-center mr-3 group-hover:shadow-md transition-all border border-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </div>
                    <span>Volver al catálogo</span>
                </a>
            </div>

            {{-- BLOQUE DE ERRORES --}}
            @if ($errors->any())
                <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-600 rounded-xl flex items-start gap-3">
                    <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <p class="font-bold">Revisa los siguientes errores:</p>
                        <ul class="mt-1 list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl shadow-gray-200/50 dark:shadow-none sm:rounded-3xl grid grid-cols-1 lg:grid-cols-2 gap-0 border border-gray-100 dark:border-gray-700">

                {{-- 🖼️ COLUMNA IZQUIERDA: IMAGEN (Con efectos PRO) --}}
                <div class="p-8 lg:p-12 flex flex-col items-center justify-center bg-gray-50 dark:bg-gray-900/50 relative">
                    
                    <div class="relative w-full max-w-md aspect-square flex items-center justify-center">
                        
                        {{-- IMAGEN CON LÓGICA HÍBRIDA --}}
                        @php
                            $imgSrc = $product->image_blob ?? ($product->image_path ? asset('storage/' . $product->image_path) : null);
                        @endphp

                        @if($imgSrc)
                            <img src="{{ $imgSrc }}" alt="{{ $product->name }}" 
                                 class="w-full h-full object-contain drop-shadow-2xl transition-all duration-500 {{ $product->stock == 0 ? 'grayscale opacity-60 blur-[1px]' : 'hover:scale-105' }}">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-300 bg-gray-100 rounded-2xl">
                                <span class="font-bold uppercase tracking-widest">Sin Imagen</span>
                            </div>
                        @endif

                        {{-- 🚫 SELLO DE AGOTADO (OVERLAY) --}}
                        @if($product->stock == 0)
                            <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                <div class="bg-black/80 backdrop-blur-sm text-white px-8 py-4 rounded-2xl border border-white/20 shadow-2xl transform -rotate-12">
                                    <span class="text-2xl font-black tracking-[0.2em] uppercase">Sold Out</span>
                                </div>
                            </div>
                        @endif

                        {{-- ⚡ AVISO FLOTANTE DE STOCK BAJO --}}
                        @if($product->stock > 0 && $product->stock <= 5)
                            <div class="absolute top-0 right-0">
                                <span class="bg-amber-400 text-amber-950 text-xs font-bold px-4 py-2 rounded-full shadow-lg animate-pulse flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                    ¡Solo quedan {{ $product->stock }}!
                                </span>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- 📝 COLUMNA DERECHA: INFO Y FORMULARIO --}}
                <div class="p-8 lg:p-12 bg-white dark:bg-gray-800 flex flex-col justify-center">
                    
                    <div class="mb-2">
                        <span class="text-indigo-500 font-bold tracking-wider uppercase text-xs bg-indigo-50 dark:bg-indigo-900/30 px-3 py-1 rounded-full">
                            {{ $product->category->name ?? 'Colección Oficial' }}
                        </span>
                    </div>

                    <h1 class="text-4xl font-black text-gray-900 dark:text-white tracking-tight mb-4">
                        {{ $product->name }}
                    </h1>

                    <p class="text-gray-500 dark:text-gray-400 leading-relaxed text-lg mb-8">
                        {{ $product->description }}
                    </p>

                    {{-- PRECIO Y ESTADO --}}
                    <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/30 rounded-2xl border border-gray-100 dark:border-gray-700 mb-8">
                        <div class="flex flex-col">
                            <span class="text-xs text-gray-400 font-bold uppercase">Precio</span>
                            <span class="text-3xl font-black text-gray-900 dark:text-white">{{ number_format($product->price, 2) }}€</span>
                        </div>

                        {{-- ETIQUETA DE ESTADO (PILL) --}}
                        <div>
                            @if($product->stock == 0)
                                <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-bold bg-rose-50 text-rose-600 border border-rose-100">
                                    <div class="w-2 h-2 rounded-full bg-rose-500"></div> Agotado
                                </span>
                            @elseif($product->stock <= 5)
                                <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-bold bg-amber-50 text-amber-600 border border-amber-100">
                                    <div class="w-2 h-2 rounded-full bg-amber-500 animate-ping"></div> Stock Bajo
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-bold bg-emerald-50 text-emerald-600 border border-emerald-100">
                                    <div class="w-2 h-2 rounded-full bg-emerald-500"></div> Disponible
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- FORMULARIO DE PERSONALIZACIÓN --}}
                    <form action="{{ route('products.customize', $product->id) }}" method="POST" class="space-y-6">
                        @csrf

                        <div class="space-y-6 {{ $product->stock == 0 ? 'opacity-50 pointer-events-none grayscale' : '' }}">
                            {{-- TALLA --}}
                            <div>
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2 uppercase tracking-wide">Selecciona Talla</label>
                                <div class="relative">
                                    <select name="size" required {{ $product->stock == 0 ? 'disabled' : '' }}
                                        class="block w-full pl-4 pr-10 py-3.5 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 rounded-xl text-gray-500 dark:text-gray-300 shadow-sm transition-shadow appearance-none cursor-pointer font-medium">
                                        <option value="" disabled selected>Elige tu talla...</option>
                                        <option value="S">S - Pequeña</option>
                                        <option value="M">M - Mediana</option>
                                        <option value="L">L - Grande</option>
                                        <option value="XL">XL - Extra Grande</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-3 gap-6">
                                {{-- NOMBRE (2/3 ancho) --}}
                                <div class="col-span-2">
                                    <div class="flex justify-between items-center mb-2">
                                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wide">Nombre</label>
                                        <span id="char-count" class="text-[10px] font-bold text-gray-400 bg-gray-100 px-2 py-0.5 rounded-md">0/15</span>
                                    </div>
                                    <input type="text" id="custom_name" name="custom_name" maxlength="15" {{ $product->stock == 0 ? 'disabled' : '' }}
                                        placeholder="TU NOMBRE"
                                        class="uppercase w-full px-4 py-3.5 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all font-medium 
                                               text-gray-500 placeholder-gray-500 dark:text-gray-300 dark:placeholder-gray-500">
                                </div>

                                {{-- NÚMERO (1/3 ancho) --}}
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2 uppercase tracking-wide">Dorsal</label>
                                    <input type="number" name="custom_number" min="1" max="99" placeholder="10" {{ $product->stock == 0 ? 'disabled' : '' }}
                                        class="w-full px-4 py-3.5 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-center font-medium 
                                               text-gray-500 placeholder-gray-500 dark:text-gray-300 dark:placeholder-gray-500">
                                </div>
                            </div>
                        </div>

                        {{-- BOTÓN DE ACCIÓN (GRANDE) --}}
                        <div class="pt-4">
                            @if($product->stock > 0)
                                <button type="submit"
                                    class="w-full group bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-4 px-8 rounded-2xl shadow-xl shadow-indigo-500/20 transition-all duration-300 transform hover:-translate-y-1 flex justify-center items-center gap-3">
                                    <span class="text-lg tracking-wide">Añadir a la cesta</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                </button>
                            @else
                                <button type="button" disabled
                                    class="w-full bg-gray-100 text-gray-400 font-bold py-4 px-8 rounded-2xl border-2 border-dashed border-gray-200 cursor-not-allowed flex justify-center items-center gap-3">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                    <span class="text-lg tracking-wide uppercase">Producto Agotado</span>
                                </button>
                                <p class="text-center text-xs text-gray-400 mt-3 font-medium">Suscríbete al boletín para saber cuándo vuelve.</p>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Script JS contador caracteres --}}
    <script>
        const input = document.getElementById('custom_name');
        const count = document.getElementById('char-count');
        if (input && count) {
            input.addEventListener('input', () => {
                input.value = input.value.toUpperCase();
                const length = input.value.length;
                count.textContent = `${length}/15`;
                if (length >= 15) count.classList.add('text-rose-500');
                else count.classList.remove('text-rose-500');
            });
        }
    </script>
</x-app-layout>
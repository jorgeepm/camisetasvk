<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Camisetas Destacadas') }} 🔥
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-8">
                <div class="flex justify-between items-end mb-8">
                    <div>
                        <h3 class="text-3xl font-black text-gray-900 dark:text-white uppercase tracking-tighter">
                            Lo más vendido
                        </h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-1">Las favoritas de nuestra comunidad esta semana.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @forelse($featuredProducts as $product)
                        <div class="group bg-gray-50 dark:bg-gray-900 rounded-3xl p-5 border border-gray-200 dark:border-gray-700 hover:shadow-2xl transition-all duration-300">
                            
                            {{-- 🖼️ IMAGEN ARREGLADA (Híbrida) --}}
                            <div class="relative overflow-hidden rounded-2xl bg-white mb-6 h-64 flex items-center justify-center">
                                {{-- Badge de popularidad --}}
                                <div class="absolute top-3 left-3 z-10 bg-red-600 text-white text-[10px] font-bold px-2 py-1 rounded-full uppercase tracking-widest shadow-lg">
                                    Top Ventas
                                </div>
                                
                                @if($product->image_blob)
                                    {{-- 1. Nueva (Blob) --}}
                                    <img src="{{ $product->image_blob }}" 
                                         class="w-full h-64 object-contain transition-transform duration-500 group-hover:scale-110"
                                         alt="{{ $product->name }}">
                                @elseif($product->image_path)
                                    {{-- 2. Antigua (Storage) --}}
                                    <img src="{{ asset('storage/' . $product->image_path) }}" 
                                         class="w-full h-64 object-contain transition-transform duration-500 group-hover:scale-110"
                                         alt="{{ $product->name }}">
                                @else
                                    {{-- 3. Placeholder --}}
                                    <img src="https://via.placeholder.com/300?text=Sin+Imagen" class="w-full h-64 object-cover opacity-50">
                                @endif
                            </div>

                            <h4 class="text-xl font-extrabold text-gray-900 dark:text-white mb-2">{{ $product->name }}</h4>
                            
                            <div class="flex justify-between items-center mt-4">
                                <span class="text-2xl font-black text-indigo-600 dark:text-indigo-400">
                                    {{ number_format($product->price, 2) }} €
                                </span>
                                
                                {{-- 🔥 LÓGICA DE BOTONES: ADMIN vs CLIENTE 🔥 --}}
                                @if(Auth::check() && Auth::user()->role === 'admin')
                                    
                                    {{-- 🔧 ADMIN: BOTÓN EDITAR --}}
                                    <a href="{{ route('products.edit', $product->id) }}" 
                                       class="flex items-center gap-2 px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 text-xs font-bold uppercase tracking-wide hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors shadow-sm bg-white dark:bg-transparent">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        Editar
                                    </a>

                                @else
                                    
                                    {{-- 🛒 CLIENTE: BOTÓN PERSONALIZAR --}}
                                    <a href="{{ route('products.show', $product->id) }}" 
                                       class="bg-gray-900 dark:bg-indigo-600 text-white px-4 py-2 rounded-xl font-bold text-sm hover:scale-105 transition-transform shadow-md">
                                        Personalizar 👕
                                    </a>

                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="col-span-3 text-center py-20">
                            <p class="text-gray-500 italic">Pronto verás aquí nuestras camisetas más populares.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
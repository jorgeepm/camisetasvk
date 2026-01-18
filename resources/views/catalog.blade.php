<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ isset($category) ? 'Camisetas de ' . $category->name : 'Catálogo Completo' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($products as $product)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between h-full group border border-gray-200 dark:border-gray-700">
                        
                        {{-- 🖼️ ZONA DE IMAGEN (Estilo unificado con "Ver Todas": Fondo Blanco) --}}
                        <div class="p-6 bg-white flex justify-center relative overflow-hidden h-64 border-b border-gray-100 dark:border-gray-700">
                            @if($product->image_blob)
                                {{-- 1. Nueva (Blob) --}}
                                <img src="{{ $product->image_blob }}" 
                                     alt="{{ $product->name }}" 
                                     class="h-full w-full object-contain transition-transform group-hover:scale-110 duration-300">
                            @elseif($product->image_path)
                                {{-- 2. Antigua (Storage) --}}
                                <img src="{{ asset('storage/' . $product->image_path) }}" 
                                     alt="{{ $product->name }}" 
                                     class="h-full w-full object-contain transition-transform group-hover:scale-110 duration-300">
                            @else
                                {{-- 3. Placeholder --}}
                                <div class="flex items-center justify-center h-full w-full text-gray-400">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                        </div>

                        {{-- CONTENIDO --}}
                        <div class="p-5 flex-grow flex flex-col justify-between">
                            <div>
                                <div class="text-xs font-bold text-indigo-500 uppercase tracking-wider mb-1">
                                    {{ $product->category->name ?? 'Camisetas' }}
                                </div>

                                <h3 class="font-bold text-lg mb-2 text-gray-900 dark:text-white leading-tight">
                                    {{ $product->name }}
                                </h3>
                                
                                <p class="text-gray-500 dark:text-gray-400 text-sm mb-4 line-clamp-2">
                                    {{ Str::limit($product->description, 50) }}
                                </p>
                            </div>

                            <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700 flex items-center justify-between">
                                
                                <span class="text-2xl font-bold text-gray-900 dark:text-white tracking-tight">
                                    {{ number_format($product->price, 2) }} €
                                </span>

                                {{-- BOTONES ADMIN vs CLIENTE --}}
                                @if(Auth::check() && Auth::user()->role === 'admin')
                                    <a href="{{ route('products.edit', $product) }}" 
                                       class="flex items-center gap-2 px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 text-xs font-bold uppercase tracking-wide hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        Editar
                                    </a>
                                @else
                                    <a href="{{ route('products.show', $product->id) }}" 
                                       class="flex items-center gap-2 bg-indigo-600 hover:bg-indigo-500 text-white px-4 py-2 rounded-lg text-sm font-bold shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Personalizar
                                    </a>
                                @endif

                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-4 text-center py-12">
                        <div class="text-gray-400 mb-2">
                            <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                        </div>
                        <p class="text-gray-500 text-lg">No hay camisetas en esta categoría... ¡aún!</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $products->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
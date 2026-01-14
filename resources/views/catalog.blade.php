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
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between h-full">
                        
                        <div class="h-48 bg-gray-200 dark:bg-gray-700 flex items-center justify-center p-4 relative">
                            @if($product->image_path)
                                <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="h-full w-full object-contain drop-shadow-md">
                            @else
                                <span class="text-gray-400">Sin imagen</span>
                            @endif
                        </div>

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
                                    {{ $product->price }} €
                                </span>

                                @if(Auth::user() && Auth::user()->role === 'admin')
                                    
                                    <a href="{{ route('products.edit', $product) }}" 
                                       class="flex items-center gap-2 px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 text-xs font-bold uppercase tracking-wide hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        Editar
                                    </a>

                                @else
                                    
                                    <a href="{{ route('cart.add', $product->id) }}" 
                                       class="flex items-center gap-2 bg-indigo-600 hover:bg-indigo-500 text-white px-4 py-2 rounded-lg text-sm font-bold shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        Añadir
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
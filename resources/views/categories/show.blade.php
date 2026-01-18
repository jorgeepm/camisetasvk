<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Camisetas de: {{ $category->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <a href="{{ route('categories.index') }}" class="text-indigo-600 hover:text-indigo-900 mb-4 inline-block">&larr; Volver a Categorías</a>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                @forelse($products as $product)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4">
                        <div class="bg-gray-200 h-48 w-full mb-4 rounded flex items-center justify-center text-gray-500">
                            <div class="mb-4 bg-gray-50 rounded-xl p-4 flex justify-center items-center">
                                <img src="{{ asset('storage/' . $product->image_path) }}" 
                                    alt="{{ $product->name }}" 
                                    class="h-56 w-auto object-contain hover:scale-105 transition-transform duration-300">
                            </div>
                        </div>

                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $product->name }}</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">{{ Str::limit($product->description, 50) }}</p>
                        
                        <div class="mt-4 flex justify-between items-center">
                            <span class="text-xl font-bold text-indigo-500 font-mono">{{ number_format($product->price, 2) }} €</span>
                            
                            <a href="{{ route('products.show', $product->id) }}" 
                            class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-indigo-700 transition shadow-md flex items-center gap-2">
                            <span>Personalizar</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            </a>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500">No hay camisetas en esta categoría.</p>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>
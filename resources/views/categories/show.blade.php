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
                            [Imagen: {{ $product->image_path }}]
                        </div>

                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $product->name }}</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">{{ Str::limit($product->description, 50) }}</p>
                        
                        <div class="mt-4 flex justify-between items-center">
                            <span class="text-xl font-bold text-indigo-500">{{ $product->price }} €</span>
                            <a href="{{ route('cart.add', $product->id) }}" 
                                    class="bg-indigo-600 text-white px-3 py-1 rounded text-sm hover:bg-indigo-500">
                                    Añadir al Carrito
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
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($category) ? 'Camisetas de ' . $category->name : 'Catálogo Completo' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($products as $product)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow duration-300">
                        <div class="h-48 bg-gray-200 flex items-center justify-center">
                           @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                           @else
                                <span class="text-gray-400">Sin imagen</span>
                           @endif
                        </div>

                        <div class="p-4">
                            <h3 class="font-bold text-lg mb-2">{{ $product->name }}</h3>
                            <p class="text-gray-600 text-sm mb-4">{{ Str::limit($product->description, 50) }}</p>
                            
                            <div class="flex justify-between items-center">
                                <span class="text-xl font-bold text-indigo-600">{{ $product->price }} €</span>
                                <a href="{{ route('cart.add', $product->id) }}" class="bg-indigo-600 text-white px-3 py-1 rounded-md text-sm hover:bg-indigo-700 transition">
                                    Añadir 🛒
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-4 text-center py-10 text-gray-500">
                        <p>No hay camisetas en esta categoría... ¡aún!</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $products->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
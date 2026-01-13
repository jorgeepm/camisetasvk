<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Panel de Administración: Productos
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="mb-4 flex justify-end">
                <a href="{{ route('products.create') }}" class="bg-blue-600 text-white font-bold py-2 px-4 rounded hover:bg-blue-700">
                    + Nuevo Producto
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Imagen</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoría</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($products as $product)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <img src="{{ asset('storage/' . $product->image_path) }}" alt="img" class="h-12 w-12 object-cover rounded">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $product->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $product->price }} €</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="{{ $product->stock < 10 ? 'text-red-600 font-bold' : 'text-green-600' }}">
                                        {{ $product->stock }} u.
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $product->category->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('products.edit', $product) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Editar</a>
                                    
                                    <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('¿Seguro que quieres borrar este producto?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Borrar</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    <div class="mt-4">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
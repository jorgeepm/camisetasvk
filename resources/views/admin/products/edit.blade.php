<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar: {{ $product->name }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Nombre:</label>
                        <input type="text" name="name" value="{{ $product->name }}" class="w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Categoría:</label>
                        <select name="category_id" class="w-full border-gray-300 rounded-md shadow-sm">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Precio (€):</label>
                            <input type="number" step="0.01" name="price" value="{{ $product->price }}" class="w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Stock:</label>
                            <input type="number" name="stock" value="{{ $product->stock }}" class="w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Descripción:</label>
                        <textarea name="description" rows="3" class="w-full border-gray-300 rounded-md shadow-sm" required>{{ $product->description }}</textarea>
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Imagen (Dejar vacío para mantener la actual):</label>
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $product->image_path) }}" class="h-20 w-auto rounded border" alt="Actual">
                        </div>
                        <input type="file" name="image" class="w-full text-sm text-gray-500" accept="image/*">
                    </div>

                    <div class="flex justify-between">
                        <button type="submit" class="bg-blue-600 text-white font-bold py-2 px-4 rounded">Actualizar</button>
                        <a href="{{ route('products.index') }}" class="text-gray-500 hover:text-gray-700 py-2 px-4">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
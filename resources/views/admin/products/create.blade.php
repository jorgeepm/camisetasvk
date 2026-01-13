<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Crear Nuevo Producto
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Nombre:</label>
                        <input type="text" name="name" class="w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Categoría:</label>
                        <select name="category_id" class="w-full border-gray-300 rounded-md shadow-sm">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Precio (€):</label>
                            <input type="number" step="0.01" name="price" class="w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Stock:</label>
                            <input type="number" name="stock" class="w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Descripción:</label>
                        <textarea name="description" rows="3" class="w-full border-gray-300 rounded-md shadow-sm" required></textarea>
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Imagen:</label>
                        <input type="file" name="image" id="imageInput" class="w-full text-sm text-gray-500" accept="image/*" required>
                        <div class="mt-2">
                            <img id="imagePreview" src="#" style="display:none; max-height: 150px;" class="rounded border">
                        </div>
                    </div>

                    <div class="flex justify-between items-center">
                        <button type="submit" class="bg-blue-600 text-white font-bold py-2 px-4 rounded hover:bg-blue-700">
                            Guardar Producto
                        </button>
                        
                        <a href="{{ route('products.index') }}" class="text-gray-500 hover:text-gray-700 py-2 px-4">Cancelar</a>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('imageInput').addEventListener('change', function(e) {
            if (e.target.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('imagePreview').src = e.target.result;
                    document.getElementById('imagePreview').style.display = 'block';
                }
                reader.readAsDataURL(e.target.files[0]);
            }
        });
    </script>
</x-app-layout>
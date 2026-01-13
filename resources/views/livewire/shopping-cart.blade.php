<div class="p-6">
    {{-- Mensajes de error (Stock) --}}
    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
            {{ session('error') }}
        </div>
    @endif

    @if(count($cart) > 0)
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Producto</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cantidad</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200">
                @foreach($cart as $id => $details)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap flex items-center">
                        <img src="{{ asset('storage/' . $details['image_path']) }}" alt="{{ $details['name'] }}" class="h-10 w-10 rounded-full object-cover mr-3">
                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $details['name'] }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $details['price'] }} €</td>
                    
                    {{-- CONTROLES LIVEWIRE --}}
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <div class="flex items-center space-x-2">
                            <button wire:click="decrement({{ $id }})" class="bg-gray-200 hover:bg-gray-300 rounded-full w-6 h-6 flex items-center justify-center font-bold text-xs cursor-pointer">-</button>
                            <span>{{ $details['quantity'] }}</span>
                            <button wire:click="increment({{ $id }})" class="bg-indigo-100 text-indigo-600 hover:bg-indigo-200 rounded-full w-6 h-6 flex items-center justify-center font-bold text-xs cursor-pointer">+</button>
                        </div>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $details['price'] * $details['quantity'] }} €
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <button wire:click="remove({{ $id }})" class="text-red-600 hover:text-red-900 text-sm cursor-pointer">Eliminar</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-6 text-right">
            <h3 class="text-xl font-bold dark:text-white">Total: {{ $total }} €</h3>
            <div class="mt-4">
                <form action="{{ route('checkout.store') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-500 transition">
                        Tramitar Pedido 💳
                    </button>
                </form>
            </div>
        </div>
    @else
        <div class="text-center py-10">
            <p class="text-gray-500 text-xl">Tu carrito está vacío 🛒</p>
            <a href="{{ route('categories.index') }}" class="text-indigo-600 hover:underline mt-4 block">Volver a la tienda</a>
        </div>
    @endif
</div>
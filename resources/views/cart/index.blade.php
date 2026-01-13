<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            🛒 Tu Carrito de Compra
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('cart'))
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr>
                                <th class="py-4 px-6 bg-gray-100 dark:bg-gray-700 font-bold uppercase text-sm text-gray-600 dark:text-gray-200 border-b border-gray-200 dark:border-gray-600">Producto</th>
                                <th class="py-4 px-6 bg-gray-100 dark:bg-gray-700 font-bold uppercase text-sm text-gray-600 dark:text-gray-200 border-b border-gray-200 dark:border-gray-600">Precio</th>
                                <th class="py-4 px-6 bg-gray-100 dark:bg-gray-700 font-bold uppercase text-sm text-gray-600 dark:text-gray-200 border-b border-gray-200 dark:border-gray-600">Cantidad</th>
                                <th class="py-4 px-6 bg-gray-100 dark:bg-gray-700 font-bold uppercase text-sm text-gray-600 dark:text-gray-200 border-b border-gray-200 dark:border-gray-600">Subtotal</th>
                                <th class="py-4 px-6 bg-gray-100 dark:bg-gray-700 font-bold uppercase text-sm text-gray-600 dark:text-gray-200 border-b border-gray-200 dark:border-gray-600">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(session('cart') as $id => $details)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="py-4 px-6 border-b border-gray-200 dark:border-gray-600 flex items-center">
                                        <img src="{{ asset('storage/' . $details['image']) }}" alt="{{ $details['name'] }}" class="w-16 h-16 object-cover rounded mr-4">
                                        <span class="text-gray-700 dark:text-gray-200 font-medium">{{ $details['name'] }}</span>
                                    </td>
                                    <td class="py-4 px-6 border-b border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-200">
                                        {{ $details['price'] }} €
                                    </td>
                                    <td class="py-4 px-6 border-b border-gray-200 dark:border-gray-600">
                                        <span class="text-center w-8 inline-block text-gray-700 dark:text-gray-200">{{ $details['quantity'] }}</span>
                                    </td>
                                    <td class="py-4 px-6 border-b border-gray-200 dark:border-gray-600 text-indigo-600 font-bold">
                                        {{ $details['price'] * $details['quantity'] }} €
                                    </td>
                                    <td class="py-4 px-6 border-b border-gray-200 dark:border-gray-600">
                                        <form action="{{ route('cart.remove') }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="id" value="{{ $id }}">
                                            <button type="submit" class="text-red-600 hover:text-red-900 font-bold text-sm">
                                                🗑️ Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" class="text-right py-6">
                                    <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200">
                                        Total: {{ $total }} €
                                    </h3>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5" class="text-right">
                                    <a href="{{ url('/categorias') }}" class="bg-gray-500 text-white font-bold py-2 px-4 rounded hover:bg-gray-600 mr-2">
                                        Seguir Comprando
                                    </a>
                                    
                                    <form action="{{ route('checkout.store') }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-indigo-600 text-white font-bold py-2 px-4 rounded hover:bg-indigo-500">
                                            Tramitar Pedido 💳
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                @else
                    <div class="text-center py-12">
                        <p class="text-gray-500 text-xl mb-6">Tu carrito está vacío 😢</p>
                        <a href="{{ url('/categorias') }}" class="bg-indigo-600 text-white font-bold py-3 px-6 rounded hover:bg-indigo-500">
                            Ir a comprar camisetas
                        </a>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
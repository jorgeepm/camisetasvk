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
                    {{-- COLUMNA PRODUCTO --}}
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            {{-- FOTO --}}
                            @if(isset($details['image_path']))
                                <img src="{{ asset('storage/' . $details['image_path']) }}" alt="{{ $details['name'] }}" class="h-12 w-12 rounded object-cover mr-4 border border-gray-200 dark:border-gray-600">
                            @endif
                            
                            <div>
                                {{-- NOMBRE CAMISETA --}}
                                <div class="text-sm font-bold text-gray-900 dark:text-white">
                                    {{ $details['name'] }}
                                </div>
                                
                                {{-- TALLA --}}
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    Talla: {{ $details['size'] ?? 'Estándar' }}
                                </div>

                                {{-- ZONA DE PERSONALIZACIÓN --}}
                                @if(isset($details['custom_name']) && $details['custom_name'])
                                    <div class="mt-1 inline-flex flex-col bg-indigo-50 dark:bg-indigo-900/50 border border-indigo-100 dark:border-indigo-800 rounded px-2 py-1">
                                        <div class="text-xs text-indigo-700 dark:text-indigo-300 font-semibold">
                                            Personalizado:
                                        </div>
                                        <div class="text-xs text-gray-600 dark:text-gray-300">
                                            👤 {{ $details['custom_name'] }} 
                                            @if(isset($details['custom_number']))
                                                <span class="mx-1 text-gray-300">|</span> 
                                                #️⃣ {{ $details['custom_number'] }}
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </td>

                    {{-- PRECIO --}}
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                        {{ number_format($details['price'], 2) }} €
                    </td>
                    
                    {{-- CONTROLES CANTIDAD --}}
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <div class="flex items-center space-x-2">
                            <button wire:click="decrement('{{ $id }}')" class="bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white rounded-full w-6 h-6 flex items-center justify-center font-bold text-xs cursor-pointer transition">-</button>
                            <span class="font-bold text-gray-900 dark:text-white w-4 text-center">{{ $details['quantity'] }}</span>
                            <button wire:click="increment('{{ $id }}')" class="bg-indigo-100 text-indigo-600 hover:bg-indigo-200 rounded-full w-6 h-6 flex items-center justify-center font-bold text-xs cursor-pointer transition">+</button>
                        </div>
                    </td>

                    {{-- SUBTOTAL --}}
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-800 dark:text-gray-200">
                        {{ number_format($details['price'] * $details['quantity'], 2) }} €
                    </td>

                    {{-- ELIMINAR --}}
                    <td class="px-6 py-4 whitespace-nowrap">
                        <button wire:click="remove('{{ $id }}')" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 text-sm cursor-pointer font-bold hover:underline">
                            Eliminar
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- RESUMEN DEL PEDIDO --}}
        <div class="mt-8 flex flex-col items-end">
            <h3 class="text-xl font-bold dark:text-white mb-2">Total: <span class="text-indigo-600 dark:text-indigo-400">{{ number_format($total, 2) }} €</span></h3>
            <p class="text-xs text-gray-500 mb-6">Impuestos incluidos. Gastos de envío calculados en el siguiente paso.</p>
            
            <div class="flex items-center gap-6">
                {{-- BOTÓN 1: SEGUIR COMPRANDO (NUEVO) --}}
                <a href="{{ route('catalog.all') }}" class="text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 font-semibold text-sm transition flex items-center">
                    ← Seguir Comprando
                </a>

                {{-- BOTÓN 2: TRAMITAR PEDIDO --}}
                <a href="{{ route('checkout.index') }}" class="inline-block bg-indigo-600 text-white px-8 py-3 rounded-md font-bold hover:bg-indigo-500 transition shadow-lg transform hover:-translate-y-0.5">
                    Tramitar Pedido ➡️
                </a>
            </div>
        </div>
    @else
        {{-- CARRITO VACÍO --}}
        <div class="text-center py-16 bg-gray-50 dark:bg-gray-700/50 rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Tu carrito está vacío</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">¡Vamos a llenarlo de camisetas chulas!</p>
            <div class="mt-6">
                <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Ir a comprar
                </a>
            </div>
        </div>
    @endif
</div>
<div class="p-6">
    {{-- Mensajes de error (Stock) --}}
    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('error') }}
        </div>
    @endif

    @if(count($cart) > 0)
        
        {{-- TÍTULO SIMPLE (Sin botón de vaciar) --}}
        <h3 class="text-lg font-bold text-gray-700 dark:text-gray-300 mb-4">Resumen de productos</h3>

        <div class="overflow-x-auto rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700/50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Producto</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Precio</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Cantidad</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Subtotal</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($cart as $id => $details)
                    {{-- 🔥 IMPORTANTE: wire:key ES LO QUE ARREGLA EL BLOQUEO AL BORRAR UNO A UNO --}}
                    <tr wire:key="cart-item-{{ $id }}" class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                        
                        {{-- COLUMNA PRODUCTO --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-16 w-16 flex-shrink-0 mr-4 bg-white rounded-lg border border-gray-200 dark:border-gray-600 p-1 flex items-center justify-center overflow-hidden">
                                    @if(isset($details['image_blob']) && !empty($details['image_blob']))
                                        <img src="{{ $details['image_blob'] }}" alt="{{ $details['name'] }}" class="h-full w-full object-contain">
                                    @elseif(isset($details['image_path']) && !empty($details['image_path']))
                                        <img src="{{ asset('storage/' . $details['image_path']) }}" alt="{{ $details['name'] }}" class="h-full w-full object-contain">
                                    @else
                                        <div class="text-gray-300 flex flex-col items-center justify-center h-full w-full">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                    @endif
                                </div>
                                
                                <div>
                                    <div class="text-sm font-bold text-gray-900 dark:text-white line-clamp-2 w-48 whitespace-normal">
                                        {{ $details['name'] }}
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        Talla: <span class="font-bold text-indigo-500">{{ $details['size'] ?? 'Estándar' }}</span>
                                    </div>
                                    @if(isset($details['custom_name']) && $details['custom_name'])
                                        <div class="mt-1 inline-flex flex-col bg-indigo-50 dark:bg-indigo-900/30 border border-indigo-100 dark:border-indigo-800 rounded px-2 py-1">
                                            <div class="text-[10px] text-indigo-700 dark:text-indigo-300 font-bold uppercase tracking-wider">Personalizado</div>
                                            <div class="text-xs text-gray-700 dark:text-gray-200 font-medium">
                                                {{ $details['custom_name'] }} 
                                                @if(isset($details['custom_number'])) <span class="mx-1 opacity-50">|</span> #{{ $details['custom_number'] }} @endif
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
                        
                        {{-- CANTIDAD --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div class="flex items-center space-x-2 bg-gray-100 dark:bg-gray-900 rounded-lg p-1 w-fit border border-gray-200 dark:border-gray-600">
                                <button type="button" wire:click="decrement('{{ $id }}')" class="hover:bg-white dark:hover:bg-gray-700 shadow-sm rounded-md w-6 h-6 flex items-center justify-center font-bold text-xs text-gray-600 dark:text-gray-300 transition">-</button>
                                <span class="font-bold text-gray-900 dark:text-white w-6 text-center text-sm">{{ $details['quantity'] }}</span>
                                <button type="button" wire:click="increment('{{ $id }}')" class="hover:bg-white dark:hover:bg-gray-700 shadow-sm rounded-md w-6 h-6 flex items-center justify-center font-bold text-xs text-indigo-600 dark:text-indigo-400 transition">+</button>
                            </div>
                        </td>

                        {{-- SUBTOTAL --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-black text-gray-800 dark:text-gray-200">
                            {{ number_format($details['price'] * $details['quantity'], 2) }} €
                        </td>

                        {{-- ELIMINAR --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            <button type="button" wire:click="remove('{{ $id }}')" class="group p-2 rounded-full hover:bg-red-50 dark:hover:bg-red-900/20 transition">
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-red-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- RESUMEN --}}
        <div class="mt-8 bg-gray-50 dark:bg-gray-900/50 p-6 rounded-xl border border-gray-200 dark:border-gray-700 flex flex-col items-end">
            <div class="flex items-center gap-4 mb-2">
                <span class="text-gray-500 dark:text-gray-400 font-medium">Total del pedido:</span>
                <span class="text-3xl font-black text-[#0004ff] dark:text-indigo-400">{{ number_format($total, 2) }} €</span>
            </div>
            <p class="text-xs text-gray-500 mb-6 italic">Impuestos incluidos. El envío se calcula al final.</p>
            
            <div class="flex items-center gap-4">
                <a href="{{ route('catalog.all') }}" class="px-4 py-3 text-gray-600 dark:text-gray-400 hover:text-[#0004ff] dark:hover:text-indigo-400 font-bold text-sm transition flex items-center gap-2">
                    <span>←</span> Seguir Comprando
                </a>
                <a href="{{ route('checkout.index') }}" 
                   class="bg-[#0004ff] dark:bg-indigo-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-[#0258f7] dark:hover:bg-indigo-500 transition-all shadow-lg hover:shadow-indigo-500/30 transform hover:-translate-y-1 flex items-center gap-2">
                    Tramitar Pedido
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>
        </div>
    @else
        {{-- CARRITO VACÍO --}}
        <div class="text-center py-20 bg-gray-50 dark:bg-gray-800/50 rounded-2xl border-2 border-dashed border-gray-200 dark:border-gray-700">
            <div class="bg-gray-100 dark:bg-gray-700 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
            </div>
            <h3 class="mt-2 text-lg font-bold text-gray-900 dark:text-white">Tu carrito está vacío</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400 mb-6">¿A qué esperas para lucir los colores de tu equipo?</p>
            <a href="{{ route('catalog.all') }}" class="inline-flex items-center px-6 py-3 border border-transparent shadow-sm text-sm font-bold rounded-xl text-white bg-[#0004ff] dark:bg-indigo-600 hover:bg-[#0258f7] dark:hover:bg-indigo-500 transition-all">Ver Catálogo</a>
        </div>
    @endif
</div>
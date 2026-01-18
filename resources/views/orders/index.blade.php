<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Mis Pedidos') }} 📦
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                
                @if($orders->count() > 0)
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nº Pedido</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Productos y Detalles</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-right">Estado</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200">
                            @foreach($orders as $order)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $order->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 dark:text-white">
                                    #{{ $order->id }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    <div class="space-y-2">
                                        @foreach($order->items as $item)
                                            <div class="border-l-2 border-indigo-500 pl-3">
                                                <span class="font-bold text-gray-800 dark:text-gray-200">
                                                    {{ $item->product->name ?? 'Camiseta' }}
                                                </span>
                                                <div class="text-[11px] text-gray-400 mt-1 uppercase tracking-wider">
                                                    <span>Talla: <b class="text-indigo-400">{{ $item->size ?? 'S/T' }}</b></span>

                                                    @if($item->custom_name)
                                                        <span class="ml-2">| Nombre: <b class="text-indigo-400">{{ $item->custom_name }}</b></span>
                                                    @endif

                                                    @if($item->custom_number)
                                                        <span class="ml-2">| Nº: <b class="text-indigo-400">{{ $item->custom_number }}</b></span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-indigo-600">
                                    {{ number_format($order->total, 2) }} €
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    {{-- LÓGICA DE TRADUCCIÓN Y COLORES --}}
                                    @php
                                        $statusData = match($order->status) {
                                            'paid' => ['text' => 'Pagado', 'class' => 'bg-green-100 text-green-800 border-green-200'],
                                            'pending' => ['text' => 'Pendiente', 'class' => 'bg-yellow-100 text-yellow-800 border-yellow-200'],
                                            'shipped' => ['text' => 'Enviado', 'class' => 'bg-blue-100 text-blue-800 border-blue-200'],
                                            'completed' => ['text' => 'Completado', 'class' => 'bg-indigo-100 text-indigo-800 border-indigo-200'],
                                            'cancelled' => ['text' => 'Cancelado', 'class' => 'bg-red-100 text-red-800 border-red-200'],
                                            default => ['text' => $order->status, 'class' => 'bg-gray-100 text-gray-800 border-gray-200'],
                                        };
                                    @endphp
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full border {{ $statusData['class'] }} uppercase tracking-wide">
                                        {{ $statusData['text'] }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center py-10">
                        <p class="text-gray-500 text-lg">Aún no has realizado ninguna compra.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detalles del Pedido #{{ $order->id }}
            </h2>
            <a href="{{ route('admin.orders.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
                ← Volver al listado
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex gap-6">
            
            <div class="w-2/3 bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4 text-gray-700">Artículos comprados</h3>
                
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th class="px-4 py-2">Producto</th>
                            <th class="px-4 py-2">Precio</th>
                            <th class="px-4 py-2">Cant.</th>
                            <th class="px-4 py-2">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr class="border-b">
                            <td class="px-4 py-3 font-medium text-gray-900">
                                {{ $item->product->name ?? 'Producto borrado' }}
                            </td>
                            <td class="px-4 py-3">{{ $item->price }} €</td>
                            <td class="px-4 py-3">{{ $item->quantity }}</td>
                            <td class="px-4 py-3 font-bold">{{ $item->price * $item->quantity }} €</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-6 flex justify-end">
                    <div class="text-right">
                        <p class="text-gray-600">Total Pagado:</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $order->total }} €</p>
                    </div>
                </div>
            </div>

            <div class="w-1/3 space-y-6">
                
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-bold mb-4 text-gray-700">Cliente</h3>
                    <p class="text-gray-900 font-medium">{{ $order->user->name }}</p>
                    <p class="text-gray-500 text-sm">{{ $order->user->email }}</p>
                    <p class="text-gray-500 text-xs mt-2">Registrado el: {{ $order->user->created_at->format('d/m/Y') }}</p>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                    <h3 class="text-lg font-bold mb-4 text-gray-700">Gestionar Estado</h3>
                    
                    <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <label class="block text-sm font-medium text-gray-700 mb-2">Estado actual:</label>
                        <select name="status" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 mb-4">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>🟡 Pendiente</option>
                            <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>🟢 Pagado</option>
                            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>🚚 Enviado</option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>✅ Completado</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>❌ Cancelado</option>
                        </select>

                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">
                            Actualizar Estado
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
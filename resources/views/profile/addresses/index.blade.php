<x-app-layout>
    <x-slot name="header">
        <h2>Mis direcciones</h2>
    </x-slot>

    <div class="max-w-4xl mx-auto">

        {{-- Formulario para añadir dirección --}}
        <form action="{{ route('profile.addresses.store') }}" method="POST">
            @csrf
            <input type="text" name="street" placeholder="Calle" required>
            <input type="text" name="city" placeholder="Ciudad" required>
            <input type="text" name="province" placeholder="Provincia" required>
            <input type="text" name="postal_code" placeholder="Código Postal" required>
            <button type="submit">Añadir dirección</button>
        </form>

        {{-- Lista de direcciones --}}
        <ul>
            @foreach($addresses as $address)
                <li>
                    {{ $address->street }} - {{ $address->city }}
                    <form action="{{ route('profile.addresses.destroy', $address) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Eliminar</button>
                    </form>
                </li>
            @endforeach
        </ul>

    </div>
</x-app-layout>
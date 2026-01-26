<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Actualizar contraseña') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Asegurate de que tu cuenta utilice una contraseña segura.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Introduce la contraseña actual')" />
            <div class="mt-1 relative" x-data="{ show: false }">
                {{-- El input cambia de tipo según el estado de 'show' --}}
                <x-text-input id="update_password_current_password" name="current_password" ::type="show ? 'text' : 'password'"  class="mt-1 block w-full" autocomplete="current-password" /> 
                {{-- El botón del ojito --}}
                <button type="button" 
                        @click="show = !show" 
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5 z-10">
                    
                    {{-- Icono Ojo Abierto (se ve cuando show es true) --}}
                    <svg x-show="show" class="h-5 w-5 text-cyan-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>

                    {{-- Icono Ojo Cerrado (se ve cuando show es false) --}}
                    <svg x-show="!show" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.025 10.025 0 014.132-5.411m0 0L21 21m-2.102-2.102L15.357 15.357m-4.608-4.608L3 3m3.658 3.658A9.959 9.959 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('Introduce la nueva contraseña')" />
            <div class="mt-1 relative" x-data="{ show: false }">
                {{-- El input cambia de tipo según el estado de 'show' --}}
                <x-text-input id="update_password_password" name="password" ::type="show ? 'text' : 'password'"  class="mt-1 block w-full" autocomplete="new-password"/>
                    
                {{-- El botón del ojito --}}
                <button type="button" 
                        @click="show = !show" 
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5 z-10">
                    
                    {{-- Icono Ojo Abierto (se ve cuando show es true) --}}
                    <svg x-show="show" class="h-5 w-5 text-cyan-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>

                    {{-- Icono Ojo Cerrado (se ve cuando show es false) --}}
                    <svg x-show="!show" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.025 10.025 0 014.132-5.411m0 0L21 21m-2.102-2.102L15.357 15.357m-4.608-4.608L3 3m3.658 3.658A9.959 9.959 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirma la nueva contraseña')" />
            <div class="mt-1 relative" x-data="{ show: false }">
                {{-- El input cambia de tipo según el estado de 'show' --}}
                <x-text-input id="update_password_password_confirmation" name="password_confirmation" ::type="show ? 'text' : 'password'" class="mt-1 block w-full" autocomplete="new-password"/>

                {{-- El botón del ojito --}}
                <button type="button" 
                        @click="show = !show" 
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5 z-10">
                    
                    {{-- Icono Ojo Abierto (se ve cuando show es true) --}}
                    <svg x-show="show" class="h-5 w-5 text-cyan-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>

                    {{-- Icono Ojo Cerrado (se ve cuando show es false) --}}
                    <svg x-show="!show" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.025 10.025 0 014.132-5.411m0 0L21 21m-2.102-2.102L15.357 15.357m-4.608-4.608L3 3m3.658 3.658A9.959 9.959 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="bg = white">{{ __('Guardar contraseña') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Contraseña actualizada con éxito') }}</p>
            @endif
        </div>
    </form>
</section>

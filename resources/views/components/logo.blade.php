{{-- resources/views/components/logo.blade.php --}}
<div {{ $attributes->merge(['class' => 'relative']) }}>
    <img src="{{ asset('storage/logo.png') }}" 
         class="dark:hidden w-full h-full object-contain" 
         alt="Logo">

    <img src="{{ asset('storage/logo-claro.png') }}" 
         class="hidden dark:block w-full h-full object-contain" 
         alt="Logo Dark">
</div>

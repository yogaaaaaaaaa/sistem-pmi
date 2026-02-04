<div class="flex flex-col items-center justify-center">
    {{-- Gambar Logo --}}
    <img src="{{ asset('images/logo.png') }}" alt="Logo P4MI" 
         {{ $attributes->merge(['class' => 'h-24 w-auto object-contain']) }}>
    
    {{-- Teks di bawahnya --}}
    <p class="mt-2 text-xl font-bold text-center text-gray-900">
        P4MI Tangerang
    </p>
</div>
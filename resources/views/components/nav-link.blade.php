@props([
    'active' => false
])

<a {{ $attributes }} class="{{ $active ? 'underline underline-offset-8 decoration-2 text-black' : 'text-black group transition-all duration-300 ease-in-out' }}" aria-current="{{ $active ? 'page' : false }}"> <span class="pb-1.5 bg-left-bottom bg-gradient-to-r from-black to-black bg-[length:0%_2px] bg-no-repeat group-hover:bg-[length:100%_2px] transition-all duration-500 ease-out"> {{ $slot }}
</span></a>
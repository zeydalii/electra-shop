<nav class="">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="flex h-72 items-center justify-center border-b-2">
      <div class="flex flex-col items-center justify-center">
        <img src="{{url('/images/logo.png')}}" alt="" class="w-24">
        <h1 class="mt-4 font-bold text-cyan-900">ELECTRA SHOP.</h1>
        <div class="mt-10 space-x-2">
          <x-nav-link href="/" :active="request()->is('/')">Home</x-nav-link>
          <x-nav-link href="/about" :active="request()->is('about')">About</x-nav-link>
          <x-nav-link href="/contact" :active="request()->is('contact')">Contact</x-nav-link>
        </div>
      </div>
    </div>
  </div>
</nav>
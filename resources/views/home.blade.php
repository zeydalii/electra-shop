@php
  function formatRupiah($number) {
    return 'IDR' . number_format($number, 2, ',', '.');
  }
@endphp
<x-layout>
  <x-slot:title>{{ $title }}</x-slot:title>
  
  <div class="px-4 mx-auto max-w-screen-xl lg:py-4 lg:px-0">
    <div class="flex justify-between gap-4 w-full sm:text-center">
      <form class="" action="/" method="GET">
        <div class="items-center w-full sm:flex sm:space-y-0">
          <div class="relative w-full">
            <input class="block p-3 pl-5 w-[350px] text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 sm:rounded-none sm:rounded-l-lg focus:ring-black/20 focus:border-black/20 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-black/20 dark:focus:border-black/20" placeholder="Search for product..." type="search" id="search" name="search" autocomplete="off" value="{{ request('search') }}">
          </div>
          <div>
            <button type="submit" class="py-3 px-5 w-full text-sm font-medium text-center text-white rounded-lg border cursor-pointer sm:rounded-none sm:rounded-r-lg">
              <svg class="w-5 h-5 text-black" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
              <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/>
              </svg>
            </button>
          </div>
        </div>
      </form>
      <div class="flex justify-center">
        <button onclick="location.href='/chart'">
          <svg class="w-5 cursor-pointer" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M160 112c0-35.3 28.7-64 64-64s64 28.7 64 64l0 48-128 0 0-48zm-48 48l-64 0c-26.5 0-48 21.5-48 48L0 416c0 53 43 96 96 96l256 0c53 0 96-43 96-96l0-208c0-26.5-21.5-48-48-48l-64 0 0-48C336 50.1 285.9 0 224 0S112 50.1 112 112l0 48zm24 48a24 24 0 1 1 0 48 24 24 0 1 1 0-48zm152 24a24 24 0 1 1 48 0 24 24 0 1 1 -48 0z"/></svg>
        </button>
      </div>
    </div>
    <div class="grid md:grid-cols-2 gap-8 lg:grid-cols-3">
      @if ($products->count() > 0)
        @foreach($products as $product)
          <div class="w-full flex justify-center">
            <div class="flex flex-col w-[340px] h-[450px] justify-between p-10 gap-4">
              <img class="min-w-full min-h-full object-cover" src="{{ Storage::url($product->image) }}" alt="">
              <div class="flex justify-between">
                <div class="flex flex-col gap-4">
                  <h2 class="font-extrabold">{{ $product->merk }}</h2>
                  <p>{{ formatRupiah($product->harga) }}</p>
                </div>
                <div class="flex flex-col gap-3">
                  <p>Stock : {{ $product->stock }}</p>
                  <form action="/store-chart/{{ $product->id }}" method="POST">
                    @csrf
                    <input type="hidden" name="session_id" value="{{ session()->getId() }}">
                    <input type="hidden" name="item_id" value="{{ $product->id }}">
                    <input type="hidden" name="jumlah" value="1">
                    <input type="hidden" name="harga" value="{{ $product->harga }}">
                    <button type="submit" class="border border-black/25 py-1 px-3 rounded-lg text-sm hover:bg-black/10">Add to chart</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
      @endforeach
      @else
        <div class="absolute mt-20 place-self-center">Tidak ada data.</div>
      @endif
    </div>

    <div class="text-gray-600 dark:text-gray-400 bg-secondary-50 dark:bg-secondary-900 mt-20">
      {{ $products->appends(['search' => $search])->links() }}
    </div>
  </div>

  <!-- Main modal -->
  @if(session('success'))
    <div id="successModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
      <div class="relative p-4 w-full max-w-md h-full md:h-auto">
          <!-- Modal content -->
          <div class="relative p-4 text-center bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
              <button id="closeModalButton" type="button" class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="successModal">
                  <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                  <span class="sr-only">Close modal</span>
              </button>
              <div class="w-12 h-12 rounded-full bg-green-100 dark:bg-green-900 p-2 flex items-center justify-center mx-auto mb-3.5">
                  <svg aria-hidden="true" class="w-8 h-8 text-green-500 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                  <span class="sr-only">Success</span>
              </div>
              <p class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">{{ session('success') }}</p>
              <button id="continueButton" data-modal-toggle="successModal" type="button" class="py-2 px-3 text-sm font-medium text-center text-white rounded-lg bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 dark:focus:ring-primary-900">
                  Continue
              </button>
          </div>
      </div>
    </div>
  @endif

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      if ({{ session('success') ? 'true' : 'false' }}) {
        const successModal = document.getElementById('successModal');
        successModal.classList.remove('hidden');
        successModal.classList.add('flex');

        document.getElementById('continueButton').addEventListener('click', function() {
          successModal.classList.add('hidden');
          successModal.classList.remove('flex');

          document.getElementById('closeModalButton').addEventListener('click', function() {
            successModal.classList.add('hidden');
            successModal.classList.remove('flex');
          });
        });
      }
    });
  </script>

</x-layout>
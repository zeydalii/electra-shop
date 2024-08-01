{{-- @dd($allItems) --}}
@php
  function formatRupiah($number) {
    return 'IDR' . number_format($number, 2, ',', '.');
  }
@endphp
<x-layout>
  <x-slot:title>{{ $title }}</x-slot:title>
  
  <div class="flex justify-center">
    <h2 class="text-lg font-semibold">My Chart</h2>
  </div>

  <div class="px-4 mx-auto max-w-screen-xl lg:py-4 lg:px-0">
    <div class="flex justify-center items-center my-10">
      <div class="w-full">
        <div class="flex flex-col gap-2">
          @if (count($allItems) > 0)
            @foreach ($allItems as $item)
              <div class="p-2 border border-black flex justify-between">
                <div class="flex gap-x-4">
                  <img class="w-[200px] h-[200px] object-cover" src="{{ Storage::url($item['image']) }}" alt="">
                  <div class="flex flex-col">
                    <h2 class="font-semibold">{{ $item['merk'] }}</h2>
                    <p>QTY : {{ $item['jumlah'] }}</p>
                    <p>{{ formatRupiah($item['harga']) }}</p>
                  </div>
                </div>
                <div class="flex flex-col justify-between">
                  <div class="flex justify-end"><button data-id="{{ $item['id'] }}" class="deleteDialogButton rounded-xl border border-black/10 h-7 w-7 hover:bg-red-300 hover:border-red-500">X</button></div>
                  <p class="subtotal-amount">{{ formatRupiah($item['subtotal']) }}</p>
                </div>
              </div>
            @endforeach
          @endif
        </div>
      </div>
    </div>
  </div>

  <div class="flex justify-center items-center">
    <form action="/chart" method="POST">
    @csrf
      <div class="w-[300px] py-3 flex flex-col gap-y-3 items-center border border-black">
        <div class="flex flex-col items-center">
          <div>Total</div>
          {{-- <p>Rp1000000</p> --}}
          <input type="hidden" name="total" id="quantityInput">
          <h5 id="totalAmount">Rp 0</h5>
        </div>
        <div class="w-[300px] flex justify-center">
          <input class="block p-3 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 sm:rounded-none focus:ring-black/20 focus:border-black/20 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-black/20 dark:focus:border-black/20" placeholder="Email" type="email" id="email" name="email" autocomplete="off" required>
        </div>
        <div>
          <button type="submit" class="border border-black/25 py-1 px-3 rounded-lg hover:bg-black/10">Bayar</button>
        </div>
      </div>
    </form>
  </div>

  <div class="hidden fixed inset-0 bg-gray-800 bg-opacity-75 bg-deleteBlur z-50 items-center justify-center">
    <div class="bg-white rounded-lg shadow dark:bg-gray-800 p-4 sm:p-5 relative delete-box-open hidden">
      <button type="button" class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white closeDeleteDialogButton">
        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
        </svg>
        <span class="sr-only">Close modal</span>
      </button>
      <svg class="text-gray-400 dark:text-gray-500 w-11 h-11 mb-3.5 mx-auto" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
      </svg>
      <p class="mb-4 text-gray-500 dark:text-gray-300">Apakah kamu yakin ingin menghapus item ini?</p>
      <div class="flex justify-center items-center space-x-4">
        <button type="button" class="py-2 px-3 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 closeDeleteDialogButton">
          Tidak
        </button>
        <form id="deleteForm" action="" method="POST">
          @csrf
          @method('DELETE')
          <input type="hidden" name="item_id" value="">
          <button type="submit" class="py-2 px-3 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">
            Iya, konfirmasi
          </button>
        </form>
      </div>
    </div>
  </div>

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
    document.addEventListener('DOMContentLoaded', function () {
      const buttons = document.querySelectorAll('.deleteDialogButton');
      const boxOpen = document.querySelector('.delete-box-open');
      const closeButton = document.querySelectorAll('.closeDeleteDialogButton');
      const bgBlur = document.querySelector('.bg-deleteBlur');
      const deleteForm = document.getElementById('deleteForm');
      const hiddenInput = deleteForm.querySelector('input[name="item_id"]');

      buttons.forEach(button => {
        button.addEventListener('click', function () {
          const expanded = button.getAttribute('aria-expanded') === 'true' || false;

          if (expanded) {
            boxOpen.classList.add('hidden');
            button.setAttribute('aria-expanded', 'false');
            bgBlur.classList.add('hidden');
          } else {
            const itemId = button.getAttribute('data-id');
            deleteForm.action = '/chart/' + itemId;
            hiddenInput.value = itemId;

            boxOpen.classList.remove('hidden');
            button.setAttribute('aria-expanded', 'true');
            bgBlur.classList.remove('hidden');
            bgBlur.classList.add('flex');
          }
        });
      });

      closeButton.forEach(button => {
        button.addEventListener('click', function () {
          boxOpen.classList.add('hidden');
          bgBlur.classList.add('hidden');
          bgBlur.classList.remove('flex');
        });
      });
    });

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

    document.addEventListener('DOMContentLoaded', function() {
            // Get all elements with the class subtotal-amount
        const subtotalElements = document.querySelectorAll('.subtotal-amount');

        // Calculate the total sum of subtotal values
        const totalSum = Array.from(subtotalElements).reduce((acc, subtotalElement) => {
            // Extract the numeric value from the inner text and add it to the accumulator
            const subtotalValue = parseFloat(subtotalElement.innerText.replace(/[^\d,]/g, '').replace(',', '.'));
            return acc + subtotalValue;
        }, 0);

        // Display the total sum in the totalAmount element
        const totalAmountElement = document.getElementById('totalAmount');
        totalAmountElement.innerText = 'IDR' + totalSum.toLocaleString('id-ID', {minimumFractionDigits: 2});

        // Set the value of the hidden input
        const quantityInputElement = document.getElementById('quantityInput');
        quantityInputElement.value = totalSum;
    });

    document.addEventListener('DOMContentLoaded', function() {
      if ({{ session('success') ? 'true' : 'false' }}) {
        const successModal = document.getElementById('successModal');
        successModal.classList.remove('hidden');
        successModal.classList.add('flex');

        setTimeout(function() {
          window.location.href = '/payment';
        }, 3000);

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
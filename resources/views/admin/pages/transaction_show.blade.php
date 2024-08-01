@php
  function formatRupiah($number) {
    return 'Rp' . number_format($number, 2, ',', '.');
  }
@endphp

@extends('admin.partials.master')
@section('content')
  
@include('admin.partials.sidebar')

<div class="text-black ml-[250px] w-[calc(100%-250px)] py-4 pr-4 flex justify-center items-center relative">
  <div class="bg-white rounded-2xl h-[calc(100vh-40px)] w-full p-10">
    <div class="border border-gray-200 rounded-xl px-5 py-2 flex flex-col">
      <div class="flex justify-between items-center pb-2">
        <h2 class="text-[35px] font-[500]">Data Detail Transaksi</h2>
        <button onclick="location.href='/admin/transactions'" class="border border-gray-200 rounded-lg px-2 py-1 flex items-center gap-x-1 font-[500] hover:bg-gray-100 transition duration-300">
          <p class="py-1 px-2">Kembali</p>
        </button>
      </div>
    </div>

    <div class="w-full flex justify-center items-center gap-x-5 h-[40px]">
      @if (session()->has('storeSuccess'))
        <div class="bg-green-500 text-white py-2 px-4 rounded-md text-sm h-full w-[400px] text-center flex justify-center items-center mt-10">
          {{ session('storeSuccess') }}
        </div>
      @endif
      @if (session()->has('updateSuccess'))
        <div class="bg-green-500 text-white py-2 px-4 rounded-md text-sm h-full w-[400px] text-center flex justify-center items-center mt-10">
          {{ session('updateSuccess') }}
        </div>
      @endif
      @if (session()->has('deleteSuccess'))
        <div class="bg-green-500 text-white py-2 px-4 rounded-md text-sm h-full w-[400px] text-center flex justify-center items-center mt-10">
          {{ session('deleteSuccess') }}
        </div>
      @endif
      @error('username')
        <div class="bg-red-500 text-white py-2 px-4 rounded-md text-sm h-full w-[400px] text-center flex justify-center items-center mt-10">
            {{ $message }}
        </div>
      @enderror
      @error('nama_lengkap')
        <div class="bg-red-500 text-white py-2 px-4 rounded-md text-sm h-full w-[400px] text-center flex justify-center items-center mt-10">
            {{ $message }}
        </div>
      @enderror
      @error('password')
        <div class="bg-red-500 text-white py-2 px-4 rounded-md text-sm h-full w-[400px] text-center flex justify-center items-center mt-10">
            {{ $message }}
        </div>
      @enderror
    </div>

    <div class="border border-gray-200 rounded-xl flex flex-col mt-10">
      <table>
        <tr class="text-[14px]">
          <th class="text-start pr-4 px-4 py-2">No</th>
          <th class="text-start w-4/12">Merk</th>
          <th class="text-start w-2/12">Jumlah</th>
          <th class="text-start w-2/12">Harga</th>
          <th class="text-start w-2/12">Subtotal</th>
        </tr>
        @if ($detailTransactions->count() > 0)
          @foreach($allItems as $item)
            <tr class="border-t">
              <td class="px-4 py-3">{{ ++$i }}</td>
              <td>{{ $item['merk'] }}</td>
              <td class="text-gray-400">{{ $item['jumlah'] }}</td>
              <td class="text-gray-400">{{ formatRupiah($item['harga']) }}</td>
              <td class="text-gray-400">{{ formatRupiah($item['subtotal']) }}</td>
            </tr>
          @endforeach
        @else
          <tr class="border-t">
            <td></td>
            <td></td>
            <td class="px-4 py-3 text-center">Tidak ada data.</td>
            <td></td>
            <td></td>
          </tr>
        @endif
      </table>
    </div>

    <div class="border border-gray-200 rounded-xl px-5 py-2 flex flex-col mt-10">
      <div class="flex justify-between items-center">
        <h2 class="text-lg">Total</h2>
        <p>{{ formatRupiah($transaction->total) }}</p>
      </div>
    </div>

    {{-- <div class="text-gray-600 dark:text-gray-400 bg-secondary-50 dark:bg-secondary-900">
			{{ $detailTransactions->appends(['search' => $search])->links() }}
		</div> --}}
  </div>
  
</div>

@endsection

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const button = document.getElementById('addDialogButton');
    const closeButton = document.getElementById('closeAddDialogButton');
    const boxOpen = document.getElementById('add-box-open');
    const bgBlur = document.getElementById('bg-blur');

    button.addEventListener('click', function () {
      const expanded = button.getAttribute('aria-expanded') === 'true' || false;
      
      if (expanded) {
        boxOpen.classList.add('hidden');
        button.setAttribute('aria-expanded', 'false');
        bgBlur.classList.add('hidden');
      } else {
        boxOpen.classList.remove('hidden');
        button.setAttribute('aria-expanded', 'true');
        bgBlur.classList.remove('hidden');
      }
    });

    closeButton.addEventListener('click', function () {
        boxOpen.classList.add('hidden');
        button.setAttribute('aria-expanded', 'false');
        bgBlur.classList.add('hidden');
    });

    document.addEventListener('click', function (event) {
      if (!button.contains(event.target) && !boxOpen.contains(event.target)) {
        boxOpen.classList.add('hidden');
        button.setAttribute('aria-expanded', 'false');
        bgBlur.classList.add('hidden');
      }
    });
  });

  document.addEventListener('DOMContentLoaded', function () {
    const buttons = document.querySelectorAll('.editDialogButton');
    const boxOpen = document.querySelector('.edit-box-open');
    const closeButton = document.querySelector('.closeEditDialogButton');
    const bgBlur = document.querySelector('.bg-editBlur');

    buttons.forEach(button => {
      button.addEventListener('click', function () {
        const expanded = button.getAttribute('aria-expanded') === 'true' || false;

        if (expanded) {
          boxOpen.classList.add('hidden');
          button.setAttribute('aria-expanded', 'false');
          bgBlur.classList.add('hidden');
        } else {
          const userId = button.getAttribute('data-id');
          const email = button.getAttribute('data-email');
          const namaLengkap = button.getAttribute('data-nama-lengkap');

          // Set values in the dialog box
          document.getElementById('edit-email').value = email;
          document.getElementById('edit-nama_lengkap').value = namaLengkap;

          document.getElementById('editForm').action = '/admin/admins/' + userId;

          boxOpen.classList.remove('hidden');
          button.setAttribute('aria-expanded', 'true');
          bgBlur.classList.remove('hidden');
          bgBlur.classList.add('flex');
        }
      });
    });

    closeButton.addEventListener('click', function () {
      boxOpen.classList.add('hidden');
      buttons.forEach(button => {
        button.setAttribute('aria-expanded', 'false');
      });
      bgBlur.classList.add('hidden');
    });

    document.addEventListener('click', function (event) {
      if (!Array.from(buttons).some(button => button.contains(event.target)) &&
        !boxOpen.contains(event.target)) {
        boxOpen.classList.add('hidden');
        buttons.forEach(button => {
          button.setAttribute('aria-expanded', 'false');
        });
        bgBlur.classList.add('hidden');
      }
    });
  });

  document.addEventListener('DOMContentLoaded', function () {
    const buttons = document.querySelectorAll('.deleteDialogButton');
    const boxOpen = document.querySelector('.delete-box-open');
    const closeButton = document.querySelector('.closeDeleteDialogButton');
    const bgBlur = document.querySelector('.bg-deleteBlur');

    buttons.forEach(button => {
      button.addEventListener('click', function () {
        const expanded = button.getAttribute('aria-expanded') === 'true' || false;

        if (expanded) {
          boxOpen.classList.add('hidden');
          button.setAttribute('aria-expanded', 'false');
          bgBlur.classList.add('hidden');
        } else {
          const userId = button.getAttribute('data-id');

          document.getElementById('deleteForm').action = '/admin/admins/' + userId;

          boxOpen.classList.remove('hidden');
          button.setAttribute('aria-expanded', 'true');
          bgBlur.classList.remove('hidden');
          bgBlur.classList.add('flex');
        }
      });
    });

    closeButton.addEventListener('click', function () {
      boxOpen.classList.add('hidden');
      buttons.forEach(button => {
        button.setAttribute('aria-expanded', 'false');
      });
      bgBlur.classList.add('hidden');
    });

    document.addEventListener('click', function (event) {
      if (!Array.from(buttons).some(button => button.contains(event.target)) &&
        !boxOpen.contains(event.target)) {
        boxOpen.classList.add('hidden');
        buttons.forEach(button => {
          button.setAttribute('aria-expanded', 'false');
        });
        bgBlur.classList.add('hidden');
      }
    });
  });
  
</script>
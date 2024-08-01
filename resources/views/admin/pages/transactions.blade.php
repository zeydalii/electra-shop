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
        <h2 class="text-[35px] font-[500]">Data Transaksi</h2>
      </div>
      <div class="flex justify-end border-t border-gray-200 pt-3 pb-1">
        <form action="/admin/transactions" method="GET" class="flex items-center mb-[1px]">
          <input type="text" name="search" autocomplete="off" placeholder="Search" class="focus:outline-none p-2 border border-gray-200 rounded-l-lg" value="{{ request('search') }}">
          <button type="submit" class="px-2 py-3 rounded-r-lg border border-l-0 border-gray-200 hover:bg-gray-100 transition duration-300"><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>
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
          <th class="text-start w-4/12">Email</th>
          <th class="text-start w-4/12">Total</th>
          <th class="text-start w-2/12">Tanggal Ditambahkan</th>
          <th class="w-2/12">Aksi</th>
        </tr>
        @if ($transactions->count() > 0)
          @foreach($transactions as $transaction)
            <tr class="border-t">
              <td class="px-4 py-3">{{ ++$i }}</td>
              <td>{{ $transaction->email }}</td>
              <td class="text-gray-400">{{ formatRupiah($transaction->total) }}</td>
              <td class="text-gray-400">{{ \Carbon\Carbon::parse($transaction->created_at)->locale('id')->isoFormat('MMMM D, YYYY') }}</td>
              <td class="text-center">
                <button onclick="location.href='/admin/transactions/{{ $transaction->id }}'" class="editDialogButton mr-2 hover:text-blue-400 transition duration-300"
                ><i class="fa-solid fa-eye"></i></button>
                <button class="deleteDialogButton ml-2 hover:text-red-400 transition duration-300" 
                  data-id="{{ $transaction->id }}"
                ><i class="fa-solid fa-trash-can"></i></button>
              </td>
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

    <div class="text-gray-600 dark:text-gray-400 bg-secondary-50 dark:bg-secondary-900">
			{{ $transactions->appends(['search' => $search])->links() }}
		</div>
  </div>

  <div class="bg-deleteBlur absolute hidden z-10 bg-black/45 top-4 right-4 left-0 bottom-4 rounded-2xl justify-center items-center">
    <div class="delete-box-open absolute hidden z-20 w-[500px] h-[210px] bg-white rounded-xl px-7 py-5 border-2 shadow-md">
      <h2 class="text-[25px] font-[500] border-b pb-3">Hapus admin</h2>
      <form id="deleteForm" method="POST" class="flex flex-col gap-y-5 mt-5">
        @method('DELETE')
        @csrf
        <p>Apakah kamu yakin ingin menghapus item ini?</p>
        <div class="flex justify-end gap-x-3">
          <button type="button" class="closeDeleteDialogButton hover:bg-red-400 transition duration-300 px-5 py-2 border rounded-lg font-[500]">Batal</button>
          <button type="submit" class="hover:bg-green-400 transition duration-300 px-5 py-2 border rounded-lg font-[500]">Iya</button>
        </div>
      </form>
    </div>
  </div>
  
</div>

@endsection

<script>

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

          document.getElementById('deleteForm').action = '/admin/transactions/' + userId;

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
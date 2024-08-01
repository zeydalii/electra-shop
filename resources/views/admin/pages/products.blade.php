@extends('admin.partials.master')
@section('content')
@php
  function formatRupiah($number) {
    return 'Rp' . number_format($number, 2, ',', '.');
  }
@endphp
@include('admin.partials.sidebar')

<div class="text-black ml-[250px] w-[calc(100%-250px)] py-4 pr-4 flex justify-center items-center relative">
  <div class="bg-white rounded-2xl h-[calc(100vh-40px)] w-full p-10">
    <div class="border border-gray-200 rounded-xl px-5 py-2 flex flex-col">
      <div class="flex justify-between items-center pb-2">
        <h2 class="text-[35px] font-[500]">Data produk</h2>
        <button id="addDialogButton" class="border border-gray-200 rounded-lg px-2 py-1 flex items-center gap-x-1 font-[500] hover:bg-gray-100 transition duration-300">
          <p class="">Tambah baru</p>
          <p class="text-2xl">+</p>
        </button>
      </div>
      <div class="flex justify-end border-t border-gray-200 pt-3 pb-1">
        <form action="/admin/products" method="GET" class="flex items-center mb-[1px]">
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

    <div class="border border-gray-200 rounded-xl flex flex-col mt-10 p-2 h-[50vh] overflow-y-auto">
      <div class="grid md:grid-cols-2 gap-8 lg:grid-cols-3">
        @if ($products->count() > 0)
          @foreach($products as $product)
            <div class="flex flex-col justify-between items-center p-2 border border-gray-200 rounded-xl">
              <div class="w-[200px]">
                <img class="" src="{{ Storage::url($product->image) }}" alt="">
              </div>
              <div class="flex w-full justify-between">
                <div>
                  <h2>{{ $product->merk }} ({{ $product->stock }})</h2>
                  <h2>{{ formatRupiah($product->harga) }}</h2>
                </div>
                <div class="h-full flex flex-col justify-center">
                  <div>
                    <button class="editDialogButton mr-2 hover:text-blue-400 transition duration-300"
                        data-id="{{ $product->id }}"
                        data-merk="{{ $product->merk }}"
                        data-harga="{{ $product->harga }}"
                        data-stock="{{ $product->stock }}"
                        data-active="{{ $product->active }}"
                      ><i class="fa-solid fa-pen"></i></button>
                    <button class="deleteDialogButton ml-2 hover:text-red-400 transition duration-300"
                      data-id="{{ $product->id }}"
                    ><i class="fa-solid fa-trash-can"></i></button>
                  </div>
                  @if ($product->active)
                    <div class="w-full flex gap-x-2 text-green-400"><svg class="w-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="#63E6BE" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512z"/></svg>Aktif</div>
                  @else
                    <div class="w-full flex gap-x-2 text-red-400"><svg class="w-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="#f70202" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512z"/></svg>Nonaktif</div>
                  @endif
                </div>
              </div>
            </div>
          @endforeach
        @else
          <div class="px-4 py-3 w-full text-center">Tidak ada data.</div>
        @endif
      </div>
    </div>

    <div class="text-gray-600 dark:text-gray-400 bg-secondary-50 dark:bg-secondary-900">
			{{ $products->appends(['search' => $search])->links() }}
		</div>
  </div>

  <div id="bg-blur" class="absolute hidden z-10 bg-black/45 top-4 right-4 left-0 bottom-4 rounded-2xl"></div>

  <div id="add-box-open" class="absolute hidden z-20 w-[500px] h-[550px] bg-white rounded-xl px-7 py-5 border-2 shadow-md">
    <h2 class="text-[25px] font-[500] border-b pb-3">Tambah produk</h2>
    <form action="/admin/products" method="POST" class="flex flex-col gap-y-5 mt-5" enctype="multipart/form-data">
      @csrf
      <div>   
        <label class="block mb-2 text-gray-900 dark:text-white" for="image">Upload Gambar <span class="text-red-500">*</span></label>
        <input class="block w-full text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="image" type="file" name="image">
      </div>
      <div class="flex flex-col gap-y-2">
        <label for="merk">Merk <span class="text-red-500">*</span></label>
        <input type="text" name="merk" id="merk" autocomplete="off" placeholder="Masukkan Merk" class="focus:outline-none p-2 border border-gray-200 rounded-lg w-[300px]" required>
      </div>
      <div class="flex flex-col gap-y-2">
        <label for="harga">Harga <span class="text-red-500">*</span></label>
        <input type="number" name="harga" id="harga" autocomplete="off" placeholder="Masukkan Nominal Harga" class="focus:outline-none p-2 border border-gray-200 rounded-lg w-[300px]" required>
      </div>
      <div class="flex justify-start items-end gap-10">
        <div class="flex flex-col gap-y-2">
          <label for="stock">Stock <span class="text-red-500">*</span></label>
          <input type="number" name="stock" id="stock" autocomplete="off" placeholder="" class="focus:outline-none p-2 border border-gray-200 rounded-lg w-[60px]" required>
        </div>
        <div class="flex items-center mb-2">
          <input type="hidden" name="active" value="0">
          <input id="active" type="checkbox" value="1" name="active" class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
          <label for="active" class="ms-2 text-gray-900 dark:text-gray-300">Tampilkan dalam Homepage</label>
        </div>
      </div>
      <div class="flex justify-end gap-x-3">
        <button id="closeAddDialogButton" type="button" class="hover:bg-red-400 hover:text-white transition duration-300 px-5 py-2 border rounded-lg font-[500]">Batal</button>
        <button type="submit" class="hover:bg-green-400 hover:text-white transition duration-300 px-5 py-2 border rounded-lg font-[500]">Simpan</button>
      </div>
    </form>
  </div>

  <div class="bg-editBlur absolute hidden z-10 bg-black/45 top-4 right-4 left-0 bottom-4 rounded-2xl justify-center items-center">
    <div class="edit-box-open absolute hidden z-20 w-[500px] h-[550px] bg-white rounded-xl px-7 py-5 border-2 shadow-md">
      <h2 class="text-[25px] font-[500] border-b pb-3">Edit produk</h2>
      <form id="editForm" method="POST" class="flex flex-col gap-y-5 mt-5" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div>   
          <label class="block mb-2 text-gray-900 dark:text-white" for="image">Upload Gambar <span class="text-red-500">*</span></label>
          <input class="block w-full text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="image" type="file" name="image">
        </div>
        <div class="flex flex-col gap-y-2">
          <label for="merk">Merk <span class="text-red-500">*</span></label>
          <input type="text" name="merk" id="edit-merk" autocomplete="off" placeholder="Masukkan merk" class="focus:outline-none p-2 border border-gray-200 rounded-lg w-[300px]" required>
        </div>
        <div class="flex flex-col gap-y-2">
          <label for="harga">Harga <span class="text-red-500">*</span></label>
          <input type="number" name="harga" id="edit-harga" autocomplete="off" placeholder="Masukkan nominal harga" class="focus:outline-none p-2 border border-gray-200 rounded-lg w-[300px]" required>
        </div>
        <div class="flex justify-start items-end gap-10">
          <div class="flex flex-col gap-y-2">
            <label for="stock">Stock <span class="text-red-500">*</span></label>
            <input type="number" name="stock" id="edit-stock" autocomplete="off" placeholder="" class="focus:outline-none p-2 border border-gray-200 rounded-lg w-[60px]" required>
          </div>
          <div class="flex items-center mb-2">
            <input type="hidden" name="active" value="0">
            <input id="edit-active" type="checkbox" value="1" name="active" class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
            <label for="active" class="ms-2 text-gray-900 dark:text-gray-300">Tampilkan dalam Homepage</label>
          </div>
        </div>
        <div class="flex justify-end gap-x-3">
          <button type="button" class="closeEditDialogButton hover:bg-red-400 hover:text-white transition duration-300 px-5 py-2 border rounded-lg font-[500]">Batal</button>
          <button type="submit" class="hover:bg-green-400 hover:text-white transition duration-300 px-5 py-2 border rounded-lg font-[500]">Simpan</button>
        </div>
      </form>
    </div>  
  </div>

  <div class="bg-deleteBlur absolute hidden z-10 bg-black/45 top-4 right-4 left-0 bottom-4 rounded-2xl justify-center items-center">
    <div class="delete-box-open absolute hidden z-20 w-[500px] h-[210px] bg-white rounded-xl px-7 py-5 border-2 shadow-md">
      <h2 class="text-[25px] font-[500] border-b pb-3">Hapus produk</h2>
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
          const productId = button.getAttribute('data-id');
          console.log(productId);
          const merk = button.getAttribute('data-merk');
          const harga = button.getAttribute('data-harga');
          const stock = button.getAttribute('data-stock');
          const active = button.getAttribute('data-active');

          // Set values in the dialog box
          document.getElementById('edit-merk').value = merk;
          document.getElementById('edit-harga').value = harga;
          document.getElementById('edit-stock').value = stock;
          const editActiveCheckbox = document.getElementById('edit-active');
          editActiveCheckbox.checked = active === '1';

          document.getElementById('editForm').action = '/admin/products/' + productId;

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
          const productId = button.getAttribute('data-id');

          document.getElementById('deleteForm').action = '/admin/products/' + productId;

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
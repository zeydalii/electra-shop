@extends('admin.partials.master')
@section('content')
  
@include('admin.partials.sidebar')

<div class="text-black ml-[250px] w-[calc(100%-250px)] py-4 pr-4 flex justify-center items-center">
  <div class="bg-white rounded-2xl h-[calc(100vh-40px)] w-full p-10">
    <div class="">
      <p class="text-gray-400">Hi, <span class="font-bold text-black">{{ auth()->user()->nama_lengkap }}</span>! Welcome to <span class="font-bold">Electra</span>'s Dashboard!</p>
      <h2 class="mt-10 text-[35px] font-[500]">Overviews</h2>
    </div>

    <div class="mt-10 flex gap-x-7">
      <div class="w-[230px] flex flex-col rounded-lg border">
        <div class="flex gap-x-4 p-4">
          <div class="bg-adminMain h-16 w-16 flex justify-center items-center rounded-full">
            <i class="fa-regular fa-user text-green-600" style="font-size: 20px;"></i>
          </div>
          <div class="flex flex-col items-start justify-center">
            <h2 class="text-2xl font-[500]">{{ $usersData }}</h2>
            <p class="text-base text-gray-400">Data Admin</p>
          </div>
        </div>
        <a href="/admin/admins" class="w-full bg-adminMain text-gray-300 rounded-b-lg py-2 px-3 text-sm flex justify-between items-center hover:text-white transition duration-300"><span>Lihat selengkapnya</span> <i class="fa-solid fa-arrow-right-long"></i></a>
      </div>

      <div class="w-[230px] flex flex-col rounded-lg border">
        <div class="flex gap-x-4 p-4">
          <div class="bg-adminMain h-16 w-16 flex justify-center items-center rounded-full">
            <i class="fa-regular fa-file-lines text-green-600" style="font-size: 20px;"></i>
          </div>
          <div class="flex flex-col items-start justify-center">
            <h2 class="text-2xl font-[500]">{{ $productsData }}</h2>
            <p class="text-base text-gray-400">Data Produk</p>
          </div>
        </div>
        <a href="/admin/products" class="w-full bg-adminMain text-gray-300 rounded-b-lg py-2 px-3 text-sm flex justify-between items-center hover:text-white transition duration-300"><span>Lihat selengkapnya</span> <i class="fa-solid fa-arrow-right-long"></i></a>
      </div>

      <div class="w-[230px] flex flex-col rounded-lg border">
        <div class="flex gap-x-4 p-4">
          <div class="bg-adminMain h-16 w-16 flex justify-center items-center rounded-full">
            <i class="fa-regular fa-file-lines text-green-600" style="font-size: 20px;"></i>
          </div>
          <div class="flex flex-col items-start justify-center">
            <h2 class="text-2xl font-[500]">{{ $transactionsData }}</h2>
            <p class="text-base text-gray-400">Data Transaksi</p>
          </div>
        </div>
        <a href="/admin/transactions" class="w-full bg-adminMain text-gray-300 rounded-b-lg py-2 px-3 text-sm flex justify-between items-center hover:text-white transition duration-300"><span>Lihat selengkapnya</span> <i class="fa-solid fa-arrow-right-long"></i></a>
      </div>
    </div>
  </div>
</div>

@endsection
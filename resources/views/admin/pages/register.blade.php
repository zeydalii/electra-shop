@extends('admin.partials.master')
@section('content')

<div class="w-full h-screen flex justify-center items-center">
  <div class="bg-white py-20 px-28 flex flex-col gap-y-3 justify-center items-center">
    <div class="flex flex-col justify-center items-center mb-5">
      <p class="font-[500] text-2xl">Daftar Akun</p>
      <p class="text-[12px]">Masukkan identitas dirimu</p>
    </div>
    @if (session()->has('registerSuccess'))
      <div class="bg-green-500 text-white py-2 px-4 rounded-md text-sm w-[250px] text-center">
        {{ session('registerSuccess') }}
      </div>
    @endif
    @error('email')
      <div class="bg-red-500 text-white py-2 px-4 rounded-md text-sm w-[250px] text-center">
          {{ $message }}
      </div>
    @enderror
    @error('nama_lengkap')
      <div class="bg-red-500 text-white py-2 px-4 rounded-md text-sm w-[250px] text-center">
        {{ $message }}
      </div>
    @enderror
    @error('password')
      <div class="bg-red-500 text-white py-2 px-4 rounded-md text-sm w-[250px] text-center">
        {{ $message }}
      </div>
    @enderror
    <div class="">
      <form action="/admin/register" method="POST" class="flex flex-col">
        @csrf
        <div class="text-sm">
          <input type="text" name="email" id="email" placeholder="Masukkan email" autocomplete="off" class="focus:outline-none border border-b-0 rounded-b-none px-4 py-2 w-[250px] rounded-md" required>
        </div>
        <div class="text-sm">
          <input type="text" name="nama_lengkap" id="nama_lengkap" placeholder="Masukkan nama lengkap" autocomplete="off" class="focus:outline-none border px-4 py-2 w-[250px]" required>
        </div>
        <div class="text-sm">
          <input type="password" name="password" id="password" placeholder="Masukkan password" autocomplete="off" class="focus:outline-none border border-t-0 rounded-t-none px-4 py-2 w-[250px] rounded-md" required>
        </div>
        <button type="submit" class="bg-adminMain text-white py-2 rounded-md text-sm mt-5">Register</button>
      </form>
    </div>
    <p class="text-sm mt-5">Sudah punya akun? <button class="underline font-bold" onclick="location.href='/admin/login'">Login disini!</button></p>
  </div>
</div>

@endsection
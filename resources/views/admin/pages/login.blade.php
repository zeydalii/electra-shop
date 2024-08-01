@extends('admin.partials.master')
@section('content')

<div class="w-full h-screen flex justify-center items-center">
  <div class="bg-white py-20 px-28 flex flex-col gap-y-3 justify-center items-center">
    <div class="flex flex-col justify-center items-center mb-5">
      <p class="font-[500] text-2xl">Selamat datang</p>
      <p class="text-[12px]">Masukkan identitas dirimu</p>
    </div>
    @if (session()->has('loginError'))
        <div class="bg-red-500 text-white py-2 px-4 rounded-md text-sm w-[250px] text-center">
            {{ session('loginError') }}
        </div>
    @endif
    <div class="">
      <form action="/admin/login" method="POST" class="flex flex-col gap-y-4">
        @csrf
        <div class="flex flex-col text-sm gap-y-2">
          <label for="email" class="">Email</label>
          <input type="email" name="email" id="email" placeholder="Masukkan email" autocomplete="off" class="focus:outline-none border px-4 py-2 w-[250px] rounded-md" required>
        </div>
        <div class="flex flex-col text-sm gap-y-2">
          <label for="password" class="">Password</label>
          <input type="password" name="password" id="password" placeholder="Masukkan password" autocomplete="off" class="focus:outline-none border px-4 py-2 w-[250px] rounded-md" required>
        </div>
        <button type="submit" class="bg-adminMain text-white py-2 rounded-md text-sm">Sign In</button>
      </form>
    </div>
    <p class="text-sm mt-5">Belum punya akun? <button class="underline font-bold" onclick="location.href='/admin/register'">Daftar disini!</button></p>
  </div>
</div>

@endsection
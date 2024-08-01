<x-layout>
  <x-slot:title>{{ $title }}</x-slot:title>
  <div class="flex flex-col gap-5 justify-center items-center">
    <h2 class="text-xl uppercase font-bold">Get In Touch</h2>
    <form class="" action="/posts" method="GET">
      <div class="flex flex-col gap-5 items-center w-full sm:flex sm:space-y-0">
        <div class="w-full">
          <input class="block p-3 pl-5 w-[350px] text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 sm:rounded-none focus:ring-black/20 focus:border-black/20 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-black/20 dark:focus:border-black/20" placeholder="Name" type="search" id="search" name="search" autocomplete="off">
        </div>
        <div class="w-full">
          <input class="block p-3 pl-5 w-[350px] text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 sm:rounded-none focus:ring-black/20 focus:border-black/20 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-black/20 dark:focus:border-black/20" placeholder="Email" type="search" id="search" name="search" autocomplete="off">
        </div>
        <div class="w-full">
          <textarea class="block p-3 pl-5 w-[350px] h-[200px] text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 sm:rounded-none focus:ring-black/20 focus:border-black/20 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-black/20 dark:focus:border-black/20" placeholder="Message" type="text" id="text" name="text" autocomplete="off"></textarea>
        </div>
        <button class="border border-black/25 py-1 px-3 mt-10">Send</button>
      </div>
    </form>
  </div>
</x-layout>
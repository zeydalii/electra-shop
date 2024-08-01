{{-- @dd($allItems) --}}
<x-layout>
  <x-slot:title>{{ $title }}</x-slot:title>
  
  <div class="flex flex-col gap-10 items-center justify-center">
    <h2 class="text-lg font-semibold">Payment</h2>

    <div class="p-2 border border-black w-full flex justify-between">
      <p>Kode pembayaran: 123456789</p>
      <p>Kode berlaku sampai dengan: <span class="text-red-500" id="timer">09:59</span></p>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Set the initial timer value
      let minutes = 09;
      let seconds = 59;

      // Get the timer element
      const timerElement = document.getElementById('timer');

      // Function to update the timer
      function updateTimer() {
        // Decrease the seconds
        seconds--;

        // If seconds are less than 0, decrease the minutes and reset seconds to 59
        if (seconds < 0) {
          minutes--;
          seconds = 59;
        }

        // If minutes are less than 0, stop the timer
        if (minutes < 0) {
          clearInterval(timerInterval);
          minutes = 0;
          seconds = 0;
        }

        // Update the timer element text
        timerElement.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
      }

      // Call the updateTimer function every second
      const timerInterval = setInterval(updateTimer, 1000);

      // Initial call to display the starting value
      updateTimer();
    });
  </script>
</x-layout>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Payment Successful</title>
  <link href="/css/app.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-indigo-50 to-purple-100 min-h-screen flex items-center justify-center">
  <main class="flex-1 p-6 md:p-10 overflow-auto flex items-center justify-center">
    <div class="relative z-10 bg-white/90 backdrop-blur-md p-6 md:p-10 rounded-3xl shadow-2xl text-center max-w-md w-full border border-indigo-100">
      <div class="flex justify-center mb-4">
        <div class="bg-gradient-to-br from-green-400 to-green-600 rounded-full p-3 shadow-lg animate-pulse">
          <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" fill="none"/>
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2l4 -4" />
          </svg>
        </div>
      </div>
      <h1 class="text-2xl md:text-3xl font-extrabold mb-2 text-green-700 drop-shadow">Payment Successful!</h1>
      @if (session('payment_reference'))
        <p class="mb-4 text-gray-600 text-sm md:text-base">Your payment reference is: <br> <strong class="font-mono text-base md:text-lg">{{ session('payment_reference') }}</strong></p>
      @endif
      <p class="mb-4 text-gray-700 text-base md:text-lg">Thank you for your payment.<br>
        You will be redirected to your payment history in
        <span id="countdown" class="font-bold text-indigo-600 text-lg md:text-xl">8</span> seconds.
      </p>
      <a href="{{ route('user.paymentHistory') }}"
         class="inline-block mt-4 px-6 md:px-8 py-3 bg-gradient-to-r from-indigo-500 to-purple-500 text-white rounded-full font-semibold shadow-lg hover:scale-105 transition text-sm md:text-base">
        Go to Payment History Now
      </a>
    </div>
  </main>

  <script>
    let seconds = 8;
    function updateCountdown() {
      document.getElementById('countdown').textContent = seconds;
      if (seconds > 0) {
        seconds--;
        setTimeout(updateCountdown, 1000);
      } else {
        window.location.href = "{{ route('user.paymentHistory') }}";
      }
    }
    window.onload = updateCountdown;
  </script>
</body>
</html>
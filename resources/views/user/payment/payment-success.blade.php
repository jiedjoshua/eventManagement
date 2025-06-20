<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Successful</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <script src="https://cdn.tailwindcss.com"></script>
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
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-100 via-purple-100 to-pink-100">

    <!-- Confetti SVG (decorative) -->
    <svg class="absolute top-0 left-0 w-full h-40 pointer-events-none" viewBox="0 0 1440 320" fill="none">
        <circle cx="100" cy="60" r="8" fill="#a5b4fc" opacity="0.7"/>
        <circle cx="400" cy="30" r="6" fill="#f472b6" opacity="0.6"/>
        <circle cx="800" cy="80" r="10" fill="#fbbf24" opacity="0.5"/>
        <circle cx="1200" cy="50" r="7" fill="#34d399" opacity="0.7"/>
        <circle cx="600" cy="20" r="5" fill="#818cf8" opacity="0.5"/>
        <circle cx="300" cy="100" r="7" fill="#f472b6" opacity="0.6"/>
        <circle cx="1000" cy="60" r="8" fill="#a5b4fc" opacity="0.7"/>
        <circle cx="1300" cy="90" r="6" fill="#fbbf24" opacity="0.5"/>
    </svg>

    <div class="relative z-10 bg-white/90 backdrop-blur-md p-10 rounded-3xl shadow-2xl text-center max-w-md w-full border border-indigo-100">
        <div class="flex justify-center mb-4">
            <div class="bg-gradient-to-br from-green-400 to-green-600 rounded-full p-3 shadow-lg animate-pulse">
                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" fill="none"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2l4 -4" />
                </svg>
            </div>
        </div>
        <h1 class="text-3xl font-extrabold mb-2 text-green-700 drop-shadow">Payment Successful!</h1>
        @if (session('payment_reference'))
    <p class="mb-4 text-gray-600">Your payment reference is: <br> <strong class="font-mono text-lg">{{ session('payment_reference') }}</strong></p>
@endif
        <p class="mb-4 text-gray-700 text-lg">Thank you for your payment.<br>
            You will be redirected to your payment history in
            <span id="countdown" class="font-bold text-indigo-600 text-xl">8</span> seconds.
        </p>
        <a href="{{ route('user.paymentHistory') }}"
           class="inline-block mt-4 px-8 py-3 bg-gradient-to-r from-indigo-500 to-purple-500 text-white rounded-full font-semibold shadow-lg hover:scale-105 transition">
            Go to Payment History Now
        </a>
    </div>
</body>
</html>
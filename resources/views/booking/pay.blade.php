<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Pay for Your Booking</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://js.stripe.com/v3/"></script>
</head>
<body class="flex h-screen bg-gray-100">
  <!-- Main Content -->
  <main class="flex-1 flex items-center justify-center p-6 md:p-10 overflow-auto">
    <div class="w-full max-w-lg bg-white rounded-xl shadow-lg p-8">
      <a href="{{ route('user.payments') }}" class="text-indigo-600 hover:underline text-sm mb-4 inline-block">&larr; Back to Payments</a>
      <h2 class="text-2xl font-bold mb-2 text-gray-800">Pay for Your Booking</h2>
      <p class="mb-1 text-gray-600">Total Due: <span class="font-semibold text-indigo-700">₱{{ number_format($booking->amount_due, 2) }}</span></p>
      <p class="mb-4 text-gray-600">Already Paid: <span class="font-semibold text-green-700">₱{{ number_format($booking->amount_paid, 2) }}</span></p>
      
      <form id="payment-form" method="POST" action="{{ route('booking.pay', $booking->id) }}">
        @csrf
        @if($booking->payment_status === 'pending')
            <div class="mb-4">
              <p class="block text-gray-700 mb-2 font-semibold">Choose payment option:</p>
              <label class="block p-3 border rounded-md mb-2 has-[:checked]:bg-indigo-50 has-[:checked]:border-indigo-400">
                <input type="radio" name="amount" value="{{ $booking->amount_due * 0.2 }}" checked class="form-radio text-indigo-600 sr-only">
                <span class="ml-2 font-medium">Pay 20% Downpayment</span>
                <span class="ml-2 text-gray-600">(₱{{ number_format($booking->amount_due * 0.2, 2) }})</span>
              </label>
              <label class="block p-3 border rounded-md has-[:checked]:bg-indigo-50 has-[:checked]:border-indigo-400">
                <input type="radio" name="amount" value="{{ $booking->amount_due }}" class="form-radio text-indigo-600 sr-only">
                <span class="ml-2 font-medium">Pay Full Amount</span>
                <span class="ml-2 text-gray-600">(₱{{ number_format($booking->amount_due, 2) }})</span>
              </label>
            </div>
        @elseif($booking->payment_status === 'partial')
            @php
                $remainingBalance = $booking->amount_due - $booking->amount_paid;
            @endphp
            <div class="mb-4 bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-md">
                <p class="font-semibold text-yellow-800">A downpayment has been made.</p>
                <p class="text-yellow-700">Please pay the remaining balance of <strong class="font-bold">₱{{ number_format($remainingBalance, 2) }}</strong>.</p>
                <input type="hidden" name="amount" value="{{ $remainingBalance }}">
            </div>
        @endif

        <div class="mb-4">
          <label for="card-holder-name" class="block text-gray-700 mb-1">Card Holder Name</label>
          <input id="card-holder-name" type="text" placeholder="Card holder name" required class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-400">
        </div>
        <div class="mb-4">
          <label class="block text-gray-700 mb-1">Card Details</label>
          <div id="card-element" class="p-3 border rounded bg-gray-50"></div>
        </div>
        <input type="hidden" name="paymentMethod" id="paymentMethod">

        {{-- Autofill and Pay button always shown --}}
        <div class="flex items-center justify-between mb-2">
            <button id="autofill-btn" type="button" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 transition font-semibold">
                Autofill Test Info
            </button>
            @php
                $buttonText = ($booking->payment_status === 'partial') ? 'Pay Remaining Balance' : 'Pay Now';
            @endphp
            <button id="card-button" type="button" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700 transition font-semibold shadow">
                {{ $buttonText }}
            </button>
        </div>
        <div id="test-card-info" class="hidden bg-indigo-50 border-l-4 border-indigo-400 p-4 mb-4 rounded-md">
          <p class="text-sm text-indigo-800 mb-2">Use these test details:</p>
          <div class="space-y-2">
            <div class="flex justify-between items-center">
              <span class="font-mono text-gray-700">4242 4242 4242 4242</span>
              <button type="button" onclick="copyToClipboard('4242424242424242')" class="text-xs bg-indigo-200 text-indigo-700 px-2 py-1 rounded hover:bg-indigo-300">Copy</button>
            </div>
            <div class="flex justify-between items-center">
              <span class="font-mono text-gray-700">Exp: 12/34, CVC: 123</span>
            </div>
          </div>
        </div>
      </form>
    </div>
  </main>

  <script>
    @if(config('services.stripe.key'))
        const stripe = Stripe('{{ config('services.stripe.key') }}');
        const elements = stripe.elements();
        const cardElement = elements.create('card');
        cardElement.mount('#card-element');

        const cardHolderName = document.getElementById('card-holder-name');
        const cardButton = document.getElementById('card-button');
        const paymentForm = document.getElementById('payment-form');
        const autofillBtn = document.getElementById('autofill-btn');
        const testCardInfo = document.getElementById('test-card-info');

        cardButton.addEventListener('click', async (e) => {
          cardButton.disabled = true;
          cardButton.textContent = 'Processing...';
          const { paymentMethod, error } = await stripe.createPaymentMethod(
            'card', cardElement, {
              billing_details: { name: cardHolderName.value }
            }
          );
          if (error) {
            alert(error.message);
            cardButton.disabled = false;
            cardButton.textContent = '{{ $buttonText }}';
          } else {
            document.getElementById('paymentMethod').value = paymentMethod.id;
            paymentForm.submit();
          }
        });

        autofillBtn.addEventListener('click', function() {
          testCardInfo.classList.remove('hidden');
          cardHolderName.value = "Test User";
        });
    @else
        // Stripe not configured - show error message
        document.addEventListener('DOMContentLoaded', function() {
            const cardElement = document.getElementById('card-element');
            const cardButton = document.getElementById('card-button');
            const autofillBtn = document.getElementById('autofill-btn');
            
            cardElement.innerHTML = '<div class="p-4 bg-red-50 border border-red-200 rounded-md"><p class="text-red-800 font-semibold">Payment System Not Configured</p><p class="text-red-600 text-sm mt-1">Stripe payment gateway is not configured. Please contact the administrator.</p></div>';
            cardButton.disabled = true;
            cardButton.textContent = 'Payment Unavailable';
            cardButton.classList.remove('bg-indigo-600', 'hover:bg-indigo-700');
            cardButton.classList.add('bg-gray-400', 'cursor-not-allowed');
            autofillBtn.style.display = 'none';
        });
    @endif

    function copyToClipboard(text) {
      navigator.clipboard.writeText(text).then(function() {
        alert('Card number copied to clipboard!');
      }, function(err) {
        alert('Could not copy text: ', err);
      });
    }
  </script>
</body>
</html>
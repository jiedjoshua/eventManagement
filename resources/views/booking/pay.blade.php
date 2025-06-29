<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Pay for Your Booking - CrwdCtrl</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://js.stripe.com/v3/"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
  <!-- Header -->
  <header class="bg-white/95 backdrop-blur-md shadow-lg py-4">
    <div class="container mx-auto px-6">
      <div class="flex items-center justify-between">
        <div class="flex items-center space-x-3">
          <div class="w-8 h-8 bg-gradient-to-r from-[#EF7C79] to-[#D76C69] rounded-lg flex items-center justify-center">
            <span class="text-white font-bold text-sm">C</span>
          </div>
          <span class="text-xl font-bold bg-gradient-to-r from-[#EF7C79] to-[#D76C69] bg-clip-text text-transparent">
            CrwdCtrl
          </span>
        </div>
        <a href="{{ route('user.payments') }}" class="inline-flex items-center text-[#EF7C79] hover:text-[#D76C69] font-medium transition-colors">
          <i class="fas fa-arrow-left mr-2"></i>Back to Payments
        </a>
      </div>
    </div>
  </header>

  <!-- Main Content -->
  <main class="flex items-center justify-center p-6 md:p-10 min-h-screen">
    <div class="w-full max-w-lg">
      <!-- Payment Card -->
      <div class="bg-white rounded-3xl shadow-2xl p-8 border border-gray-100">
        <!-- Header Section -->
        <div class="text-center mb-8">
          <div class="w-16 h-16 bg-gradient-to-br from-[#EF7C79] to-[#D76C69] rounded-2xl flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-credit-card text-white text-2xl"></i>
          </div>
          <h2 class="text-2xl font-bold text-gray-800 mb-2">Complete Your Payment</h2>
          <p class="text-gray-600">Secure payment powered by Stripe</p>
        </div>

        <!-- Payment Summary -->
        <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-2xl p-6 mb-6">
          <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
            <i class="fas fa-receipt mr-2 text-[#EF7C79]"></i>Payment Summary
          </h3>
          <div class="space-y-3">
            <div class="flex justify-between items-center">
              <span class="text-gray-600">Total Due:</span>
              <span class="font-bold text-lg text-[#EF7C79]">₱{{ number_format($booking->amount_due, 2) }}</span>
            </div>
            <div class="flex justify-between items-center">
              <span class="text-gray-600">Already Paid:</span>
              <span class="font-semibold text-green-600">₱{{ number_format($booking->amount_paid, 2) }}</span>
            </div>
            <div class="border-t border-gray-200 pt-3">
              <div class="flex justify-between items-center">
                <span class="font-semibold text-gray-800">Amount to Pay:</span>
                <span class="font-bold text-xl text-[#EF7C79]">
                  @if($booking->payment_status === 'partial')
                    ₱{{ number_format($booking->amount_due - $booking->amount_paid, 2) }}
                  @else
                    ₱{{ number_format($booking->amount_due * 0.2, 2) }}
                  @endif
                </span>
              </div>
            </div>
          </div>
        </div>
        
        <form id="payment-form" method="POST" action="{{ route('booking.pay', $booking->id) }}">
          @csrf
          
          <!-- Payment Options -->
          @if($booking->payment_status === 'pending')
            <div class="mb-6">
              <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-credit-card mr-2 text-[#EF7C79]"></i>Choose Payment Option
              </h3>
              <div class="space-y-3">
                <label class="block p-4 border-2 border-gray-200 rounded-xl cursor-pointer transition-all duration-200 hover:border-[#EF7C79] hover:bg-[#EF7C79]/5 has-[:checked]:border-[#EF7C79] has-[:checked]:bg-[#EF7C79]/10">
                  <input type="radio" name="amount" value="{{ $booking->amount_due * 0.2 }}" checked class="form-radio text-[#EF7C79] sr-only">
                  <div class="flex items-center justify-between">
                    <div>
                      <span class="font-semibold text-gray-800">Pay 20% Downpayment</span>
                      <p class="text-sm text-gray-600 mt-1">Secure your booking with a downpayment</p>
                    </div>
                    <span class="font-bold text-[#EF7C79]">₱{{ number_format($booking->amount_due * 0.2, 2) }}</span>
                  </div>
                </label>
                <label class="block p-4 border-2 border-gray-200 rounded-xl cursor-pointer transition-all duration-200 hover:border-[#EF7C79] hover:bg-[#EF7C79]/5 has-[:checked]:border-[#EF7C79] has-[:checked]:bg-[#EF7C79]/10">
                  <input type="radio" name="amount" value="{{ $booking->amount_due }}" class="form-radio text-[#EF7C79] sr-only">
                  <div class="flex items-center justify-between">
                    <div>
                      <span class="font-semibold text-gray-800">Pay Full Amount</span>
                      <p class="text-sm text-gray-600 mt-1">Complete payment in one transaction</p>
                    </div>
                    <span class="font-bold text-[#EF7C79]">₱{{ number_format($booking->amount_due, 2) }}</span>
                  </div>
                </label>
              </div>
            </div>
          @elseif($booking->payment_status === 'partial')
            @php
                $remainingBalance = $booking->amount_due - $booking->amount_paid;
            @endphp
            <div class="mb-6 bg-gradient-to-r from-yellow-50 to-orange-50 border border-yellow-200 rounded-2xl p-4">
              <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-yellow-100 rounded-xl flex items-center justify-center">
                  <i class="fas fa-info-circle text-yellow-600"></i>
                </div>
                <div>
                  <p class="font-semibold text-yellow-800">Downpayment Received</p>
                  <p class="text-yellow-700 text-sm">Please pay the remaining balance of <strong class="font-bold">₱{{ number_format($remainingBalance, 2) }}</strong></p>
                </div>
              </div>
              <input type="hidden" name="amount" value="{{ $remainingBalance }}">
            </div>
          @endif

          <!-- Card Details Form -->
          <div class="space-y-6">
            <!-- Card Holder Name -->
            <div>
              <label for="card-holder-name" class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="fas fa-user mr-2 text-[#EF7C79]"></i>Card Holder Name
              </label>
              <input id="card-holder-name" type="text" placeholder="Enter card holder name" required 
                class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-[#EF7C79] focus:border-[#EF7C79] text-base transition-all duration-200 bg-white">
            </div>
            
            <!-- Card Details -->
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="fas fa-credit-card mr-2 text-[#EF7C79]"></i>Card Details
              </label>
              <div id="card-element" class="p-4 border border-gray-300 rounded-xl bg-gray-50 focus-within:ring-2 focus-within:ring-[#EF7C79] focus-within:border-[#EF7C79] transition-all duration-200"></div>
            </div>
          </div>
          
          <input type="hidden" name="paymentMethod" id="paymentMethod">

          <!-- Action Buttons -->
          <div class="flex flex-col sm:flex-row gap-3 mt-8">
            <button id="autofill-btn" type="button" 
              class="flex-1 bg-gray-100 text-gray-700 px-6 py-3 rounded-xl hover:bg-gray-200 transition-all duration-200 font-semibold border border-gray-200">
              <i class="fas fa-magic mr-2"></i>Autofill Test Info
            </button>
            @php
                $buttonText = ($booking->payment_status === 'partial') ? 'Pay Remaining Balance' : 'Pay Now';
            @endphp
            <button id="card-button" type="button" 
              class="flex-1 bg-gradient-to-r from-[#EF7C79] to-[#D76C69] hover:from-[#D76C69] hover:to-[#C55A57] text-white px-6 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300">
              <i class="fas fa-lock mr-2"></i>{{ $buttonText }}
            </button>
          </div>
        </form>

        <!-- Test Card Info -->
        <div id="test-card-info" class="hidden bg-gradient-to-r from-[#EF7C79]/10 to-[#D76C69]/10 border border-[#EF7C79]/20 rounded-2xl p-4 mt-6">
          <div class="flex items-center space-x-3 mb-3">
            <i class="fas fa-info-circle text-[#EF7C79]"></i>
            <span class="font-semibold text-[#EF7C79]">Test Card Details</span>
          </div>
          <div class="space-y-3">
            <div class="flex justify-between items-center bg-white rounded-lg p-3">
              <span class="font-mono text-gray-700">4242 4242 4242 4242</span>
              <button type="button" onclick="copyToClipboard('4242424242424242')" 
                class="text-xs bg-[#EF7C79] text-white px-3 py-1 rounded-lg hover:bg-[#D76C69] transition-colors">
                <i class="fas fa-copy mr-1"></i>Copy
              </button>
            </div>
            <div class="bg-white rounded-lg p-3">
              <span class="font-mono text-gray-700">Exp: 12/34, CVC: 123</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <script>
    @if(config('services.stripe.key'))
        const stripe = Stripe('{{ config('services.stripe.key') }}');
        const elements = stripe.elements();
        const cardElement = elements.create('card', {
          style: {
            base: {
              fontSize: '16px',
              color: '#374151',
              '::placeholder': {
                color: '#9CA3AF',
              },
            },
          },
        });
        cardElement.mount('#card-element');

        const cardHolderName = document.getElementById('card-holder-name');
        const cardButton = document.getElementById('card-button');
        const paymentForm = document.getElementById('payment-form');
        const autofillBtn = document.getElementById('autofill-btn');
        const testCardInfo = document.getElementById('test-card-info');

        cardButton.addEventListener('click', async (e) => {
          cardButton.disabled = true;
          cardButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Processing...';
          
          const { paymentMethod, error } = await stripe.createPaymentMethod(
            'card', cardElement, {
              billing_details: { name: cardHolderName.value }
            }
          );
          
          if (error) {
            alert(error.message);
            cardButton.disabled = false;
            cardButton.innerHTML = '<i class="fas fa-lock mr-2"></i>{{ $buttonText }}';
          } else {
            document.getElementById('paymentMethod').value = paymentMethod.id;
            paymentForm.submit();
          }
        });

        autofillBtn.addEventListener('click', function() {
          testCardInfo.classList.remove('hidden');
          cardHolderName.value = "Test User";
          autofillBtn.innerHTML = '<i class="fas fa-check mr-2"></i>Filled!';
          autofillBtn.classList.remove('bg-gray-100', 'text-gray-700');
          autofillBtn.classList.add('bg-green-100', 'text-green-700');
        });
    @else
        // Stripe not configured - show error message
        document.addEventListener('DOMContentLoaded', function() {
            const cardElement = document.getElementById('card-element');
            const cardButton = document.getElementById('card-button');
            const autofillBtn = document.getElementById('autofill-btn');
            
            cardElement.innerHTML = `
              <div class="p-6 bg-red-50 border border-red-200 rounded-xl">
                <div class="flex items-center space-x-3">
                  <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-red-600"></i>
                  </div>
                  <div>
                    <p class="text-red-800 font-semibold">Payment System Not Configured</p>
                    <p class="text-red-600 text-sm mt-1">Stripe payment gateway is not configured. Please contact the administrator.</p>
                  </div>
                </div>
              </div>`;
            cardButton.disabled = true;
            cardButton.innerHTML = '<i class="fas fa-ban mr-2"></i>Payment Unavailable';
            cardButton.classList.remove('bg-gradient-to-r', 'from-[#EF7C79]', 'to-[#D76C69]', 'hover:from-[#D76C69]', 'hover:to-[#C55A57]');
            cardButton.classList.add('bg-gray-400', 'cursor-not-allowed');
            autofillBtn.style.display = 'none';
        });
    @endif

    function copyToClipboard(text) {
      navigator.clipboard.writeText(text).then(function() {
        // Show success feedback
        const copyBtn = event.target;
        const originalText = copyBtn.innerHTML;
        copyBtn.innerHTML = '<i class="fas fa-check mr-1"></i>Copied!';
        copyBtn.classList.remove('bg-[#EF7C79]', 'hover:bg-[#D76C69]');
        copyBtn.classList.add('bg-green-500', 'hover:bg-green-600');
        
        setTimeout(() => {
          copyBtn.innerHTML = originalText;
          copyBtn.classList.remove('bg-green-500', 'hover:bg-green-600');
          copyBtn.classList.add('bg-[#EF7C79]', 'hover:bg-[#D76C69]');
        }, 2000);
      }, function(err) {
        alert('Could not copy text: ', err);
      });
    }
  </script>
</body>
</html>
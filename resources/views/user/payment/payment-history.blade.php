<x-customer-layout title="Payment History" active-page="payment-history">
  <main class="flex-1 p-6 md:p-10 overflow-auto">
    <h1 class="text-3xl font-bold mb-8">Payment History</h1>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
      <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-2xl p-6 border border-green-200">
        <div class="flex items-center">
          <div class="w-12 h-12 bg-green-600 rounded-xl flex items-center justify-center mr-4">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
            </svg>
          </div>
          <div>
            <p class="text-2xl font-bold text-green-900">₱{{ number_format($totalPaid, 2) }}</p>
            <p class="text-green-700 text-sm font-medium">Total Paid</p>
          </div>
        </div>
      </div>

      <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-2xl p-6 border border-red-200">
        <div class="flex items-center">
          <div class="w-12 h-12 bg-red-600 rounded-xl flex items-center justify-center mr-4">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
            </svg>
          </div>
          <div>
            <p class="text-2xl font-bold text-red-900">₱{{ number_format($totalRefunded, 2) }}</p>
            <p class="text-red-700 text-sm font-medium">Total Refunded</p>
          </div>
        </div>
      </div>

      <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-6 border border-blue-200">
        <div class="flex items-center">
          <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center mr-4">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
            </svg>
          </div>
          <div>
            <p class="text-2xl font-bold text-blue-900">₱{{ number_format($netAmount, 2) }}</p>
            <p class="text-blue-700 text-sm font-medium">Net Amount</p>
          </div>
        </div>
      </div>
    </div>

    @if($payments->isEmpty())
      <div class="bg-white p-6 rounded shadow text-gray-600">
        You have no payment history yet.
      </div>
    @else
      <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded shadow">
          <thead>
            <tr>
              <th class="px-3 md:px-6 py-3 border-b-2 text-left text-xs font-semibold text-gray-600 uppercase">Reference #</th>
              <th class="px-3 md:px-6 py-3 border-b-2 text-left text-xs font-semibold text-gray-600 uppercase">Event Name</th>
              <th class="px-3 md:px-6 py-3 border-b-2 text-left text-xs font-semibold text-gray-600 uppercase">Type</th>
              <th class="px-3 md:px-6 py-3 border-b-2 text-left text-xs font-semibold text-gray-600 uppercase">Amount</th>
              <th class="px-3 md:px-6 py-3 border-b-2 text-left text-xs font-semibold text-gray-600 uppercase">Date</th>
              <th class="px-3 md:px-6 py-3 border-b-2 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
            </tr>
          </thead>
          <tbody>
            @foreach($payments as $payment)
            <tr class="hover:bg-indigo-50 transition">
              <td class="px-3 md:px-6 py-4 border-b font-mono text-sm">{{ $payment->reference }}</td>
              <td class="px-3 md:px-6 py-4 border-b text-sm md:text-base">{{ $payment->booking->event_name ?? 'N/A' }}</td>
              <td class="px-3 md:px-6 py-4 border-b text-sm md:text-base">
                @if($payment->amount > 0)
                  <span class="inline-flex items-center px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                    </svg>
                    Payment
                  </span>
                @else
                  <span class="inline-flex items-center px-2 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                    </svg>
                    Refund
                  </span>
                @endif
              </td>
              <td class="px-3 md:px-6 py-4 border-b text-sm md:text-base font-semibold {{ $payment->amount > 0 ? 'text-green-700' : 'text-red-700' }}">
                {{ $payment->amount > 0 ? '+' : '' }}₱{{ number_format(abs($payment->amount), 2) }}
              </td>
              <td class="px-3 md:px-6 py-4 border-b text-sm md:text-base">
                {{ \Carbon\Carbon::parse($payment->paid_at)->format('M d, Y h:i A') }}
              </td>
              <td class="px-3 md:px-6 py-4 border-b">
                @if($payment->amount > 0)
                  <span class="inline-block px-2 py-1 text-xs font-semibold text-green-800 bg-green-200 rounded">Paid</span>
                @else
                  <span class="inline-block px-2 py-1 text-xs font-semibold text-red-800 bg-red-200 rounded">Refunded</span>
                @endif
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @endif
  </main>
</x-customer-layout>
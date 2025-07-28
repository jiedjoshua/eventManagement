<x-customer-layout title="Payment History" active-page="payment-history">
  <main class="flex-1 p-6 md:p-10 overflow-auto">
    <h1 class="text-3xl font-bold mb-8">Payment History</h1>

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
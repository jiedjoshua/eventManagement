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
              <th class="px-3 md:px-6 py-3 border-b-2 text-left text-xs font-semibold text-gray-600 uppercase">Amount Paid</th>
              <th class="px-3 md:px-6 py-3 border-b-2 text-left text-xs font-semibold text-gray-600 uppercase">Payment Date</th>
              <th class="px-3 md:px-6 py-3 border-b-2 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
            </tr>
          </thead>
          <tbody>
            @foreach($payments as $payment)
            <tr class="hover:bg-indigo-50 transition">
              <td class="px-3 md:px-6 py-4 border-b font-mono text-sm">{{ $payment->reference }}</td>
              <td class="px-3 md:px-6 py-4 border-b text-sm md:text-base">{{ $payment->booking->event_name }}</td>
              <td class="px-3 md:px-6 py-4 border-b text-green-700 font-semibold text-sm md:text-base">₱{{ number_format($payment->amount, 2) }}</td>
              <td class="px-3 md:px-6 py-4 border-b text-sm md:text-base">
                {{ \Carbon\Carbon::parse($payment->paid_at)->format('M d, Y h:i A') }}
              </td>
              <td class="px-3 md:px-6 py-4 border-b">
                <span class="inline-block px-2 py-1 text-xs font-semibold text-green-800 bg-green-200 rounded">Paid</span>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @endif
  </main>
</x-customer-layout>
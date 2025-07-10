<x-customer-layout title="Payments" active-page="payments">
  <!-- Downpayment Reminder Modal -->
  @php
    $unpaidBookings = $bookings->filter(function($b) { return $b->payment_status !== 'paid'; });
  @endphp
  @if($unpaidBookings->count())
    <div id="downpayment-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40" style="display:none;">
      <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full p-6 relative border border-indigo-100">
        <button onclick="document.getElementById('downpayment-modal').style.display='none'" class="absolute top-3 right-3 text-indigo-300 hover:text-indigo-600 text-2xl transition-colors">&times;</button>
        <div class="flex items-center mb-4">
          <svg class="w-8 h-8 text-indigo-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z" />
          </svg>
          <h2 class="text-xl font-bold text-indigo-800">Downpayment Required</h2>
        </div>
        <p class="mb-4 text-gray-700">A <span class="font-semibold text-indigo-700">20% downpayment</span> is required to secure your booking. Please pay before the deadline to avoid cancellation.</p>
        <ul class="mb-4 space-y-2">
          @foreach($unpaidBookings as $booking)
            <li class="flex items-center justify-between bg-indigo-50 rounded p-3">
              <div>
                <span class="font-semibold text-indigo-900">{{ $booking->event_name }}</span>
                <span class="ml-2 text-xs text-gray-500">({{ \Carbon\Carbon::parse($booking->event_date)->format('M d, Y') }})</span>
              </div>
              <div>
                @if($booking->payment_due_date)
                  <span class="text-sm font-medium {{ \Carbon\Carbon::parse($booking->payment_due_date)->isPast() ? 'text-red-600' : 'text-indigo-700' }}">
                    Due: {{ \Carbon\Carbon::parse($booking->payment_due_date)->format('M d, Y') }}
                    @if(\Carbon\Carbon::parse($booking->payment_due_date)->isPast())
                      <span class="text-xs text-red-500">(Overdue)</span>
                    @endif
                  </span>
                @else
                  <span class="text-xs text-gray-400">No due date set</span>
                @endif
              </div>
            </li>
          @endforeach
        </ul>
        <button onclick="document.getElementById('downpayment-modal').style.display='none'" class="w-full py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-semibold mt-2 transition-colors">OK, Got it</button>
      </div>
    </div>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('downpayment-modal').style.display = 'flex';
      });
    </script>
  @endif
  <main class="flex-1 p-6 md:p-10 overflow-auto">
    <h1 class="text-3xl font-bold mb-8">Payments Due</h1>

    @if($bookings->isEmpty())
      <div class="bg-white p-6 rounded shadow text-gray-600">
        You have no payments due at this time.
      </div>
    @else
      <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded shadow">
                      <thead>
              <tr>
                <th class="px-3 md:px-6 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase">Event Name</th>
                <th class="px-3 md:px-6 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase">Event Date</th>
                <th class="px-3 md:px-6 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase">Payment Due</th>
                <th class="px-3 md:px-6 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase">Total Due</th>
                <th class="px-3 md:px-6 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase">Paid</th>
                <th class="px-3 md:px-6 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-3 md:px-6 py-3 border-b"></th>
              </tr>
            </thead>
          <tbody>
            @foreach($bookings as $booking)
              <tr>
                <td class="px-3 md:px-6 py-4 border-b text-sm md:text-base">{{ $booking->event_name }}</td>
                <td class="px-3 md:px-6 py-4 border-b text-sm md:text-base">{{ \Carbon\Carbon::parse($booking->event_date)->format('M d, Y') }}</td>
                <td class="px-3 md:px-6 py-4 border-b text-sm md:text-base">
                  @if($booking->payment_due_date)
                    <span class="{{ \Carbon\Carbon::parse($booking->payment_due_date)->isPast() ? 'text-red-600 font-semibold' : 'text-gray-900' }}">
                      {{ \Carbon\Carbon::parse($booking->payment_due_date)->format('M d, Y') }}
                    </span>
                    @if(\Carbon\Carbon::parse($booking->payment_due_date)->isPast())
                      <span class="block text-xs text-red-500">Overdue</span>
                    @endif
                  @else
                    <span class="text-gray-400">Not set</span>
                  @endif
                </td>
                <td class="px-3 md:px-6 py-4 border-b text-sm md:text-base">₱{{ number_format($booking->amount_due, 2) }}</td>
                <td class="px-3 md:px-6 py-4 border-b text-sm md:text-base">₱{{ number_format($booking->amount_paid, 2) }}</td>
                <td class="px-3 md:px-6 py-4 border-b text-sm md:text-base capitalize">{{ $booking->payment_status }}</td>
                <td class="px-3 md:px-6 py-4 border-b">
                  <a href="{{ route('booking.pay', $booking->id) }}" class="inline-block bg-indigo-600 text-white px-2 md:px-4 py-1.5 md:py-2 rounded text-xs md:text-sm font-medium hover:bg-indigo-700 transition-colors duration-200 whitespace-nowrap">
                    Pay Now
                  </a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @endif
  </main>
</x-customer-layout>
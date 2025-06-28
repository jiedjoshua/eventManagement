<x-customer-layout title="Payments" active-page="payments">
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
                <td class="px-3 md:px-6 py-4 border-b text-sm md:text-base">₱{{ number_format($booking->amount_due, 2) }}</td>
                <td class="px-3 md:px-6 py-4 border-b text-sm md:text-base">₱{{ number_format($booking->amount_paid, 2) }}</td>
                <td class="px-3 md:px-6 py-4 border-b text-sm md:text-base capitalize">{{ $booking->payment_status }}</td>
                <td class="px-3 md:px-6 py-4 border-b">
                  <a href="{{ route('booking.pay', $booking->id) }}" class="bg-indigo-600 text-white px-3 md:px-4 py-2 rounded hover:bg-indigo-700 transition text-sm md:text-base">
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
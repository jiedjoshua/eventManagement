<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Payments Due</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex h-screen bg-gray-100">

 <!-- Sidebar -->
  <aside class="w-64 bg-white shadow-md flex flex-col">
    <div class="p-6 text-2xl font-bold text-indigo-600">Customer Panel</div>
    <nav class="flex-1 px-4 space-y-2 text-sm text-gray-700">
      <!-- Menu -->
      <div>
        <p class="font-semibold text-gray-900">Home</p>
        <a href="{{ route('user.dashboard') }}" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Dashboard</a>
      </div>

      <div>
        <p class="mt-4 font-semibold text-gray-900">My Events</p>
        <a href="{{ route('user.bookedEvents') }} " class="block pl-4 py-2 hover:bg-indigo-100 rounded">Booked Events</a>
        <a href="{{ route('user.attendingEvents') }} " class="block pl-4 py-2 hover:bg-indigo-100 rounded">Attending Events</a>
        <a href="#" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Guest List</a>
      </div>

      <div>
        <p class="mt-4 font-semibold text-gray-900">Payment</p>
        <a href="{{ route('user.payments') }}" class="block pl-4 py-2 rounded bg-indigo-200 font-semibold text-indigo-800">Payments</a>
        <a href="{{ route('user.paymentHistory') }}" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Payment History</a>
      </div>

      <div>
        <p class="mt-4 font-semibold text-gray-900">Settings</p>
        <a href="{{ route('user.accountSettings') }}" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Account Settings</a>
      </div>
    </nav>

    <div class="px-6 py-4 border-t">
  <form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="block text-red-600 font-semibold hover:underline">
      Logout
    </button>
  </form>
</div>

  </aside>
  <!-- Main Content -->
  <main class="flex-1 p-10 overflow-auto">
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
              <th class="px-6 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase">Event Name</th>
              <th class="px-6 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase">Event Date</th>
              <th class="px-6 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase">Total Due</th>
              <th class="px-6 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase">Paid</th>
              <th class="px-6 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase">Status</th>
              <th class="px-6 py-3 border-b"></th>
            </tr>
          </thead>
          <tbody>
            @foreach($bookings as $booking)
              <tr>
                <td class="px-6 py-4 border-b">{{ $booking->event_name }}</td>
                <td class="px-6 py-4 border-b">{{ \Carbon\Carbon::parse($booking->event_date)->format('M d, Y') }}</td>
                <td class="px-6 py-4 border-b">₱{{ number_format($booking->amount_due, 2) }}</td>
                <td class="px-6 py-4 border-b">₱{{ number_format($booking->amount_paid, 2) }}</td>
                <td class="px-6 py-4 border-b capitalize">{{ $booking->payment_status }}</td>
                <td class="px-6 py-4 border-b">
                  <a href="{{ route('booking.pay', $booking->id) }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">
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
</body>
</html>
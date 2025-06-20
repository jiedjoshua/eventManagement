<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Payment History</title>
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
                <a href="{{ route('user.payments') }}" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Payments</a>
                <a href="{{ route('user.paymentHistory') }}" class="block pl-4 py-2 rounded bg-indigo-200 font-semibold text-indigo-800">Payment History</a>
            </div>

            <div>
                <p class="mt-4 font-semibold text-gray-900">Settings</p>
                <a href="#" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Account Settings</a>
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
                            <th class="px-6 py-3 border-b-2 text-left text-xs font-semibold text-gray-600 uppercase">Reference #</th>
                            <th class="px-6 py-3 border-b-2 text-left text-xs font-semibold text-gray-600 uppercase">Event Name</th>
                            <th class="px-6 py-3 border-b-2 text-left text-xs font-semibold text-gray-600 uppercase">Amount Paid</th>
                            <th class="px-6 py-3 border-b-2 text-left text-xs font-semibold text-gray-600 uppercase">Payment Date</th>
                            <th class="px-6 py-3 border-b-2 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payments as $payment)
                        <tr class="hover:bg-indigo-50 transition">
                            <td class="px-6 py-4 border-b font-mono text-sm">{{ $payment->reference }}</td>
                            <td class="px-6 py-4 border-b">{{ $payment->booking->event_name }}</td>
                            <td class="px-6 py-4 border-b text-green-700 font-semibold">₱{{ number_format($payment->amount, 2) }}</td>
                            <td class="px-6 py-4 border-b">
                                {{ \Carbon\Carbon::parse($payment->paid_at)->format('M d, Y h:i A') }}
                            </td>
                            <td class="px-6 py-4 border-b">
                                <span class="inline-block px-2 py-1 text-xs font-semibold text-green-800 bg-green-200 rounded">Paid</span>
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
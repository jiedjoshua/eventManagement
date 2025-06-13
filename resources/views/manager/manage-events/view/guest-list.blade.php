<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Guest List - Event Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .dropdown-panel {
            position: absolute;
            background: white;
            border: 1px solid #cbd5e0;
            border-radius: 0.25rem;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
            z-index: 10;
            padding: 0.5rem;
            width: 200px;
        }
    </style>
</head>
<body class="flex h-screen bg-gray-50">
    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-md flex flex-col">
        <div class="p-6 text-2xl font-bold text-indigo-600">Event Panel</div>
        <nav class="flex-1 px-4 space-y-2 text-sm text-gray-700">
            <div>
                <p class="font-semibold text-gray-900">Home</p>
                <a href="{{ route('events.dashboard', ['event' => $event->id]) }}" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Dashboard</a>
            </div>

            <div>
                <p class="mt-4 font-semibold text-gray-900">Check-in Controls</p>
                <a href="{{ route('events.qrScanner', ['event' => $event->id]) }}" class="block pl-4 py-2 hover:bg-indigo-100 rounded">QR Scanner</a>
                <a href="#" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Manual Check-in</a>
                <a href="{{ route('events.checkedIn', ['event' => $event->id]) }}" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Checked in Guests</a>
            </div>

            <div>
                <p class="mt-4 font-semibold text-gray-900">Guest List Preview</p>
                <a href="{{ route('events.guests', ['event' => $event->id]) }}" class="block pl-4 py-2 rounded bg-indigo-200 font-semibold text-indigo-800">View full guest list</a>
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

    <main class="flex-1 p-8 overflow-y-auto">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Guest List</h1>
                    <p class="text-gray-600 mt-1">{{ $event->event_name }}</p>
                </div>
                <div class="flex gap-4">
                    <div class="text-sm text-gray-600 bg-white px-4 py-2 rounded shadow font-medium">
                        Total Guests: <span class="font-semibold text-indigo-600">{{ $event->guests->count() }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Guest</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">RSVP Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($event->guests as $index => $guest)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-indigo-100 rounded-full flex items-center justify-center">
                                            <span class="text-indigo-600 font-medium">
                                                {{ strtoupper(substr($guest->first_name, 0, 1) . substr($guest->last_name, 0, 1)) }}
                                            </span>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $guest->first_name }} {{ $guest->last_name }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $guest->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $guest->pivot->rsvp_status === 'accepted' ? 'bg-green-100 text-green-800' : 
                                           ($guest->pivot->rsvp_status === 'declined' ? 'bg-red-100 text-red-800' : 
                                           'bg-yellow-100 text-yellow-800') }}">
                                        {{ ucfirst($guest->pivot->rsvp_status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                        </svg>
                                        <p class="text-lg font-medium">No guests found</p>
                                        <p class="text-sm text-gray-500 mt-1">Add guests to see them listed here</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>
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
    <!-- Enhanced Sidebar -->
    <aside class="w-64 bg-gradient-to-b from-white to-gray-50 shadow-xl border-r border-gray-200 flex flex-col h-screen">
        <!-- Enhanced Header -->
        <div class="p-6 border-b border-gray-200 flex-shrink-0">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Event Panel</h2>
                    <p class="text-sm text-gray-500">Event Manager</p>
                </div>
            </div>
        </div>
        
        <!-- Enhanced Home Button -->
        <div class="px-4 py-4 border-b border-gray-200">
            <a href="{{ route('home') }}" class="flex items-center space-x-3 bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white px-4 py-3 rounded-xl transition-all duration-200 text-sm font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span>Go to Home</span>
            </a>
        </div>
        
        <!-- Enhanced Navigation -->
        <nav class="flex-1 px-4 space-y-6 py-6 overflow-y-auto">
            <!-- Home Section -->
            <div>
                <div class="flex items-center mb-3">
                    <div class="w-2 h-2 bg-indigo-500 rounded-full mr-3"></div>
                    <p class="font-bold text-gray-900 text-sm uppercase tracking-wide">Home</p>
                </div>
                <a href="{{ route('events.dashboard', ['event' => $event->id]) }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <span>Dashboard</span>
                </a>
            </div>

            <!-- Check-in Controls Section -->
            <div>
                <div class="flex items-center mb-3">
                    <div class="w-2 h-2 bg-green-500 rounded-full mr-3"></div>
                    <p class="font-bold text-gray-900 text-sm uppercase tracking-wide">Check-in Controls</p>
                </div>
                <div class="space-y-2">
                    <a href="{{ route('events.qrScanner', ['event' => $event->id]) }}" 
                       class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V6a1 1 0 00-1-1H5a1 1 0 00-1 1v1a1 1 0 001 1zm12 0h2a1 1 0 001-1V6a1 1 0 00-1-1h-2a1 1 0 00-1 1v1a1 1 0 001 1zM5 20h2a1 1 0 001-1v-1a1 1 0 00-1-1H5a1 1 0 00-1 1v1a1 1 0 001 1z"></path>
                        </svg>
                        <span>QR Scanner</span>
                    </a>
                    <a href="{{ route('events.manualCheckin', ['event' => $event->id]) }}" 
                       class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <span>Manual Check-in</span>
                    </a>
                    <a href="{{ route('events.checkedIn', ['event' => $event->id]) }}" 
                       class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Checked in Guests</span>
                    </a>
                </div>
            </div>

            <!-- Guest List Section -->
            <div>
                <div class="flex items-center mb-3">
                    <div class="w-2 h-2 bg-purple-500 rounded-full mr-3"></div>
                    <p class="font-bold text-gray-900 text-sm uppercase tracking-wide">Guest Management</p>
                </div>
                <a href="{{ route('events.guests', ['event' => $event->id]) }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 bg-gradient-to-r from-purple-100 to-purple-200 text-purple-700 font-semibold shadow-md">
                    <svg class="h-5 w-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span>View full guest list</span>
                </a>
            </div>
        </nav>

        <!-- Enhanced Back Button -->
        <div class="px-4 py-4 border-t border-gray-200 flex-shrink-0">
            <a href="{{ route('manager.upcomingEvents') }}" 
               class="w-full flex items-center space-x-3 px-4 py-3 text-red-600 hover:text-red-700 hover:bg-red-50 rounded-xl transition-all duration-200 font-semibold group">
                <svg class="h-5 w-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Back to Manager Panel</span>
            </a>
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
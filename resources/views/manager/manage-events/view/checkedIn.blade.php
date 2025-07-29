<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Checked-in Guests - Event Management</title>
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
                       class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 bg-gradient-to-r from-green-100 to-green-200 text-green-700 font-semibold shadow-md">
                        <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                <h1 class="text-3xl font-bold text-gray-800">Checked-in Guests</h1>
                <div class="flex items-center gap-4">
                    <div class="text-sm text-gray-600 bg-white px-4 py-2 rounded shadow font-medium">
                        <span class="font-semibold text-indigo-600">{{ $event->guests->count() }}</span> Registered
                    </div>
                    <div class="text-sm text-gray-600 bg-white px-4 py-2 rounded shadow font-medium">
                        <span class="font-semibold text-green-600">{{ $event->checkedInExternalGuests->count() }}</span> External
                    </div>
                    <div class="text-sm text-gray-600 bg-white px-4 py-2 rounded shadow font-medium">
                        Total: <span class="font-semibold text-indigo-600">{{ $event->guests->count() + $event->checkedInExternalGuests->count() }}</span>
                    </div>
                    <div id="realtime-status" class="flex items-center text-xs text-gray-500">
                        <div class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></div>
                        <span>Live updates enabled</span>
                    </div>
                </div>
            </div>
            <p class="text-gray-600">View all guests who have checked in to the event.</p>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-indigo-500">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-users text-2xl text-indigo-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Registered Guests</p>
                        <p class="text-2xl font-bold text-indigo-600">{{ $event->guests->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-user-plus text-2xl text-green-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">External Guests</p>
                        <p class="text-2xl font-bold text-green-600">{{ $event->checkedInExternalGuests->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-2xl text-blue-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Checked-in</p>
                        <p class="text-2xl font-bold text-blue-600">{{ $event->guests->count() + $event->checkedInExternalGuests->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Registered Guests Section -->
        <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
            <div class="px-6 py-4 border-b bg-indigo-50">
                <h3 class="text-lg font-semibold text-indigo-800 flex items-center">
                    <i class="fas fa-users mr-2"></i>Registered Guests
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-indigo-50 border-b">
                            <th class="px-6 py-3 text-left text-xs font-medium text-indigo-700 uppercase tracking-wider">Guest Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-indigo-700 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-indigo-700 uppercase tracking-wider">Check-in Time</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($event->guests as $guest)
                            <tr class="hover:bg-indigo-50 transition-colors">
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
                                    <div class="text-sm text-gray-900">
                                        {{ \Carbon\Carbon::parse($guest->pivot->checked_in_at)->format('F d, Y g:i A') }}
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                        </svg>
                                        <p class="text-lg font-medium">No registered guests have checked in yet</p>
                                        <p class="text-sm text-gray-500 mt-1">Registered guests will appear here once they check in</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- External Guests Section -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b bg-green-50">
                <h3 class="text-lg font-semibold text-green-800 flex items-center">
                    <i class="fas fa-user-plus mr-2"></i>External Guests
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-green-50 border-b">
                            <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Guest Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">QR Code</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Check-in Time</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($event->checkedInExternalGuests as $guest)
                            <tr class="hover:bg-green-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-green-100 rounded-full flex items-center justify-center">
                                            <span class="text-green-600 font-medium">
                                                {{ strtoupper(substr($guest->name ?? 'E', 0, 1)) }}
                                            </span>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $guest->name ?? 'External Guest' }}
                                            </div>
                                            <div class="text-xs text-green-600 font-medium">External Guest</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-600 font-mono bg-gray-100 px-2 py-1 rounded">
                                        {{ $guest->unique_code ?? 'N/A' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ \Carbon\Carbon::parse($guest->checked_in_at)->format('F d, Y g:i A') }}
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                        </svg>
                                        <p class="text-lg font-medium">No external guests have checked in yet</p>
                                        <p class="text-sm text-gray-500 mt-1">External guests will appear here once they check in via QR code</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script>
        // Real-time updates for checked-in guests
        let lastUpdateTime = null;
        let updateInterval;
        let isUpdating = false;
        
        function updateStatusIndicator(status, message) {
            const statusElement = document.getElementById('realtime-status');
            const dotElement = statusElement.querySelector('.w-2');
            const textElement = statusElement.querySelector('span');
            
            switch(status) {
                case 'connected':
                    dotElement.className = 'w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse';
                    textElement.textContent = message || 'Live updates enabled';
                    break;
                case 'updating':
                    dotElement.className = 'w-2 h-2 bg-yellow-500 rounded-full mr-2 animate-pulse';
                    textElement.textContent = message || 'Updating...';
                    break;
                case 'error':
                    dotElement.className = 'w-2 h-2 bg-red-500 rounded-full mr-2';
                    textElement.textContent = message || 'Connection error';
                    break;
                case 'disconnected':
                    dotElement.className = 'w-2 h-2 bg-gray-400 rounded-full mr-2';
                    textElement.textContent = message || 'Updates paused';
                    break;
            }
        }
        
        function updateCheckedInList() {
            if (isUpdating) return;
            
            isUpdating = true;
            updateStatusIndicator('updating', 'Updating...');
            
            fetch(`{{ route('api.events.checkedInData', ['event' => $event->id]) }}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    // Update summary counts
                    const registeredCountElement = document.querySelector('.text-indigo-600');
                    const externalCountElement = document.querySelector('.text-green-600');
                    const totalCountElement = document.querySelector('.text-blue-600');
                    
                    if (registeredCountElement) {
                        registeredCountElement.textContent = data.summary.registered_count;
                    }
                    if (externalCountElement) {
                        externalCountElement.textContent = data.summary.external_count;
                    }
                    if (totalCountElement) {
                        totalCountElement.textContent = data.summary.total_count;
                    }
                    
                    // Update registered guests table
                    const registeredTbody = document.querySelector('tbody');
                    if (registeredTbody && data.registered_guests.length > 0) {
                        registeredTbody.innerHTML = data.registered_guests.map(guest => `
                            <tr class="hover:bg-indigo-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-indigo-100 rounded-full flex items-center justify-center">
                                            <span class="text-indigo-600 font-medium">
                                                ${guest.initials}
                                            </span>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                ${guest.first_name} ${guest.last_name}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">${guest.email}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        ${guest.formatted_checkin_time}
                                    </div>
                                </td>
                            </tr>
                        `).join('');
                    } else if (registeredTbody) {
                        registeredTbody.innerHTML = `
                            <tr>
                                <td colspan="3" class="px-6 py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                        </svg>
                                        <p class="text-lg font-medium">No registered guests have checked in yet</p>
                                        <p class="text-sm text-gray-500 mt-1">Registered guests will appear here once they check in</p>
                                    </div>
                                </td>
                            </tr>
                        `;
                    }
                    
                    // Update external guests table
                    const externalTbody = document.querySelectorAll('tbody')[1];
                    if (externalTbody && data.external_guests.length > 0) {
                        externalTbody.innerHTML = data.external_guests.map(guest => `
                            <tr class="hover:bg-green-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-green-100 rounded-full flex items-center justify-center">
                                            <span class="text-green-600 font-medium">
                                                ${guest.initials}
                                            </span>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                ${guest.name}
                                            </div>
                                            <div class="text-xs text-green-600 font-medium">External Guest</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-600 font-mono bg-gray-100 px-2 py-1 rounded">
                                        ${guest.unique_code}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        ${guest.formatted_checkin_time}
                                    </div>
                                </td>
                            </tr>
                        `).join('');
                    } else if (externalTbody) {
                        externalTbody.innerHTML = `
                            <tr>
                                <td colspan="3" class="px-6 py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                        </svg>
                                        <p class="text-lg font-medium">No external guests have checked in yet</p>
                                        <p class="text-sm text-gray-500 mt-1">External guests will appear here once they check in via QR code</p>
                                    </div>
                                </td>
                            </tr>
                        `;
                    }
                    
                    // Update last update time
                    lastUpdateTime = data.last_updated;
                    updateStatusIndicator('connected', 'Live updates enabled');
                })
                .catch(error => {
                    console.error('Error updating checked-in list:', error);
                    updateStatusIndicator('error', 'Connection error');
                })
                .finally(() => {
                    isUpdating = false;
                });
        }
        
        // Start real-time updates
        function startRealTimeUpdates() {
            // Initial update
            updateCheckedInList();
            
            // Set up interval for updates (every 3 seconds)
            updateInterval = setInterval(updateCheckedInList, 3000);
            updateStatusIndicator('connected', 'Live updates enabled');
        }
        
        // Stop real-time updates
        function stopRealTimeUpdates() {
            if (updateInterval) {
                clearInterval(updateInterval);
                updateInterval = null;
            }
            updateStatusIndicator('disconnected', 'Updates paused');
        }
        
        // Start updates when page loads
        document.addEventListener('DOMContentLoaded', function() {
            startRealTimeUpdates();
            
            // Stop updates when page is hidden (to save resources)
            document.addEventListener('visibilitychange', function() {
                if (document.hidden) {
                    stopRealTimeUpdates();
                } else {
                    startRealTimeUpdates();
                }
            });
        });
    </script>
</body>
</html>
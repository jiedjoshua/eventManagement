<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Manual Check-in - Event Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .dropdown-panel {
            position: absolute;
            background: white;
            border: 1px solid #cbd5e0;
            border-radius: 0.25rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            z-index: 10;
            padding: 0.5rem;
            width: 200px;
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                <a href="{{ route('events.manualCheckin', ['event' => $event->id]) }}" class="block pl-4 py-2 rounded bg-indigo-200 font-semibold text-indigo-800">Manual Check-in</a>
                <a href="{{ route('events.checkedIn', ['event' => $event->id]) }}" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Checked in Guests</a>
            </div>

            <div>
                <p class="mt-4 font-semibold text-gray-900">Guest List Preview</p>
                <a href="{{ route('events.guests', ['event' => $event->id]) }}" class="block pl-4 py-2 hover:bg-indigo-100 rounded">View full guest list</a>
            </div>
        </nav>

        <div class="px-6 py-4 border-t">
           
               
                <a href="{{ route('manager.upcomingEvents') }}" class="block text-red-600 font-semibold hover:underline">
                    Back to Manager Panel
                </a>
        </div>
    </aside>

    <main class="flex-1 p-8 overflow-y-auto">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-3xl font-bold text-gray-800">Manual Check-in</h1>
                <div class="text-sm text-gray-600 bg-white px-4 py-2 rounded shadow font-medium">
                    Total Guests: <span class="font-semibold text-indigo-600">{{ $event->guests->count() }}</span>
                </div>
            </div>
            <p class="text-gray-600">Search and check in guests manually.</p>
        </div>

        <!-- Search Section -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <form id="searchForm" class="space-y-4">
                <div class="flex gap-4">
                    <div class="flex-1">
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search Guest</label>
                        <input type="text" id="search" name="search"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Search by name or email...">
                    </div>
                    <div class="flex items-end">
                        <button type="submit"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            Search
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Results Section -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 border-b">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Guest Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="searchResults">
                        <!-- Results will be populated here -->
                    </tbody>
                </table>
            </div>
        </div>
    </main>


 <script>
    const eventId = {{ $event->id }};

    document.getElementById('searchForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const searchTerm = document.getElementById('search').value;
        
        // Show loading state
        document.getElementById('searchResults').innerHTML = 
            '<tr>' +
                '<td colspan="4" class="px-6 py-4 text-center">' +
                    '<div class="flex justify-center">' +
                        '<svg class="animate-spin h-5 w-5 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">' +
                            '<circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>' +
                            '<path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>' +
                        '</svg>' +
                    '</div>' +
                '</td>' +
            '</tr>';

        // Update the fetch URL to use the web route
        fetch('/events/' + eventId + '/search-guests?search=' + encodeURIComponent(searchTerm), {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            let resultsHtml = '';
            
            if (data.guests && data.guests.length > 0) {
                data.guests.forEach(function(guest) {
                    const initials = guest.first_name.charAt(0) + guest.last_name.charAt(0);
                    const statusClass = guest.checked_in_at ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800';
                    const statusText = guest.checked_in_at ? 'Checked In' : 'Not Checked In';
                    
                    resultsHtml += 
                        '<tr class="hover:bg-gray-50 transition-colors">' +
                            '<td class="px-6 py-4 whitespace-nowrap">' +
                                '<div class="flex items-center">' +
                                    '<div class="flex-shrink-0 h-10 w-10 bg-indigo-100 rounded-full flex items-center justify-center">' +
                                        '<span class="text-indigo-600 font-medium">' + initials + '</span>' +
                                    '</div>' +
                                    '<div class="ml-4">' +
                                        '<div class="text-sm font-medium text-gray-900">' + 
                                            guest.first_name + ' ' + guest.last_name +
                                        '</div>' +
                                    '</div>' +
                                '</div>' +
                            '</td>' +
                            '<td class="px-6 py-4 whitespace-nowrap">' +
                                '<div class="text-sm text-gray-900">' + guest.email + '</div>' +
                            '</td>' +
                            '<td class="px-6 py-4 whitespace-nowrap">' +
                                '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ' + statusClass + '">' +
                                    statusText +
                                '</span>' +
                            '</td>' +
                            '<td class="px-6 py-4 whitespace-nowrap text-sm">';
                    
                    if (!guest.checked_in_at) {
                        resultsHtml += 
                            '<button onclick="checkInGuest(' + guest.id + ')" ' +
                                'class="text-indigo-600 hover:text-indigo-900 font-medium">' +
                                'Check In' +
                            '</button>';
                    } else {
                        resultsHtml += '<span class="text-gray-500">Already checked in</span>';
                    }
                    
                    resultsHtml += '</td></tr>';
                });
            } else {
                resultsHtml = 
                    '<tr>' +
                        '<td colspan="4" class="px-6 py-4 text-center text-gray-500">' +
                            'No guests found matching your search.' +
                        '</td>' +
                    '</tr>';
            }

            document.getElementById('searchResults').innerHTML = resultsHtml;
        })
        .catch(error => {
            document.getElementById('searchResults').innerHTML = 
                '<tr>' +
                    '<td colspan="4" class="px-6 py-4 text-center text-red-500">' +
                        'An error occurred while searching. Please try again.' +
                    '</td>' +
                '</tr>';
        });
    });

    function checkInGuest(guestId) {
        fetch('/events/' + eventId + '/check-in/' + guestId, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Refresh the search results
                document.getElementById('searchForm').dispatchEvent(new Event('submit'));
            } else {
                alert(data.message || 'Failed to check in guest');
            }
        })
        .catch(error => {
            alert('An error occurred while checking in the guest');
        });
    }
</script>
</body>

</html>
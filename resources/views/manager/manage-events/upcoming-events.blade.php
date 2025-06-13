<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Upcoming Events</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="flex h-screen bg-gray-100">
    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-md flex flex-col">
        <div class="p-6 text-2xl font-bold text-indigo-600">Event Panel</div>
        <nav class="flex-1 px-4 space-y-2 text-sm text-gray-700">
            <!-- Menu -->
            <div>
                <p class="font-semibold text-gray-900">Home</p>
                <a href="{{ route('manager.dashboard') }}" class="block pl-4 py-2 rounded hover:bg-indigo-100">Dashboard</a>
            </div>

            <div>
                <p class="mt-4 font-semibold text-gray-900">Manage Events</p>
                <a href="{{ route('manager.showEvent') }}" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Events</a>
                <a href="{{ route('manager.bookedEvents') }}" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Booked Events</a>
                <a href="{{ route('manager.upcomingEvents') }}" class="block pl-4 py-2 bg-indigo-200 font-semibold text-indigo-800 rounded">Upcoming Events</a>
                <a href="#" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Create Event</a>
            </div>

            <div>
                <p class="mt-4 font-semibold text-gray-900">RSVP Management</p>
                <a href="#" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Guest Lists</a>
                <a href="#" class="block pl-4 py-2 hover:bg-indigo-100 rounded">RSVP Status</a>
            </div>

            <div>
                <p class="mt-4 font-semibold text-gray-900">QR Code Check-In</p>
                <a href="#" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Generate QR Codes</a>
                <a href="#" class="block pl-4 py-2 hover:bg-indigo-100 rounded">View Check-in Status</a>
            </div>

            <div>
                <p class="mt-4 font-semibold text-gray-900">Reports & Analytics</p>
                <a href="#" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Event Summary</a>
                <a href="#" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Feedback Summary</a>
            </div>

            <div>
                <p class="mt-4 font-semibold text-gray-900">Settings</p>
                <a href="#" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Account Settings</a>
            </div>
        </nav>

        <div class="px-6 py-4 border-t">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="block text-red-600 font-semibold hover:underline">Logout</button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-10 overflow-auto">
        <div class="mb-8 flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-800">Upcoming Events</h1>

            <!-- Filter Dropdown -->
            <div class="flex gap-4">
                <select name="event_type" id="eventTypeFilter" onchange="applyFilters()"
                    class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Filter By Type</option>
                    <option value="wedding" {{ request('event_type') == 'wedding' ? 'selected' : '' }}>Wedding</option>
                    <option value="birthday" {{ request('event_type') == 'birthday' ? 'selected' : '' }}>Birthday</option>
                    <option value="corporate" {{ request('event_type') == 'corporate' ? 'selected' : '' }}>Corporate</option>
                    <option value="debut" {{ request('event_type') == 'debut' ? 'selected' : '' }}>Debut</option>
                </select>

                <select name="sort" id="sortFilter" onchange="applyFilters()"
                    class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Sort By</option>
                    <option value="date-asc" {{ request('sort') == 'date-asc' ? 'selected' : '' }}>Date (Earliest)</option>
                    <option value="date-desc" {{ request('sort') == 'date-desc' ? 'selected' : '' }}>Date (Latest)</option>
                    <option value="name-asc" {{ request('sort') == 'name-asc' ? 'selected' : '' }}>Name (A-Z)</option>
                    <option value="name-desc" {{ request('sort') == 'name-desc' ? 'selected' : '' }}>Name (Z-A)</option>
                </select>
            </div>
        </div>

        <!-- Events Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($events as $event)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-6">
                    <!-- Event Status Badge -->
                    <div class="flex justify-between items-start mb-4">
                        <span class="px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                            {{ ucwords($event->status) }}
                        </span>
                        <span class="text-sm text-gray-500">
                            Ref: {{ strtoupper($event->booking->reference ?? 'N/A') }}
                        </span>
                    </div>

                    <!-- Event Details -->
                    <h3 class="text-xl font-bold text-gray-900 mb-2">{{ ucwords($event->event_name) }}</h3>

                    <div class="space-y-2 text-gray-600">
                        <p class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            {{ \Carbon\Carbon::parse($event->event_date)->format('F d, Y') }}
                        </p>

                        <p class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ \Carbon\Carbon::parse($event->start_time)->format('g:i A') }} -
                            {{ \Carbon\Carbon::parse($event->end_time)->format('g:i A') }}
                        </p>

                        <p class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ ucwords($event->venue_name) }}
                        </p>

                        <p class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            {{ $event->guest_count }} Guests
                        </p>

                        <p class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                            {{ ucwords($event->package_type) }}
                        </p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-6 flex gap-2">
                        <button onclick="showEventDetails('{{ $event->id }}')"
                            class="flex-1 bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition">
                            View Details
                        </button>

                        <button onclick="showReschedModal('{{ $event->id }}')"
                            class="flex-1 bg-yellow-600 text-white px-4 py-2 rounded-md hover:bg-yellow-700 transition">
                            Reschedule
                        </button>

                        <a href="{{ route('events.dashboard', $event->id) }}"
                            class="flex-1 bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition text-center">
                            Event Mode
                        </a>

                        <!-- Guest list button -->
                    </div>

                    <!-- Guest list button -->


                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12 text-gray-500">
                <p class="text-xl">No Upcoming Events Found</p>
                <p class="mt-2">Events that are scheduled for future dates will appear here.</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($events->hasPages())
        <div class="mt-6">
            {{ $events->appends(request()->query())->links() }}
        </div>
        @endif

        <!-- Reschedule Modal -->
        <div id="reschedModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="mt-3">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Reschedule Event</h3>
                    <form id="reschedForm" method="POST" class="space-y-4">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label class="block text-sm font-medium text-gray-700">New Date</label>
                            <input type="date" name="event_date"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">New Start Time</label>
                            <input type="time" name="start_time"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">New End Time</label>
                            <input type="time" name="end_time"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                required>
                        </div>

                        <div class="flex justify-end space-x-3 mt-5">
                            <button type="button" onclick="closeReschedModal()"
                                class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                                Cancel
                            </button>
                            <button type="submit"
                                class="px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700">
                                Confirm Reschedule
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <!-- Event Details Modal (Add this if you need a detailed view) -->
    <div id="eventDetailsModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
            <div id="modalContent">
                <!-- Modal content will be populated by JavaScript -->
            </div>
        </div>
    </div>

    <!-- Success Notification Popup -->
    <div id="successNotification" class="hidden fixed top-4 right-4 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg transform transition-transform duration-300 ease-in-out">
        <div class="flex items-center space-x-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span id="notificationMessage"></span>
        </div>
    </div>

    <script>
        // Add this to your existing JavaScript
        function showNotification(message) {
            const notification = document.getElementById('successNotification');
            const messageElement = document.getElementById('notificationMessage');
            messageElement.textContent = message;

            // Show notification
            notification.classList.remove('hidden');
            notification.classList.add('transform', 'translate-y-0');

            // Hide after 3.5 seconds
            setTimeout(() => {
                notification.classList.add('transform', '-translate-y-full');
                setTimeout(() => {
                    notification.classList.add('hidden');
                }, 300);
            }, 3500);
        }

        // Check for success message in session
        @if(session('success'))
        showNotification("{{ session('success') }}");
        @endif
    </script>
</body>

<script>
    function showEventDetails(eventId) {
        const modal = document.getElementById('eventDetailsModal');
        const content = document.getElementById('modalContent');

        // Helper function to capitalize first letter of each word
        function toTitleCase(str) {
            return str.replace(/\w\S*/g, function(txt) {
                return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
            });
        }

        fetch(`/manager/events/${eventId}/details`)
            .then(response => response.json())
            .then(data => {
                const event = data.event;
                content.innerHTML = `
                <div class="p-6">
                    <div class="flex justify-between items-start mb-6">
                        <h3 class="text-2xl font-bold text-gray-900">${toTitleCase(event.event_name)}</h3>
                        <button onclick="document.getElementById('eventDetailsModal').classList.add('hidden')" 
                                class="text-gray-500 hover:text-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Event Type</h4>
                                <p class="text-lg">${toTitleCase(event.event_type)}</p>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Date</h4>
                                <p class="text-lg">${new Date(event.event_date).toLocaleDateString('en-US', { 
                                    weekday: 'long',
                                    year: 'numeric',
                                    month: 'long',
                                    day: 'numeric'
                                })}</p>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Time</h4>
                                <p class="text-lg">${event.start_time} - ${event.end_time}</p>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Venue</h4>
                                <p class="text-lg">${toTitleCase(event.venue_name)}</p>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Package Type</h4>
                                <p class="text-lg">${toTitleCase(event.package_type)}</p>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Guest Count</h4>
                                <p class="text-lg">${event.guest_count} Guests</p>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Reference Number</h4>
                                <p class="text-lg">${event.booking?.reference ? event.booking.reference.toUpperCase() : 'N/A'}</p>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Status</h4>
                                <p class="text-lg">${toTitleCase(event.status)}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Person Section -->
                    <div class="mt-8 border-t pt-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Contact Person</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Name</h4>
                                <p class="text-lg">${toTitleCase(event.contact_person.name)}</p>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Phone</h4>
                                <p class="text-lg">${event.contact_person.phone || 'N/A'}</p>
                            </div>
                            <div class="md:col-span-2">
                                <h4 class="text-sm font-medium text-gray-500">Email</h4>
                                <p class="text-lg">${event.contact_person.email}</p>
                            </div>
                        </div>
                    </div>
                </div>
            `;
                modal.classList.remove('hidden');
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Failed to load event details. Please try again.');
            });
    }

    // Close modal when clicking outside
    document.getElementById('eventDetailsModal').addEventListener('click', function(e) {
        if (e.target === this) {
            this.classList.add('hidden');
        }
    });

    function applyFilters() {
        const eventType = document.getElementById('eventTypeFilter').value;
        const sort = document.getElementById('sortFilter').value;

        let url = new URL(window.location.href);

        // Update or remove event_type parameter
        if (eventType) {
            url.searchParams.set('event_type', eventType);
        } else {
            url.searchParams.delete('event_type');
        }

        // Update or remove sort parameter
        if (sort) {
            url.searchParams.set('sort', sort);
        } else {
            url.searchParams.delete('sort');
        }

        // Redirect to the new URL
        window.location.href = url.toString();
    }

    // Initialize filters from URL parameters
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);

        const eventType = urlParams.get('event_type');
        if (eventType) {
            document.getElementById('eventTypeFilter').value = eventType;
        }

        const sort = urlParams.get('sort');
        if (sort) {
            document.getElementById('sortFilter').value = sort;
        }
    });

    function showReschedModal(eventId) {
        const modal = document.getElementById('reschedModal');
        const form = document.getElementById('reschedForm');

        // Fetch current event details
        fetch(`/manager/events/${eventId}/details`)
            .then(response => response.json())
            .then(data => {
                const event = data.event;

                // Set default values for the form inputs
                document.querySelector('input[name="event_date"]').value = event.event_date;
                document.querySelector('input[name="start_time"]').value = event.start_time;
                document.querySelector('input[name="end_time"]').value = event.end_time;

                // Set the form action
                form.action = `/manager/events/${eventId}/reschedule`;

                // Show the modal
                modal.classList.remove('hidden');
            });
    }

    function closeReschedModal() {
        const modal = document.getElementById('reschedModal');
        modal.classList.add('hidden');
    }

    // Add this to your existing event listeners
    document.getElementById('reschedModal').addEventListener('click', function(e) {
        if (e.target === this) {
            this.classList.add('hidden');
        }
    });
</script>
</body>

</html>
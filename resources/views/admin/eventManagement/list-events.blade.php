<x-admin-layout title="Event Management" active-page="events">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Event Management</h1>
        <button onclick="openCreateEventModal()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            <span>Add Event</span>
        </button>
    </div>

    <!-- Success Notification -->
    <div id="eventSuccessNotification" class="hidden fixed top-4 right-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded z-50">
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span id="eventSuccessMessage"></span>
        </div>
    </div>

    <!-- Filter/Search -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <div class="flex flex-col md:flex-row md:items-end gap-4">
            <div>
                <label for="searchEventInput" class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                <input type="text" id="searchEventInput" placeholder="Search events..." class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>
            <div>
                <label for="typeEventFilter" class="block text-sm font-medium text-gray-700 mb-2">Filter by Type</label>
                <select id="typeEventFilter" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">All Types</option>
                    <option value="wedding">Wedding</option>
                    <option value="birthday">Birthday</option>
                    <option value="baptism">Baptism</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Events Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200" id="eventTableBody">
                @forelse($events as $event)
                    <tr data-name="{{ strtolower($event->name) }}" data-type="{{ strtolower($event->type) }}">
                        <td class="px-6 py-4 whitespace-nowrap">{{ $event->event_name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap capitalize">{{ $event->event_type }}</td>
                       <td class="px-6 py-4 whitespace-nowrap">{{ \Illuminate\Support\Carbon::parse($event->date)->format('Y-m-d') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <button onclick="openEditEventModal({{ $event->id }})" class="text-indigo-600 hover:underline mr-2">Edit</button>
                            <button onclick="deleteEvent({{ $event->id }}, '{{ $event->name }}')" class="text-red-600 hover:underline">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">No events found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">
            {{ $events->links() }}
        </div>
    </div>

    <!-- Create/Edit Event Modal -->
    <div id="eventModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-10 mx-auto p-5 border w-11/12 md:w-1/2 lg:w-1/3 shadow-lg rounded-md bg-white max-h-screen overflow-y-auto">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-900" id="eventModalTitle">Create Event</h3>
                <button onclick="closeEventModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form id="eventForm" class="space-y-6">
                @csrf
                <input type="hidden" id="eventId" name="event_id">
                <input type="hidden" id="event_method" name="_method" value="POST">
                <div>
                    <label for="eventName" class="block text-sm font-medium text-gray-700 mb-2">Event Name *</label>
                    <input type="text" id="eventName" name="event_name" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="e.g., John's Wedding">
                </div>
                <div>
                    <label for="eventType" class="block text-sm font-medium text-gray-700 mb-2">Event Type *</label>
                    <select id="eventType" name="event_type" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">Select Event Type</option>
                        <option value="wedding">Wedding</option>
                        <option value="birthday">Birthday</option>
                        <option value="baptism">Baptism</option>
                    </select>
                </div>
                <div>
                    <label for="packageType" class="block text-sm font-medium text-gray-700 mb-2">Package Type *</label>
                    <select id="packageType" name="package_type" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">Select Package</option>
                        @foreach($packages as $package)
                            <option value="{{ $package->name }}">{{ $package->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="eventDate" class="block text-sm font-medium text-gray-700 mb-2">Event Date *</label>
                    <input type="date" id="eventDate" name="event_date" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="startTime" class="block text-sm font-medium text-gray-700 mb-2">Start Time *</label>
                        <input type="time" id="startTime" name="start_time" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label for="endTime" class="block text-sm font-medium text-gray-700 mb-2">End Time *</label>
                        <input type="time" id="endTime" name="end_time" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>
                <div>
                    <label for="venueName" class="block text-sm font-medium text-gray-700 mb-2">Venue *</label>
                    <select id="venueName" name="venue_name" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">Select Venue</option>
                        @foreach($venues as $venue)
                            <option value="{{ $venue->name }}">{{ $venue->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="guestCount" class="block text-sm font-medium text-gray-700 mb-2">Estimated Guest Count *</label>
                    <input type="number" id="guestCount" name="guest_count" required min="1" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="e.g., 100">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Add-ons</label>
                    <div class="flex flex-wrap gap-2">
                        @foreach($addons as $addon)
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="addons[]" value="{{ $addon->id }}" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm">{{ $addon->display_name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                <div class="flex justify-end space-x-4 pt-4 border-t border-gray-200">
                    <button type="button" onclick="closeEventModal()" class="bg-gray-100 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-200 transition-colors">Cancel</button>
                    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition-colors">
                        <span id="eventSubmitButtonText">Create Event</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="eventDeleteModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mt-4">Delete Event</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500">
                        Are you sure you want to delete "<span id="eventDeleteName"></span>"? This action cannot be undone.
                    </p>
                </div>
                <div class="flex justify-center space-x-4 mt-4">
                    <button onclick="closeEventDeleteModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors">Cancel</button>
                    <button onclick="confirmEventDelete()" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors">Delete</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        let eventToDelete = null;
        let isEventEditMode = false;

        // Filter/search functionality
        document.getElementById('searchEventInput').addEventListener('input', filterEvents);
        document.getElementById('typeEventFilter').addEventListener('change', filterEvents);

        function filterEvents() {
            const searchTerm = document.getElementById('searchEventInput').value.toLowerCase();
            const typeFilter = document.getElementById('typeEventFilter').value;
            const rows = document.querySelectorAll('#eventTableBody tr');
            rows.forEach(row => {
                const name = row.dataset.name;
                const type = row.dataset.type;
                const nameMatch = !searchTerm || name.includes(searchTerm);
                const typeMatch = !typeFilter || type === typeFilter;
                row.style.display = (nameMatch && typeMatch) ? '' : 'none';
            });
        }

        // Success notification
        function showEventSuccessNotification(message) {
            const notification = document.getElementById('eventSuccessNotification');
            const messageElement = document.getElementById('eventSuccessMessage');
            messageElement.textContent = message;
            notification.classList.remove('hidden');
            setTimeout(() => {
                notification.classList.add('hidden');
            }, 3000);
        }

        // Event Modal Functions
        function openCreateEventModal() {
            isEventEditMode = false;
            document.getElementById('eventModalTitle').textContent = 'Create Event';
            document.getElementById('eventSubmitButtonText').textContent = 'Create Event';
            document.getElementById('event_method').value = 'POST';
            document.getElementById('eventForm').action = '/admin/events';
            document.getElementById('eventForm').reset();
            document.getElementById('eventId').value = '';
            document.getElementById('eventModal').classList.remove('hidden');
        }

        function openEditEventModal(eventId) {
            isEventEditMode = true;
            document.getElementById('eventModalTitle').textContent = 'Edit Event';
            document.getElementById('eventSubmitButtonText').textContent = 'Update Event';
            document.getElementById('event_method').value = 'PUT';
            document.getElementById('eventForm').action = `/admin/events/${eventId}`;
            document.getElementById('eventId').value = eventId;
            // Load event data
            fetch(`/admin/events/${eventId}/edit`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const event = data.event;
                        document.getElementById('eventName').value = event.name;
                        document.getElementById('eventType').value = event.type;
                        document.getElementById('eventDate').value = event.date;
                        document.getElementById('eventModal').classList.remove('hidden');
                    } else {
                        alert('Failed to load event data');
                    }
                })
                .catch(error => {
                    alert('Failed to load event data');
                });
        }

        function closeEventModal() {
            document.getElementById('eventModal').classList.add('hidden');
            isEventEditMode = false;
        }

        // Event form submission
        document.getElementById('eventForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            let url = this.action;
            fetch(url, {
                method: 'POST', // Always use POST
                body: formData,
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    closeEventModal();
                    showEventSuccessNotification(data.message);
                    setTimeout(() => { window.location.reload(); }, 1000);
                } else {
                    alert(data.message || 'Failed to save event');
                }
            })
            .catch(error => {
                alert('Failed to save event. Please check your input and try again.');
            });
        });

        // Delete event
        function deleteEvent(eventId, eventName) {
            eventToDelete = eventId;
            document.getElementById('eventDeleteName').textContent = eventName;
            document.getElementById('eventDeleteModal').classList.remove('hidden');
        }
        function closeEventDeleteModal() {
            document.getElementById('eventDeleteModal').classList.add('hidden');
            eventToDelete = null;
        }
        function confirmEventDelete() {
            if (eventToDelete) {
                fetch(`/admin/events/${eventToDelete}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    closeEventDeleteModal();
                    if (data.success) {
                        showEventSuccessNotification(data.message);
                        setTimeout(() => { window.location.reload(); }, 1000);
                    } else {
                        alert(data.message || 'Failed to delete event');
                    }
                })
                .catch(error => {
                    alert('Failed to delete event. Please try again.');
                });
            }
        }

        // Close modals when clicking outside
        window.addEventListener('click', function(e) {
            const eventModal = document.getElementById('eventModal');
            const eventDeleteModal = document.getElementById('eventDeleteModal');
            if (e.target === eventModal) {
                closeEventModal();
            }
            if (e.target === eventDeleteModal) {
                closeEventDeleteModal();
            }
        });
        // Close modals with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeEventModal();
                closeEventDeleteModal();
            }
        });
    </script>
    @endpush
</x-admin-layout> 
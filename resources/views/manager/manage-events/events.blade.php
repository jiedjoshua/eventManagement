<x-manager-layout title="Events" :active-page="'events'">
@push('styles')
  <style>
    /* Dropdown panel style */
    .dropdown-panel {
      position: absolute;
      background: white;
      border: 1px solid #cbd5e0;
      /* Tailwind gray-300 */
      border-radius: 0.25rem;
      box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
      z-index: 10;
      padding: 0.5rem;
      width: 200px;
    }
  </style>
@endpush

    <h1 class="text-3xl font-bold mb-6">Events</h1>

    <!-- Search -->
    <div class="mb-4">
      <input type="text" placeholder="Search events..." class="w-full px-4 py-2 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-400" />
    </div>

    <table class="min-w-full border border-gray-300 bg-white rounded">
  <thead class="bg-gray-50">
    <tr>
      <th class="px-6 py-3 border-b border-gray-200 text-left text-sm font-medium text-gray-700">Event Name</th>

      <!-- Date & Time with dropdown -->
      <th class="relative px-6 py-3 border-b border-gray-200 text-left text-sm font-medium text-gray-700">
        <button type="button"
          class="inline-flex items-center space-x-1 focus:outline-none"
          aria-haspopup="true" aria-expanded="false" aria-controls="dateTimeDropdown"
          id="dateTimeToggle">
          <span>Date & Time</span>
          <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
          </svg>
        </button>

        <div id="dateTimeDropdown" class="dropdown-panel hidden mt-2" role="menu" aria-labelledby="dateTimeToggle">
          <label class="block text-xs font-semibold mb-1">Date</label>
          <input type="date" class="w-full border border-gray-300 rounded px-2 py-1 mb-3" />

          <label class="block text-xs font-semibold mb-1">Time</label>
          <input type="time" class="w-full border border-gray-300 rounded px-2 py-1" />
        </div>
      </th>

      <!-- Venue with dropdown -->
      <th class="relative px-6 py-3 border-b border-gray-200 text-left text-sm font-medium text-gray-700">
        <button type="button"
          class="inline-flex items-center space-x-1 focus:outline-none"
          aria-haspopup="true" aria-expanded="false" aria-controls="venueDropdown"
          id="venueToggle">
          <span>Venue</span>
          <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
          </svg>
        </button>

        <div id="venueDropdown" class="dropdown-panel hidden mt-2" role="menu" aria-labelledby="venueToggle">
          <select class="w-full border border-gray-300 rounded px-2 py-1">
            <option value="">All Venues</option>
            <option>Venue A</option>
            <option>Venue B</option>
            <option>Venue C</option>
          </select>
        </div>
      </th>

      <!-- Event Type with dropdown -->
      <th class="relative px-6 py-3 border-b border-gray-200 text-left text-sm font-medium text-gray-700">
        <button type="button"
          class="inline-flex items-center space-x-1 focus:outline-none"
          aria-haspopup="true" aria-expanded="false" aria-controls="typeDropdown"
          id="typeToggle">
          <span>Event Type</span>
          <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
          </svg>
        </button>

        <div id="typeDropdown" class="dropdown-panel hidden mt-2" role="menu" aria-labelledby="typeToggle">
          <select class="w-full border border-gray-300 rounded px-2 py-1">
            <option value="">All Types</option>
            <option>Birthday</option>
            <option>Wedding</option>
            <option>Conference</option>
          </select>
        </div>
      </th>

      <!-- Payment Status with dropdown -->
      <th class="relative px-6 py-3 border-b border-gray-200 text-left text-sm font-medium text-gray-700">
        <button type="button"
          class="inline-flex items-center space-x-1 focus:outline-none"
          aria-haspopup="true" aria-expanded="false" aria-controls="paymentDropdown"
          id="paymentToggle">
          <span>Payment Status</span>
          <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
          </svg>
        </button>

        <div id="paymentDropdown" class="dropdown-panel hidden mt-2" role="menu" aria-labelledby="paymentToggle">
          <select class="w-full border border-gray-300 rounded px-2 py-1">
            <option value="">All Payments</option>
            <option value="paid">Full Payment</option>
            <option value="partial">20% Downpayment</option>
            <option value="pending">No Payment</option>
          </select>
        </div>
      </th>

      <!-- Status with dropdown -->
      <th class="relative px-6 py-3 border-b border-gray-200 text-left text-sm font-medium text-gray-700">
        <button type="button"
          class="inline-flex items-center space-x-1 focus:outline-none"
          aria-haspopup="true" aria-expanded="false" aria-controls="statusDropdown"
          id="statusToggle">
          <span>Status</span>
          <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
          </svg>
        </button>

        <div id="statusDropdown" class="dropdown-panel hidden mt-2" role="menu" aria-labelledby="statusToggle">
          <select class="w-full border border-gray-300 rounded px-2 py-1">
            <option value="">All Status</option>
            <option>Confirmed</option>
            <option>Pending</option>
            <option>Cancelled</option>
          </select>
        </div>
      </th>

      <th class="px-6 py-3 border-b border-gray-200 text-left text-sm font-medium text-gray-700">Actions</th>
    </tr>
  </thead>

  <tbody>
    @forelse ($events as $event)
    <tr class="border-b border-gray-200 hover:bg-gray-50">
      <td class="px-6 py-4 text-sm text-gray-900">{{ ucwords($event->event_name) }}</td>
      <td class="px-6 py-4 text-sm text-gray-900">{{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }} {{ $event->start_time }}</td>
      <td class="px-6 py-4 text-sm text-gray-900">{{ $event->venue_name }}</td>
      <td class="px-6 py-4 text-sm text-gray-900">{{ ucwords($event->event_type) }}</td>
      
      <!-- Payment Status Column -->
      <td class="px-6 py-4 text-sm">
        @if($event->booking && $event->booking->payment_status === 'paid')
          <span class="inline-block px-2 py-1 text-xs font-semibold text-green-800 bg-green-200 rounded">Full Payment</span>
        @elseif($event->booking && $event->booking->payment_status === 'partial')
          <span class="inline-block px-2 py-1 text-xs font-semibold text-blue-800 bg-blue-200 rounded">20% Downpayment</span>
        @elseif($event->booking && $event->booking->payment_status === 'pending')
          <span class="inline-block px-2 py-1 text-xs font-semibold text-red-800 bg-red-200 rounded">No Payment</span>
        @else
          <span class="inline-block px-2 py-1 text-xs font-semibold text-gray-800 bg-gray-200 rounded">N/A</span>
        @endif
      </td>
      
      <td class="px-6 py-4 text-sm 
      @if($event->status == 'Confirmed') text-green-600 font-semibold
      @elseif($event->status == 'Pending') text-yellow-600 font-semibold
      @elseif($event->status == 'Cancelled') text-red-600 font-semibold
      @else text-gray-900
      @endif">
        {{ $event->status }}
      </td>
      <td class="px-6 py-4 text-sm text-gray-900">
        <button onclick="viewEvent({{ $event->id }})" class="text-indigo-600 hover:text-indigo-900 mr-2">View</button>
        <button onclick="editEvent({{ $event->id }})" class="text-indigo-600 hover:text-indigo-900 mr-2">Edit</button>
        <button onclick="deleteEvent({{ $event->id }})" class="text-red-600 hover:text-red-900">Delete</button>
      </td>
    </tr>
    @empty
    <tr>
      <td colspan="7" class="text-center py-4 text-gray-500">No events found.</td>
    </tr>
    @endforelse
  </tbody>
</table>

<!-- View Event Modal -->
<div id="viewEventModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold text-gray-900">Event Details</h3>
            <button onclick="closeViewModal()" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div id="viewEventDetails" class="space-y-4">
            <!-- Event details will be loaded here -->
        </div>
    </div>
</div>

<!-- Edit Event Modal -->
<div id="editEventModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold text-gray-900">Edit Event</h3>
            <button onclick="closeEditModal()" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <form id="editEventForm" class="space-y-4">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Event Name</label>
                    <input type="text" id="edit_event_name" name="event_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Event Type</label>
                    <select id="edit_event_type" name="event_type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                        <option value="wedding">Wedding</option>
                        <option value="birthday">Birthday</option>
                        <option value="baptism">Baptism</option>
                        <option value="debut">Debut</option>
                        <option value="corporate">Corporate</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Event Date</label>
                    <input type="date" id="edit_event_date" name="event_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Start Time</label>
                    <input type="time" id="edit_start_time" name="start_time" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">End Time</label>
                    <input type="time" id="edit_end_time" name="end_time" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Guest Count</label>
                    <input type="number" id="edit_guest_count" name="guest_count" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Venue Name</label>
                <select id="edit_venue_name" name="venue_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    <option value="">Select a venue</option>
                    @foreach($venues as $venue)
                        <option value="{{ $venue->name }}">{{ $venue->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                    Update Event
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteEventModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold text-red-600">Delete Event</h3>
            <button onclick="closeDeleteModal()" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="mb-4">
            <p class="text-gray-700">Are you sure you want to delete this event?</p>
            <p class="text-sm text-gray-500 mt-2">This action cannot be undone.</p>
        </div>
        <div class="flex justify-end space-x-3">
            <button onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                Cancel
            </button>
            <button onclick="confirmDeleteEvent()" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                Delete
            </button>
        </div>
    </div>
</div>

<!-- Success Notification Modal -->
<div id="successModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="flex items-center justify-center mb-4">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
        </div>
        <div class="text-center">
            <h3 class="text-lg font-medium text-gray-900 mb-2">Success!</h3>
            <p id="successMessage" class="text-sm text-gray-500 mb-4"></p>
            <button onclick="closeSuccessModal()" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                OK
            </button>
        </div>
    </div>
</div>

<!-- Error Notification Modal -->
<div id="errorModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="flex items-center justify-center mb-4">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
        </div>
        <div class="text-center">
            <h3 class="text-lg font-medium text-gray-900 mb-2">Error!</h3>
            <p id="errorMessage" class="text-sm text-gray-500 mb-4"></p>
            <button onclick="closeErrorModal()" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                OK
            </button>
        </div>
    </div>
</div>
 

@push('scripts')
 <script>
  let currentEventId = null;

  function setupDropdown(toggleId, dropdownId) {
    const toggleBtn = document.getElementById(toggleId);
    const dropdown = document.getElementById(dropdownId);

    toggleBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      const isOpen = dropdown.classList.contains('hidden') === false;
      closeAllDropdowns();
      if (!isOpen) {
        dropdown.classList.remove('hidden');
        toggleBtn.setAttribute('aria-expanded', 'true');
      } else {
        dropdown.classList.add('hidden');
        toggleBtn.setAttribute('aria-expanded', 'false');
      }
    });
  }

  function closeAllDropdowns() {
    document.querySelectorAll('.dropdown-panel').forEach(panel => panel.classList.add('hidden'));
    document.querySelectorAll('button[aria-expanded]').forEach(btn => btn.setAttribute('aria-expanded', 'false'));
  }

  // Close dropdowns when clicking outside
  document.addEventListener('click', (e) => {
    if (!e.target.closest('.dropdown-panel') && !e.target.closest('[id$="Toggle"]')) {
      closeAllDropdowns();
    }
  });

  // Close dropdowns when pressing Escape key
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      closeAllDropdowns();
    }
  });

  // Setup dropdowns
  setupDropdown('dateTimeToggle', 'dateTimeDropdown');
  setupDropdown('venueToggle', 'venueDropdown');
  setupDropdown('typeToggle', 'typeDropdown');
  setupDropdown('paymentToggle', 'paymentDropdown'); 
  setupDropdown('statusToggle', 'statusDropdown');

  // View Event Function
  function viewEvent(eventId) {
    fetch(`/manager/events/${eventId}/details`)
      .then(response => response.json())
      .then(data => {
        const event = data.event;
        const detailsContainer = document.getElementById('viewEventDetails');
        
        detailsContainer.innerHTML = `
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <h4 class="font-semibold text-gray-900">Event Information</h4>
              <p><strong>Name:</strong> ${event.event_name}</p>
              <p><strong>Type:</strong> ${event.event_type}</p>
              <p><strong>Date:</strong> ${event.event_date}</p>
              <p><strong>Time:</strong> ${event.start_time} - ${event.end_time}</p>
            </div>
            <div>
              <h4 class="font-semibold text-gray-900">Venue & Guests</h4>
              <p><strong>Venue:</strong> ${event.venue_name}</p>
              <p><strong>Guest Count:</strong> ${event.guest_count}</p>
              <p><strong>Package:</strong> ${event.package_type}</p>
              <p><strong>Status:</strong> ${event.status}</p>
            </div>
          </div>
          <div class="mt-4">
            <h4 class="font-semibold text-gray-900">Contact Person</h4>
            <p><strong>Name:</strong> ${event.contact_person.name}</p>
            <p><strong>Email:</strong> ${event.contact_person.email}</p>
            <p><strong>Phone:</strong> ${event.contact_person.phone}</p>
          </div>
        `;
        
        document.getElementById('viewEventModal').classList.remove('hidden');
      })
      .catch(error => {
        console.error('Error:', error);
        showError('Error loading event details');
      });
  }

  // Edit Event Function
  function editEvent(eventId) {
    currentEventId = eventId;
    
    fetch(`/manager/events/${eventId}/details`)
      .then(response => response.json())
      .then(data => {
        const event = data.event;
        
        document.getElementById('edit_event_name').value = event.event_name;
        document.getElementById('edit_event_type').value = event.event_type;
        document.getElementById('edit_event_date').value = event.event_date;
        document.getElementById('edit_start_time').value = event.start_time;
        document.getElementById('edit_end_time').value = event.end_time;
        document.getElementById('edit_guest_count').value = event.guest_count;
        
        // Set the selected venue in the dropdown
        const venueSelect = document.getElementById('edit_venue_name');
        venueSelect.value = event.venue_name;
        
        document.getElementById('editEventModal').classList.remove('hidden');
      })
      .catch(error => {
        console.error('Error:', error);
        showError('Error loading event details');
      });
  }

  // Delete Event Function
  function deleteEvent(eventId) {
    currentEventId = eventId;
    document.getElementById('deleteEventModal').classList.remove('hidden');
  }

  // Close Modal Functions
  function closeViewModal() {
    document.getElementById('viewEventModal').classList.add('hidden');
  }

  function closeEditModal() {
    document.getElementById('editEventModal').classList.add('hidden');
    currentEventId = null;
  }

  function closeDeleteModal() {
    document.getElementById('deleteEventModal').classList.add('hidden');
    currentEventId = null;
  }

  function closeSuccessModal() {
    document.getElementById('successModal').classList.add('hidden');
  }

  function closeErrorModal() {
    document.getElementById('errorModal').classList.add('hidden');
  }

  // Show notification functions
  function showSuccess(message) {
    document.getElementById('successMessage').textContent = message;
    document.getElementById('successModal').classList.remove('hidden');
  }

  function showError(message) {
    document.getElementById('errorMessage').textContent = message;
    document.getElementById('errorModal').classList.remove('hidden');
  }

  // Confirm Delete Function
  function confirmDeleteEvent() {
    if (!currentEventId) return;
    
    fetch(`/manager/events/${currentEventId}`, {
      method: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        'Content-Type': 'application/json',
      },
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        closeDeleteModal();
        showSuccess(data.message || 'Event deleted successfully!');
        setTimeout(() => {
          location.reload(); // Refresh the page to show updated data
        }, 1500);
      } else {
        showError(data.message || 'Error deleting event');
      }
    })
    .catch(error => {
      console.error('Error:', error);
      showError('Error deleting event');
    });
  }

  // Handle Edit Form Submission
  document.getElementById('editEventForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    if (!currentEventId) return;
    
    const formData = new FormData(this);
    
    fetch(`/manager/events/${currentEventId}`, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      },
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        closeEditModal();
        showSuccess(data.message || 'Event updated successfully!');
        setTimeout(() => {
          location.reload(); // Refresh the page to show updated data
        }, 1500);
      } else {
        showError(data.message || 'Error updating event');
      }
    })
    .catch(error => {
      console.error('Error:', error);
      showError('Error updating event');
    });
  });
</script>
@endpush
</x-manager-layout>
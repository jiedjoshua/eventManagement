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
      <td class="px-6 py-4 text-sm text-gray-900">{{ $event->event_name }}</td>
      <td class="px-6 py-4 text-sm text-gray-900">{{ $event->event_date }} {{ $event->start_time }}</td>
      <td class="px-6 py-4 text-sm text-gray-900">{{ $event->venue_name }}</td>
      <td class="px-6 py-4 text-sm text-gray-900">{{ $event->event_type }}</td>
      
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
        <a href="{{ route('events.dashboard', $event->id) }}" class="text-indigo-600 hover:underline mr-2">View</a>
        <button class="text-indigo-600 hover:text-indigo-900">Edit</button>
        <button class="text-red-600 hover:text-red-900 ml-4">Delete</button>
      </td>
    </tr>
    @empty
    <tr>
      <td colspan="7" class="text-center py-4 text-gray-500">No events found.</td>
    </tr>
    @endforelse
  </tbody>
</table>
 

@push('scripts')
 <script>
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
</script>
@endpush
</x-manager-layout>
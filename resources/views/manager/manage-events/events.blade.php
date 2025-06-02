<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Event Dashboard with Sidebar and Filters</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    /* Dropdown panel style */
    .dropdown-panel {
      position: absolute;
      background: white;
      border: 1px solid #cbd5e0; /* Tailwind gray-300 */
      border-radius: 0.25rem;
      box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
      z-index: 10;
      padding: 0.5rem;
      width: 200px;
    }
  </style>
</head>
<body class="flex h-screen bg-gray-100">

  <!-- Sidebar -->
  <aside class="w-64 bg-white shadow-md flex flex-col">
    <div class="p-6 text-2xl font-bold text-indigo-600">Event Panel</div>
    <nav class="flex-1 px-4 space-y-2 text-sm text-gray-700">

      <div>
        <p class="font-semibold text-gray-900">Home</p>
        <a href="{{ route('manager.dashboard') }} " class="block pl-4 py-2 hover:bg-indigo-100 rounded">Dashboard</a>
      </div>

      <div>
        <p class="mt-4 font-semibold text-gray-900">Manage Events</p>
        <a href="{{ route('manager.showEvent') }}" class="block pl-4 py-2 rounded bg-indigo-200 font-semibold text-indigo-800">Events</a>
        <a href="#" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Upcoming Events</a>
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
    <button type="submit" class="block text-red-600 font-semibold hover:underline">
      Logout
    </button>
  </form>
</div>
  </aside>

  <!-- Main Content -->
  <main class="flex-1 p-10 overflow-auto">
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
              id="dateTimeToggle"
            >
              <span>Date & Time</span>
              <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
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
              id="venueToggle"
            >
              <span>Venue</span>
              <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
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
              id="typeToggle"
            >
              <span>Event Type</span>
              <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
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

          <!-- Status with dropdown -->
          <th class="relative px-6 py-3 border-b border-gray-200 text-left text-sm font-medium text-gray-700">
            <button type="button" 
              class="inline-flex items-center space-x-1 focus:outline-none"
              aria-haspopup="true" aria-expanded="false" aria-controls="statusDropdown"
              id="statusToggle"
            >
              <span>Status</span>
              <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
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
        <tr class="border-b border-gray-200 hover:bg-gray-50">
          <td class="px-6 py-4 text-sm text-gray-900">Summer Gala</td>
          <td class="px-6 py-4 text-sm text-gray-900">2025-06-15 18:00</td>
          <td class="px-6 py-4 text-sm text-gray-900">Grand Hall</td>
          <td class="px-6 py-4 text-sm text-gray-900">Conference</td>
          <td class="px-6 py-4 text-sm text-green-600 font-semibold">Confirmed</td>
          <td class="px-6 py-4 text-sm text-gray-900">
             <button class="text-indigo-600 hover:underline mr-2">View</button>
            <button class="text-indigo-600 hover:text-indigo-900">Edit</button>
            <button class="text-red-600 hover:text-red-900 ml-4">Delete</button>
          </td>
        </tr>
        <!-- More rows here -->
      </tbody>
    </table>
  </main>

  <script>
    // Function to toggle dropdown visibility and manage aria-expanded attribute
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

    

    // Setup dropdowns
    setupDropdown('dateTimeToggle', 'dateTimeDropdown');
    setupDropdown('venueToggle', 'venueDropdown');
    setupDropdown('typeToggle', 'typeDropdown');
    setupDropdown('statusToggle', 'statusDropdown');
  </script>

</body>
</html>

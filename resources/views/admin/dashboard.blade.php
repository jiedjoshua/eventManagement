<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Event Management Sidebar</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex h-screen bg-gray-100">

  <!-- Sidebar -->
  <aside class="w-64 bg-white shadow-md flex flex-col">
    <div class="p-6 text-2xl font-bold text-indigo-600">Admin Panel</div>
    <nav class="flex-1 px-4 space-y-2 text-sm text-gray-700">
      <!-- Menu -->
      <div>
        <p class="font-semibold text-gray-900">Home</p>
        <a href="#" class="block pl-4 py-2 rounded bg-indigo-200 font-semibold text-indigo-800">Dashboard</a>
      </div>

      <div>
        <p class="mt-4 font-semibold text-gray-900">User Management</p>
        <a href="#" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Users</a>
        <a href="#" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Create User</a>
      </div>

      <div>
        <p class="mt-4 font-semibold text-gray-900">Event Management</p>
        <a href="#" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Events</a>
        <a href="#" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Create Event</a>
      </div>

      <div>
        <p class="mt-4 font-semibold text-gray-900">Venue Management</p>
        <a href="#" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Venues</a>
        <a href="#" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Add Venue</a>
      </div>

      <div>
        <p class="mt-4 font-semibold text-gray-900">Event Package Management</p>
        <a href="#" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Wedding</a>
        <a href="#" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Birthday</a>
         <a href="#" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Baptism</a>
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
    <h1 class="text-3xl font-bold mb-8">Dashboard</h1>

    <!-- Cards Row -->
    <div class="flex flex-wrap gap-6 mb-10">
      <!-- Card Template -->
      <div class="w-72 h-28 bg-white rounded-lg shadow-md flex items-center p-5 space-x-5">
        <div class="w-20 h-20 bg-indigo-600 rounded-md flex items-center justify-center text-white text-2xl">
          <!-- Icon -->
          <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10m-12 4h14a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v10a2 2 0 002 2z" />
          </svg>
        </div>
        <div class="flex flex-col justify-center">
          <span class="text-3xl font-bold text-gray-900">27</span>
          <span class="text-gray-500 uppercase tracking-wide mt-1 text-xs">Upcoming Events</span>
        </div>
      </div>

      <!-- Duplicate & change text for other cards -->
      <div class="w-72 h-28 bg-white rounded-lg shadow-md flex items-center p-5 space-x-5">
        <div class="w-20 h-20 bg-indigo-600 rounded-md flex items-center justify-center text-white text-2xl">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
          </svg>
        </div>
        <div class="flex flex-col justify-center">
          <span class="text-3xl font-bold text-gray-900">15</span>
          <span class="text-gray-500 uppercase tracking-wide mt-1 text-xs">Confirmed Bookings</span>
        </div>
      </div>

      <div class="w-72 h-28 bg-white rounded-lg shadow-md flex items-center p-5 space-x-5">
        <div class="w-20 h-20 bg-indigo-600 rounded-md flex items-center justify-center text-white text-2xl">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-6h6v6m2 4H7a2 2 0 01-2-2V5a2 2 0 012-2h10a2 2 0 012 2v14a2 2 0 01-2 2z" />
          </svg>
        </div>
        <div class="flex flex-col justify-center">
          <span class="text-3xl font-bold text-gray-900">8</span>
          <span class="text-gray-500 uppercase tracking-wide mt-1 text-xs">Past Events</span>
        </div>
      </div>

      <div class="w-72 h-28 bg-white rounded-lg shadow-md flex items-center p-5 space-x-5">
        <div class="w-20 h-20 bg-indigo-600 rounded-md flex items-center justify-center text-white text-2xl">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z" />
          </svg>
        </div>
        <div class="flex flex-col justify-center">
          <span class="text-3xl font-bold text-gray-900">42</span>
          <span class="text-gray-500 uppercase tracking-wide mt-1 text-xs">Total Guests</span>
        </div>
      </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <!-- Chart Card 1 -->
      <div class="bg-white rounded-lg shadow-md p-6 h-96 flex flex-col">
        <h2 class="text-xl font-semibold mb-4">Event Attendance Overview</h2>
        <div class="flex-grow bg-gray-100 flex items-center justify-center text-gray-400 rounded">
            Chart Placeholder
        </div>
    </div>


      <!-- Chart Card 2 -->
      <div class="bg-white rounded-lg shadow-md p-6 h-96 flex flex-col">
        <h2 class="text-xl font-semibold mb-4">Event Attendance Overview</h2>
        <div class="flex-grow bg-gray-100 flex items-center justify-center text-gray-400 rounded">
            Chart Placeholder
        </div>
    </div>
 
  </main>
</body>
</html>
 
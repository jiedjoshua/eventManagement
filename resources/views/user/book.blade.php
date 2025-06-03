<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Booked Events with Sidebar</title>
  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen flex">

  <!-- Sidebar -->
  <aside class="w-64 bg-white shadow-md flex flex-col">
    <div class="p-6 text-2xl font-bold text-indigo-600">Event Panel</div>
    <nav class="flex-1 px-4 space-y-2 text-sm text-gray-700 overflow-y-auto">
      <!-- Menu -->
      <div>
        <p class="font-semibold text-gray-900">Home</p>
        <a href="{{ route('user.dashboard') }}" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Dashboard</a>
      </div>

      <div>
        <p class="mt-4 font-semibold text-gray-900">My Events</p>
        <a href="{{ route('user.bookedEvents') }}" class="block pl-4 py-2 rounded bg-indigo-200 font-semibold text-indigo-800">Booked Events</a>
        <a href="#" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Attending Events</a>
        <a href="#" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Guest List</a>
      </div>

      <div>
        <p class="mt-4 font-semibold text-gray-900">Settings</p>
        <a href="#" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Account Settings</a>
      </div>
    </nav>

   
 <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
  </aside>

  <!-- Main content -->
  <main class="flex-1 p-6 overflow-y-auto">
    <header class="mb-8">
      <h1 class="text-3xl font-bold text-gray-800">My Events - Booked Events</h1>
      <p class="text-gray-600 mt-2">Manage the events you are hosting or have booked.</p>
    </header>

   <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">

@isset($bookedEvents)
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
    @forelse ($bookedEvents as $event)
      @php
        // Set default status because Event model has no 'status' field
        $status = $event->status ?? 'Pending';  // or whatever default you want
        $statusColors = [
          'Pending' => 'bg-yellow-100 text-yellow-800',
          'Approved' => 'bg-green-100 text-green-800',
          'Cancelled' => 'bg-red-100 text-red-800',
        ];
        $statusClass = $statusColors[$status] ?? 'bg-gray-100 text-gray-800';
      @endphp

      <div class="bg-white rounded-lg shadow-md p-5 flex flex-col justify-between">
        <div>
          <h3 class="text-xl font-bold mb-1">{{ $event->event_name }}</h3>
          <p class="text-gray-600 mb-1"><strong>Type:</strong> {{ $event->event_type }}</p>
          <p class="text-gray-600 mb-1">
            <strong>Date:</strong> {{ \Carbon\Carbon::parse($event->event_date)->format('F d, Y') }}, 
            {{ \Carbon\Carbon::parse($event->start_time)->format('g:i A') }}
          </p>
          <p class="text-gray-600 mb-2"><strong>Location:</strong> {{ $event->venue_name }}</p>

          <span class="inline-block px-3 py-1 text-sm font-medium rounded-full {{ $statusClass }}">
            {{ $status }}
          </span>
        </div>

        <div class="mt-4 flex flex-wrap gap-2">
          <button type="button" class="flex-1 bg-blue-600 text-white text-sm py-2 rounded hover:bg-blue-700 transition">
            View Details
          </button>
          <button type="button" class="flex-1 bg-green-600 text-white text-sm py-2 rounded hover:bg-green-700 transition">
            Edit Booking
          </button>
          <button type="button" class="flex-1 bg-purple-600 text-white text-sm py-2 rounded hover:bg-purple-700 transition">
            Guest List
          </button>
          <button type="button" class="flex-1 bg-indigo-600 text-white text-sm py-2 rounded hover:bg-indigo-700 transition">
            QR / Invitations
          </button>
        </div>
      </div>
    @empty
      <p class="text-gray-600 col-span-full">You have no booked events at the moment.</p>
    @endforelse
  </div>
@endisset



    </div>
  </main>

</body>
</html>

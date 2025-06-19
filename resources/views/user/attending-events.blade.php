<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Attending Events</title>
  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="bg-gray-50 min-h-screen flex">

  <!-- Sidebar -->
  <aside class="w-64 bg-white shadow-md flex flex-col">
    <div class="p-6 text-2xl font-bold text-indigo-600">Customer Panel</div>
    <nav class="flex-1 px-4 space-y-2 text-sm text-gray-700 overflow-y-auto">
      <div>
        <p class="font-semibold text-gray-900">Home</p>
        <a href="{{ route('user.dashboard') }}" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Dashboard</a>
      </div>

      <div>
        <p class="mt-4 font-semibold text-gray-900">My Events</p>
        <a href="{{ route('user.bookedEvents') }}" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Booked Events</a>
        <a href="{{ route('user.attendingEvents') }}" class="block pl-4 py-2 bg-indigo-200 text-indigo-800 font-semibold rounded">Attending Events</a>
        <a href="#" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Guest List</a>
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

  <!-- Main content -->
  <main class="flex-1 p-6 overflow-y-auto">
    <header class="mb-8">
      <h1 class="text-3xl font-bold text-gray-800">My Events - Attending</h1>
      <p class="text-gray-600 mt-2">Here are the events you accepted invitations to.</p>
    </header>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
      @forelse ($acceptedEvents as $event)
        <div class="bg-white rounded-lg shadow-md p-5 flex flex-col justify-between">
          <div>
            <h3 class="text-xl font-bold mb-1">{{ $event->event_name }}</h3>
            <p class="text-gray-600 mb-1"><strong>Type:</strong> {{ $event->event_type }}</p>
            <p class="text-gray-600 mb-1">
              <strong>Date:</strong> {{ \Carbon\Carbon::parse($event->event_date)->format('F d, Y') }},
              {{ \Carbon\Carbon::parse($event->start_time)->format('g:i A') }}
            </p>
            <p class="text-gray-600 mb-2"><strong>Location:</strong> {{ $event->venue_name }}</p>

            <span class="inline-block px-3 py-1 text-sm font-medium rounded-full bg-green-100 text-green-800">
              Accepted
            </span>
          </div>

          <div class="mt-4 flex flex-wrap gap-2">
            <a href="{{ url('/invite/' . $event->id) }}" 
               class="flex-1 bg-indigo-600 text-white text-sm py-2 text-center rounded hover:bg-indigo-700 transition">
              View QR Code
            </a>
          </div>
        </div>
      @empty
        <p class="text-gray-600 col-span-full">You are not attending any events yet.</p>
      @endforelse
    </div>
  </main>

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Generate External QR Codes</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex h-screen bg-gray-100">

<!-- Sidebar -->
  <aside class="w-64 bg-white shadow-md flex flex-col">
    <div class="p-6 text-2xl font-bold text-indigo-600">Manager Panel</div>
    <nav class="flex-1 px-4 space-y-2 text-sm text-gray-700">
      <!-- Menu -->
      <div>
        <p class="font-semibold text-gray-900">Home</p>
        <a href="{{ route('manager.dashboard') }} " class="block pl-4 py-2 hover:bg-indigo-100 rounded">Dashboard</a>
      </div>

      <div>
        <p class="mt-4 font-semibold text-gray-900">Manage Events</p>
        <a href="{{ route('manager.showEvent') }}" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Events</a>
         <a href="{{ route('manager.bookedEvents') }}" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Booked Events</a>
        <a href="{{ route('manager.upcomingEvents') }}" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Upcoming Events</a>
        <a href="#" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Create Event</a>
      </div>

      <div>
        <p class="mt-4 font-semibold text-gray-900">RSVP Management</p>
        <a href="{{ route('manager.guestLists') }}" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Guest Lists</a>
        <a href="{{ route('manager.showGenerateExternalQRCodes') }}" class="block pl-4 py-2 rounded bg-indigo-200 font-semibold text-indigo-800">Generate QR Codes</a>
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
    <h1 class="text-3xl font-bold mb-8">Generate QR Codes for Physical Invitations</h1>

    <div class="max-w-xl mx-auto bg-white rounded-lg shadow-md p-8">
      <form method="POST" action="{{ route('manager.generateExternalQRCodes') }}">
        @csrf

        <!-- 1. Choose Event -->
        <div class="mb-6">
          <label class="block text-gray-700 font-semibold mb-2">Select Event</label>
          <select name="event_id" required class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400">
            <option value="">-- Choose an event --</option>
            @foreach($events as $event)
              <option value="{{ $event->id }}">
                {{ $event->event_name }} ({{ \Carbon\Carbon::parse($event->event_date)->format('F d, Y') }})
              </option>
            @endforeach
          </select>
        </div>

        <!-- 2. Quantity -->
        <div class="mb-6">
          <label class="block text-gray-700 font-semibold mb-2">Number of QR Codes</label>
          <input type="number" name="quantity" min="1" max="500" value="1"
                 class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400" required>
        </div>

        <!-- 3. Download Button -->
        <div class="flex justify-end">
          <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
            Download ZIP
          </button>
        </div>
      </form>
    </div>
  </main>
</body>
</html>
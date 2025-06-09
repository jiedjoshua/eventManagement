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
        <a href="{{ route('events.dashboard', ['event' => $event->id]) }}" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Dashboard</a>
      </div>

      <div>
        <p class="mt-4 font-semibold text-gray-900">Check-in Controls</p>
        <a href="{{ route('events.qrScanner', ['event' => $event->id]) }}" class="block pl-4 py-2 hover:bg-indigo-100 rounded">QR Scanner</a>
        <a href="#" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Manual Check-in</a>
         <a href="{{ route('events.checkedIn', ['event' => $event->id]) }}" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Checked in Guests</a>
      </div>

      <div>
        <p class="font-semibold text-gray-900">Guest List Preview </p>
        <a href="{{ route('events.guests', ['event' => $event->id]) }}" class="block pl-4 py-2 rounded bg-indigo-200 font-semibold text-indigo-800">View full guest list</a>
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

  <main class="flex-1 p-8 overflow-y-auto">
  <div class="flex justify-between items-center mb-6">
  <h1 class="text-3xl font-bold text-gray-800">Guest List for {{ $event->event_name }}</h1>
  </div>



<div class="p-6 bg-white rounded shadow">


    <table class="min-w-full table-auto border border-gray-300 rounded-md">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="px-4 py-2 border">#</th>
                <th class="px-4 py-2 border">Name</th>
                <th class="px-4 py-2 border">Email</th>
                <th class="px-4 py-2 border">RSVP Status</th>
                <th class="px-4 py-2 border">Plus One</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($event->guests as $index => $guest)
                <tr class="bg-white hover:bg-gray-50">
                    <td class="px-4 py-2 border">{{ $index + 1 }}</td>
                    <td class="px-4 py-2 border">{{ $guest->first_name }} {{ $guest->last_name }}</td>
                    <td class="px-4 py-2 border">{{ $guest->email }}</td>
                    <td class="px-4 py-2 border capitalize">{{ $guest->pivot->rsvp_status }}</td>
                    <td class="px-4 py-2 border">{{ $guest->pivot->plus_one ? 'Yes' : 'No' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-4 py-4 text-center text-gray-500">No guests found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
 

</body>
</html>

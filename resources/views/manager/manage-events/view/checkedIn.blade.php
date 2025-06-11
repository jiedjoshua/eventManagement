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
        <a href="{{ route('events.checkedIn', ['event' => $event->id]) }}" class="block pl-4 py-2 rounded bg-indigo-200 font-semibold text-indigo-800">Checked in Guests</a>
      </div>

      <div>
        <p class="mt-4 font-semibold text-gray-900">Guest List Preview </p>
        <a href="{{ route('events.guests', ['event' => $event->id]) }}" class="block pl-4 py-2 hover:bg-indigo-100 rounded">View full guest list</a>
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
  <h1 class="text-3xl font-bold text-gray-800">Checked in Guests</h1>
</div>



  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
     <table class="w-full table-auto border-collapse">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="p-2">Name</th>
                <th class="p-2">Email</th>
                <th class="p-2">Checked-in At</th>
            </tr>
        </thead>
        <tbody>
            @forelse($event->guests as $guest)
                <tr class="border-t">
                    <td class="p-2">{{ $guest->first_name }} {{ $guest->last_name }}</td>
                    <td class="p-2">{{ $guest->email }}</td>
                    <td class="p-2">{{ \Carbon\Carbon::parse($guest->checked_in_at)->format('M d, Y h:i A') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="p-2 text-center">No guests have checked in yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
  </div>
</main>



 

</body>
</html>

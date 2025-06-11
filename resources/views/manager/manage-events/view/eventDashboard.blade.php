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
        <a href="{{ route('events.dashboard', ['event' => $event->id]) }}" class="block pl-4 py-2 rounded bg-indigo-200 font-semibold text-indigo-800">Dashboard</a>
      </div>

      <div>
        <p class="mt-4 font-semibold text-gray-900">Check-in Controls</p>
        <a href="{{ route('events.qrScanner', ['event' => $event->id]) }}" class="block pl-4 py-2 hover:bg-indigo-100 rounded">QR Scanner</a>
        <a href="#" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Manual Check-in</a>
        <a href="{{ route('events.checkedIn', ['event' => $event->id]) }}" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Checked in Guests</a>
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
  <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
  <div class="text-sm text-gray-600 bg-white px-4 py-2 rounded shadow font-medium">
    Philippine Time: <span id="ph-time" class="font-semibold text-gray-800"></span>
  </div>
</div>



  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Event Summary Card -->
    <div class="bg-white rounded-2xl shadow p-6">
      <h2 class="text-xl font-semibold text-indigo-700 mb-4">Event Summary</h2>
      <div class="space-y-2 text-gray-700 text-sm">
        <p><span class="font-semibold text-gray-900">Event Name:</span> {{$event->event_name}}</p>
        <p><span class="font-semibold text-gray-900">Event Type:</span> {event_type}</p>
        <p><span class="font-semibold text-gray-900">Date:</span> {event_date}</p>
        <p><span class="font-semibold text-gray-900">Time:</span> {start_time} - {end_time}</p>
        <p><span class="font-semibold text-gray-900">Venue:</span> {venue_name}</p>
        <p><span class="font-semibold text-gray-900">Package:</span> {package_type}</p>
        <p><span class="font-semibold text-gray-900">Guests Invited:</span> {guest_count}</p>
        <p><span class="font-semibold text-gray-900">RSVP Deadline:</span> {rsvp_deadline}</p>
      </div>
    </div>

    <!-- Attendance Stats Card -->
    <div class="bg-white rounded-2xl shadow p-6">
      <h2 class="text-xl font-semibold text-indigo-700 mb-4">Attendance Stats</h2>
      <div class="grid grid-cols-2 gap-4 text-gray-700 text-sm">
        <div class="bg-indigo-50 rounded-lg p-3">
          <p class="text-xs font-medium text-indigo-600">Invited</p>
          <p class="text-lg font-semibold text-gray-900">{total_invited}</p>
        </div>
        <div class="bg-green-50 rounded-lg p-3">
          <p class="text-xs font-medium text-green-600">Accepted</p>
          <p class="text-lg font-semibold text-gray-900">{total_accepted}</p>
        </div>
        <div class="bg-red-50 rounded-lg p-3">
          <p class="text-xs font-medium text-red-600">Declined</p>
          <p class="text-lg font-semibold text-gray-900">{total_declined}</p>
        </div>
        <div class="bg-blue-50 rounded-lg p-3">
          <p class="text-xs font-medium text-blue-600">Checked In</p>
          <p class="text-lg font-semibold text-gray-900">{checked_in_count}</p>
        </div>
        <div class="bg-yellow-50 rounded-lg p-3 col-span-2">
          <p class="text-xs font-medium text-yellow-600">Not Checked In</p>
          <p class="text-lg font-semibold text-gray-900">{not_checked_in}</p>
        </div>
      </div>
    </div>
  </div>
</main>

<script>
  function updatePhilippineTime() {
    const now = new Date();
    const options = {
      timeZone: 'Asia/Manila',
      hour12: true,
      hour: '2-digit',
      minute: '2-digit',
      second: '2-digit',
      weekday: 'short',
      year: 'numeric',
      month: 'short',
      day: 'numeric',
    };
    const formatter = new Intl.DateTimeFormat('en-PH', options);
    document.getElementById('ph-time').textContent = formatter.format(now);
  }

  updatePhilippineTime();
  setInterval(updatePhilippineTime, 1000);
</script>

 

</body>
</html>

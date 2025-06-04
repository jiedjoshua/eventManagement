<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Invitation for {{ $event->event_name }}</title>
  <link href="https://cdn.tailwindcss.com" rel="stylesheet" />
</head>
<body class="bg-gray-50 min-h-screen flex flex-col items-center justify-center p-6">

  <div class="bg-white p-8 rounded-lg shadow-md text-center max-w-md w-full">
    <h1 class="text-3xl font-bold mb-4">You're invited to:</h1>
    <h2 class="text-xl font-semibold mb-6">{{ $event->event_name }}</h2>
    <p class="mb-6 text-gray-700">
      Date: {{ \Carbon\Carbon::parse($event->event_date)->format('F d, Y') }} <br>
      Time: {{ \Carbon\Carbon::parse($event->start_time)->format('g:i A') }} <br>
      Location: {{ $event->venue_name }}
    </p>

    <div class="mb-6">
      {!! $qrCode !!}
    </div>

    <p class="text-gray-600 mb-4">Show this QR code at the event entrance for verification.</p>

    <a href="{{ route('user.dashboard') }}" class="inline-block bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700 transition">
      Back to Dashboard
    </a>
  </div>

</body>
</html>

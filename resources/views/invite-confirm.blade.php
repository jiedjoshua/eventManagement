<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Event Invitation</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded shadow-md max-w-md w-full text-center">
        <h1 class="text-xl font-semibold mb-4">You're Invited!</h1>
        <p class="mb-6">
            Do you want to attend the event
            <strong>{{ $event->event_name }}</strong>?
        </p>

        <div class="flex justify-center gap-4">
            <a href="{{ route('invite.accept', ['eventId' => $event->id]) }}"
               class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded">
                Accept
            </a>
            <a href="{{ route('invite.decline') }}"
               class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded">
                Decline
            </a>
        </div>
    </div>
</body>
</html>

<!-- resources/views/dashboards/eventmanager.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Event Manager Dashboard</title>
</head>
<body>
    <h1>Welcome, Event Manager {{ auth()->user()->first_name }}!</h1>

    <p>This is the Event Manager dashboard.</p>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>

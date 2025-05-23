<!-- resources/views/dashboards/user.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>User Dashboard</title>
</head>
<body>
    <h1>Welcome, {{ auth()->user()->first_name }}!</h1>

    <p>This is the Regular User dashboard.</p>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>

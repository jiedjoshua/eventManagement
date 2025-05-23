<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Super Admin Dashboard</title>
</head>
<body>
    <h1>Welcome, Super Admin {{ auth()->user()->first_name }}!</h1>

    <p>This is the Super Admin dashboard.</p>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>
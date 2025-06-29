<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - CrwdCtrl</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="/public/favicon.svg">
    <link rel="icon" type="image/x-icon" href="/public/favicon.ico">
    <link rel="shortcut icon" href="/public/favicon.svg">
    <link rel="apple-touch-icon" href="/public/favicon.svg">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @stack('styles')
</head>
<body class="flex h-screen bg-gray-50">
    <!-- Sidebar -->
    <x-admin-sidebar :active-page="$activePage ?? ''">
        Admin Panel
    </x-admin-sidebar>

    <!-- Main Content -->
    <main class="flex-1 p-8 overflow-auto">
        {{ $slot }}
    </main>

    <!-- Modals and Notifications -->
    @stack('modals')
    @stack('notifications')
    @stack('scripts')
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Customer Panel' }} - CrwdCtrl</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Add this line -->
    <script src="https://unpkg.com/alpinejs" defer></script>
    @stack('styles')
</head>
<body class="flex h-screen bg-gray-50">
    <!-- Sidebar -->
    <x-customer-sidebar :active-page="$activePage ?? ''">
        Customer Panel
    </x-customer-sidebar>

    <!-- Main Content -->
    <main class="flex-1 p-8 overflow-auto">
        {{ $slot }}
    </main>

    <!-- Modals and Notifications -->
    @stack('modals')
    @stack('notifications')
    @stack('scripts') <!-- Make sure this is here! -->
</body>
</html>
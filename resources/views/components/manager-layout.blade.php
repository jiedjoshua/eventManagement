<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Event Management' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
     @stack('styles')
    
</head>
<body class="flex h-screen bg-gray-50">
    <!-- Sidebar -->
    <x-manager-sidebar :active-page="$activePage ?? ''">
        Manager Panel
    </x-manager-sidebar>

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
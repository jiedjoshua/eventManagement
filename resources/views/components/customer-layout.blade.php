<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Customer Panel' }} - CrwdCtrl</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Add this line -->
    <script src="https://unpkg.com/alpinejs" defer></script>
    @stack('styles')
</head>
<body class="flex h-screen bg-gray-50" x-data="{ sidebarOpen: false }">
    <!-- Mobile Overlay -->
    <div x-show="sidebarOpen" 
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-40 bg-black bg-opacity-50 lg:hidden"
         @click="sidebarOpen = false">
    </div>

    <!-- Sidebar -->
    <aside x-show="sidebarOpen || window.innerWidth >= 1024" 
           x-transition:enter="transition ease-in-out duration-300 transform"
           x-transition:enter-start="-translate-x-full"
           x-transition:enter-end="translate-x-0"
           x-transition:leave="transition ease-in-out duration-300 transform"
           x-transition:leave-start="translate-x-0"
           x-transition:leave-end="-translate-x-full"
           class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-lg flex flex-col lg:relative lg:translate-x-0">
        <x-customer-sidebar :active-page="$activePage ?? ''">
            Customer Panel
        </x-customer-sidebar>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col lg:ml-0">
        <!-- Mobile Header -->
        <header class="lg:hidden bg-white shadow-sm border-b border-gray-200 px-4 py-3">
            <div class="flex items-center justify-between">
                <button @click="sidebarOpen = true" class="text-gray-600 hover:text-gray-900 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <h1 class="text-lg font-semibold text-gray-900">Customer Panel</h1>
                <div class="w-6"></div> <!-- Spacer for centering -->
            </div>
        </header>

        <!-- Content Area -->
        <div class="flex-1 p-4 lg:p-8 overflow-auto">
            {{ $slot }}
        </div>
    </main>

    <!-- Modals and Notifications -->
    @stack('modals')
    @stack('notifications')
    @stack('scripts') <!-- Make sure this is here! -->
</body>
</html>
@props(['activePage' => ''])

<aside class="w-64 bg-white shadow-lg flex flex-col h-screen">
    <div class="p-6 text-2xl font-bold text-indigo-600 border-b border-gray-200 flex-shrink-0">
        {{ $slot }}
    </div>
    
    <!-- Home Button -->
    <div class="px-4 py-3 border-b border-gray-200">
        <a href="{{ route('home') }}" class="flex items-center space-x-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition-colors text-sm font-medium">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span>Go to Home</span>
        </a>
    </div>
    
    <nav class="flex-1 px-4 space-y-2 text-sm text-gray-700 py-6 overflow-y-auto">
        <!-- Home Section -->
        <div>
            <p class="font-semibold text-gray-900 mb-2">Home</p>
            <a href="{{ route('admin.dashboard') }}" 
               class="block pl-4 py-2 rounded transition-colors {{ $activePage === 'dashboard' ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'hover:bg-indigo-50' }}">
                Dashboard
            </a>
        </div>

        <!-- User Management Section -->
        <div>
            <p class="mt-6 font-semibold text-gray-900 mb-2">User Management</p>
            <a href="{{ route('admin.listusers') }}" 
               class="block pl-4 py-2 rounded transition-colors {{ $activePage === 'users' ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'hover:bg-indigo-50' }}">
                Users
            </a>
            <a href="{{ route('admin.listusers') }}?action=create" 
               class="block pl-4 py-2 rounded transition-colors {{ $activePage === 'create-user' ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'hover:bg-indigo-50' }}">
                Create User
            </a>
        </div>

        <!-- Venue Management Section -->
        <div>
            <p class="mt-6 font-semibold text-gray-900 mb-2">Venue Management</p>
            <a href="{{ route('admin.venues.index') }}"
                class="block pl-4 py-2 rounded transition-colors {{ $activePage === 'venues' ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'hover:bg-indigo-50' }}">
                Venues
            </a>
            <a href="{{ route('admin.venues.map') }}"
                class="block pl-4 py-2 rounded transition-colors {{ $activePage === 'venue-map' ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'hover:bg-indigo-50' }}">
                Venue Map
            </a>
            <a href="{{ route('admin.venue-calendar') }}"
                class="block pl-4 py-2 rounded transition-colors {{ $activePage === 'venue-calendar' ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'hover:bg-indigo-50' }}">
                Venue Calendar
            </a>
        </div>

        <!-- Event Management Section -->
        <div>
            <p class="mt-6 font-semibold text-gray-900 mb-2">Event Management</p>
            <a href="{{ route('admin.events.index') }}" 
               class="block pl-4 py-2 rounded transition-colors {{ $activePage === 'events' ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'hover:bg-indigo-50' }}">
                Events
            </a>
        </div>

        <!-- Event Package Management Section -->
        <div>
            <p class="mt-6 font-semibold text-gray-900 mb-2">Event Package Management</p>
            <a href="{{ route('admin.packages.index') }}" 
               class="block pl-4 py-2 rounded transition-colors {{ $activePage === 'packages' ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'hover:bg-indigo-50' }}">
                All Packages
            </a>
            <a href="{{ route('admin.packages.index') }}?type=Wedding" 
               class="block pl-4 py-2 rounded transition-colors {{ $activePage === 'wedding-packages' ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'hover:bg-indigo-50' }}">
                Wedding
            </a>
            <a href="{{ route('admin.packages.index') }}?type=Birthday" 
               class="block pl-4 py-2 rounded transition-colors {{ $activePage === 'birthday-packages' ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'hover:bg-indigo-50' }}">
                Birthday
            </a>
            <a href="{{ route('admin.packages.index') }}?type=Baptism" 
               class="block pl-4 py-2 rounded transition-colors {{ $activePage === 'baptism-packages' ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'hover:bg-indigo-50' }}">
                Baptism
            </a>
        </div>

        <!-- Content Management Section -->
        <div>
            <p class="mt-6 font-semibold text-gray-900 mb-2">Content Management</p>
            <a href="{{ route('admin.cms.home-page') }}" 
               class="block pl-4 py-2 rounded transition-colors {{ $activePage === 'cms' ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'hover:bg-indigo-50' }}">
                Home Page CMS
            </a>
            <a href="{{ route('admin.cms.services-page') }}" 
               class="block pl-4 py-2 rounded transition-colors {{ $activePage === 'services-cms' ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'hover:bg-indigo-50' }}">
                Services Page CMS
            </a>
        </div>

        <!-- Settings Section -->
        <div>
            <p class="mt-6 font-semibold text-gray-900 mb-2">Settings</p>
            <a href="{{ route('admin.account-settings') }}" 
               class="block pl-4 py-2 rounded transition-colors {{ $activePage === 'account-settings' ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'hover:bg-indigo-50' }}">
                Account Settings
            </a>
        </div>
    </nav>

    <!-- Logout Section -->
    <div class="px-6 py-4 border-t border-gray-200 flex-shrink-0">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="block text-red-600 font-semibold hover:text-red-700 transition-colors">
                Logout
            </button>
        </form>
    </div>
</aside>
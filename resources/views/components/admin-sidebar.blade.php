@props(['activePage' => ''])

<aside class="w-64 bg-gradient-to-b from-gray-50 to-white shadow-xl border-r border-gray-200 flex flex-col h-screen">
    <!-- Enhanced Header -->
    <div class="p-6 border-b border-gray-200 flex-shrink-0">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                    {{ $slot }}
                </h1>
                <p class="text-xs text-gray-500 font-medium">Administration Panel</p>
            </div>
        </div>
    </div>
    
    <!-- Enhanced Home Button -->
    <div class="px-4 py-4 border-b border-gray-200">
        <a href="{{ route('home') }}" class="flex items-center space-x-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-4 py-3 rounded-xl transition-all duration-300 text-sm font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span>Go to Home</span>
        </a>
    </div>
    
    <nav class="flex-1 px-4 space-y-1 text-sm text-gray-700 py-6 overflow-y-auto">
        <!-- Home Section -->
        <div class="mb-6">
            <div class="flex items-center space-x-2 mb-3">
                <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                <p class="font-bold text-gray-900 text-xs uppercase tracking-wider">Home</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" 
               class="flex items-center space-x-3 pl-4 py-3 rounded-xl transition-all duration-300 {{ $activePage === 'dashboard' ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-lg' : 'hover:bg-blue-50 hover:text-blue-700' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                </svg>
                <span class="font-medium">Dashboard</span>
            </a>
        </div>

        <!-- User Management Section -->
        <div class="mb-6">
            <div class="flex items-center space-x-2 mb-3">
                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                <p class="font-bold text-gray-900 text-xs uppercase tracking-wider">User Management</p>
            </div>
            <a href="{{ route('admin.listusers') }}" 
               class="flex items-center space-x-3 pl-4 py-3 rounded-xl transition-all duration-300 {{ $activePage === 'users' ? 'bg-gradient-to-r from-green-500 to-green-600 text-white shadow-lg' : 'hover:bg-green-50 hover:text-green-700' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                </svg>
                <span class="font-medium">Users</span>
            </a>
            <a href="{{ route('admin.listusers') }}?action=create" 
               class="flex items-center space-x-3 pl-4 py-3 rounded-xl transition-all duration-300 {{ $activePage === 'create-user' ? 'bg-gradient-to-r from-green-500 to-green-600 text-white shadow-lg' : 'hover:bg-green-50 hover:text-green-700' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
                <span class="font-medium">Create User</span>
            </a>
        </div>

        <!-- Venue Management Section -->
        <div class="mb-6">
            <div class="flex items-center space-x-2 mb-3">
                <div class="w-2 h-2 bg-purple-500 rounded-full"></div>
                <p class="font-bold text-gray-900 text-xs uppercase tracking-wider">Venue Management</p>
            </div>
            <a href="{{ route('admin.venues.index') }}"
                class="flex items-center space-x-3 pl-4 py-3 rounded-xl transition-all duration-300 {{ $activePage === 'venues' ? 'bg-gradient-to-r from-purple-500 to-purple-600 text-white shadow-lg' : 'hover:bg-purple-50 hover:text-purple-700' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                <span class="font-medium">Venues</span>
            </a>
            <a href="{{ route('admin.venues.map') }}"
                class="flex items-center space-x-3 pl-4 py-3 rounded-xl transition-all duration-300 {{ $activePage === 'venue-map' ? 'bg-gradient-to-r from-purple-500 to-purple-600 text-white shadow-lg' : 'hover:bg-purple-50 hover:text-purple-700' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-1.447-.894L15 4m0 13V4m-6 3l6-3"></path>
                </svg>
                <span class="font-medium">Venue Map</span>
            </a>
            <a href="{{ route('admin.venue-calendar') }}"
                class="flex items-center space-x-3 pl-4 py-3 rounded-xl transition-all duration-300 {{ $activePage === 'venue-calendar' ? 'bg-gradient-to-r from-purple-500 to-purple-600 text-white shadow-lg' : 'hover:bg-purple-50 hover:text-purple-700' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span class="font-medium">Venue Calendar</span>
            </a>
        </div>

        <!-- Event Management Section -->
        <div class="mb-6">
            <div class="flex items-center space-x-2 mb-3">
                <div class="w-2 h-2 bg-orange-500 rounded-full"></div>
                <p class="font-bold text-gray-900 text-xs uppercase tracking-wider">Event Management</p>
            </div>
            <a href="{{ route('admin.events.index') }}" 
               class="flex items-center space-x-3 pl-4 py-3 rounded-xl transition-all duration-300 {{ $activePage === 'events' ? 'bg-gradient-to-r from-orange-500 to-orange-600 text-white shadow-lg' : 'hover:bg-orange-50 hover:text-orange-700' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span class="font-medium">Events</span>
            </a>
        </div>

        <!-- Event Package Management Section -->
        <div class="mb-6">
            <div class="flex items-center space-x-2 mb-3">
                <div class="w-2 h-2 bg-yellow-500 rounded-full"></div>
                <p class="font-bold text-gray-900 text-xs uppercase tracking-wider">Package Management</p>
            </div>
            <a href="{{ route('admin.packages.index') }}" 
               class="flex items-center space-x-3 pl-4 py-3 rounded-xl transition-all duration-300 {{ $activePage === 'packages' ? 'bg-gradient-to-r from-yellow-500 to-yellow-600 text-white shadow-lg' : 'hover:bg-yellow-50 hover:text-yellow-700' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                <span class="font-medium">All Packages</span>
            </a>
            <a href="{{ route('admin.packages.index') }}?type=Wedding" 
               class="flex items-center space-x-3 pl-4 py-3 rounded-xl transition-all duration-300 {{ $activePage === 'wedding-packages' ? 'bg-gradient-to-r from-yellow-500 to-yellow-600 text-white shadow-lg' : 'hover:bg-yellow-50 hover:text-yellow-700' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
                <span class="font-medium">Wedding</span>
            </a>
            <a href="{{ route('admin.packages.index') }}?type=Birthday" 
               class="flex items-center space-x-3 pl-4 py-3 rounded-xl transition-all duration-300 {{ $activePage === 'birthday-packages' ? 'bg-gradient-to-r from-yellow-500 to-yellow-600 text-white shadow-lg' : 'hover:bg-yellow-50 hover:text-yellow-700' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path>
                </svg>
                <span class="font-medium">Birthday</span>
            </a>
            <a href="{{ route('admin.packages.index') }}?type=Baptism" 
               class="flex items-center space-x-3 pl-4 py-3 rounded-xl transition-all duration-300 {{ $activePage === 'baptism-packages' ? 'bg-gradient-to-r from-yellow-500 to-yellow-600 text-white shadow-lg' : 'hover:bg-yellow-50 hover:text-yellow-700' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
                <span class="font-medium">Baptism</span>
            </a>
        </div>

        <!-- Content Management Section -->
        <div class="mb-6">
            <div class="flex items-center space-x-2 mb-3">
                <div class="w-2 h-2 bg-red-500 rounded-full"></div>
                <p class="font-bold text-gray-900 text-xs uppercase tracking-wider">Content Management</p>
            </div>
            <a href="{{ route('admin.cms.home-page') }}" 
               class="flex items-center space-x-3 pl-4 py-3 rounded-xl transition-all duration-300 {{ $activePage === 'cms' ? 'bg-gradient-to-r from-red-500 to-red-600 text-white shadow-lg' : 'hover:bg-red-50 hover:text-red-700' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span class="font-medium">Home Page</span>
            </a>
            <a href="{{ route('admin.cms.services-page') }}" 
               class="flex items-center space-x-3 pl-4 py-3 rounded-xl transition-all duration-300 {{ $activePage === 'services-cms' ? 'bg-gradient-to-r from-red-500 to-red-600 text-white shadow-lg' : 'hover:bg-red-50 hover:text-red-700' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2V6"></path>
                </svg>
                <span class="font-medium">Services Page</span>
            </a>
            <a href="{{ route('admin.cms.packages-page') }}" 
               class="flex items-center space-x-3 pl-4 py-3 rounded-xl transition-all duration-300 {{ $activePage === 'packages-cms' ? 'bg-gradient-to-r from-red-500 to-red-600 text-white shadow-lg' : 'hover:bg-red-50 hover:text-red-700' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                <span class="font-medium">Packages Page</span>
            </a>
            <a href="{{ route('admin.cms.gallery-page') }}" 
               class="flex items-center space-x-3 pl-4 py-3 rounded-xl transition-all duration-300 {{ $activePage === 'gallery-cms' ? 'bg-gradient-to-r from-red-500 to-red-600 text-white shadow-lg' : 'hover:bg-red-50 hover:text-red-700' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span class="font-medium">Gallery Page</span>
            </a>
            <a href="{{ route('admin.cms.about-page') }}" 
               class="flex items-center space-x-3 pl-4 py-3 rounded-xl transition-all duration-300 {{ $activePage === 'about-cms' ? 'bg-gradient-to-r from-red-500 to-red-600 text-white shadow-lg' : 'hover:bg-red-50 hover:text-red-700' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="font-medium">About Page</span>
            </a>
            <a href="{{ route('admin.cms.contact-page') }}" 
               class="flex items-center space-x-3 pl-4 py-3 rounded-xl transition-all duration-300 {{ $activePage === 'contact-cms' ? 'bg-gradient-to-r from-red-500 to-red-600 text-white shadow-lg' : 'hover:bg-red-50 hover:text-red-700' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                <span class="font-medium">Contact Page</span>
            </a>
        </div>

        <!-- Settings Section -->
        <div class="mb-6">
            <div class="flex items-center space-x-2 mb-3">
                <div class="w-2 h-2 bg-gray-500 rounded-full"></div>
                <p class="font-bold text-gray-900 text-xs uppercase tracking-wider">Settings</p>
            </div>
            <a href="{{ route('admin.account-settings') }}" 
               class="flex items-center space-x-3 pl-4 py-3 rounded-xl transition-all duration-300 {{ $activePage === 'account-settings' ? 'bg-gradient-to-r from-gray-500 to-gray-600 text-white shadow-lg' : 'hover:bg-gray-50 hover:text-gray-700' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span class="font-medium">Account Settings</span>
            </a>
        </div>
    </nav>

    <!-- Enhanced Logout Section -->
    <div class="px-6 py-4 border-t border-gray-200 flex-shrink-0">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex items-center space-x-3 w-full text-red-600 hover:text-red-700 font-semibold transition-all duration-300 py-3 px-4 rounded-xl hover:bg-red-50 group">
                <svg class="w-5 h-5 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                <span>Logout</span>
            </button>
        </form>
    </div>
</aside>
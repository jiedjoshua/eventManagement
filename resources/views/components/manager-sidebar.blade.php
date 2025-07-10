@props(['activePage' => ''])

<aside class="w-64 bg-gradient-to-b from-white to-gray-50 shadow-xl border-r border-gray-200 flex flex-col h-screen">
    <!-- Enhanced Header -->
    <div class="p-6 border-b border-gray-200 flex-shrink-0">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-900">{{ $slot }}</h2>
                <p class="text-sm text-gray-500">Event Manager</p>
            </div>
        </div>
    </div>
    
    <!-- Enhanced Home Button -->
    <div class="px-4 py-4 border-b border-gray-200">
        <a href="{{ route('home') }}" class="flex items-center space-x-3 bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white px-4 py-3 rounded-xl transition-all duration-200 text-sm font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span>Go to Home</span>
        </a>
    </div>
    
    <!-- Enhanced Navigation -->
    <nav class="flex-1 px-4 space-y-6 py-6 overflow-y-auto">
        <!-- Home Section -->
        <div>
            <div class="flex items-center mb-3">
                <div class="w-2 h-2 bg-indigo-500 rounded-full mr-3"></div>
                <p class="font-bold text-gray-900 text-sm uppercase tracking-wide">Home</p>
            </div>
            <a href="{{ route('manager.dashboard') }}" 
               class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ $activePage === 'dashboard' ? 'bg-gradient-to-r from-indigo-100 to-indigo-200 text-indigo-700 font-semibold shadow-md' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
                <svg class="h-5 w-5 {{ $activePage === 'dashboard' ? 'text-indigo-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                <span>Dashboard</span>
            </a>
        </div>

        <!-- Manage Events Section -->
        <div>
            <div class="flex items-center mb-3">
                <div class="w-2 h-2 bg-green-500 rounded-full mr-3"></div>
                <p class="font-bold text-gray-900 text-sm uppercase tracking-wide">Manage Events</p>
            </div>
            <div class="space-y-2">
                <a href="{{ route('manager.showEvent') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ $activePage === 'events' ? 'bg-gradient-to-r from-green-100 to-green-200 text-green-700 font-semibold shadow-md' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
                    <svg class="h-5 w-5 {{ $activePage === 'events' ? 'text-green-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span>Events</span>
                </a>
                <a href="{{ route('manager.bookedEvents') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ $activePage === 'booked-events' ? 'bg-gradient-to-r from-green-100 to-green-200 text-green-700 font-semibold shadow-md' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
                    <svg class="h-5 w-5 {{ $activePage === 'booked-events' ? 'text-green-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span>Booked Events</span>
                </a>
                <a href="{{ route('manager.upcomingEvents') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ $activePage === 'upcoming-events' ? 'bg-gradient-to-r from-green-100 to-green-200 text-green-700 font-semibold shadow-md' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
                    <svg class="h-5 w-5 {{ $activePage === 'upcoming-events' ? 'text-green-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Upcoming Events</span>
                </a>
            </div>
        </div>

        <!-- RSVP Management Section -->
        <div>
            <div class="flex items-center mb-3">
                <div class="w-2 h-2 bg-purple-500 rounded-full mr-3"></div>
                <p class="font-bold text-gray-900 text-sm uppercase tracking-wide">RSVP Management</p>
            </div>
            <div class="space-y-2">
                <a href="{{ route('manager.guestLists') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ $activePage === 'guest-lists' ? 'bg-gradient-to-r from-purple-100 to-purple-200 text-purple-700 font-semibold shadow-md' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
                    <svg class="h-5 w-5 {{ $activePage === 'guest-lists' ? 'text-purple-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span>Guest Lists</span>
                </a>
                <a href="{{ route('manager.showGenerateExternalQRCodes') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ $activePage === 'qr-codes' ? 'bg-gradient-to-r from-purple-100 to-purple-200 text-purple-700 font-semibold shadow-md' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
                    <svg class="h-5 w-5 {{ $activePage === 'qr-codes' ? 'text-purple-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V6a1 1 0 00-1-1H5a1 1 0 00-1 1v1a1 1 0 001 1zm12 0h2a1 1 0 001-1V6a1 1 0 00-1-1h-2a1 1 0 00-1 1v1a1 1 0 001 1zM5 20h2a1 1 0 001-1v-1a1 1 0 00-1-1H5a1 1 0 00-1 1v1a1 1 0 001 1z"></path>
                    </svg>
                    <span>Generate QR Codes</span>
                </a>
            </div>
        </div>

        <!-- Venue Management Section -->
        <div>
            <div class="flex items-center mb-3">
                <div class="w-2 h-2 bg-blue-500 rounded-full mr-3"></div>
                <p class="font-bold text-gray-900 text-sm uppercase tracking-wide">Venue Management</p>
            </div>
            <div class="space-y-2">
                <a href="{{ route('manager.venues') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ $activePage === 'venues' ? 'bg-gradient-to-r from-blue-100 to-blue-200 text-blue-700 font-semibold shadow-md' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
                    <svg class="h-5 w-5 {{ $activePage === 'venues' ? 'text-blue-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <span>List Venues</span>
                </a>
                <a href="{{ route('manager.venue-calendar') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ $activePage === 'venue-calendar' ? 'bg-gradient-to-r from-blue-100 to-blue-200 text-blue-700 font-semibold shadow-md' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
                    <svg class="h-5 w-5 {{ $activePage === 'venue-calendar' ? 'text-blue-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span>Venue Calendar</span>
                </a>
                <a href="{{ route('manager.venue-map') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ $activePage === 'venue-map' ? 'bg-gradient-to-r from-blue-100 to-blue-200 text-blue-700 font-semibold shadow-md' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
                    <svg class="h-5 w-5 {{ $activePage === 'venue-map' ? 'text-blue-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span>Venue Map</span>
                </a>
            </div>
        </div>

        <!-- Reports & Analytics Section -->
        <div>
            <div class="flex items-center mb-3">
                <div class="w-2 h-2 bg-orange-500 rounded-full mr-3"></div>
                <p class="font-bold text-gray-900 text-sm uppercase tracking-wide">Reports & Analytics</p>
            </div>
            <div class="space-y-2">
                <a href="{{ route('manager.feedback.analytics') }}"
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ (isset($activePage) && $activePage === 'feedback-analytics') ? 'bg-gradient-to-r from-orange-100 to-orange-200 text-orange-700 font-semibold shadow-md' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
                    <svg class="h-5 w-5 {{ (isset($activePage) && $activePage === 'feedback-analytics') ? 'text-orange-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <span>Feedback Analytics</span>
                </a>
                <a href="{{ route('manager.paymentHistory') }}"
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ (isset($activePage) && $activePage === 'payment-history') ? 'bg-gradient-to-r from-emerald-100 to-emerald-200 text-emerald-700 font-semibold shadow-md' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
                    <svg class="h-5 w-5 {{ (isset($activePage) && $activePage === 'payment-history') ? 'text-emerald-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                    <span>Payment History</span>
                </a>
                <a href="{{ route('manager.endedEvents') }}"
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ (isset($activePage) && $activePage === 'ended-events') ? 'bg-gradient-to-r from-indigo-100 to-indigo-200 text-indigo-700 font-semibold shadow-md' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
                    <svg class="h-5 w-5 {{ (isset($activePage) && $activePage === 'ended-events') ? 'text-indigo-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17h6" />
                    </svg>
                    <span>Ended Events & Feedbacks</span>
                </a>
            </div>
        </div>

        <!-- Settings Section -->
        <div>
            <div class="flex items-center mb-3">
                <div class="w-2 h-2 bg-yellow-500 rounded-full mr-3"></div>
                <p class="font-bold text-gray-900 text-sm uppercase tracking-wide">Settings</p>
            </div>
            <a href="{{ route('manager.account-settings') }}" 
               class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ $activePage === 'account-settings' ? 'bg-gradient-to-r from-yellow-100 to-yellow-200 text-yellow-700 font-semibold shadow-md' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
                <svg class="h-5 w-5 {{ $activePage === 'account-settings' ? 'text-yellow-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span>Account Settings</span>
            </a>
        </div>
    </nav>

    <!-- Enhanced Logout Section -->
    <div class="px-4 py-4 border-t border-gray-200 flex-shrink-0">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center space-x-3 px-4 py-3 text-red-600 hover:text-red-700 hover:bg-red-50 rounded-xl transition-all duration-200 font-semibold group">
                <svg class="h-5 w-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                <span>Logout</span>
            </button>
        </form>
    </div>
</aside>
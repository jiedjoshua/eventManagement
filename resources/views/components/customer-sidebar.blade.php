@props(['activePage' => ''])

<aside class="w-full h-full bg-gradient-to-b from-white to-gray-50 shadow-xl border-r border-gray-200 flex flex-col">
    <!-- Enhanced Header -->
    <div class="p-6 border-b border-gray-200 flex-shrink-0">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900">{{ $slot }}</h2>
                    <p class="text-sm text-gray-500">Customer Portal</p>
                </div>
            </div>
            <!-- Close button for mobile -->
            <button @click="sidebarOpen = false" class="lg:hidden p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors focus:outline-none">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
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
            <a href="{{ route('user.dashboard') }}" 
               class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ $activePage === 'dashboard' ? 'bg-gradient-to-r from-indigo-100 to-indigo-200 text-indigo-700 font-semibold shadow-md' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
                <svg class="h-5 w-5 {{ $activePage === 'dashboard' ? 'text-indigo-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                <span>Dashboard</span>
            </a>
        </div>

        <!-- My Events Section -->
        <div>
            <div class="flex items-center mb-3">
                <div class="w-2 h-2 bg-green-500 rounded-full mr-3"></div>
                <p class="font-bold text-gray-900 text-sm uppercase tracking-wide">My Events</p>
            </div>
            <div class="space-y-2">
                <a href="{{ route('user.bookedEvents') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ $activePage === 'booked-events' ? 'bg-gradient-to-r from-green-100 to-green-200 text-green-700 font-semibold shadow-md' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
                    <svg class="h-5 w-5 {{ $activePage === 'booked-events' ? 'text-green-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span>Booked Events</span>
                </a>
                <a href="{{ route('user.attendingEvents') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ $activePage === 'attending-events' ? 'bg-gradient-to-r from-green-100 to-green-200 text-green-700 font-semibold shadow-md' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
                    <svg class="h-5 w-5 {{ $activePage === 'attending-events' ? 'text-green-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span>Attending Events</span>
                </a>
            </div>
        </div>

        <!-- Payment Section -->
        <div>
            <div class="flex items-center mb-3">
                <div class="w-2 h-2 bg-purple-500 rounded-full mr-3"></div>
                <p class="font-bold text-gray-900 text-sm uppercase tracking-wide">Payment</p>
            </div>
            <div class="space-y-2">
                <a href="{{ route('user.payments') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ $activePage === 'payments' ? 'bg-gradient-to-r from-purple-100 to-purple-200 text-purple-700 font-semibold shadow-md' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
                    <svg class="h-5 w-5 {{ $activePage === 'payments' ? 'text-purple-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                    <span>Payments</span>
                </a>
                <a href="{{ route('user.paymentHistory') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ $activePage === 'payment-history' ? 'bg-gradient-to-r from-purple-100 to-purple-200 text-purple-700 font-semibold shadow-md' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
                    <svg class="h-5 w-5 {{ $activePage === 'payment-history' ? 'text-purple-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    <span>Payment History</span>
                </a>
            </div>
        </div>

        <!-- Settings Section -->
        <div>
            <div class="flex items-center mb-3">
                <div class="w-2 h-2 bg-yellow-500 rounded-full mr-3"></div>
                <p class="font-bold text-gray-900 text-sm uppercase tracking-wide">Settings</p>
            </div>
            <a href="{{ route('user.accountSettings') }}" 
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
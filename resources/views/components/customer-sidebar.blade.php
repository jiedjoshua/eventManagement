@props(['activePage' => ''])

<aside class="w-full h-full bg-white shadow-lg flex flex-col">
    <!-- Header with close button for mobile -->
    <div class="p-6 text-2xl font-bold text-indigo-600 border-b border-gray-200 flex-shrink-0 flex items-center justify-between">
        <span>{{ $slot }}</span>
        <!-- Close button for mobile -->
        <button @click="sidebarOpen = false" class="lg:hidden text-gray-500 hover:text-gray-700 focus:outline-none">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
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
            <a href="{{ route('user.dashboard') }}" 
               class="block pl-4 py-2 rounded transition-colors {{ $activePage === 'dashboard' ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'hover:bg-indigo-50' }}">
                Dashboard
            </a>
        </div>

        <!-- My Events Section -->
        <div>
            <p class="mt-6 font-semibold text-gray-900 mb-2">My Events</p>
            <a href="{{ route('user.bookedEvents') }}" 
               class="block pl-4 py-2 rounded transition-colors {{ $activePage === 'booked-events' ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'hover:bg-indigo-50' }}">
                Booked Events
            </a>
            <a href="{{ route('user.attendingEvents') }}" 
               class="block pl-4 py-2 rounded transition-colors {{ $activePage === 'attending-events' ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'hover:bg-indigo-50' }}">
                Attending Events
            </a>
        </div>

        <!-- Payment Section -->
        <div>
            <p class="mt-6 font-semibold text-gray-900 mb-2">Payment</p>
            <a href="{{ route('user.payments') }}" 
               class="block pl-4 py-2 rounded transition-colors {{ $activePage === 'payments' ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'hover:bg-indigo-50' }}">
                Payments
            </a>
            <a href="{{ route('user.paymentHistory') }}" 
               class="block pl-4 py-2 rounded transition-colors {{ $activePage === 'payment-history' ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'hover:bg-indigo-50' }}">
                Payment History
            </a>
        </div>

        <!-- Settings Section -->
        <div>
            <p class="mt-6 font-semibold text-gray-900 mb-2">Settings</p>
            <a href="{{ route('user.accountSettings') }}" 
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
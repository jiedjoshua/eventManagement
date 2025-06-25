@props(['activePage' => ''])

<aside class="w-64 bg-white shadow-lg flex flex-col h-screen">
    <div class="p-6 text-2xl font-bold text-indigo-600 border-b border-gray-200 flex-shrink-0">
        {{ $slot }}
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
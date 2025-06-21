@props(['activePage' => ''])

<aside class="w-64 bg-white shadow-lg flex flex-col">
    <div class="p-6 text-2xl font-bold text-indigo-600 border-b border-gray-200">
        {{ $slot }}
    </div>
    <nav class="flex-1 px-4 space-y-2 text-sm text-gray-700 py-6">
        <!-- Home Section -->
        <div>
            <p class="font-semibold text-gray-900 mb-2">Home</p>
            <a href="{{ route('manager.dashboard') }}" 
               class="block pl-4 py-2 rounded transition-colors {{ $activePage === 'dashboard' ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'hover:bg-indigo-50' }}">
                Dashboard
            </a>
        </div>

        <!-- Manage Events Section -->
        <div>
            <p class="mt-6 font-semibold text-gray-900 mb-2">Manage Events</p>
            <a href="{{ route('manager.showEvent') }}" 
               class="block pl-4 py-2 rounded transition-colors {{ $activePage === 'events' ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'hover:bg-indigo-50' }}">
                Events
            </a>
            <a href="{{ route('manager.bookedEvents') }}" 
               class="block pl-4 py-2 rounded transition-colors {{ $activePage === 'booked-events' ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'hover:bg-indigo-50' }}">
                Booked Events
            </a>
            <a href="{{ route('manager.upcomingEvents') }}" 
               class="block pl-4 py-2 rounded transition-colors {{ $activePage === 'upcoming-events' ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'hover:bg-indigo-50' }}">
                Upcoming Events
            </a>
            <a href="#" 
               class="block pl-4 py-2 rounded transition-colors {{ $activePage === 'create-event' ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'hover:bg-indigo-50' }}">
                Create Event
            </a>
        </div>

        <!-- RSVP Management Section -->
        <div>
            <p class="mt-6 font-semibold text-gray-900 mb-2">RSVP Management</p>
            <a href="{{ route('manager.guestLists') }}" 
               class="block pl-4 py-2 rounded transition-colors {{ $activePage === 'guest-lists' ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'hover:bg-indigo-50' }}">
                Guest Lists
            </a>
            <a href="{{ route('manager.showGenerateExternalQRCodes') }}" 
               class="block pl-4 py-2 rounded transition-colors {{ $activePage === 'qr-codes' ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'hover:bg-indigo-50' }}">
                Generate QR Codes
            </a>
        </div>

        <!-- Reports & Analytics Section -->
        <div>
            <p class="mt-6 font-semibold text-gray-900 mb-2">Reports & Analytics</p>
            <a href="#" 
               class="block pl-4 py-2 rounded transition-colors {{ $activePage === 'event-summary' ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'hover:bg-indigo-50' }}">
                Event Summary
            </a>
            <a href="#" 
               class="block pl-4 py-2 rounded transition-colors {{ $activePage === 'feedback-summary' ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'hover:bg-indigo-50' }}">
                Feedback Summary
            </a>
        </div>

        <!-- Settings Section -->
        <div>
            <p class="mt-6 font-semibold text-gray-900 mb-2">Settings</p>
            <a href="#" 
               class="block pl-4 py-2 rounded transition-colors {{ $activePage === 'account-settings' ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'hover:bg-indigo-50' }}">
                Account Settings
            </a>
        </div>
    </nav>

    <!-- Logout Section -->
    <div class="px-6 py-4 border-t border-gray-200">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="block text-red-600 font-semibold hover:text-red-700 transition-colors">
                Logout
            </button>
        </form>
    </div>
</aside>
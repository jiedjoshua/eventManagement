<x-manager-layout title="Upcoming Events" :active-page="'upcoming-events'">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Upcoming Events</h1>
                <p class="text-gray-600 mt-1">Manage and view all upcoming events</p>
            </div>

            <!-- Stats Cards -->
            <div class="flex gap-4">
                <div class="flex items-center bg-gradient-to-r from-indigo-100 to-indigo-50 px-6 py-4 rounded-xl shadow border border-indigo-200 min-w-[140px]">
                    <div class="bg-indigo-500 text-white rounded-full p-2 mr-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-indigo-700">{{ $events->total() }}</div>
                        <div class="text-sm text-gray-600">Total Events</div>
                    </div>
                </div>
                <div class="flex items-center bg-gradient-to-r from-green-100 to-green-50 px-6 py-4 rounded-xl shadow border border-green-200 min-w-[140px]">
                    <div class="bg-green-500 text-white rounded-full p-2 mr-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-green-700">
                            {{ $events->where('booking.payment_status', 'paid')->count() }}
                        </div>
                        <div class="text-sm text-gray-600">Fully Paid</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Filter Section -->
        <div class="bg-gradient-to-r from-white via-indigo-50 to-white p-8 rounded-2xl shadow border border-gray-100 mt-4">
            <div class="flex flex-wrap gap-6 items-end">
                <div class="flex-1 min-w-48">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Event Type</label>
                    <select name="event_type" id="eventTypeFilter" onchange="applyFilters()"
                        class="w-full rounded-xl border-gray-300 shadow focus:border-indigo-500 focus:ring-indigo-500 text-base py-2 px-3">
                        <option value="">All Event Types</option>
                        <option value="wedding" {{ request('event_type') == 'wedding' ? 'selected' : '' }}>Wedding</option>
                        <option value="birthday" {{ request('event_type') == 'birthday' ? 'selected' : '' }}>Birthday</option>
                        <option value="corporate" {{ request('event_type') == 'corporate' ? 'selected' : '' }}>Corporate</option>
                        <option value="debut" {{ request('event_type') == 'debut' ? 'selected' : '' }}>Debut</option>
                    </select>
                </div>

                <div class="flex-1 min-w-48">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Payment Status</label>
                    <select name="payment_status" id="paymentStatusFilter" onchange="applyFilters()"
                        class="w-full rounded-xl border-gray-300 shadow focus:border-indigo-500 focus:ring-indigo-500 text-base py-2 px-3">
                        <option value="">All Payments</option>
                        <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Fully Paid</option>
                        <option value="partial" {{ request('payment_status') == 'partial' ? 'selected' : '' }}>Partial Payment</option>
                        <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>No Payment</option>
                    </select>
                </div>

                <div class="flex-1 min-w-48">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Sort By</label>
                    <select name="sort" id="sortFilter" onchange="applyFilters()"
                        class="w-full rounded-xl border-gray-300 shadow focus:border-indigo-500 focus:ring-indigo-500 text-base py-2 px-3">
                        <option value="">Default</option>
                        <option value="date-asc" {{ request('sort') == 'date-asc' ? 'selected' : '' }}>Date (Earliest)</option>
                        <option value="date-desc" {{ request('sort') == 'date-desc' ? 'selected' : '' }}>Date (Latest)</option>
                        <option value="name-asc" {{ request('sort') == 'name-asc' ? 'selected' : '' }}>Name (A-Z)</option>
                        <option value="name-desc" {{ request('sort') == 'name-desc' ? 'selected' : '' }}>Name (Z-A)</option>
                    </select>
                </div>

                <div class="flex items-end">
                    <button onclick="clearFilters()"
                        class="px-5 py-2 bg-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-300 transition-colors shadow">
                        Clear Filters
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Events Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($events as $event)
        @php
        $isPast = \Carbon\Carbon::parse($event->event_date)->endOfDay()->lt(now());
        $paymentStatus = $event->booking->payment_status ?? 'unknown';
        $borderColor = match($paymentStatus) {
            'paid' => 'border-green-400',
            'partial' => 'border-blue-400',
            'pending' => 'border-red-400',
            default => 'border-gray-300',
        };
        $eventTypeColor = match($event->event_type) {
            'wedding' => 'bg-pink-100 text-pink-700',
            'birthday' => 'bg-yellow-100 text-yellow-700',
            'corporate' => 'bg-blue-100 text-blue-700',
            'debut' => 'bg-purple-100 text-purple-700',
            default => 'bg-gray-100 text-gray-700',
        };
        @endphp
        <div class="relative bg-white rounded-2xl shadow-lg border-l-8 {{ $borderColor }} overflow-hidden hover:scale-[1.025] hover:shadow-2xl transition-transform duration-200">
            <!-- Event Type Badge -->
            <span class="absolute top-16 right-4 px-3 py-1 rounded-full text-xs font-semibold {{ $eventTypeColor }} shadow">{{ ucfirst($event->event_type) }}</span>
            <!-- Payment Status Header -->
            <div class="px-6 pt-6 pb-2 border-b border-gray-100">
                <div class="flex justify-between items-start">
                    <span class="text-xs text-gray-400 font-mono tracking-wider">{{ strtoupper($event->booking->reference ?? 'N/A') }}</span>
                    @if($event->booking && $event->booking->payment_status === 'paid')
                    <span class="inline-flex items-center px-3 py-1 text-sm font-semibold text-green-800 bg-green-100 rounded-full">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        Full Payment
                    </span>
                    @elseif($event->booking && $event->booking->payment_status === 'partial')
                    <span class="inline-flex items-center px-3 py-1 text-sm font-semibold text-blue-800 bg-blue-100 rounded-full">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path>
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        20% Downpayment
                    </span>
                    @elseif($event->booking && $event->booking->payment_status === 'pending')
                    <span class="inline-flex items-center px-3 py-1 text-sm font-semibold text-red-800 bg-red-100 rounded-full">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        No Payment
                    </span>
                    @else
                    <span class="inline-flex items-center px-3 py-1 text-sm font-semibold text-gray-800 bg-gray-100 rounded-full">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        Unknown
                    </span>
                    @endif
                </div>
            </div>

            <!-- Event Content -->
            <div class="p-6 space-y-4">
                <!-- Event Title -->
                <h3 class="text-2xl font-bold text-gray-900 mb-2 line-clamp-2">{{ ucwords($event->event_name) }}</h3>

                <!-- Event Details -->
                <div class="space-y-2 text-gray-600">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span class="font-medium">{{ \Carbon\Carbon::parse($event->event_date)->format('F d, Y') }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="font-medium">
                            {{ \Carbon\Carbon::parse($event->start_time)->format('g:i A') }} -
                            {{ \Carbon\Carbon::parse($event->end_time)->format('g:i A') }}
                        </span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span class="font-medium">{{ ucwords($event->venue_name) }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span class="font-medium">{{ $event->guest_count }} Guests</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                        <span class="font-medium">{{ ucwords($event->package_type) }}</span>
                    </div>
                </div>

                <!-- Action Buttons -->
                @if(!$isPast)
                <div class="mt-6 space-y-2">
                    <!-- Primary Actions Row -->
                    <div class="flex gap-2">
                        <button onclick="showEventDetails('{{ $event->id }}')"
                            class="flex-1 bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition-colors font-medium shadow">
                            View Details
                        </button>
                        <button onclick="showReschedModal('{{ $event->id }}')"
                            class="flex-1 bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700 transition-colors font-medium shadow">
                            Reschedule
                        </button>
                    </div>

                    <!-- Secondary Actions Row -->
                    <div class="flex gap-2">
                        <a href="{{ route('events.dashboard', $event->id) }}"
                            class="flex-1 bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors font-medium text-center shadow">
                            Event Mode
                        </a>
                        <button onclick="showCancelModal('{{ $event->id }}', '{{ addslashes($event->event_name) }}')"
                            class="flex-1 bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors font-medium shadow">
                            Cancel Event
                        </button>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-16">
            <div class="max-w-md mx-auto">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No Upcoming Events</h3>
                <p class="text-gray-600">Events that are scheduled for future dates will appear here.</p>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Enhanced Pagination -->
    @if($events->hasPages())
    <div class="mt-8 flex justify-center">
        <div class="bg-white px-6 py-4 rounded-2xl shadow-lg border border-gray-200 flex items-center">
            <style>
                .custom-pagination .page-link {
                    @apply mx-1 px-4 py-2 rounded-lg text-base font-semibold text-gray-700 bg-gray-100 hover:bg-indigo-100 hover:text-indigo-700 transition-colors duration-150 shadow-sm;
                }
                .custom-pagination .active .page-link {
                    @apply bg-indigo-600 text-white shadow;
                }
                .custom-pagination .disabled .page-link {
                    @apply opacity-50 cursor-not-allowed;
                }
            </style>
            <div class="custom-pagination">
                {!! $events->appends(request()->query())->links() !!}
            </div>
        </div>
    </div>
    @endif
    </main>

    @push('modals')
    <!-- Event Details Modal -->
    <div id="eventDetailsModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
            <div id="modalContent">
                <!-- Modal content will be populated by JavaScript -->
            </div>
        </div>
    </div>

    <!-- Reschedule Event Modal -->
    <div id="reschedModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-1/2 lg:w-1/3 shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-gray-900">Reschedule Event</h3>
                <button onclick="closeReschedModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form id="reschedForm" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')

                <div>
                    <label for="event_date" class="block text-sm font-medium text-gray-700 mb-2">New Event Date</label>
                    <input type="date" name="event_date" id="event_date" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="start_time" class="block text-sm font-medium text-gray-700 mb-2">Start Time</label>
                        <input type="time" name="start_time" id="start_time" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                    </div>
                    <div>
                        <label for="end_time" class="block text-sm font-medium text-gray-700 mb-2">End Time</label>
                        <input type="time" name="end_time" id="end_time" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                    </div>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="button" onclick="closeReschedModal()"
                        class="flex-1 bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition-colors font-medium">
                        Cancel
                    </button>
                    <button type="submit"
                        class="flex-1 bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700 transition-colors font-medium">
                        Reschedule Event
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Cancel Event Modal -->
    <div id="cancelModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-1/2 lg:w-1/3 shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-gray-900">Cancel Event</h3>
                <button onclick="closeCancelModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div class="mb-6">
                <p class="text-gray-700 mb-4">Are you sure you want to cancel this event?</p>
                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="flex">
                        <svg class="w-5 h-5 text-red-400 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <h4 class="text-sm font-medium text-red-800">Event to Cancel:</h4>
                            <p class="text-sm text-red-700 mt-1" id="cancelEventName"></p>
                        </div>
                    </div>
                </div>
            </div>

            <form id="cancelEventForm" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')
                <div>
                    <label for="cancel_reason" class="block text-sm font-medium text-gray-700 mb-2">Cancellation Reason</label>
                    <textarea id="cancel_reason" name="cancel_reason" rows="3"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                        placeholder="Please provide a reason for cancellation..." required></textarea>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="button" onclick="closeCancelModal()"
                        class="flex-1 bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition-colors font-medium">
                        Keep Event
                    </button>
                    <button type="submit"
                        class="flex-1 bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors font-medium">
                        Confirm Cancellation
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endpush

    @push('notifications')
    <!-- Error Notification Popup -->
    <div id="errorNotification" class="hidden fixed top-4 right-4 bg-red-500 text-white px-6 py-4 rounded-lg shadow-lg transform transition-transform duration-300 ease-in-out">
        <div class="flex items-center space-x-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
            <span id="errorMessage"></span>
        </div>
    </div>

    <!-- Success Notification Popup -->
    <div id="successNotification" class="hidden fixed top-4 right-4 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg transform transition-transform duration-300 ease-in-out">
        <div class="flex items-center space-x-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span id="notificationMessage"></span>
        </div>
    </div>
    @endpush
   @push('scripts')
<script>
    // Notification functions
    function showNotification(message) {
        const notification = document.getElementById('successNotification');
        const messageElement = document.getElementById('notificationMessage');
        messageElement.textContent = message;

        notification.classList.remove('hidden');
        notification.classList.add('transform', 'translate-y-0');

        setTimeout(() => {
            notification.classList.add('transform', '-translate-y-full');
            setTimeout(() => {
                notification.classList.add('hidden');
            }, 300);
        }, 3500);
    }

    function showErrorNotification(message) {
        const notification = document.getElementById('errorNotification');
        const messageElement = document.getElementById('errorMessage');
        messageElement.textContent = message;

        notification.classList.remove('hidden');
        notification.classList.add('transform', 'translate-y-0');

        setTimeout(() => {
            notification.classList.add('transform', '-translate-y-full');
            setTimeout(() => {
                notification.classList.add('hidden');
            }, 300);
        }, 3500);
    }

    // Filter functions
    function applyFilters() {
        const eventType = document.getElementById('eventTypeFilter').value;
        const paymentStatus = document.getElementById('paymentStatusFilter').value;
        const sort = document.getElementById('sortFilter').value;

        let url = new URL(window.location.href);

        if (eventType) url.searchParams.set('event_type', eventType);
        else url.searchParams.delete('event_type');

        if (paymentStatus) url.searchParams.set('payment_status', paymentStatus);
        else url.searchParams.delete('payment_status');

        if (sort) url.searchParams.set('sort', sort);
        else url.searchParams.delete('sort');

        window.location.href = url.toString();
    }

    function clearFilters() {
        window.location.href = window.location.pathname;
    }

    // Modal functions
    function showEventDetails(eventId) {
        console.log('Opening modal for event:', eventId);
        
        const modal = document.getElementById('eventDetailsModal');
        const content = document.getElementById('modalContent');

        if (!modal) {
            console.error('Modal element not found!');
            showErrorNotification('Modal element not found!');
            return;
        }

        if (!content) {
            console.error('Modal content element not found!');
            showErrorNotification('Modal content element not found!');
            return;
        }

        // Show loading state
        content.innerHTML = '<div class="p-6 text-center">Loading...</div>';
        modal.classList.remove('hidden');

        // Fetch event details
        fetch(`/manager/events/${eventId}/details`)
            .then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Event data:', data);

                const event = data.event;

                // Helper function to safely handle null/undefined values
                function toTitleCase(str) {
                    if (!str || str === null || str === undefined) {
                        return 'N/A';
                    }
                    return str.toString().replace(/\w\S*/g, function(txt) {
                        return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
                    });
                }

                // Helper function to safely get nested properties
                function safeGet(obj, path, defaultValue = 'N/A') {
                    return path.split('.').reduce((current, key) => {
                        return current && current[key] !== undefined ? current[key] : defaultValue;
                    }, obj);
                }

                // Helper function to format time (e.g., "13:00" to "1:00 PM")
                function formatTime(timeString) {
                    if (!timeString) return 'N/A';
                    try {
                        const [hours, minutes] = timeString.split(':');
                        const hour = parseInt(hours);
                        const ampm = hour >= 12 ? 'PM' : 'AM';
                        const displayHour = hour % 12 || 12;
                        return `${displayHour}:${minutes} ${ampm}`;
                    } catch (e) {
                        return timeString; // Return original if parsing fails
                    }
                }

                content.innerHTML = `
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-6">
                            <h3 class="text-2xl font-bold text-gray-900">${toTitleCase(event.event_name)}</h3>
                            <button onclick="closeEventModal()" class="text-gray-500 hover:text-gray-700">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Event Type</h4>
                                    <p class="text-lg">${toTitleCase(event.event_type)}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Date</h4>
                                    <p class="text-lg">${event.event_date ? new Date(event.event_date).toLocaleDateString('en-US', { 
                                        weekday: 'long',
                                        year: 'numeric',
                                        month: 'long',
                                        day: 'numeric'
                                    }) : 'N/A'}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Time</h4>
                                    <p class="text-lg">${formatTime(event.start_time)} - ${formatTime(event.end_time)}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Venue</h4>
                                    <p class="text-lg">${toTitleCase(event.venue_name)}</p>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Package Type</h4>
                                    <p class="text-lg">${toTitleCase(event.package_type)}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Guest Count</h4>
                                    <p class="text-lg">${event.guest_count || 0} Guests</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Reference Number</h4>
                                    <p class="text-lg">${safeGet(event, 'booking.reference', 'N/A').toUpperCase()}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Status</h4>
                                    <p class="text-lg">${toTitleCase(event.status)}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Person Section -->
                        <div class="mt-8 border-t pt-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Contact Person</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Name</h4>
                                    <p class="text-lg">${toTitleCase(safeGet(event, 'contact_person.name', 'N/A'))}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Phone</h4>
                                    <p class="text-lg">${safeGet(event, 'contact_person.phone', 'N/A')}</p>
                                </div>
                                <div class="md:col-span-2">
                                    <h4 class="text-sm font-medium text-gray-500">Email</h4>
                                    <p class="text-lg">${safeGet(event, 'contact_person.email', 'N/A')}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            })
            .catch(error => {
                console.error('Error fetching event details:', error);
                showErrorNotification('Failed to load event details. Please try again.');
                content.innerHTML = `
                    <div class="p-6 text-center">
                        <p class="text-red-600">Failed to load event details.</p>
                        <p class="text-sm text-gray-500 mt-2">${error.message}</p>
                        <button onclick="closeEventModal()" class="mt-4 px-4 py-2 bg-gray-300 rounded">Close</button>
                    </div>
                `;
            });
    }

    function closeEventModal() {
        const modal = document.getElementById('eventDetailsModal');
        if (modal) {
            modal.classList.add('hidden');
        }
    }

    function showReschedModal(eventId) {
        console.log('showReschedModal called with eventId:', eventId);
        
        const modal = document.getElementById('reschedModal');
        const form = document.getElementById('reschedForm');

        if (!modal) {
            console.error('Reschedule modal not found!');
            showErrorNotification('Modal not found!');
            return;
        }

        if (!form) {
            console.error('Reschedule form not found!');
            showErrorNotification('Form not found!');
            return;
        }

        console.log('Modal and form found, showing modal...');
        modal.classList.remove('hidden');

        console.log('Fetching event details...');
        fetch(`/manager/events/${eventId}/details`)
            .then(response => {
                console.log('Fetch response status:', response.status);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Event data received:', data);
                const event = data.event;
                
                const dateInput = document.querySelector('input[name="event_date"]');
                const startTimeInput = document.querySelector('input[name="start_time"]');
                const endTimeInput = document.querySelector('input[name="end_time"]');
                
                console.log('Form inputs found:', {
                    dateInput: !!dateInput,
                    startTimeInput: !!startTimeInput,
                    endTimeInput: !!endTimeInput
                });
                
                // Format date
                if (dateInput && event.event_date) {
                    let formattedDate;
                    if (event.event_date.includes('T')) {
                        formattedDate = event.event_date.split('T')[0];
                    } else {
                        formattedDate = event.event_date;
                    }
                    dateInput.value = formattedDate;
                    console.log('Set date to:', formattedDate);
                }
                
                // Format start time - ensure HH:mm format
                if (startTimeInput && event.start_time) {
                    console.log('Raw start_time:', event.start_time);
                    
                    let formattedStartTime = event.start_time;
                    
                    // If it's in H:mm format, convert to HH:mm
                    if (formattedStartTime.match(/^\d{1}:\d{2}$/)) {
                        const [hours, minutes] = formattedStartTime.split(':');
                        formattedStartTime = `${hours.padStart(2, '0')}:${minutes}`;
                    }
                    
                    startTimeInput.value = formattedStartTime;
                    console.log('Set start time to:', formattedStartTime);
                }
                
                // Format end time - ensure HH:mm format
                if (endTimeInput && event.end_time) {
                    console.log('Raw end_time:', event.end_time);
                    
                    let formattedEndTime = event.end_time;
                    
                    // If it's in H:mm format, convert to HH:mm
                    if (formattedEndTime.match(/^\d{1}:\d{2}$/)) {
                        const [hours, minutes] = formattedEndTime.split(':');
                        formattedEndTime = `${hours.padStart(2, '0')}:${minutes}`;
                    }
                    
                    endTimeInput.value = formattedEndTime;
                    console.log('Set end time to:', formattedEndTime);
                }
                
                form.action = `/manager/events/${eventId}/reschedule`;
                console.log('Set form action to:', form.action);
            })
            .catch(error => {
                console.error('Error in showReschedModal:', error);
                showErrorNotification('Failed to load event details for rescheduling.');
                modal.classList.add('hidden');
            });
    }

    function closeReschedModal() {
        console.log('closeReschedModal called');
        const modal = document.getElementById('reschedModal');
        if (modal) {
            modal.classList.add('hidden');
            console.log('Modal hidden');
        } else {
            console.error('Reschedule modal not found for closing');
        }
    }

    function showCancelModal(eventId, eventName) {
        const modal = document.getElementById('cancelModal');
        const form = document.getElementById('cancelEventForm');
        const eventNameElement = document.getElementById('cancelEventName');
        
        if (!modal || !form || !eventNameElement) {
            showErrorNotification('Modal elements not found!');
            return;
        }
        
        eventNameElement.textContent = eventName;
        form.action = `/manager/events/${eventId}/cancel`;
        modal.classList.remove('hidden');
    }
    
    function closeCancelModal() {
        const modal = document.getElementById('cancelModal');
        if (modal) {
            modal.classList.add('hidden');
            const form = document.getElementById('cancelEventForm');
            if (form) form.reset();
        }
    }

    // Initialize everything when DOM is loaded
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize filters from URL parameters
        const urlParams = new URLSearchParams(window.location.search);
        ['eventTypeFilter', 'paymentStatusFilter', 'sortFilter'].forEach(filterId => {
            const paramName = filterId.replace('Filter', '').toLowerCase();
            const value = urlParams.get(paramName);
            if (value) {
                document.getElementById(filterId).value = value;
            }
        });

        // Set up modal click-outside-to-close
        ['eventDetailsModal', 'reschedModal', 'cancelModal'].forEach(modalId => {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        if (modalId === 'eventDetailsModal') closeEventModal();
                        else if (modalId === 'reschedModal') closeReschedModal();
                        else if (modalId === 'cancelModal') closeCancelModal();
                    }
                });
            }
        });

       // Handle cancel form submission
const cancelForm = document.getElementById('cancelEventForm');
if (cancelForm) {
    cancelForm.addEventListener('submit', function(e) {
        e.preventDefault(); // Prevent normal form submission

        const formData = new FormData(this);
        const reason = formData.get('cancel_reason');

        if (!reason.trim()) {
            showErrorNotification('Please provide a cancellation reason.');
            return;
        }

        // Get CSRF token safely
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                         document.querySelector('input[name="_token"]')?.value;

        if (!csrfToken) {
            showErrorNotification('CSRF token not found. Please refresh the page.');
            return;
        }

        console.log('Submitting cancel form to:', this.action);
        console.log('Form data:', Object.fromEntries(formData));

        fetch(this.action, {
            method: 'POST', // Use POST for AJAX, Laravel will handle the method override
            body: formData,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => {
            console.log('Response status:', response.status);
            
            if (!response.ok) {
                return response.text().then(text => {
                    console.log('Response text:', text);
                    throw new Error(`HTTP ${response.status}: ${text}`);
                });
            }
            
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            if (data.success) {
                showNotification(data.message || 'Event cancelled successfully!');
                closeCancelModal();
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                showErrorNotification(data.message || 'Failed to cancel event.');
            }
        })
        .catch(error => {
            console.error('Error cancelling event:', error);
            showErrorNotification('An error occurred while cancelling the event: ' + error.message);
        });
    });
}

        // Handle reschedule form submission
        const reschedForm = document.getElementById('reschedForm');
        if (reschedForm) {
            reschedForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);

                // Get CSRF token safely
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                                 document.querySelector('input[name="_token"]')?.value;

                if (!csrfToken) {
                    showErrorNotification('CSRF token not found. Please refresh the page.');
                    return;
                }

                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification(data.message || 'Event rescheduled successfully!');
                        closeReschedModal();
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    } else {
                        showErrorNotification(data.message || 'Failed to reschedule event.');
                    }
                })
                .catch(error => {
                    console.error('Error rescheduling event:', error);
                    showErrorNotification('An error occurred while rescheduling the event.');
                });
            });
        }

        // Show session messages
        @if(session('error'))
            showErrorNotification("{{ session('error') }}");
        @endif

        @if(session('success'))
            showNotification("{{ session('success') }}");
        @endif
    });
</script>
@endpush
    </x-manager-layoutt>
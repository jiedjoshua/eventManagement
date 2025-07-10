<x-manager-layout title="Booked Events" :active-page="'booked-events'">
        <h1 class="text-3xl font-bold mb-8">Booked Events</h1>

        <!-- Search Form -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <form method="GET" action="{{ route('manager.bookedEvents') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                    <input type="text" 
                           name="search" 
                           id="search" 
                           value="{{ request('search') }}"
                           placeholder="Reference, Event Name, Customer..."
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="status" 
                            id="status" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">All Statuses</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
                
                <div>
                    <label for="event_type" class="block text-sm font-medium text-gray-700 mb-2">Event Type</label>
                    <select name="event_type" 
                            id="event_type" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">All Types</option>
                        <option value="wedding" {{ request('event_type') === 'wedding' ? 'selected' : '' }}>Wedding</option>
                        <option value="birthday" {{ request('event_type') === 'birthday' ? 'selected' : '' }}>Birthday</option>
                        <option value="baptism" {{ request('event_type') === 'baptism' ? 'selected' : '' }}>Baptism</option>
                    </select>
                </div>
                
                <div class="flex items-end space-x-2">
                    <button type="submit" 
                            class="flex-1 bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        Search
                    </button>
                    <a href="{{ route('manager.bookedEvents') }}" 
                       class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500">
                        Clear
                    </a>
                </div>
            </form>
        </div>

        <!-- Results Summary -->
        @if(request('search') || request('status') || request('event_type'))
            <div class="bg-blue-50 border border-blue-200 rounded-md p-4 mb-6">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-blue-800">
                        <span class="font-medium">{{ $bookings->count() }}</span> booking(s) found
                        @if(request('search'))
                            for "<span class="font-medium">{{ request('search') }}</span>"
                        @endif
                        @if(request('status'))
                            with status "<span class="font-medium">{{ ucfirst(request('status')) }}</span>"
                        @endif
                        @if(request('event_type'))
                            of type "<span class="font-medium">{{ ucfirst(request('event_type')) }}</span>"
                        @endif
                    </div>
                    <a href="{{ route('manager.bookedEvents') }}" class="text-blue-600 hover:text-blue-800 text-sm">
                        Clear filters
                    </a>
                </div>
            </div>
        @endif

        <!-- Booking List -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reference</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Event Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Event Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Time</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Guest Count</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($bookings as $booking)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $booking->reference }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $booking->event_name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $booking->user->first_name }} {{ $booking->user->last_name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ ucfirst($booking->event_type) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ date('M d, Y', strtotime($booking->event_date)) }}<br>
                                {{ date('h:i A', strtotime($booking->start_time)) }} - {{ date('h:i A', strtotime($booking->end_time)) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $booking->guest_count }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $booking->status === 'approved' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $booking->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <button onclick="showViewModal('{{ $booking->id }}')"
                                        class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded">
                                        View
                                    </button>

                                    @if($booking->status === 'pending')
                                    <form action="{{ route('manager.approveBooking', $booking->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded">
                                            Approve
                                        </button>
                                    </form>

                                    <button onclick="showRejectModal('{{ $booking->id }}')"
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                                        Reject
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                                @if(request('search') || request('status') || request('event_type'))
                                    No bookings found matching your search criteria.
                                @else
                                    No bookings found.
                                @endif
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @push('modals')
        <!-- View Modal -->
        <div id="viewModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
            <div class="relative top-20 mx-auto p-5 border w-3/4 max-w-2xl shadow-lg rounded-md bg-white">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-900">Booking Details</h3>
                    <button onclick="closeViewModal()" class="text-gray-500 hover:text-gray-700">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div id="bookingDetails" class="mt-4">

                </div>
            </div>
        </div>

        <!-- Reject Modal -->
        <div id="rejectModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="mt-3 text-center">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Reject Booking</h3>
                    <div class="mt-2 px-7 py-3">
                        <form id="rejectForm" action="" method="POST">
                            @csrf
                            @method('PATCH')
                            <textarea name="rejection_reason" class="w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none" rows="4" placeholder="Enter reason for rejection..." required></textarea>
                            <div class="flex justify-end space-x-2 mt-4">
                                <button type="button" onclick="closeRejectModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded">Cancel</button>
                                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded">Confirm Reject</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endpush
    </main>
@push('scripts')
    <script>
        function showViewModal(bookingId) {
            const modal = document.getElementById('viewModal');
            const detailsContainer = document.getElementById('bookingDetails');

            // Fetch booking details
            fetch(`/manager/bookings/${bookingId}/details`)
                .then(response => response.json())
                .then(data => {
                    const booking = data.booking;

                    // Safely handle selected_addons
                    let addonsHtml = '<li>No add-ons selected</li>';
                    if (booking.selected_addons && typeof booking.selected_addons === 'string' && booking.selected_addons.trim() !== '') {
                        try {
                            const addons = JSON.parse(booking.selected_addons);
                            if (Array.isArray(addons) && addons.length > 0) {
                                addonsHtml = addons.map(addon =>
                                    `<li class="text-base">${addon}</li>`
                                ).join('');
                            } else if (typeof addons === 'object' && addons !== null) {
                                // Handle case where addons might be an object
                                const addonNames = Object.values(addons).filter(name => name && name.trim() !== '');
                                if (addonNames.length > 0) {
                                    addonsHtml = addonNames.map(addon =>
                                        `<li class="text-base">${addon}</li>`
                                    ).join('');
                                }
                            }
                        } catch (e) {
                            console.log('Error parsing addons:', e);
                            // Try to display as plain text if JSON parsing fails
                            if (typeof booking.selected_addons === 'string' && booking.selected_addons.trim() !== '') {
                                addonsHtml = `<li class="text-base">${booking.selected_addons}</li>`;
                            } else {
                                addonsHtml = '<li>No add-ons selected</li>';
                            }
                        }
                    }

                    // Check if church should be displayed (for wedding or baptism events)
                    const showChurch = booking.event_type === 'wedding' || booking.event_type === 'baptism';
                    const churchHtml = showChurch ? `
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Church</h4>
                            <p class="text-base">${booking.church ? booking.church.name : 'N/A'}</p>
                        </div>
                    ` : '';

                    detailsContainer.innerHTML = `
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-4">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Reference Number</h4>
                            <p class="text-base">${booking.reference}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Event Name</h4>
                            <p class="text-base">${booking.event_name}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Event Type</h4>
                            <p class="text-base">${booking.event_type}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Date & Time</h4>
                            <p class="text-base">${booking.formatted_date}</p>
                            <p class="text-base">${booking.formatted_time}</p>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Venue</h4>
                            <p class="text-base">${booking.venue ? booking.venue.name : 'N/A'}</p>
                        </div>
                        ${churchHtml}
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Package</h4>
                            <p class="text-base">${booking.package ? booking.package.name : 'N/A'}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Guest Count</h4>
                            <p class="text-base">${booking.guest_count}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Total Price</h4>
                            <p class="text-base">₱${booking.total_price.toLocaleString('en-PH')}</p>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <h4 class="text-sm font-medium text-gray-500">Additional Notes</h4>
                    <p class="text-base">${booking.additional_notes || 'No additional notes'}</p>
                </div>
                <div class="mt-4">
                    <h4 class="text-sm font-medium text-gray-500">Selected Add-ons</h4>
                    <ul class="list-disc list-inside">
                        ${addonsHtml}
                    </ul>
                </div>
            `;
                })
                .catch(error => {
                    console.error('Error fetching booking details:', error);
                    detailsContainer.innerHTML = `
                <div class="text-red-500">
                    Error loading booking details. Please try again.
                </div>
            `;
                });

            modal.classList.remove('hidden');
        }

        function closeViewModal() {
            const modal = document.getElementById('viewModal');
            modal.classList.add('hidden');
        }

        function showRejectModal(bookingId) {
            const modal = document.getElementById('rejectModal');
            const form = document.getElementById('rejectForm');
            form.action = `/manager/bookings/${bookingId}/reject`;
            modal.classList.remove('hidden');
        }

        function closeRejectModal() {
            const modal = document.getElementById('rejectModal');
            modal.classList.add('hidden');
        }
    </script>
@endpush
    </x-manager-layout>
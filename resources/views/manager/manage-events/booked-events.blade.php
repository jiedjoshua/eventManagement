<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Booked Events</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="flex h-screen bg-gray-100">
    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-md flex flex-col">
        <div class="p-6 text-2xl font-bold text-indigo-600">Manager Panel</div>
        <nav class="flex-1 px-4 space-y-2 text-sm text-gray-700">
            <!-- Menu -->
            <div>
                <p class="font-semibold text-gray-900">Home</p>
                <a href="{{ route('manager.dashboard') }} " class="block pl-4 py-2 hover:bg-indigo-100 rounded">Dashboard</a>
            </div>

            <div>
                <p class="mt-4 font-semibold text-gray-900">Manage Events</p>
                <a href="{{ route('manager.showEvent') }}" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Events</a>
                <a href="{{ route('manager.bookedEvents') }}" class="block pl-4 py-2 rounded bg-indigo-200 font-semibold text-indigo-800">Booked Events</a>
                <a href="#" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Upcoming Events</a>
                <a href="#" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Create Event</a>
            </div>

            <div>
                <p class="mt-4 font-semibold text-gray-900">RSVP Management</p>
                <a href="#" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Guest Lists</a>
                <a href="#" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Generate QR Codes</a>
            </div>

            <div>
                <p class="mt-4 font-semibold text-gray-900">Reports & Analytics</p>
                <a href="#" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Event Summary</a>
                <a href="#" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Feedback Summary</a>
            </div>

            <div>
                <p class="mt-4 font-semibold text-gray-900">Settings</p>
                <a href="#" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Account Settings</a>
            </div>
        </nav>

        <div class="px-6 py-4 border-t">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="block text-red-600 font-semibold hover:underline">
                    Logout
                </button>
            </form>
        </div>

    </aside>



    <!-- Main Content -->
    <main class="flex-1 p-10 overflow-auto">
        <h1 class="text-3xl font-bold mb-8">Booked Events</h1>

        <!-- Booking List -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reference</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Event Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Event Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Time</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Guest Count</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($bookings as $booking)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $booking->reference }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $booking->event_name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $booking->event_type }}
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
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

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
    </main>

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
                    if (booking.selected_addons) {
                        try {
                            const addons = JSON.parse(booking.selected_addons);
                            if (Array.isArray(addons) && addons.length > 0) {
                                addonsHtml = addons.map(addon =>
                                    `<li class="text-base">${addon}</li>`
                                ).join('');
                            }
                        } catch (e) {
                            console.log('Error parsing addons:', e);
                            addonsHtml = '<li>Error loading add-ons</li>';
                        }
                    }

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
</body>

</html>
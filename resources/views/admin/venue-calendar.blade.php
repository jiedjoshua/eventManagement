<x-admin-layout title="Venue Calendar" active-page="venue-calendar">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Venue Calendar</h1>
                <p class="text-gray-600 mt-1">View venue availability and bookings</p>
            </div>

            <!-- Calendar Navigation -->
            <div class="flex items-center gap-4">
                <button onclick="previousMonth()" class="p-2 rounded-lg border border-gray-300 hover:bg-gray-50">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                <h2 id="currentMonth" class="text-xl font-semibold text-gray-900"></h2>
                <button onclick="nextMonth()" class="p-2 rounded-lg border border-gray-300 hover:bg-gray-50">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
                <button onclick="goToToday()" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                    Today
                </button>
            </div>
        </div>

        <!-- Venue Filter -->
        <div class="flex gap-4 mb-6">
            <div class="flex-1">
                <label for="venueFilter" class="block text-sm font-medium text-gray-700 mb-2">Select Venue</label>
                <select id="venueFilter" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">All Venues</option>
                    @foreach($venues as $venue)
                    <option value="{{ $venue->id }}">{{ $venue->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end gap-2">
                <button onclick="openMarkUnavailableModal()" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                    Mark Unavailable
                </button>
                <button onclick="refreshCalendar()" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Refresh
                </button>
            </div>
        </div>
        
        <!-- Instructions -->
        <div id="instructions" class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded-lg" style="display: none;">
            <p class="text-sm text-blue-800">
                <strong>How to mark venue as unavailable:</strong> Select a venue, click on a date in the calendar (it will be highlighted with a blue ring), then click "Mark Unavailable".
            </p>
        </div>
    </div>

    <!-- Calendar Grid -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <!-- Calendar Header -->
        <div class="grid grid-cols-7 bg-gray-50 border-b border-gray-200">
            <div class="p-4 text-center text-sm font-medium text-gray-500">Sun</div>
            <div class="p-4 text-center text-sm font-medium text-gray-500">Mon</div>
            <div class="p-4 text-center text-sm font-medium text-gray-500">Tue</div>
            <div class="p-4 text-center text-sm font-medium text-gray-500">Wed</div>
            <div class="p-4 text-center text-sm font-medium text-gray-500">Thu</div>
            <div class="p-4 text-center text-sm font-medium text-gray-500">Fri</div>
            <div class="p-4 text-center text-sm font-medium text-gray-500">Sat</div>
        </div>

        <!-- Calendar Days -->
        <div id="calendarGrid" class="grid grid-cols-7">
            <!-- Calendar days will be populated by JavaScript -->
        </div>
    </div>

    <!-- Legend -->
    <div class="mt-6 bg-white rounded-lg shadow-sm border border-gray-200 p-4">
        <h3 class="text-lg font-medium text-gray-900 mb-3">Legend</h3>
        <div class="flex flex-wrap gap-4">
            <div class="flex items-center">
                <div class="w-4 h-4 bg-green-100 border-2 border-green-500 rounded mr-2"></div>
                <span class="text-sm text-gray-700">Available</span>
            </div>
            <div class="flex items-center">
                <div class="w-4 h-4 bg-red-100 border-2 border-red-500 rounded mr-2"></div>
                <span class="text-sm text-gray-700">Approved</span>
            </div>
            <div class="flex items-center">
                <div class="w-4 h-4 bg-yellow-100 border-2 border-yellow-500 rounded mr-2"></div>
                <span class="text-sm text-gray-700">Pending</span>
            </div>
            <div class="flex items-center">
                <div class="w-4 h-4 bg-gray-200 border-2 border-gray-400 rounded mr-2"></div>
                <span class="text-sm text-gray-700">Cancelled / Rejected</span>
            </div>
            <div class="flex items-center">
                <div class="w-4 h-4 bg-gray-100 border-2 border-gray-300 rounded mr-2"></div>
                <span class="text-sm text-gray-700">Past Date</span>
            </div>
            <div class="flex items-center">
                <div class="w-4 h-4 bg-purple-100 border-2 border-purple-500 rounded mr-2"></div>
                <span class="text-sm text-gray-700">Marked Unavailable</span>
            </div>
        </div>
    </div>

    <!-- Booking Details Modal -->
    <div id="bookingModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-2/3 lg:w-1/2 shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-gray-900">Booking Details</h3>
                <button onclick="closeBookingModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div id="bookingDetails" class="space-y-4">
                <!-- Booking details will be loaded here -->
            </div>
        </div>
    </div>

            <!-- Mark Unavailable Modal -->
        <div id="markUnavailableModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-2/3 lg:w-1/2 shadow-lg rounded-md bg-white">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-900">Mark Venue as Unavailable</h3>
                    <button onclick="closeMarkUnavailableModal()" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <form id="markUnavailableForm" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Venue</label>
                        <p id="selectedVenueName" class="text-gray-900 font-medium"></p>
                        <input type="hidden" id="unavailableVenue" name="venue_id">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Date</label>
                        <p id="selectedDate" class="text-gray-900 font-medium"></p>
                        <input type="hidden" id="unavailableDate" name="date">
                    </div>
                    <div>
                        <label for="unavailabilityType" class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                        <select id="unavailabilityType" name="type" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="full_day">Full Day</option>
                            <option value="partial_day">Partial Day</option>
                        </select>
                    </div>
                    <div id="timeFields" class="hidden space-y-4">
                        <div>
                            <label for="unavailableStartTime" class="block text-sm font-medium text-gray-700 mb-2">Start Time</label>
                            <input type="time" id="unavailableStartTime" name="start_time" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                            <label for="unavailableEndTime" class="block text-sm font-medium text-gray-700 mb-2">End Time</label>
                            <input type="time" id="unavailableEndTime" name="end_time" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    </div>
                    <div>
                        <label for="unavailabilityReason" class="block text-sm font-medium text-gray-700 mb-2">Reason (Optional)</label>
                        <textarea id="unavailabilityReason" name="reason" rows="3" placeholder="e.g., Maintenance, Private event, etc." class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                    </div>
                    <div class="flex justify-end gap-3 pt-4">
                        <button type="button" onclick="closeMarkUnavailableModal()" class="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                            Mark Unavailable
                        </button>
                    </div>
                </form>
            </div>
        </div>

    @push('scripts')
    <script>
        let currentDate = new Date();
        let selectedVenueId = '';
        let selectedDate = null; // Will store as YYYY-MM-DD string
        let bookings = [];
        let unavailabilities = [];

        // Initialize calendar
        document.addEventListener('DOMContentLoaded', function() {
            updateCalendar();
            loadBookings();
            setupUnavailabilityForm();
        });

        // Venue filter change
        document.getElementById('venueFilter').addEventListener('change', function() {
            selectedVenueId = this.value;
            selectedDate = null; // Clear selected date when changing venue
            
            // Show/hide instructions
            const instructions = document.getElementById('instructions');
            const selectedDateInfo = document.getElementById('selectedDateInfo');
            if (selectedVenueId) {
                instructions.style.display = 'block';
                if (selectedDateInfo) {
                    selectedDateInfo.style.display = 'none';
                }
            } else {
                instructions.style.display = 'none';
                if (selectedDateInfo) {
                    selectedDateInfo.style.display = 'none';
                }
            }
            
            loadBookings();
            if (selectedVenueId) {
                loadUnavailabilities();
            } else {
                unavailabilities = [];
                updateCalendar();
            }
        });

        function setupUnavailabilityForm() {
            // Handle unavailability type change
            document.getElementById('unavailabilityType').addEventListener('change', function() {
                const timeFields = document.getElementById('timeFields');
                const startTime = document.getElementById('unavailableStartTime');
                const endTime = document.getElementById('unavailableEndTime');
                
                if (this.value === 'partial_day') {
                    timeFields.classList.remove('hidden');
                    startTime.required = true;
                    endTime.required = true;
                } else {
                    timeFields.classList.add('hidden');
                    startTime.required = false;
                    endTime.required = false;
                }
            });

            // Handle form submission
            document.getElementById('markUnavailableForm').addEventListener('submit', function(e) {
                e.preventDefault();
                markVenueUnavailable();
            });
        }

        function updateCalendar() {
            const year = currentDate.getFullYear();
            const month = currentDate.getMonth();
            
            // Update month display
            const monthNames = ['January', 'February', 'March', 'April', 'May', 'June',
                               'July', 'August', 'September', 'October', 'November', 'December'];
            document.getElementById('currentMonth').textContent = `${monthNames[month]} ${year}`;

            // Get first day of month and number of days
            const firstDay = new Date(year, month, 1);
            const lastDay = new Date(year, month + 1, 0);
            const startDate = new Date(firstDay);
            startDate.setDate(startDate.getDate() - firstDay.getDay());

            const calendarGrid = document.getElementById('calendarGrid');
            calendarGrid.innerHTML = '';

            // Generate calendar days
            for (let i = 0; i < 42; i++) {
                const date = new Date(startDate);
                date.setDate(startDate.getDate() + i);

                const dayElement = document.createElement('div');
                dayElement.className = 'min-h-32 border-r border-b border-gray-200 p-2 relative';

                // Check if date is in current month
                const isCurrentMonth = date.getMonth() === month;
                const isToday = isSameDay(date, new Date());
                const isPast = date < new Date(new Date().setHours(0, 0, 0, 0));

                let dayClass = 'text-gray-400';
                let bgClass = 'bg-gray-50';

                if (isCurrentMonth) {
                    dayClass = 'text-gray-900';
                    bgClass = 'bg-white';
                }

                if (isToday) {
                    dayClass = 'text-red-600 font-bold';
                    bgClass = 'bg-white border-2 border-red-500';
                }

                if (isPast) {
                    bgClass = 'bg-gray-100';
                }

                // Get bookings for this date
                const dateBookings = getBookingsForDate(date);
                const bookingStatus = getBookingStatus(dateBookings);

                // Check for unavailabilities
                const dateUnavailabilities = getUnavailabilitiesForDate(date);
                const hasUnavailability = dateUnavailabilities.length > 0;

                // Apply booking status styling
                if (hasUnavailability) {
                    bgClass = 'bg-purple-100 border-2 border-purple-500';
                } else if (bookingStatus === 'past') {
                    bgClass = 'bg-gray-100';
                } else if (bookingStatus === 'approved') {
                    bgClass = 'bg-red-100 border-2 border-red-500';
                } else if (bookingStatus === 'pending') {
                    bgClass = 'bg-yellow-100 border-2 border-yellow-500';
                } else if (bookingStatus === 'cancelled') {
                    bgClass = 'bg-gray-200 border-2 border-gray-400';
                } else if (!isPast && isCurrentMonth) {
                    bgClass = 'bg-green-100 border-2 border-green-500';
                }

                // Add selection indicator
                if (isSelectedDate(date)) {
                    bgClass += ' ring-4 ring-blue-300';
                }

                dayElement.className = `min-h-32 border-r border-b border-gray-200 p-2 relative ${bgClass}`;

                // Date number
                const dateNumber = document.createElement('div');
                dateNumber.className = `text-sm ${dayClass} font-medium mb-1`;
                dateNumber.textContent = date.getDate();
                dayElement.appendChild(dateNumber);

                // Booking indicators
                if (dateBookings.length > 0) {
                    const bookingIndicator = document.createElement('div');
                    bookingIndicator.className = 'text-xs text-gray-600 mb-1';
                    bookingIndicator.textContent = `${dateBookings.length} booking${dateBookings.length > 1 ? 's' : ''}`;
                    dayElement.appendChild(bookingIndicator);

                    // Show first booking preview
                    const firstBooking = dateBookings[0];
                    const bookingPreview = document.createElement('div');
                    bookingPreview.className = 'text-xs text-gray-700 truncate cursor-pointer hover:bg-gray-200 p-1 rounded';
                    bookingPreview.textContent = toTitleCase(firstBooking.event_name || 'Event');
                    bookingPreview.onclick = () => showBookingDetails(date, dateBookings);
                    dayElement.appendChild(bookingPreview);
                }

                // Click handler for date
                dayElement.onclick = (e) => {
                    // Prevent event bubbling
                    e.stopPropagation();
                    
                    // Store selected date as YYYY-MM-DD string using Philippine timezone
                    const year = date.getFullYear();
                    const month = String(date.getMonth() + 1).padStart(2, '0');
                    const day = String(date.getDate()).padStart(2, '0');
                    selectedDate = `${year}-${month}-${day}`;
                    console.log('Selected date:', selectedDate, 'Day:', date.getDate());
                    
                    updateCalendar(); // Update to show the blue ring
                    
                    // Only show booking details if there are bookings and we're not in mark unavailable mode
                    if (!document.getElementById('markUnavailableModal').classList.contains('hidden')) {
                        return; // Don't show booking details if unavailability modal is open
                    }
                    
                    // Only show booking details if there are actual bookings
                    if (dateBookings.length > 0) {
                        showBookingDetails(date, dateBookings);
                    }
                };

                calendarGrid.appendChild(dayElement);
            }
        }

        function isSameDay(date1, date2) {
            // Normalize dates to avoid timezone issues
            const d1 = new Date(date1.getFullYear(), date1.getMonth(), date1.getDate());
            const d2 = new Date(date2.getFullYear(), date2.getMonth(), date2.getDate());
            
            const same = d1.getTime() === d2.getTime();
            
            return same;
        }

        function isSelectedDate(date) {
            if (!selectedDate) return false;
            
            // Create date string in same format as selectedDate
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            const dateString = `${year}-${month}-${day}`;
            const isSelected = dateString === selectedDate;
            
            // Only log when there's a mismatch for debugging
            if (date.getDate() === 4 && selectedDate && !isSelected) {
                console.log('Debug - Date 4 not selected:', {
                    dateString: dateString,
                    selectedDate: selectedDate,
                    isSelected: isSelected
                });
            }
            
            return isSelected;
        }

        function getBookingsForDate(date) {
            return bookings.filter(booking => {
                const bookingDate = new Date(booking.event_date);
                return isSameDay(bookingDate, date);
            });
        }

        function getUnavailabilitiesForDate(date) {
            return unavailabilities.filter(unavailability => {
                const unavailabilityDate = new Date(unavailability.date);
                return isSameDay(unavailabilityDate, date);
            });
        }

        function getBookingStatus(dateBookings) {
            if (dateBookings.length === 0) return 'available';

            // Check if this is a past date
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            const bookingDate = new Date(dateBookings[0].event_date);
            bookingDate.setHours(0, 0, 0, 0);
            
            if (bookingDate < today) {
                return 'past';
            }

            const hasApproved = dateBookings.some(booking => booking.status === 'approved');
            if (hasApproved) return 'approved';

            const hasPending = dateBookings.some(booking => booking.status === 'pending');
            if (hasPending) return 'pending';

            // If all bookings are either cancelled or rejected
            const allCancelledOrRejected = dateBookings.every(
                booking => booking.status === 'cancelled' || booking.status === 'rejected'
            );
            if (allCancelledOrRejected) return 'cancelled';

            return 'available'; // If only rejected/cancelled bookings exist, treat as available for new bookings but with a visual cue.
        }

        function loadBookings() {
            const params = new URLSearchParams();
            if (selectedVenueId) {
                params.append('venue_id', selectedVenueId);
            }
            params.append('year', currentDate.getFullYear());
            params.append('month', currentDate.getMonth() + 1);

            fetch(`/admin/venue-calendar/bookings?${params}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        bookings = data.bookings;
                        updateCalendar();
                    } else {
                        console.error('Failed to load bookings:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error loading bookings:', error);
                });
        }

        function loadUnavailabilities() {
            if (!selectedVenueId) return;

            const params = new URLSearchParams();
            params.append('venue_id', selectedVenueId);
            params.append('year', currentDate.getFullYear());
            params.append('month', currentDate.getMonth() + 1);

            fetch(`/api/venues/unavailabilities?${params}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        unavailabilities = data.data;
                        updateCalendar();
                    } else {
                        console.error('Failed to load unavailabilities:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error loading unavailabilities:', error);
                });
        }

        function showBookingDetails(date, dateBookings) {
            const modal = document.getElementById('bookingModal');
            const detailsContainer = document.getElementById('bookingDetails');

            const dateUnavailabilities = getUnavailabilitiesForDate(date);
            let content = '';

            // Show unavailabilities first
            if (dateUnavailabilities.length > 0) {
                const unavailabilitiesHtml = dateUnavailabilities.map(unavailability => `
                    <div class="border border-purple-200 rounded-lg p-4 mb-4 bg-purple-50">
                        <div class="flex justify-between items-start mb-2">
                            <h4 class="text-lg font-semibold text-purple-900">Venue Unavailable</h4>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                ${unavailability.type === 'full_day' ? 'Full Day' : 'Partial Day'}
                            </span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="font-medium text-gray-700">Date:</span>
                                <p class="text-gray-900">${new Date(unavailability.date).toLocaleDateString()}</p>
                            </div>
                            ${unavailability.type === 'partial_day' ? `
                            <div>
                                <span class="font-medium text-gray-700">Time:</span>
                                <p class="text-gray-900">${unavailability.start_time} - ${unavailability.end_time}</p>
                            </div>
                            ` : ''}
                            <div class="md:col-span-2">
                                <span class="font-medium text-gray-700">Reason:</span>
                                <p class="text-gray-900">${unavailability.reason || 'No reason provided'}</p>
                            </div>
                            <div class="md:col-span-2">
                                <span class="font-medium text-gray-700">Marked by:</span>
                                <p class="text-gray-900">${unavailability.created_by}</p>
                            </div>
                        </div>
                        <div class="mt-3">
                            <button onclick="removeUnavailability(${unavailability.id})" class="px-3 py-1 bg-red-600 text-white text-sm rounded hover:bg-red-700 transition-colors">
                                Remove Unavailability
                            </button>
                        </div>
                    </div>
                `).join('');
                content += unavailabilitiesHtml;
            }

            // Show bookings
            if (dateBookings.length === 0 && dateUnavailabilities.length === 0) {
                content = `
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No Bookings</h3>
                        <p class="mt-1 text-sm text-gray-500">No bookings for ${date.toLocaleDateString()}</p>
                    </div>
                `;
            } else if (dateBookings.length > 0) {
                const bookingsHtml = dateBookings.map(booking => `
                    <div class="border border-gray-200 rounded-lg p-4 mb-4">
                        <div class="flex justify-between items-start mb-2">
                            <h4 class="text-lg font-semibold text-gray-900">${toTitleCase(booking.event_name || 'Event')}</h4>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${
                                booking.status === 'approved' ? 'bg-green-100 text-green-800' :
                                booking.status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                'bg-gray-100 text-gray-800'
                            }">
                                ${booking.status.charAt(0).toUpperCase() + booking.status.slice(1)}
                            </span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="font-medium text-gray-700">Venue:</span>
                                <p class="text-gray-900">${booking.venue_name}</p>
                            </div>
                            <div>
                                <span class="font-medium text-gray-700">Date:</span>
                                <p class="text-gray-900">${new Date(booking.event_date).toLocaleDateString()}</p>
                            </div>
                            <div>
                                <span class="font-medium text-gray-700">Time:</span>
                                <p class="text-gray-900">${booking.event_time || 'Not specified'}</p>
                            </div>
                            <div>
                                <span class="font-medium text-gray-700">Guest Count:</span>
                                <p class="text-gray-900">${booking.guest_count || 'Not specified'}</p>
                            </div>
                            <div class="md:col-span-2">
                                <span class="font-medium text-gray-700">Client:</span>
                                <p class="text-gray-900">${booking.client_name || 'Not specified'}</p>
                            </div>
                            ${booking.notes ? `
                            <div class="md:col-span-2">
                                <span class="font-medium text-gray-700">Notes:</span>
                                <p class="text-gray-900">${booking.notes}</p>
                            </div>
                            ` : ''}
                        </div>
                    </div>
                `).join('');

                content += `
                    <div class="mb-4">
                        <h4 class="text-lg font-medium text-gray-900">Bookings for ${date.toLocaleDateString()}</h4>
                    </div>
                    ${bookingsHtml}
                `;
            }

            detailsContainer.innerHTML = content;
            modal.classList.remove('hidden');
        }

        function closeBookingModal() {
            document.getElementById('bookingModal').classList.add('hidden');
        }

        function previousMonth() {
            currentDate.setMonth(currentDate.getMonth() - 1);
            updateCalendar();
            loadBookings();
            if (selectedVenueId) {
                loadUnavailabilities();
            }
        }

        function nextMonth() {
            currentDate.setMonth(currentDate.getMonth() + 1);
            updateCalendar();
            loadBookings();
            if (selectedVenueId) {
                loadUnavailabilities();
            }
        }

        function goToToday() {
            currentDate = new Date();
            updateCalendar();
            loadBookings();
            if (selectedVenueId) {
                loadUnavailabilities();
            }
        }

        function refreshCalendar() {
            loadBookings();
            if (selectedVenueId) {
                loadUnavailabilities();
            }
        }

        function openMarkUnavailableModal() {
            if (!selectedVenueId) {
                alert('Please select a venue first');
                return;
            }
            
            if (!selectedDate) {
                alert('Please click on a date in the calendar first');
                return;
            }

            // Check if the selected date is in the past
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            if (selectedDate < today) {
                alert('Cannot mark past dates as unavailable');
                return;
            }

            // Close booking modal if it's open
            closeBookingModal();

            // Get venue name
            const venueSelect = document.getElementById('venueFilter');
            const venueName = venueSelect.options[venueSelect.selectedIndex].text;

            // Update modal with selected venue and date
            console.log('Opening modal with selected date:', selectedDate);
            document.getElementById('selectedVenueName').textContent = venueName;
            document.getElementById('selectedDate').textContent = new Date(selectedDate + 'T00:00:00').toLocaleDateString();
            document.getElementById('unavailableVenue').value = selectedVenueId;
            document.getElementById('unavailableDate').value = selectedDate;

            document.getElementById('markUnavailableModal').classList.remove('hidden');
        }

        function closeMarkUnavailableModal() {
            document.getElementById('markUnavailableModal').classList.add('hidden');
            document.getElementById('markUnavailableForm').reset();
            selectedDate = null;
            

            
            updateCalendar(); // Remove the blue ring
        }

        function markVenueUnavailable() {
            const form = document.getElementById('markUnavailableForm');
            const formData = new FormData(form);

            fetch('/api/venues/mark-unavailable', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    venue_id: formData.get('venue_id'),
                    date: formData.get('date'),
                    type: formData.get('type'),
                    start_time: formData.get('start_time'),
                    end_time: formData.get('end_time'),
                    reason: formData.get('reason')
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Venue marked as unavailable successfully');
                    closeMarkUnavailableModal();
                    selectedDate = null;
                    loadUnavailabilities();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while marking venue as unavailable');
            });
        }

        function removeUnavailability(unavailabilityId) {
            if (!confirm('Are you sure you want to remove this unavailability?')) {
                return;
            }

            fetch('/api/venues/remove-unavailability', {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    unavailability_id: unavailabilityId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Unavailability removed successfully');
                    closeBookingModal();
                    loadUnavailabilities();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while removing unavailability');
            });
        }

        // Close modal when clicking outside
        window.addEventListener('click', function(e) {
            const bookingModal = document.getElementById('bookingModal');
            const markUnavailableModal = document.getElementById('markUnavailableModal');
            
            if (e.target === bookingModal) {
                closeBookingModal();
            }
            if (e.target === markUnavailableModal) {
                closeMarkUnavailableModal();
            }

            // Clear selected date when clicking outside calendar (but not on modals)
            if (!e.target.closest('#calendarGrid') && 
                !e.target.closest('#markUnavailableModal') && 
                !e.target.closest('#bookingModal') &&
                !e.target.closest('#venueFilter')) {
                selectedDate = null;
                updateCalendar();
                

            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeBookingModal();
                closeMarkUnavailableModal();
            }
        });

        function toTitleCase(str) {
            return str.toLowerCase().split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ');
        }
    </script>
    @endpush
</x-admin-layout> 
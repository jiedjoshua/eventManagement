<x-customer-layout :active-page="'dashboard'" :title="'Dashboard'">
    <!-- Downpayment Reminder Modal -->
    @php
        // Try to get bookings from $bookings, $user->bookings, or fallback to []
        $dashboardBookings = isset($bookings) ? $bookings : (isset($user) && method_exists($user, 'booking') ? $user->booking : collect());
        if (!isset($dashboardBookings) || !is_iterable($dashboardBookings)) $dashboardBookings = collect();
        $unpaidBookings = $dashboardBookings->filter(function($b) { 
            return $b->status === 'approved' && $b->payment_status !== 'paid'; 
        });
    @endphp
    @if($unpaidBookings->count())
        <div id="downpayment-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40" style="display:none;">
            <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full p-6 relative border border-indigo-100">
                <button onclick="document.getElementById('downpayment-modal').style.display='none'" class="absolute top-3 right-3 text-indigo-300 hover:text-indigo-600 text-2xl transition-colors">&times;</button>
                <div class="flex items-center mb-4">
                    <svg class="w-8 h-8 text-indigo-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z" />
                    </svg>
                    <h2 class="text-xl font-bold text-indigo-800">Downpayment Required</h2>
                </div>
                <p class="mb-4 text-gray-700">A <span class="font-semibold text-indigo-700">20% downpayment</span> is required to secure your booking. Please pay before the deadline to avoid cancellation.</p>
                <ul class="mb-4 space-y-2">
                    @foreach($unpaidBookings as $booking)
                        <li class="flex items-center justify-between bg-indigo-50 rounded p-3">
                            <div>
                                <span class="font-semibold text-indigo-900">{{ $booking->event_name }}</span>
                                <span class="ml-2 text-xs text-gray-500">({{ \Carbon\Carbon::parse($booking->event_date)->format('M d, Y') }})</span>
                            </div>
                            <div>
                                @if($booking->payment_due_date)
                                    <span class="text-sm font-medium {{ \Carbon\Carbon::parse($booking->payment_due_date)->isPast() ? 'text-red-600' : 'text-indigo-700' }}">
                                        Due: {{ \Carbon\Carbon::parse($booking->payment_due_date)->format('M d, Y') }}
                                        @if(\Carbon\Carbon::parse($booking->payment_due_date)->isPast())
                                            <span class="text-xs text-red-500">(Overdue)</span>
                                        @endif
                                    </span>
                                @else
                                    <span class="text-xs text-gray-400">No due date set</span>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
                <button onclick="document.getElementById('downpayment-modal').style.display='none'" class="w-full py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-semibold mt-2 transition-colors">OK, Got it</button>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('downpayment-modal').style.display = 'flex';
            });
        </script>
    @endif
    <!-- Dashboard Header -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
                <p class="text-gray-600 mt-1">Welcome back! Here's an overview of your events and activities.</p>
            </div>

            <!-- Quick Actions -->
            <div class="flex gap-3">
                <a href="{{ route('book-now') }}" 
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors font-medium shadow">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Book New Event
                </a>
                <a href="{{ route('user.attendingEvents') }}" 
                    class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors font-medium">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    View Events
                </a>
            </div>
        </div>
    </div>

    <!-- Enhanced Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <!-- Upcoming Events Card -->
        <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-2xl shadow-lg border border-indigo-200 p-6 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm font-medium text-indigo-600 uppercase tracking-wide">Upcoming Events</p>
                    <p class="text-3xl font-bold text-indigo-900 mt-2">{{ $stats['upcoming_events'] }}</p>
                    <p class="text-indigo-700 text-sm mt-1">Events you're attending</p>
                </div>
                <div class="w-16 h-16 bg-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Confirmed Bookings Card -->
        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-2xl shadow-lg border border-green-200 p-6 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm font-medium text-green-600 uppercase tracking-wide">Confirmed Bookings</p>
                    <p class="text-3xl font-bold text-green-900 mt-2">{{ $stats['confirmed_bookings'] }}</p>
                    <p class="text-green-700 text-sm mt-1">Your event bookings</p>
                </div>
                <div class="w-16 h-16 bg-green-600 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Past Events Card -->
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-2xl shadow-lg border border-purple-200 p-6 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm font-medium text-purple-600 uppercase tracking-wide">Past Events</p>
                    <p class="text-3xl font-bold text-purple-900 mt-2">{{ $stats['past_events'] }}</p>
                    <p class="text-purple-700 text-sm mt-1">Events you've attended</p>
                </div>
                <div class="w-16 h-16 bg-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6h6v6m2 4H7a2 2 0 01-2-2V5a2 2 0 012-2h10a2 2 0 012 2v14a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Chart Card 1: Event Participation Over Time -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Event Participation</h2>
                    <p class="text-gray-600 text-sm mt-1">Your event activity over time</p>
                </div>
                <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
            </div>
            <div class="h-80">
                <canvas id="participationChart"></canvas>
            </div>
        </div>

        <!-- Chart Card 2: Event Types Breakdown -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Event Types</h2>
                    <p class="text-gray-600 text-sm mt-1">Breakdown of your event preferences</p>
                </div>
                <div class="w-12 h-12 bg-pink-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                    </svg>
                </div>
            </div>
            <div class="h-80">
                <canvas id="eventTypesChart"></canvas>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Chart 1: Event Participation Over Time (Line Chart)
        const participationCtx = document.getElementById('participationChart').getContext('2d');
        new Chart(participationCtx, {
            type: 'line',
            data: {
                labels: @json($participationData['labels']),
                datasets: [{
                    label: 'Events Participated',
                    data: @json($participationData['data']),
                    borderColor: 'rgb(99, 102, 241)',
                    backgroundColor: 'rgba(99, 102, 241, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: 'rgb(99, 102, 241)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 3,
                    pointRadius: 6,
                    pointHoverRadius: 8,
                    pointHoverBackgroundColor: 'rgb(99, 102, 241)',
                    pointHoverBorderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: 'rgb(99, 102, 241)',
                        borderWidth: 1,
                        cornerRadius: 8,
                        displayColors: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)',
                            drawBorder: false
                        },
                        ticks: {
                            stepSize: 1,
                            font: {
                                size: 12,
                                weight: '500'
                            },
                            color: '#6b7280'
                        }
                    },
                    x: {
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)',
                            drawBorder: false
                        },
                        ticks: {
                            font: {
                                size: 12,
                                weight: '500'
                            },
                            color: '#6b7280'
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                },
                elements: {
                    point: {
                        hoverRadius: 8
                    }
                }
            }
        });

        // Chart 2: Event Types Breakdown (Doughnut Chart)
        const eventTypesCtx = document.getElementById('eventTypesChart').getContext('2d');
        new Chart(eventTypesCtx, {
            type: 'doughnut',
            data: {
                labels: @json($eventTypesData['labels']),
                datasets: [{
                    data: @json($eventTypesData['data']),
                    backgroundColor: [
                        'rgba(99, 102, 241, 0.9)',
                        'rgba(236, 72, 153, 0.9)',
                        'rgba(34, 197, 94, 0.9)',
                        'rgba(251, 146, 60, 0.9)',
                        'rgba(168, 85, 247, 0.9)',
                        'rgba(6, 182, 212, 0.9)'
                    ],
                    borderColor: [
                        'rgb(99, 102, 241)',
                        'rgb(236, 72, 153)',
                        'rgb(34, 197, 94)',
                        'rgb(251, 146, 60)',
                        'rgb(168, 85, 247)',
                        'rgb(6, 182, 212)'
                    ],
                    borderWidth: 3,
                    hoverBorderWidth: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                            font: {
                                size: 12,
                                weight: '500'
                            },
                            color: '#374151'
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: 'rgb(99, 102, 241)',
                        borderWidth: 1,
                        cornerRadius: 8,
                        displayColors: true
                    }
                },
                cutout: '65%',
                elements: {
                    arc: {
                        borderWidth: 3
                    }
                }
            }
        });

        // Add smooth animations when page loads
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.bg-gradient-to-br');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.6s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
    @endpush
</x-customer-layout>
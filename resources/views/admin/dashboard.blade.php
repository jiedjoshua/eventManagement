<x-admin-layout title="Dashboard" active-page="dashboard">
    <h1 class="text-3xl font-bold mb-8">Dashboard</h1>

    <!-- Cards Row -->
    <div class="flex flex-wrap gap-6 mb-10">
        <!-- Total Events -->
        <div class="w-72 h-28 bg-white rounded-lg shadow-md flex items-center p-5 space-x-5">
            <div class="w-20 h-20 bg-blue-600 rounded-md flex items-center justify-center text-white text-2xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10m-12 4h14a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
            <div class="flex flex-col justify-center">
                <span class="text-3xl font-bold text-gray-900">{{ $totalEvents }}</span>
                <span class="text-gray-500 uppercase tracking-wide mt-1 text-xs">Total Events</span>
            </div>
        </div>

        <!-- Upcoming Events -->
        <div class="w-72 h-28 bg-white rounded-lg shadow-md flex items-center p-5 space-x-5">
            <div class="w-20 h-20 bg-green-600 rounded-md flex items-center justify-center text-white text-2xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="flex flex-col justify-center">
                <span class="text-3xl font-bold text-gray-900">{{ $upcomingEvents }}</span>
                <span class="text-gray-500 uppercase tracking-wide mt-1 text-xs">Upcoming Events</span>
            </div>
        </div>

        <!-- Total Bookings -->
        <div class="w-72 h-28 bg-white rounded-lg shadow-md flex items-center p-5 space-x-5">
            <div class="w-20 h-20 bg-purple-600 rounded-md flex items-center justify-center text-white text-2xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
            <div class="flex flex-col justify-center">
                <span class="text-3xl font-bold text-gray-900">{{ $totalBookings }}</span>
                <span class="text-gray-500 uppercase tracking-wide mt-1 text-xs">Total Bookings</span>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="w-72 h-28 bg-white rounded-lg shadow-md flex items-center p-5 space-x-5">
            <div class="w-20 h-20 bg-yellow-600 rounded-md flex items-center justify-center text-white text-2xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                </svg>
            </div>
            <div class="flex flex-col justify-center">
                <span class="text-3xl font-bold text-gray-900">₱{{ number_format($totalRevenue) }}</span>
                <span class="text-gray-500 uppercase tracking-wide mt-1 text-xs">Total Revenue</span>
            </div>
        </div>

        <!-- Total Users -->
        <div class="w-72 h-28 bg-white rounded-lg shadow-md flex items-center p-5 space-x-5">
            <div class="w-20 h-20 bg-red-600 rounded-md flex items-center justify-center text-white text-2xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <div class="flex flex-col justify-center">
                <span class="text-3xl font-bold text-gray-900">{{ $totalUsers }}</span>
                <span class="text-gray-500 uppercase tracking-wide mt-1 text-xs">Total Users</span>
            </div>
        </div>

        <!-- Pending Bookings -->
        <div class="w-72 h-28 bg-white rounded-lg shadow-md flex items-center p-5 space-x-5">
            <div class="w-20 h-20 bg-orange-600 rounded-md flex items-center justify-center text-white text-2xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="flex flex-col justify-center">
                <span class="text-3xl font-bold text-gray-900">{{ $pendingBookings }}</span>
                <span class="text-gray-500 uppercase tracking-wide mt-1 text-xs">Pending Bookings</span>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Events by Month Chart -->
        <div class="bg-white rounded-lg shadow-md p-6 h-96 flex flex-col">
            <h2 class="text-xl font-semibold mb-4">Events by Month</h2>
            <div class="flex-grow">
                <canvas id="eventsChart" width="400" height="300"></canvas>
            </div>
        </div>

        <!-- Revenue Chart -->
        <div class="bg-white rounded-lg shadow-md p-6 h-96 flex flex-col">
            <h2 class="text-xl font-semibold mb-4">Revenue Overview</h2>
            <div class="flex-grow">
                <canvas id="revenueChart" width="400" height="300"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Activities Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Bookings -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">Recent Bookings</h2>
            <div class="space-y-4">
                @forelse($recentBookings as $booking)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div>
                        <p class="font-semibold text-gray-800">{{ $booking->event_name }}</p>
                        <p class="text-sm text-gray-600">{{ $booking->user->name ?? 'Guest' }} • {{ $booking->event_date }}</p>
                    </div>
                    <span class="px-2 py-1 text-xs rounded-full 
                        @if($booking->status === 'approved') bg-green-100 text-green-800
                        @elseif($booking->status === 'pending') bg-yellow-100 text-yellow-800
                        @elseif($booking->status === 'rejected') bg-red-100 text-red-800
                        @else bg-gray-100 text-gray-800 @endif">
                        {{ ucfirst($booking->status) }}
                    </span>
                </div>
                @empty
                <p class="text-gray-500 text-center py-4">No recent bookings</p>
                @endforelse
            </div>
        </div>

        <!-- Recent Events -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">Upcoming Events</h2>
            <div class="space-y-4">
                @forelse($upcomingEventsList as $event)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div>
                        <p class="font-semibold text-gray-800">{{ $event->event_name }}</p>
                        <p class="text-sm text-gray-600">{{ $event->event_date }} • {{ $event->venue->name ?? 'TBD' }}</p>
                    </div>
                    <span class="text-sm text-gray-500">{{ $event->guests_count ?? 0 }} guests</span>
                </div>
                @empty
                <p class="text-gray-500 text-center py-4">No upcoming events</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        // Events by Month Chart
        const eventsCtx = document.getElementById('eventsChart').getContext('2d');
        new Chart(eventsCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($eventsChartData['labels']) !!},
                datasets: [{
                    label: 'Events',
                    data: {!! json_encode($eventsChartData['data']) !!},
                    backgroundColor: 'rgba(59, 130, 246, 0.8)',
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        // Revenue Chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($revenueChartData['labels']) !!},
                datasets: [{
                    label: 'Revenue (₱)',
                    data: {!! json_encode($revenueChartData['data']) !!},
                    borderColor: 'rgba(34, 197, 94, 1)',
                    backgroundColor: 'rgba(34, 197, 94, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '₱' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    </script>
</x-admin-layout>
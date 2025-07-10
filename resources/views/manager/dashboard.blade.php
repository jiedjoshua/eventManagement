<x-manager-layout title="Dashboard" :active-page="'dashboard'">
    <!-- Header Section -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Manager Dashboard</h1>
            <p class="text-gray-600">Overview of your event management activities</p>
        </div>
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
            <div class="text-sm text-gray-600 bg-white px-4 py-3 rounded-lg shadow-md font-medium border">
                <i class="fas fa-clock mr-2 text-indigo-600"></i>
                <span class="font-semibold text-gray-800" id="ph-time"></span>
            </div>
        </div>
    </div>

    <!-- Stats Cards Row -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Events Managed -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-500 mb-1">Total Events</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $totalEvents }}</p>
                    <p class="text-xs text-gray-500 mt-1">Events Managed</p>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-calendar-alt text-white text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Upcoming Events -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-500 mb-1">Upcoming</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $upcomingEvents }}</p>
                    <p class="text-xs text-gray-500 mt-1">Events Scheduled</p>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-clock text-white text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Pending Bookings/Approvals -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-500 mb-1">Pending</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $pendingBookings }}</p>
                    <p class="text-xs text-gray-500 mt-1">Approvals Needed</p>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-hourglass-half text-white text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Cancelled Events -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-500 mb-1">Cancelled</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $cancelledEvents }}</p>
                    <p class="text-xs text-gray-500 mt-1">Events Cancelled</p>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-times-circle text-white text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions Section -->
    <div class="mb-8">
        <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
            <i class="fas fa-bolt mr-2 text-indigo-600"></i>Quick Actions
        </h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('manager.showEvent') }}" class="bg-gradient-to-r from-indigo-600 to-indigo-700 text-white p-4 rounded-xl shadow-lg hover:from-indigo-700 hover:to-indigo-800 transition-all transform hover:-translate-y-1">
                <div class="flex items-center">
                    <i class="fas fa-calendar-plus text-2xl mr-3"></i>
                    <div>
                        <p class="font-semibold">Manage Events</p>
                        <p class="text-xs opacity-90">View and manage all events</p>
                    </div>
                </div>
            </a>
            
            <a href="{{ route('manager.upcomingEvents') }}" class="bg-gradient-to-r from-green-600 to-green-700 text-white p-4 rounded-xl shadow-lg hover:from-green-700 hover:to-green-800 transition-all transform hover:-translate-y-1">
                <div class="flex items-center">
                    <i class="fas fa-list text-2xl mr-3"></i>
                    <div>
                        <p class="font-semibold">Upcoming Events</p>
                        <p class="text-xs opacity-90">View scheduled events</p>
                    </div>
                </div>
            </a>
            
            <a href="{{ route('manager.bookedEvents') }}" class="bg-gradient-to-r from-blue-600 to-blue-700 text-white p-4 rounded-xl shadow-lg hover:from-blue-700 hover:to-blue-800 transition-all transform hover:-translate-y-1">
                <div class="flex items-center">
                    <i class="fas fa-tasks text-2xl mr-3"></i>
                    <div>
                        <p class="font-semibold">Booked Events</p>
                        <p class="text-xs opacity-90">Handle bookings</p>
                    </div>
                </div>
            </a>
            
            <a href="{{ route('manager.guestLists') }}" class="bg-gradient-to-r from-purple-600 to-purple-700 text-white p-4 rounded-xl shadow-lg hover:from-purple-700 hover:to-purple-800 transition-all transform hover:-translate-y-1">
                <div class="flex items-center">
                    <i class="fas fa-users text-2xl mr-3"></i>
                    <div>
                        <p class="font-semibold">Guest Lists</p>
                        <p class="text-xs opacity-90">Manage guest lists</p>
                    </div>
                </div>
            </a>
            
            <a href="{{ route('manager.paymentHistory') }}" class="bg-gradient-to-r from-emerald-600 to-emerald-700 text-white p-4 rounded-xl shadow-lg hover:from-emerald-700 hover:to-emerald-800 transition-all transform hover:-translate-y-1">
                <div class="flex items-center">
                    <i class="fas fa-credit-card text-2xl mr-3"></i>
                    <div>
                        <p class="font-semibold">Payment History</p>
                        <p class="text-xs opacity-90">View all payments</p>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Chart Card 1: Events Per Month -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold text-indigo-700 flex items-center">
                    <i class="fas fa-chart-bar mr-2"></i>Events Per Month
                </h2>
                <div class="w-3 h-3 bg-indigo-500 rounded-full"></div>
            </div>
            <div class="h-80">
                <canvas id="eventsPerMonthChart"></canvas>
            </div>
        </div>

        <!-- Chart Card 2: Event Types Distribution -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold text-indigo-700 flex items-center">
                    <i class="fas fa-chart-pie mr-2"></i>Event Types Distribution
                </h2>
                <div class="w-3 h-3 bg-indigo-500 rounded-full"></div>
            </div>
            <div class="h-80">
                <canvas id="eventTypesChart"></canvas>
            </div>
        </div>
    </div>

    <script>
        function updatePhilippineTime() {
            const now = new Date();
            const options = {
                timeZone: 'Asia/Manila',
                hour12: true,
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                weekday: 'short',
                year: 'numeric',
                month: 'short',
                day: 'numeric',
            };
            const formatter = new Intl.DateTimeFormat('en-PH', options);
            document.getElementById('ph-time').textContent = formatter.format(now);
        }
        updatePhilippineTime();
        setInterval(updatePhilippineTime, 1000);
    </script>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // Chart 1: Events Per Month
  const eventsPerMonthCtx = document.getElementById('eventsPerMonthChart').getContext('2d');
  new Chart(eventsPerMonthCtx, {
    type: 'bar',
    data: {
      labels: @json($months),
      datasets: [{
        label: 'Events',
        data: @json($eventCounts),
        backgroundColor: 'rgba(99, 102, 241, 0.8)',
        borderColor: 'rgb(99, 102, 241)',
        borderWidth: 2,
        borderRadius: 8
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { display: false },
        title: { display: false }
      },
      scales: {
        y: { 
          beginAtZero: true,
          grid: {
            color: 'rgba(0, 0, 0, 0.1)'
          },
          ticks: {
            font: { size: 12 }
          }
        },
        x: {
          grid: {
            display: false
          },
          ticks: {
            font: { size: 12 }
          }
        }
      }
    }
  });

  // Chart 2: Event Types Distribution
  const eventTypesCtx = document.getElementById('eventTypesChart').getContext('2d');
  new Chart(eventTypesCtx, {
    type: 'doughnut',
    data: {
      labels: @json($eventTypeLabels),
      datasets: [{
        data: @json($eventTypeCounts),
        backgroundColor: [
          'rgba(99, 102, 241, 0.8)',
          'rgba(236, 72, 153, 0.8)',
          'rgba(34, 197, 94, 0.8)',
          'rgba(251, 146, 60, 0.8)',
          'rgba(168, 85, 247, 0.8)',
          'rgba(6, 182, 212, 0.8)'
        ],
        borderColor: [
          'rgb(99, 102, 241)',
          'rgb(236, 72, 153)',
          'rgb(34, 197, 94)',
          'rgb(251, 146, 60)',
          'rgb(168, 85, 247)',
          'rgb(6, 182, 212)'
        ],
        borderWidth: 2
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
            font: { size: 12 }
          }
        },
        title: { display: false }
      },
      cutout: '60%'
    }
  });
</script>
@endpush

</x-manager-layout>
 
<x-manager-layout title="Dashboard" :active-page="'dashboard'">
    <h1 class="text-3xl font-bold mb-8">Dashboard</h1>

    <!-- Cards Row -->
   <div class="flex flex-wrap gap-6 mb-10">
  <!-- Total Events Managed -->
  <div class="w-72 h-28 bg-white rounded-lg shadow-md flex items-center p-5 space-x-5">
    <div class="w-20 h-20 bg-indigo-600 rounded-md flex items-center justify-center text-white text-2xl">
      <!-- Icon -->
      <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10m-12 4h14a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v10a2 2 0 002 2z" />
      </svg>
    </div>
    <div class="flex flex-col justify-center">
      <span class="text-3xl font-bold text-gray-900">{{ $totalEvents }}</span>
      <span class="text-gray-500 uppercase tracking-wide mt-1 text-xs">Total Events Managed</span>
    </div>
  </div>

  <!-- Upcoming Events -->
  <div class="w-72 h-28 bg-white rounded-lg shadow-md flex items-center p-5 space-x-5">
    <div class="w-20 h-20 bg-indigo-600 rounded-md flex items-center justify-center text-white text-2xl">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
      </svg>
    </div>
    <div class="flex flex-col justify-center">
      <span class="text-3xl font-bold text-gray-900">{{ $upcomingEvents }}</span>
      <span class="text-gray-500 uppercase tracking-wide mt-1 text-xs">Upcoming Events</span>
    </div>
  </div>

  <!-- Pending Bookings/Approvals -->
  <div class="w-72 h-28 bg-white rounded-lg shadow-md flex items-center p-5 space-x-5">
    <div class="w-20 h-20 bg-indigo-600 rounded-md flex items-center justify-center text-white text-2xl">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-6h6v6m2 4H7a2 2 0 01-2-2V5a2 2 0 012-2h10a2 2 0 012 2v14a2 2 0 01-2 2z" />
      </svg>
    </div>
    <div class="flex flex-col justify-center">
      <span class="text-3xl font-bold text-gray-900">{{ $pendingBookings }}</span>
      <span class="text-gray-500 uppercase tracking-wide mt-1 text-xs">Pending Approvals</span>
    </div>
  </div>

  <!-- Cancelled Events -->
  <div class="w-72 h-28 bg-white rounded-lg shadow-md flex items-center p-5 space-x-5">
    <div class="w-20 h-20 bg-indigo-600 rounded-md flex items-center justify-center text-white text-2xl">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z" />
      </svg>
    </div>
    <div class="flex flex-col justify-center">
      <span class="text-3xl font-bold text-gray-900">{{ $cancelledEvents }}</span>
      <span class="text-gray-500 uppercase tracking-wide mt-1 text-xs">Cancelled Events</span>
    </div>
  </div>
</div>

  <!-- Charts Section -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
  <!-- Chart Card 1: Events Per Month -->
  <div class="bg-white rounded-lg shadow-md p-6 h-96 flex flex-col">
    <h2 class="text-xl font-semibold mb-4">Events Per Month</h2>
    <div class="flex-grow">
      <canvas id="eventsPerMonthChart"></canvas>
    </div>
  </div>

  <!-- Chart Card 2: Event Types Distribution -->
  <div class="bg-white rounded-lg shadow-md p-6 h-96 flex flex-col">
    <h2 class="text-xl font-semibold mb-4">Event Types Distribution</h2>
    <div class="flex-grow">
      <canvas id="eventTypesChart"></canvas>
    </div>
  </div>
</div>

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
        backgroundColor: 'rgba(99, 102, 241, 0.7)',
        borderColor: 'rgb(99, 102, 241)',
        borderWidth: 2
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { display: false }
      },
      scales: {
        y: { beginAtZero: true }
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
          labels: { padding: 20, usePointStyle: true }
        }
      },
      cutout: '60%'
    }
  });
</script>
@endpush

</x-manager-layout>
 
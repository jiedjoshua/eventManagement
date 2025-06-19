<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Event Dashboard - Event Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .dropdown-panel {
            position: absolute;
            background: white;
            border: 1px solid #cbd5e0;
            border-radius: 0.25rem;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
            z-index: 10;
            padding: 0.5rem;
            width: 200px;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="flex h-screen bg-gray-50">

    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-md flex flex-col">
        <div class="p-6 text-2xl font-bold text-indigo-600">Event Panel</div>
        <nav class="flex-1 px-4 space-y-2 text-sm text-gray-700">
            <div>
                <p class="font-semibold text-gray-900">Home</p>
                <a href="{{ route('events.dashboard', ['event' => $event->id]) }}" class="block pl-4 py-2 rounded bg-indigo-200 font-semibold text-indigo-800">Dashboard</a>
            </div>
            <div>
                <p class="mt-4 font-semibold text-gray-900">Check-in Controls</p>
                <a href="{{ route('events.qrScanner', ['event' => $event->id]) }}" class="block pl-4 py-2 hover:bg-indigo-100 rounded">QR Scanner</a>
                <a href="{{ route('events.manualCheckin', ['event' => $event->id]) }}" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Manual Check-in</a>
                <a href="{{ route('events.checkedIn', ['event' => $event->id]) }}" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Checked in Guests</a>
            </div>
            <div>
                <p class="mt-4 font-semibold text-gray-900">Guest List Preview</p>
                <a href="{{ route('events.guests', ['event' => $event->id]) }}" class="block pl-4 py-2 hover:bg-indigo-100 rounded">View full guest list</a>
            </div>
        </nav>
        <div class="px-6 py-4 border-t">
           
               
                <a href="{{ route('manager.upcomingEvents') }}" class="block text-red-600 font-semibold hover:underline">
                    Back to Manager Panel
                </a>
        </div>
    </aside>

    <main class="flex-1 p-8 overflow-y-auto">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
            <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
            <div class="text-sm text-gray-600 bg-white px-4 py-2 rounded shadow font-medium">
                Philippine Time: <span id="ph-time" class="font-semibold text-gray-800"></span>
            </div>
        </div>
<!-- Quick Actions Card -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <a href="{{ route('events.qrScanner', ['event' => $event->id]) }}"
               class="block w-full text-center px-4 py-4 bg-indigo-600 text-white rounded-xl font-semibold shadow hover:bg-indigo-700 transition">
                <span class="block text-lg mb-1">QR Scanner</span>
                <span class="text-xs">Scan guests in real-time</span>
            </a>
            <a href="{{ route('events.manualCheckin', ['event' => $event->id]) }}"
               class="block w-full text-center px-4 py-4 bg-yellow-500 text-white rounded-xl font-semibold shadow hover:bg-yellow-600 transition">
                <span class="block text-lg mb-1">Manual Check-in</span>
                <span class="text-xs">Search and check in guests</span>
            </a>
            <a href="{{ route('events.checkedIn', ['event' => $event->id]) }}"
               class="block w-full text-center px-4 py-4 bg-green-500 text-white rounded-xl font-semibold shadow hover:bg-green-600 transition">
                <span class="block text-lg mb-1">Checked-in Guests</span>
                <span class="text-xs">View all checked-in guests</span>
            </a>
            <a href="{{ route('events.guests', ['event' => $event->id]) }}"
               class="block w-full text-center px-4 py-4 bg-blue-500 text-white rounded-xl font-semibold shadow hover:bg-blue-600 transition">
                <span class="block text-lg mb-1">Full Guest List</span>
                <span class="text-xs">See all invited guests</span>
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
          
            <!-- Attendance Stats Card -->
            <div class="bg-white rounded-2xl shadow p-6 flex flex-col gap-4">
                <h2 class="text-xl font-semibold text-indigo-700 mb-2">Attendance Stats</h2>
                <div class="grid grid-cols-2 gap-4 text-gray-700 text-sm">
                    <div class="bg-indigo-50 rounded-lg p-3">
                        <p class="text-xs font-medium text-indigo-600">Invited</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $total_invited ?? 0 }}</p>
                    </div>
                    <div class="bg-green-50 rounded-lg p-3">
                        <p class="text-xs font-medium text-green-600">Accepted</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $total_accepted ?? '-' }}</p>
                    </div>
                    <div class="bg-red-50 rounded-lg p-3">
                        <p class="text-xs font-medium text-red-600">Declined</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $total_declined ?? '-' }}</p>
                    </div>
                    <div class="bg-blue-50 rounded-lg p-3">
                        <p class="text-xs font-medium text-blue-600">Checked In</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $checked_in_count ?? '-' }}</p>
                    </div>
                    <div class="bg-yellow-50 rounded-lg p-3 col-span-2">
                        <p class="text-xs font-medium text-yellow-600">Not Checked In</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $not_checked_in ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Event Details Card -->
            <div class="bg-white rounded-2xl shadow p-6 flex flex-col gap-2 md:col-span-2">
                <h2 class="text-xl font-semibold text-indigo-700 mb-2">Event Details</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-2 text-gray-700 text-sm">
                    <div><span class="font-semibold text-gray-900">Event Name:</span> {{ ucwords("$event->event_name") }}</div>
                    <div><span class="font-semibold text-gray-900">Event Type:</span> {{ ucwords("$event->event_type") ?? '-' }}</div>
                    <div><span class="font-semibold text-gray-900">Date:</span> {{ \Carbon\Carbon::parse($event->event_date)->format('F d, Y') }}</div>
                    <div><span class="font-semibold text-gray-900">Time:</span> {{ $event->start_time ?? '-' }} - {{ $event->end_time ?? '-' }}</div>
                    <div><span class="font-semibold text-gray-900">Venue:</span> {{ ucwords("$event->venue_name") ?? '-' }}</div>
                    <div><span class="font-semibold text-gray-900">Package:</span> {{ ucwords("$event->package_type") ?? '-' }}</div>
                    <div><span class="font-semibold text-gray-900">Guests Invited:</span> {{ $event->guest_count ?? $total_invited ?? 0 }}</div>
                </div>
            </div>
        </div>

        

        <!-- Charts Section -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- RSVP Status Chart -->
    <div class="bg-white rounded-2xl shadow p-6">
        <h2 class="text-xl font-semibold text-indigo-700 mb-4">RSVP Status Distribution</h2>
        <div class="h-80">
            <canvas id="rsvpChart"></canvas>
        </div>
    </div>

    <!-- Check-in Statistics Chart -->
    <div class="bg-white rounded-2xl shadow p-6">
        <h2 class="text-xl font-semibold text-indigo-700 mb-4">Check-in Statistics</h2>
        <div class="h-80">
            <canvas id="checkinChart"></canvas>
        </div>
    </div>
</div>
    </main>

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

        const rsvpCtx = document.getElementById('rsvpChart').getContext('2d');
new Chart(rsvpCtx, {
    type: 'pie',
    data: {
        labels: ['Accepted', 'Declined', 'Pending'],
        datasets: [{
            data: [
                {{ $total_accepted ?? 0 }},
                {{ $total_declined ?? 0 }},
                {{ ($total_invited ?? 0) - (($total_accepted ?? 0) + ($total_declined ?? 0)) }}
            ],
            backgroundColor: [
                'rgba(34, 197, 94, 0.8)',  // green
                'rgba(239, 68, 68, 0.8)',  // red
                'rgba(234, 179, 8, 0.8)'   // yellow
            ],
            borderColor: [
                'rgb(34, 197, 94)',
                'rgb(239, 68, 68)',
                'rgb(234, 179, 8)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            },
            title: {
                display: true,
                text: 'RSVP Status Distribution'
            }
        }
    }
});

// Check-in Statistics Chart
const checkinCtx = document.getElementById('checkinChart').getContext('2d');
new Chart(checkinCtx, {
    type: 'bar',
    data: {
        labels: ['Checked In', 'Not Checked In'],
        datasets: [{
            label: 'Number of Guests',
            data: [
                {{ $checked_in_count ?? 0 }},
                {{ $not_checked_in ?? 0 }}
            ],
            backgroundColor: [
                'rgba(59, 130, 246, 0.8)',  // blue
                'rgba(234, 179, 8, 0.8)'    // yellow
            ],
            borderColor: [
                'rgb(59, 130, 246)',
                'rgb(234, 179, 8)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            },
            title: {
                display: true,
                text: 'Check-in Statistics'
            }
        },
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
    </script>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Event Dashboard - Event Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
        
        .stat-card {
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
        
        .quick-action-card {
            transition: all 0.3s ease;
        }
        
        .quick-action-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="flex h-screen bg-gray-50">

    <!-- Enhanced Sidebar -->
    <aside class="w-64 bg-gradient-to-b from-white to-gray-50 shadow-xl border-r border-gray-200 flex flex-col h-screen">
        <!-- Enhanced Header -->
        <div class="p-6 border-b border-gray-200 flex-shrink-0">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Event Panel</h2>
                    <p class="text-sm text-gray-500">Event Manager</p>
                </div>
            </div>
        </div>
        
        <!-- Enhanced Home Button -->
        <div class="px-4 py-4 border-b border-gray-200">
            <a href="{{ route('home') }}" class="flex items-center space-x-3 bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white px-4 py-3 rounded-xl transition-all duration-200 text-sm font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span>Go to Home</span>
            </a>
        </div>
        
        <!-- Enhanced Navigation -->
        <nav class="flex-1 px-4 space-y-6 py-6 overflow-y-auto">
            <!-- Home Section -->
            <div>
                <div class="flex items-center mb-3">
                    <div class="w-2 h-2 bg-indigo-500 rounded-full mr-3"></div>
                    <p class="font-bold text-gray-900 text-sm uppercase tracking-wide">Home</p>
                </div>
                <a href="{{ route('events.dashboard', ['event' => $event->id]) }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 bg-gradient-to-r from-indigo-100 to-indigo-200 text-indigo-700 font-semibold shadow-md">
                    <svg class="h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <span>Dashboard</span>
                </a>
            </div>

            <!-- Check-in Controls Section -->
            <div>
                <div class="flex items-center mb-3">
                    <div class="w-2 h-2 bg-green-500 rounded-full mr-3"></div>
                    <p class="font-bold text-gray-900 text-sm uppercase tracking-wide">Check-in Controls</p>
                </div>
                <div class="space-y-2">
                    <a href="{{ route('events.qrScanner', ['event' => $event->id]) }}" 
                       class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V6a1 1 0 00-1-1H5a1 1 0 00-1 1v1a1 1 0 001 1zm12 0h2a1 1 0 001-1V6a1 1 0 00-1-1h-2a1 1 0 00-1 1v1a1 1 0 001 1zM5 20h2a1 1 0 001-1v-1a1 1 0 00-1-1H5a1 1 0 00-1 1v1a1 1 0 001 1z"></path>
                        </svg>
                        <span>QR Scanner</span>
                    </a>
                    <a href="{{ route('events.manualCheckin', ['event' => $event->id]) }}" 
                       class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <span>Manual Check-in</span>
                    </a>
                    <a href="{{ route('events.checkedIn', ['event' => $event->id]) }}" 
                       class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Checked in Guests</span>
                    </a>
                </div>
            </div>

            <!-- Guest List Section -->
            <div>
                <div class="flex items-center mb-3">
                    <div class="w-2 h-2 bg-purple-500 rounded-full mr-3"></div>
                    <p class="font-bold text-gray-900 text-sm uppercase tracking-wide">Guest Management</p>
                </div>
                <a href="{{ route('events.guests', ['event' => $event->id]) }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span>View full guest list</span>
                </a>
            </div>

            @if($event->status === 'completed')
            <!-- Event Feedback Section -->
            <div>
                <div class="flex items-center mb-3">
                    <div class="w-2 h-2 bg-orange-500 rounded-full mr-3"></div>
                    <p class="font-bold text-gray-900 text-sm uppercase tracking-wide">Event Feedback</p>
                </div>
                <a href="{{ route('manager.event.feedbacks', ['event' => $event->id]) }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    <span>View Event Feedbacks</span>
                </a>
            </div>
            @endif
        </nav>

        <!-- Enhanced Back Button -->
        <div class="px-4 py-4 border-t border-gray-200 flex-shrink-0">
            <a href="{{ route('manager.upcomingEvents') }}" 
               class="w-full flex items-center space-x-3 px-4 py-3 text-red-600 hover:text-red-700 hover:bg-red-50 rounded-xl transition-all duration-200 font-semibold group">
                <svg class="h-5 w-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Back to Manager Panel</span>
            </a>
        </div>
    </aside>

    <main class="flex-1 p-6 lg:p-8 overflow-y-auto">
        <!-- Header Section -->
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Event Dashboard</h1>
                <p class="text-gray-600">{{ ucwords($event->event_name) }}</p>
            </div>
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
                <!-- Event Status Badge -->
                <div class="text-sm bg-white px-4 py-3 rounded-lg shadow-md font-medium border">
                    <span class="font-semibold text-gray-800">Status: </span>
                    @if($event->status === 'completed')
                        <span class="text-green-600 font-bold bg-green-100 px-2 py-1 rounded-full text-xs">
                            <i class="fas fa-check-circle mr-1"></i>COMPLETED
                        </span>
                    @else
                        <span class="text-blue-600 font-bold bg-blue-100 px-2 py-1 rounded-full text-xs">
                            <i class="fas fa-play-circle mr-1"></i>ACTIVE
                        </span>
                    @endif
                </div>
                <div class="text-sm text-gray-600 bg-white px-4 py-3 rounded-lg shadow-md font-medium border">
                    <i class="fas fa-clock mr-2 text-indigo-600"></i>
                    <span class="font-semibold text-gray-800" id="ph-time"></span>
                </div>
            </div>
        </div>

        <!-- Quick Actions Section -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-bolt mr-2 text-indigo-600"></i>Quick Actions
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                <a href="{{ route('events.qrScanner', ['event' => $event->id]) }}"
                   class="quick-action-card block w-full text-center px-4 py-6 bg-gradient-to-br from-indigo-600 to-indigo-700 text-white rounded-xl font-semibold shadow-lg hover:from-indigo-700 hover:to-indigo-800 transition-all">
                    <i class="fas fa-qrcode text-2xl mb-3"></i>
                    <span class="block text-lg mb-1">QR Scanner</span>
                    <span class="text-xs opacity-90">Scan guests in real-time</span>
                </a>
                <a href="{{ route('events.manualCheckin', ['event' => $event->id]) }}"
                   class="quick-action-card block w-full text-center px-4 py-6 bg-gradient-to-br from-yellow-500 to-yellow-600 text-white rounded-xl font-semibold shadow-lg hover:from-yellow-600 hover:to-yellow-700 transition-all">
                    <i class="fas fa-search text-2xl mb-3"></i>
                    <span class="block text-lg mb-1">Manual Check-in</span>
                    <span class="text-xs opacity-90">Search and check in guests</span>
                </a>
                <a href="{{ route('events.checkedIn', ['event' => $event->id]) }}"
                   class="quick-action-card block w-full text-center px-4 py-6 bg-gradient-to-br from-green-500 to-green-600 text-white rounded-xl font-semibold shadow-lg hover:from-green-600 hover:to-green-700 transition-all">
                    <i class="fas fa-check-circle text-2xl mb-3"></i>
                    <span class="block text-lg mb-1">Checked-in Guests</span>
                    <span class="text-xs opacity-90">View all checked-in guests</span>
                </a>
                <a href="{{ route('events.guests', ['event' => $event->id]) }}"
                   class="quick-action-card block w-full text-center px-4 py-6 bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-xl font-semibold shadow-lg hover:from-blue-600 hover:to-blue-700 transition-all">
                    <i class="fas fa-users text-2xl mb-3"></i>
                    <span class="block text-lg mb-1">Full Guest List</span>
                    <span class="text-xs opacity-90">See all invited guests</span>
                </a>
                @if($event->status !== 'completed')
                <button onclick="endEvent({{ $event->id }})"
                   class="quick-action-card block w-full text-center px-4 py-6 bg-gradient-to-br from-red-600 to-red-700 text-white rounded-xl font-semibold shadow-lg hover:from-red-700 hover:to-red-800 transition-all">
                    <i class="fas fa-stop-circle text-2xl mb-3"></i>
                    <span class="block text-lg mb-1">End Event</span>
                    <span class="text-xs opacity-90">Mark event as completed</span>
                </button>
                @else
                <div class="quick-action-card block w-full text-center px-4 py-6 bg-gradient-to-br from-gray-400 to-gray-500 text-white rounded-xl font-semibold shadow-lg">
                    <i class="fas fa-flag-checkered text-2xl mb-3"></i>
                    <span class="block text-lg mb-1">Event Ended</span>
                    <span class="text-xs opacity-90">Event is completed</span>
                </div>
                @endif
            </div>
        </div>

        <!-- Stats and Details Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Attendance Stats Card -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border stat-card">
                <h2 class="text-xl font-semibold text-indigo-700 mb-4 flex items-center">
                    <i class="fas fa-chart-pie mr-2"></i>Attendance Stats
                </h2>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-indigo-50 rounded-xl p-4 border border-indigo-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-medium text-indigo-600">Invited</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $total_invited ?? 0 }}</p>
                            </div>
                            <i class="fas fa-user-plus text-indigo-400 text-xl"></i>
                        </div>
                    </div>
                    <div class="bg-green-50 rounded-xl p-4 border border-green-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-medium text-green-600">Accepted</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $total_accepted ?? 0 }}</p>
                            </div>
                            <i class="fas fa-check text-green-400 text-xl"></i>
                        </div>
                    </div>
                    <div class="bg-red-50 rounded-xl p-4 border border-red-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-medium text-red-600">Declined</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $total_declined ?? 0 }}</p>
                            </div>
                            <i class="fas fa-times text-red-400 text-xl"></i>
                        </div>
                    </div>
                    <div class="bg-blue-50 rounded-xl p-4 border border-blue-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-medium text-blue-600">Checked In</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $checked_in_count ?? 0 }}</p>
                            </div>
                            <i class="fas fa-user-check text-blue-400 text-xl"></i>
                        </div>
                    </div>
                    <div class="bg-yellow-50 rounded-xl p-4 border border-yellow-100 col-span-2">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-medium text-yellow-600">Not Checked In</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $not_checked_in ?? 0 }}</p>
                            </div>
                            <i class="fas fa-user-clock text-yellow-400 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Event Details Card -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border lg:col-span-2 stat-card">
                <h2 class="text-xl font-semibold text-indigo-700 mb-4 flex items-center">
                    <i class="fas fa-info-circle mr-2"></i>Event Details
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                            <i class="fas fa-calendar text-indigo-600 mr-3 w-5"></i>
                            <div>
                                <p class="text-xs font-medium text-gray-500">Event Name</p>
                                <p class="font-semibold text-gray-900">{{ ucwords($event->event_name) }}</p>
                            </div>
                        </div>
                        <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                            <i class="fas fa-tag text-indigo-600 mr-3 w-5"></i>
                            <div>
                                <p class="text-xs font-medium text-gray-500">Event Type</p>
                                <p class="font-semibold text-gray-900">{{ ucwords($event->event_type) ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                            <i class="fas fa-calendar-day text-indigo-600 mr-3 w-5"></i>
                            <div>
                                <p class="text-xs font-medium text-gray-500">Date</p>
                                <p class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($event->event_date)->format('F d, Y') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                            <i class="fas fa-clock text-indigo-600 mr-3 w-5"></i>
                            <div>
                                <p class="text-xs font-medium text-gray-500">Time</p>
                                <p class="font-semibold text-gray-900">{{ $event->start_time ?? 'N/A' }} - {{ $event->end_time ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                            <i class="fas fa-map-marker-alt text-indigo-600 mr-3 w-5"></i>
                            <div>
                                <p class="text-xs font-medium text-gray-500">Venue</p>
                                <p class="font-semibold text-gray-900">{{ ucwords($event->venue_name) ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                            <i class="fas fa-box text-indigo-600 mr-3 w-5"></i>
                            <div>
                                <p class="text-xs font-medium text-gray-500">Package</p>
                                <p class="font-semibold text-gray-900">{{ ucwords($event->package_type) ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- RSVP Status Chart -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border">
                <h2 class="text-xl font-semibold text-indigo-700 mb-4 flex items-center">
                    <i class="fas fa-chart-pie mr-2"></i>RSVP Status Distribution
                </h2>
                <div class="h-80">
                    <canvas id="rsvpChart"></canvas>
                </div>
            </div>

            <!-- Check-in Statistics Chart -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border">
                <h2 class="text-xl font-semibold text-indigo-700 mb-4 flex items-center">
                    <i class="fas fa-chart-bar mr-2"></i>Check-in Statistics
                </h2>
                <div class="h-80">
                    <canvas id="checkinChart"></canvas>
                </div>
            </div>
        </div>

        @if($event->status === 'completed')
        <!-- Event Feedback Section -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border">
            <h2 class="text-xl font-semibold text-indigo-700 mb-4 flex items-center">
                <i class="fas fa-comments mr-2"></i>Event Feedback
            </h2>
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('manager.event.feedbacks', ['event' => $event->id]) }}"
                   class="flex items-center justify-center px-6 py-3 bg-gradient-to-r from-purple-600 to-purple-700 text-white rounded-lg hover:from-purple-700 hover:to-purple-800 transition-all font-semibold shadow-md">
                    <i class="fas fa-chart-bar mr-2"></i>View Event Feedbacks
                </a>
                <a href="{{ route('manager.feedback.analytics') }}"
                   class="flex items-center justify-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white rounded-lg hover:from-indigo-700 hover:to-indigo-800 transition-all font-semibold shadow-md">
                    <i class="fas fa-analytics mr-2"></i>Feedback Analytics
                </a>
            </div>
        </div>
        @endif
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

        // End Event Function
        function endEvent(eventId) {
            if (confirm('Are you sure you want to end this event? This will mark the event as completed and enable feedback collection from guests.')) {
                fetch(`/manager/events/${eventId}/end`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Event has been marked as completed! Guests can now provide feedback.');
                        location.reload(); // Refresh the page to show updated status
                    } else {
                        alert('Error: ' + (data.message || 'Failed to end event'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error ending event. Please try again.');
                });
            }
        }

        // RSVP Status Chart
        const rsvpCtx = document.getElementById('rsvpChart').getContext('2d');
        new Chart(rsvpCtx, {
            type: 'doughnut',
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
                            usePointStyle: true
                        }
                    },
                    title: {
                        display: false
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
                    borderWidth: 2,
                    borderRadius: 8
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
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            font: {
                                size: 12
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                size: 12
                            }
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
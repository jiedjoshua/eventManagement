<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Booking - {{ ucwords($booking->event_name) }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-md flex flex-col">
            <div class="p-6 text-2xl font-bold text-indigo-600">Customer Panel</div>
            <nav class="flex-1 px-4 space-y-2 text-sm text-gray-700">
                <!-- Menu -->
                <div>
                    <p class="font-semibold text-gray-900">Home</p>
                    <a href="{{ route('user.dashboard') }}" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Dashboard</a>
                </div>

                <div>
                    <p class="mt-4 font-semibold text-gray-900">My Events</p>
                    <a href="{{ route('user.bookedEvents') }} " class="block pl-4 py-2 rounded bg-indigo-200 font-semibold text-indigo-800">Booked Events</a>
                    <a href="{{ route('user.attendingEvents') }} " class="block pl-4 py-2 hover:bg-indigo-100 rounded">Attending Events</a>
                    <a href="#" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Guest List</a>
                </div>

                <div>
                    <p class="mt-4 font-semibold text-gray-900">Payment</p>
                    <a href="{{ route('user.payments') }}" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Payments</a>
                    <a href="{{ route('user.paymentHistory') }}" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Payment History</a>
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


        <main class="flex-1 p-8">
            <div class="max-w-3xl mx-auto">
                <header class="mb-8">
                    <h1 class="text-3xl font-bold text-gray-800">Edit Booking</h1>
                    <p class="text-gray-600">Reference: {{ $booking->reference }}</p>

                    <!-- Add this success message section -->
                    @if(session('success'))
                    <div class="mt-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                    @endif
                </header>
                </header>

                <form action="{{ route('bookings.update', $booking->reference) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('POST')

                    <div class="bg-white shadow rounded-lg p-6 space-y-6">
                        <!-- Event Details Section -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Event Name</label>
                                <input type="text" name="event_name" value="{{ ucwords(old('event_name', $booking->event_name)) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('event_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Event Type</label>
                                <select id="event_type" name="event_type"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select event type</option>
                                    <option value="wedding" {{ old('event_type', $booking->event_type) == 'wedding' ? 'selected' : '' }}>Wedding</option>
                                    <option value="birthday" {{ old('event_type', $booking->event_type) == 'birthday' ? 'selected' : '' }}>Birthday Party</option>
                                    <option value="debut" {{ old('event_type', $booking->event_type) == 'debut' ? 'selected' : '' }}>Debut</option>
                                    <option value="baptism" {{ old('event_type', $booking->event_type) == 'baptism' ? 'selected' : '' }}>Baptism</option>
                                </select>
                                @error('event_type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Event Date</label>
                                <input type="date" name="event_date"
                                    value="{{ old('event_date', $booking->event_date ? \Carbon\Carbon::parse($booking->event_date)->format('Y-m-d') : '') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('event_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Guest Count</label>
                                <input type="number" name="guest_count" value="{{ old('guest_count', $booking->guest_count) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('guest_count')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Start Time</label>
                                <input type="time" name="start_time" value="{{ old('start_time', $booking->start_time) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('start_time')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">End Time</label>
                                <input type="time" name="end_time" value="{{ old('end_time', $booking->end_time) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('end_time')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Venue</label>
                                <select name="venue_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @foreach($venues as $venue)
                                    <option value="{{ $venue->id }}" {{ old('venue_id', $booking->venue_id) == $venue->id ? 'selected' : '' }}>
                                        {{ ucwords($venue->name) }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('venue_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Package</label>
                                <select name="package_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @foreach($packages as $package)
                                    <option value="{{ $package->id }}" {{ old('package_id', $booking->package_id) == $package->id ? 'selected' : '' }}>
                                        {{ ucwords($package->name) }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('package_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Notes Section -->
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Venue Notes</label>
                                <textarea name="venue_notes" rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('venue_notes', $booking->venue_notes) }}</textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Additional Notes</label>
                                <textarea name="additional_notes" rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('additional_notes', $booking->additional_notes) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('user.bookedEvents') }}"
                            class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            Cancel
                        </a>
                        <button type="submit"
                            class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Update Booking
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>

</html>
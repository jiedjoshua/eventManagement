<x-customer-layout title="Edit Booking - {{ ucwords($booking->event_name) }}" active-page="booked-events">
  <main class="flex-1 p-6 md:p-10 overflow-auto">
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
        <div class="flex flex-col sm:flex-row justify-end gap-3">
          <a href="{{ route('user.bookedEvents') }}"
              class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 text-center">
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
</x-customer-layout>
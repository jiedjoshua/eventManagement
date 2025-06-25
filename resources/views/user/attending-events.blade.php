<x-customer-layout title="My Events - Attending" active-page="attending-events">
  <header class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800">My Events - Attending</h1>
    <p class="text-gray-600 mt-2">Here are the events you accepted invitations to.</p>
  </header>

  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
    @forelse ($acceptedEvents as $event)
    @php
    $isPast = \Carbon\Carbon::parse($event->event_date)->endOfDay()->lt(now());
    @endphp
    <div class="bg-white rounded-lg shadow-md p-5 flex flex-col justify-between {{ $isPast ? 'opacity-60' : '' }}">
      <div>
        <h3 class="text-xl font-bold mb-1">{{ $event->event_name }}</h3>
        <p class="text-gray-600 mb-1"><strong>Type:</strong> {{ $event->event_type }}</p>
        <p class="text-gray-600 mb-1">
          <strong>Date:</strong> {{ \Carbon\Carbon::parse($event->event_date)->format('F d, Y') }},
          {{ \Carbon\Carbon::parse($event->start_time)->format('g:i A') }}
        </p>
        <p class="text-gray-600 mb-2"><strong>Location:</strong> {{ $event->venue_name }}</p>

        @if($isPast)
        <span class="inline-block px-3 py-1 text-sm font-medium rounded-full bg-gray-200 text-gray-700">
          Event Done
        </span>
        @else
        <span class="inline-block px-3 py-1 text-sm font-medium rounded-full bg-green-100 text-green-800">
          Accepted
        </span>
        @endif
      </div>

      <div class="mt-4 flex flex-wrap gap-2">
        @if($isPast)
        <a href="{{ route('feedback.create', $event->id) }}"
          class="flex-1 bg-yellow-600 text-white text-sm py-2 text-center rounded hover:bg-yellow-700 transition">
          Give Feedback
        </a>
        @else
        <a href="{{ url('/invite/' . $event->id) }}"
          class="flex-1 bg-indigo-600 text-white text-sm py-2 text-center rounded hover:bg-indigo-700 transition">
          View QR Code
        </a>
        @endif
      </div>
      @empty
      <p class="text-gray-600 col-span-full">You are not attending any events yet.</p>
      @endforelse
    </div>
</x-customer-layout>
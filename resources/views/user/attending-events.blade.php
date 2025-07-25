<x-customer-layout title="My Events - Attending" active-page="attending-events">
  <main class="flex-1 p-6 md:p-10 overflow-auto">
    <header class="mb-8">
      <h1 class="text-3xl font-bold text-gray-800">My Events - Attending</h1>
      <p class="text-gray-600 mt-2">Here are the events you accepted invitations to.</p>
    </header>

    @if($acceptedEvents->count() > 0)
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
        @foreach ($acceptedEvents as $event)
        @php
        $isPast = \Carbon\Carbon::parse($event->event_date)->endOfDay()->lt(now());
        $isCompleted = $event->status === 'completed';
        @endphp
        <div class="bg-white rounded-lg shadow-md p-4 md:p-5 flex flex-col justify-between {{ $isPast ? 'opacity-60' : '' }}">
          <div>
            <h3 class="text-lg md:text-xl font-bold mb-1">{{ $event->event_name }}</h3>
            <p class="text-gray-600 mb-1 text-sm md:text-base"><strong>Type:</strong> {{ $event->event_type }}</p>
            <p class="text-gray-600 mb-1 text-sm md:text-base">
              <strong>Date:</strong> {{ \Carbon\Carbon::parse($event->event_date)->format('F d, Y') }},
              {{ \Carbon\Carbon::parse($event->start_time)->format('g:i A') }}
            </p>
            <p class="text-gray-600 mb-2 text-sm md:text-base"><strong>Location:</strong> {{ $event->venue_name }}</p>

            @if($isCompleted)
            <span class="inline-block px-3 py-1 text-sm font-medium rounded-full bg-green-200 text-green-800">
              Completed
            </span>
            @elseif($isPast)
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
            @if($isCompleted)
            <a href="{{ route('feedback.create', $event->id) }}"
              class="flex-1 bg-yellow-600 text-white text-sm py-2 text-center rounded hover:bg-yellow-700 transition">
              Give Feedback
            </a>
            @elseif($isPast)
            <span class="flex-1 bg-gray-400 text-white text-sm py-2 text-center rounded cursor-not-allowed">
              Event Not Ended
            </span>
            @else
            <a href="{{ url('/invite/' . $event->id) }}"
              class="flex-1 bg-indigo-600 text-white text-sm py-2 text-center rounded hover:bg-indigo-700 transition">
              View QR Code
            </a>
            @endif
          </div>
        </div>
        @endforeach
      </div>
    @else
      <div class="text-center py-12">
        <p class="text-gray-600 text-lg">You are not attending any events yet.</p>
      </div>
    @endif
  </main>
</x-customer-layout>
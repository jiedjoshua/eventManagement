<x-customer-layout title="My Events - Attending" active-page="attending-events">
  <main class="flex-1 p-6 md:p-10 overflow-auto">
    
    <!-- Enhanced Header -->
    <div class="mb-8">
      <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">Events I'm Attending</h1>
          <p class="text-gray-600 mt-2">Track all the events you've accepted invitations to attend.</p>
        </div>
        <div class="flex gap-3">
          <a href="{{ route('book-now') }}" 
             class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors font-medium">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Book Event
          </a>
          <a href="{{ route('user.bookedEvents') }}" 
             class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors font-medium shadow">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            My Bookings
          </a>
        </div>
      </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
      <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-4 border border-blue-200">
        <div class="flex items-center">
          <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center mr-4">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
          </div>
          <div>
            <p class="text-2xl font-bold text-blue-900">{{ $acceptedEvents->count() }}</p>
            <p class="text-blue-700 text-sm font-medium">Total Attending</p>
          </div>
        </div>
      </div>

      <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-2xl p-4 border border-green-200">
        <div class="flex items-center">
          <div class="w-12 h-12 bg-green-600 rounded-xl flex items-center justify-center mr-4">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
          </div>
          <div>
            <p class="text-2xl font-bold text-green-900">{{ $acceptedEvents->where('status', 'completed')->count() }}</p>
            <p class="text-green-700 text-sm font-medium">Completed</p>
          </div>
        </div>
      </div>

      <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-2xl p-4 border border-indigo-200">
        <div class="flex items-center">
          <div class="w-12 h-12 bg-indigo-600 rounded-xl flex items-center justify-center mr-4">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
          </div>
          <div>
            <p class="text-2xl font-bold text-indigo-900">{{ $acceptedEvents->where('status', '!=', 'completed')->where('event_date', '>', now())->count() }}</p>
            <p class="text-indigo-700 text-sm font-medium">Upcoming</p>
          </div>
        </div>
      </div>
    </div>

    @if($acceptedEvents->count() > 0)
      <!-- Enhanced Event Cards -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($acceptedEvents as $event)
        @php
        $isPast = \Carbon\Carbon::parse($event->event_date)->endOfDay()->lt(now());
        $isCompleted = $event->status === 'completed';
        $isUpcoming = !$isPast && !$isCompleted;
        @endphp
        
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 {{ $isPast ? 'opacity-75' : '' }}">
          
          <!-- Event Header -->
          <div class="flex items-start justify-between mb-4">
            <div class="flex-1">
              <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $event->event_name }}</h3>
              <div class="flex items-center">
                @if($isCompleted)
                <span class="inline-flex items-center px-3 py-1 text-sm font-medium rounded-full bg-green-100 text-green-800 border border-green-200">
                  <span class="w-2 h-2 rounded-full mr-2 bg-green-500"></span>
                  Completed
                </span>
                @elseif($isPast)
                <span class="inline-flex items-center px-3 py-1 text-sm font-medium rounded-full bg-gray-100 text-gray-700 border border-gray-200">
                  <span class="w-2 h-2 rounded-full mr-2 bg-gray-500"></span>
                  Event Done
                </span>
                @else
                <span class="inline-flex items-center px-3 py-1 text-sm font-medium rounded-full bg-indigo-100 text-indigo-800 border border-indigo-200">
                  <span class="w-2 h-2 rounded-full mr-2 bg-indigo-500"></span>
                  Accepted
                </span>
                @endif
              </div>
            </div>
          </div>

          <!-- Event Details -->
          <div class="space-y-3 mb-6">
            <div class="flex items-center text-gray-600">
              <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
              </svg>
              <span class="text-sm">{{ ucwords($event->event_type) }}</span>
            </div>
            
            <div class="flex items-center text-gray-600">
              <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
              </svg>
              <span class="text-sm">{{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }}</span>
            </div>
            
            <div class="flex items-center text-gray-600">
              <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              <span class="text-sm">{{ \Carbon\Carbon::parse($event->start_time)->format('g:i A') }}</span>
            </div>
            
            <div class="flex items-center text-gray-600">
              <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
              </svg>
              <span class="text-sm">{{ $event->venue_name }}</span>
            </div>
          </div>

          <!-- Action Buttons -->
          <div class="space-y-3">
            @if($isCompleted)
            <a href="{{ route('feedback.create', $event->id) }}"
              class="w-full bg-gradient-to-r from-yellow-500 to-yellow-600 text-white text-sm py-3 px-4 rounded-xl hover:from-yellow-600 hover:to-yellow-700 transition-all duration-200 font-medium text-center shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
              <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
              </svg>
              Give Feedback
            </a>
            @elseif($isPast)
            <span class="w-full bg-gray-300 text-gray-600 text-sm py-3 px-4 rounded-xl cursor-not-allowed text-center font-medium">
              <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              Event Not Ended
            </span>
            @else
            <a href="{{ url('/invite/' . $event->id) }}"
              class="w-full bg-gradient-to-r from-indigo-500 to-indigo-600 text-white text-sm py-3 px-4 rounded-xl hover:from-indigo-600 hover:to-indigo-700 transition-all duration-200 font-medium text-center shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
              <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V6a1 1 0 00-1-1H5a1 1 0 00-1 1v1a1 1 0 001 1zm12 0h2a1 1 0 001-1V6a1 1 0 00-1-1h-2a1 1 0 00-1 1v1a1 1 0 001 1zM5 20h2a1 1 0 001-1v-1a1 1 0 00-1-1H5a1 1 0 00-1 1v1a1 1 0 001 1z"></path>
              </svg>
              View QR Code
            </a>
            @endif
          </div>
        </div>
        @endforeach
      </div>
    @else
      <!-- Enhanced Empty State -->
      <div class="text-center py-16">
        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
          <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
          </svg>
        </div>
        <h3 class="text-2xl font-bold text-gray-900 mb-3">No Events to Attend</h3>
        <p class="text-gray-600 mb-8 max-w-md mx-auto">You haven't accepted any event invitations yet. When you receive an invitation, you can accept it to see the event details here.</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
          <a href="{{ route('book-now') }}" 
             class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white rounded-xl hover:from-indigo-700 hover:to-indigo-800 transition-all duration-200 font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Book Your Own Event
          </a>
          <a href="{{ route('user.bookedEvents') }}" 
             class="inline-flex items-center px-6 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-200 font-semibold">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            View My Bookings
          </a>
        </div>
      </div>
    @endif
  </main>
</x-customer-layout>
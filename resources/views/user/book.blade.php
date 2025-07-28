<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>Booked Events</title>
  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body class="bg-gray-50 min-h-screen flex">

  <x-customer-layout title="My Events - Booked Events" active-page="booked-events">
    <main class="flex-1 p-6 md:p-10 overflow-auto"
      x-data="{ 
          showModal: false,
          showQRModal: false,
          currentBooking: null,
          inviteLink: '',
          copied: false,
          init() {
              this.showModal = false;
              this.showQRModal = false;
          },
          showCopiedMessage() {
              this.copied = true;
              setTimeout(() => {
                  this.copied = false;
              }, 2000);
          },
          formatDate(date) {
              return new Date(date).toLocaleDateString('en-US', {
                  year: 'numeric',
                  month: 'long',
                  day: 'numeric'
              });
          },
          editBooking(reference) {
              window.location.href = `/user/bookings/${reference}/edit`;
          },
          formatTime(time) {
              return new Date(`2000-01-01T${time}`).toLocaleTimeString('en-US', {
                  hour: 'numeric',
                  minute: '2-digit'
              });
          }
      }">
      
      <!-- Enhanced Header -->
      <div class="mb-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
          <div>
            <h1 class="text-3xl font-bold text-gray-900">My Booked Events</h1>
            <p class="text-gray-600 mt-2">Manage and track all your event bookings in one place.</p>
          </div>
          <a href="{{ route('book-now') }}" 
             class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white rounded-xl hover:from-indigo-700 hover:to-indigo-800 transition-all duration-200 font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Book New Event
          </a>
        </div>
      </div>

      <!-- Stats Cards -->
      <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-4 border border-blue-200">
          <div class="flex items-center">
            <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center mr-4">
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
              </svg>
            </div>
            <div>
              <p class="text-2xl font-bold text-blue-900">{{ $bookedEvents->count() }}</p>
              <p class="text-blue-700 text-sm font-medium">Total Events</p>
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
              <p class="text-2xl font-bold text-green-900">{{ $bookedEvents->where('status', 'approved')->count() }}</p>
              <p class="text-green-700 text-sm font-medium">Approved</p>
            </div>
          </div>
        </div>

        <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-2xl p-4 border border-yellow-200">
          <div class="flex items-center">
            <div class="w-12 h-12 bg-yellow-600 rounded-xl flex items-center justify-center mr-4">
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </div>
            <div>
              <p class="text-2xl font-bold text-yellow-900">{{ $bookedEvents->where('status', 'pending')->count() }}</p>
              <p class="text-yellow-700 text-sm font-medium">Pending</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Enhanced Event Cards -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($bookedEvents as $booking)
        @php
        $status = $booking->status ?? 'Pending';
        $statusColors = [
        'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
        'approved' => 'bg-green-100 text-green-800 border-green-200',
        'rejected' => 'bg-red-100 text-red-800 border-red-200',
        ];
        $statusClass = $statusColors[$status] ?? 'bg-gray-100 text-gray-800 border-gray-200';
        $isPast = \Carbon\Carbon::parse($booking->event_date)->endOfDay()->lt(now());
        $isCompleted = $booking->event && $booking->event->status === 'completed';
        @endphp

        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
          <!-- Event Header -->
          <div class="flex items-start justify-between mb-4">
            <div class="flex-1">
              <h3 class="text-xl font-bold text-gray-900 mb-2">{{ ucwords($booking->event_name) }}</h3>
              <span class="inline-flex items-center px-3 py-1 text-sm font-medium rounded-full border {{ $statusClass }}">
                <span class="w-2 h-2 rounded-full mr-2 
                  {{ $status === 'approved' ? 'bg-green-500' : ($status === 'pending' ? 'bg-yellow-500' : 'bg-red-500') }}"></span>
                {{ ucfirst($status) }}
              </span>
            </div>
          </div>

          <!-- Event Details -->
          <div class="space-y-3 mb-6">
            <div class="flex items-center text-gray-600">
              <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
              </svg>
              <span class="text-sm">{{ ucwords($booking->event_type) }}</span>
            </div>
            
            <div class="flex items-center text-gray-600">
              <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
              </svg>
              <span class="text-sm">{{ \Carbon\Carbon::parse($booking->event_date)->format('M d, Y') }}</span>
            </div>
            
            <div class="flex items-center text-gray-600">
              <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              <span class="text-sm">{{ \Carbon\Carbon::parse($booking->start_time)->format('g:i A') }}</span>
            </div>
            
            <div class="flex items-center text-gray-600">
              <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
              </svg>
              <span class="text-sm">{{ ucwords($booking->venue->name ?? 'Not specified') }}</span>
            </div>

            <div class="flex items-center text-gray-600">
              <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
              </svg>
              <span class="text-sm font-mono text-gray-500">{{ strtoupper($booking->reference) }}</span>
            </div>
          </div>

          <!-- Action Buttons -->
          <div class="space-y-3">
            @if($isCompleted)
              @if($booking->event)
              <a href="{{ route('feedback.create', $booking->event->id) }}"
                 class="w-full bg-gradient-to-r from-yellow-500 to-yellow-600 text-white text-sm py-3 px-4 rounded-xl hover:from-yellow-600 hover:to-yellow-700 transition-all duration-200 font-medium text-center shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                </svg>
                Give Feedback
              </a>
              @endif
            @elseif($isPast)
              <span class="w-full bg-gray-300 text-gray-600 text-sm py-3 px-4 rounded-xl cursor-not-allowed text-center font-medium">
                Event Not Ended
              </span>
            @else
              <button type="button"
                @click="showModal = true; currentBooking = {{ $booking->toJson() }}"
                class="w-full bg-gradient-to-r from-blue-500 to-blue-600 text-white text-sm py-3 px-4 rounded-xl hover:from-blue-600 hover:to-blue-700 transition-all duration-200 font-medium shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                View Details
              </button>

              @if($booking->status === 'approved')
              <div class="grid grid-cols-2 gap-2">
                <a href="{{ route('user.guest-list', $booking->reference) }}"
                  class="bg-gradient-to-r from-purple-500 to-purple-600 text-white text-sm py-2 px-3 rounded-lg hover:from-purple-600 hover:to-purple-700 transition-all duration-200 font-medium text-center shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                  <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                  </svg>
                  Guest List
                </a>

                @if($booking->event)
                <button type="button"
                  @click="showQRModal = true; inviteLink = '{{ route('invite.confirm', $booking->event->id) }}'"
                  class="bg-gradient-to-r from-indigo-500 to-indigo-600 text-white text-sm py-2 px-3 rounded-lg hover:from-indigo-600 hover:to-indigo-700 transition-all duration-200 font-medium shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                  <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V6a1 1 0 00-1-1H5a1 1 0 00-1 1v1a1 1 0 001 1zm12 0h2a1 1 0 001-1V6a1 1 0 00-1-1h-2a1 1 0 00-1 1v1a1 1 0 001 1zm12 0h2a1 1 0 001-1v-1a1 1 0 00-1-1H5a1 1 0 00-1 1v1a1 1 0 001 1z"></path>
                  </svg>
                  QR / Invite
                </button>
                @endif
              </div>

              @endif
            @endif
          </div>
        </div>
        @empty
        <div class="col-span-full text-center py-12">
          <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
          </div>
          <h3 class="text-xl font-semibold text-gray-900 mb-2">No Booked Events</h3>
          <p class="text-gray-600 mb-6">You haven't booked any events yet. Start by creating your first event booking!</p>
          <a href="{{ route('book-now') }}" 
             class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white rounded-xl hover:from-indigo-700 hover:to-indigo-800 transition-all duration-200 font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Book Your First Event
          </a>
        </div>
        @endforelse
      </div>

      <!-- Enhanced Details Modal -->
      <div x-show="showModal"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
        <div class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full mx-4 overflow-hidden max-h-[90vh] overflow-y-auto"
          @click.away="showModal = false"
          x-transition:enter="transition ease-out duration-300"
          x-transition:enter-start="opacity-0 transform scale-95"
          x-transition:enter-end="opacity-100 transform scale-100"
          x-transition:leave="transition ease-in duration-200"
          x-transition:leave-start="opacity-100 transform scale-100"
          x-transition:leave-end="opacity-0 transform scale-95">

          <!-- Modal Header -->
          <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-8 py-6 flex justify-between items-center border-b border-gray-200">
            <div>
              <h3 class="text-2xl font-bold text-gray-900"
                x-text="currentBooking?.event_name?.split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase()).join(' ')">
              </h3>
              <p class="text-gray-600 mt-1" x-text="'Booking Reference: ' + (currentBooking?.reference?.toUpperCase())"></p>
            </div>
            <button @click="showModal = false" class="text-gray-400 hover:text-gray-600 transition-colors p-2 rounded-lg hover:bg-gray-200">
              <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
            </button>
          </div>

          <!-- Modal Body -->
          <div class="p-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
              <!-- Event Details Section -->
              <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-6 border border-blue-200">
                <h4 class="font-bold text-xl mb-6 text-blue-900 flex items-center">
                  <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                  </svg>
                  Event Details
                </h4>
                <div class="space-y-4">
                  <div class="flex justify-between items-center">
                    <span class="font-semibold text-blue-800">Event Type:</span>
                    <span class="text-blue-900" x-text="currentBooking?.event_type?.split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ')"></span>
                  </div>
                  <div class="flex justify-between items-center">
                    <span class="font-semibold text-blue-800">Date:</span>
                    <span class="text-blue-900" x-text="new Date(currentBooking?.event_date).toLocaleDateString('en-US', {
                          year: 'numeric',
                          month: 'long',
                          day: 'numeric'
                      })"></span>
                  </div>
                  <div class="flex justify-between items-center">
                    <span class="font-semibold text-blue-800">Time:</span>
                    <span class="text-blue-900" x-text="(currentBooking?.start_time + ' - ' + currentBooking?.end_time).toUpperCase()"></span>
                  </div>
                  <div class="flex justify-between items-center">
                    <span class="font-semibold text-blue-800">Guest Count:</span>
                    <span class="text-blue-900" x-text="currentBooking?.guest_count"></span>
                  </div>
                  <div class="flex justify-between items-center">
                    <span class="font-semibold text-blue-800">Status:</span>
                    <span class="px-3 py-1 rounded-full text-sm font-medium"
                      x-text="currentBooking?.status?.charAt(0).toUpperCase() + currentBooking?.status?.slice(1)"
                      :class="{
                              'bg-yellow-100 text-yellow-800': currentBooking?.status === 'pending',
                              'bg-green-100 text-green-800': currentBooking?.status === 'approved',
                              'bg-red-100 text-red-800': currentBooking?.status === 'rejected'
                          }">
                    </span>
                  </div>
                </div>
              </div>

              <!-- Venue & Package Section -->
              <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-2xl p-6 border border-green-200">
                <h4 class="font-bold text-xl mb-6 text-green-900 flex items-center">
                  <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                  </svg>
                  Venue & Package
                </h4>
                <div class="space-y-4">
                  <div class="flex justify-between items-center">
                    <span class="font-semibold text-green-800">Venue:</span>
                    <span class="text-green-900" x-text="currentBooking?.venue?.name ? 
                          currentBooking.venue.name.split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ') : 
                          'Not specified'"></span>
                  </div>
                  <div class="flex justify-between items-center">
                    <span class="font-semibold text-green-800">Package:</span>
                    <span class="text-green-900" x-text="currentBooking?.package?.name ? 
                          currentBooking.package.name.split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ') : 
                          'Not specified'"></span>
                  </div>
                  <div class="flex justify-between items-center">
                    <span class="font-semibold text-green-800">Package Price:</span>
                    <span class="text-green-900" x-text="currentBooking?.package_price_at_booking ? 
                          '₱' + Number(currentBooking.package_price_at_booking).toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) : 
                          'Not specified'"></span>
                  </div>
                  <div class="flex justify-between items-center">
                    <span class="font-semibold text-green-800">Total Price:</span>
                    <span class="text-green-900 font-bold" x-text="currentBooking?.total_price ? 
                          '₱' + Number(currentBooking.total_price).toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) : 
                          'Not specified'"></span>
                  </div>
                </div>
              </div>

              <!-- Notes Section -->
              <div class="lg:col-span-2 bg-gradient-to-br from-purple-50 to-purple-100 rounded-2xl p-6 border border-purple-200">
                <h4 class="font-bold text-xl mb-6 text-purple-900 flex items-center">
                  <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                  </svg>
                  Additional Notes
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                  <div>
                    <h5 class="font-semibold text-purple-800 mb-3">Venue Notes:</h5>
                    <p class="text-purple-900 bg-white rounded-lg p-4 border border-purple-200" x-text="currentBooking?.venue_notes ? 
                          currentBooking.venue_notes.split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ') : 
                          'No venue notes provided'"></p>
                  </div>
                  <div>
                    <h5 class="font-semibold text-purple-800 mb-3">Additional Notes:</h5>
                    <p class="text-purple-900 bg-white rounded-lg p-4 border border-purple-200" x-text="currentBooking?.additional_notes ? 
                          currentBooking.additional_notes.split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ') : 
                          'No additional notes provided'"></p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-8 flex justify-end space-x-4">
              <template x-if="currentBooking?.status === 'pending'">
                <button @click="editBooking(currentBooking?.reference)"
                  class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-6 py-3 rounded-xl hover:from-blue-600 hover:to-blue-700 transition-all duration-200 font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                  <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                  </svg>
                  Edit Booking
                </button>
              </template>
              <button @click="showModal = false"
                class="bg-gray-300 text-gray-700 px-6 py-3 rounded-xl hover:bg-gray-400 transition-all duration-200 font-semibold">
                Close
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Enhanced QR/Invitation Modal -->
      <div x-show="showQRModal"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 overflow-hidden"
          @click.away="showQRModal = false"
          x-transition:enter="transition ease-out duration-300"
          x-transition:enter-start="opacity-0 transform scale-95"
          x-transition:enter-end="opacity-100 transform scale-100"
          x-transition:leave="transition ease-in duration-200"
          x-transition:leave-start="opacity-100 transform scale-100"
          x-transition:leave-end="opacity-0 transform scale-95">
          
          <!-- Modal Header -->
          <div class="bg-gradient-to-r from-indigo-50 to-indigo-100 px-6 py-4 flex justify-between items-center border-b border-indigo-200">
            <h3 class="text-xl font-bold text-indigo-900 flex items-center">
              <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V6a1 1 0 00-1-1H5a1 1 0 00-1 1v1a1 1 0 001 1zm12 0h2a1 1 0 001-1V6a1 1 0 00-1-1h-2a1 1 0 00-1 1v1a1 1 0 001 1zm12 0h2a1 1 0 001-1v-1a1 1 0 00-1-1H5a1 1 0 00-1 1v1a1 1 0 001 1z"></path>
              </svg>
              Invitation Link
            </h3>
            <button @click="showQRModal = false" class="text-indigo-400 hover:text-indigo-600 transition-colors p-2 rounded-lg hover:bg-indigo-200">
              <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
            </button>
          </div>

          <!-- Modal Body -->
          <div class="p-6">
            <div class="mb-6">
              <p class="text-gray-700 mb-4">Share this invitation link with your guests to allow them to RSVP for your event:</p>
              <div class="flex">
                <input type="text"
                  x-ref="inviteInput"
                  :value="inviteLink"
                  readonly
                  class="flex-1 p-3 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-gray-50 text-gray-700">
                <button
                  @click="$refs.inviteInput.select(); document.execCommand('copy'); showCopiedMessage()"
                  class="bg-gradient-to-r from-indigo-500 to-indigo-600 text-white px-4 py-3 rounded-r-lg hover:from-indigo-600 hover:to-indigo-700 transition-all duration-200 font-medium shadow-md hover:shadow-lg">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                  </svg>
                </button>
              </div>
              <div x-show="copied"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100"
                class="mt-3 flex items-center text-green-600 text-sm">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Link copied to clipboard!
              </div>
            </div>
          </div>
        </div>
      </div>



    </main>
  </x-customer-layout>

</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Booked Events with Sidebar</title>
  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body class="bg-gray-50 min-h-screen flex">

  <!-- Sidebar -->
  <aside class="w-64 bg-white shadow-md flex flex-col">
    <div class="p-6 text-2xl font-bold text-indigo-600">Customer Panel</div>
    <nav class="flex-1 px-4 space-y-2 text-sm text-gray-700 overflow-y-auto">
      <!-- Menu -->
      <div>
        <p class="font-semibold text-gray-900">Home</p>
        <a href="{{ route('user.dashboard') }}" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Dashboard</a>
      </div>

      <div>
        <p class="mt-4 font-semibold text-gray-900">My Events</p>
        <a href="{{ route('user.bookedEvents') }}" class="block pl-4 py-2 rounded bg-indigo-200 font-semibold text-indigo-800">Booked Events</a>
        <a href="#" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Attending Events</a>
        <a href="#" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Guest List</a>
      </div>

      <div>
        <p class="mt-4 font-semibold text-gray-900">Payment</p>
        <a href="{{ route('user.payments') }}" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Payments</a>
        <a href="{{ route('user.paymentHistory') }}" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Payment History</a>
      </div>

      <div>
        <p class="mt-4 font-semibold text-gray-900">Settings</p>
        <a href="{{ route('user.accountSettings') }}" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Account Settings</a>
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

  <!-- Main content -->

  <main class="flex-1 p-6 overflow-y-auto"
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
    <header class="mb-8">
      <h1 class="text-3xl font-bold text-gray-800">My Events - Booked Events</h1>
      <p class="text-gray-600 mt-2">Manage the events you are hosting or have booked.</p>
    </header>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
      @forelse ($bookedEvents as $booking)
      @php
      $status = $booking->status ?? 'Pending';
      $statusColors = [
      'pending' => 'bg-yellow-100 text-yellow-800',
      'approved' => 'bg-green-100 text-green-800',
      'rejected' => 'bg-red-100 text-red-800',
      ];
      $statusClass = $statusColors[$status] ?? 'bg-gray-100 text-gray-800';
      @endphp

      <div class="bg-white rounded-lg shadow-md p-5 flex flex-col justify-between">
        <div>
          <h3 class="text-xl font-bold mb-1">{{ ucwords($booking->event_name) }}</h3>
          <p class="text-gray-600 mb-1">
            <strong>Type:</strong> {{ ucwords($booking->event_type) }}
          </p>
          <p class="text-gray-600 mb-1">
            <strong>Date:</strong> {{ \Carbon\Carbon::parse($booking->event_date)->format('F d, Y') }},
            {{ \Carbon\Carbon::parse($booking->start_time)->format('g:i A') }}
          </p>
          <p class="text-gray-600 mb-1">
            <strong>Venue:</strong> {{ ucwords($booking->venue->name) }}
          </p>
          <p class="text-gray-600 mb-1">
            <strong>Package:</strong> {{ ucwords($booking->package->name) }}
          </p>
          <p class="text-gray-600 mb-2">
            <strong>Reference:</strong> {{ strtoupper($booking->reference) }}
          </p>

          <span class="inline-block px-3 py-1 text-sm font-medium rounded-full {{ $statusClass }}">
            {{ ucfirst($status) }}
          </span>
        </div>

        <div class="mt-4 flex flex-wrap gap-2">
          <button type="button"
            @click="showModal = true; currentBooking = {{ $booking->toJson() }}"
            class="flex-1 bg-blue-600 text-white text-sm py-2 rounded hover:bg-blue-700 transition">
            View Details
          </button>

          @if($booking->status === 'approved')
          <button type="button"
            class="flex-1 bg-purple-600 text-white text-sm py-2 rounded hover:bg-purple-700 transition"
            @click="openModal('{{ $booking->reference }}')">
            Guest List
          </button>

          <button type="button"
            @click="showQRModal = true; inviteLink = '{{ route('invite.confirm', $booking->event->id) }}'"
            class="flex-1 bg-indigo-600 text-white text-sm py-2 rounded hover:bg-indigo-700 transition">
            QR / Invitations
          </button>
          @endif
        </div>
      </div>
      @empty
      <p class="text-gray-600 col-span-full">You Have No Booked Events At The Moment.</p>
      @endforelse
    </div>


    <!-- Details Modal -->
    <div x-show="showModal"
      class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
      x-transition>
      <div class="bg-white rounded-lg shadow-xl max-w-3xl w-full mx-4 overflow-hidden"
        @click.away="showModal = false">

        <!-- Modal Header -->
        <div class="bg-gray-50 px-6 py-4 flex justify-between items-center border-b">
          <h3 class="text-xl font-semibold text-gray-900"
            x-text="currentBooking?.event_name?.split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase()).join(' ')">
          </h3>
          <button @click="showModal = false" class="text-gray-400 hover:text-gray-600">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>
        </div>

        <!-- Modal Body -->
        <div class="p-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Event Details Section -->
            <div>
              <h4 class="font-semibold text-lg mb-4">Event Details</h4>
              <div class="space-y-3">
                <p><span class="font-medium">Reference:</span>
                  <span x-text="currentBooking?.reference?.toUpperCase()"></span>
                </p>
                <p><span class="font-medium">Event Type:</span>
                  <span x-text="currentBooking?.event_type?.split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ')"></span>
                </p>
                <p><span class="font-medium">Date:</span>
                  <span x-text="new Date(currentBooking?.event_date).toLocaleDateString('en-US', {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    })"></span>
                </p>
                <p><span class="font-medium">Time:</span>
                  <span x-text="(currentBooking?.start_time + ' - ' + currentBooking?.end_time).toUpperCase()"></span>
                </p>
                <p><span class="font-medium">Guest Count:</span>
                  <span x-text="currentBooking?.guest_count"></span>
                </p>
                <p><span class="font-medium">Status:</span>
                  <span x-text="currentBooking?.status?.charAt(0).toUpperCase() + currentBooking?.status?.slice(1)"
                    :class="{
                            'text-yellow-600': currentBooking?.status === 'pending',
                            'text-green-600': currentBooking?.status === 'approved',
                            'text-red-600': currentBooking?.status === 'rejected'
                        }">
                  </span>
                </p>
              </div>
            </div>

            <!-- Venue & Package Section -->
            <div>
              <h4 class="font-semibold text-lg mb-4">Venue & Package Details</h4>
              <div class="space-y-3">
                <p><span class="font-medium">Venue:</span>
                  <span x-text="currentBooking?.venue?.name?.split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ')"></span>
                </p>
                <p><span class="font-medium">Package:</span>
                  <span x-text="currentBooking?.package?.name?.split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ')"></span>
                </p>
                <p><span class="font-medium">Package Price:</span>
                  <span x-text="'₱' + Number(currentBooking?.package_price_at_booking).toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 })"></span>
                </p>
                <p><span class="font-medium">Total Price:</span>
                  <span x-text="'₱' + Number(currentBooking?.total_price).toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 })"></span>
                </p>
              </div>
            </div>

            <!-- Notes Section -->
            <div class="md:col-span-2">
              <h4 class="font-semibold text-lg mb-4">Notes</h4>
              <div class="space-y-3">
                <p><span class="font-medium">Venue Notes:</span>
                  <span x-text="currentBooking?.venue_notes ? 
                        currentBooking.venue_notes.split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ') : 
                        'No Venue Notes'"></span>
                </p>
                <p><span class="font-medium">Additional Notes:</span>
                  <span x-text="currentBooking?.additional_notes ? 
                        currentBooking.additional_notes.split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ') : 
                        'No Additional Notes'"></span>
                </p>
              </div>
            </div>
          </div>

          <!-- Action Buttons -->
          <div class="mt-6 flex justify-end space-x-3">
            <template x-if="currentBooking?.status === 'pending'">
              <button @click="editBooking(currentBooking?.reference)"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                Edit Booking
              </button>
            </template>
            <button @click="showModal = false"
              class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400 transition">
              Close
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- QR/Invitation Modal -->
    <div x-show="showQRModal"
      class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
      x-transition>
      <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4 overflow-hidden"
        @click.away="showQRModal = false">
        <!-- Modal Header -->
        <div class="bg-gray-50 px-6 py-4 flex justify-between items-center border-b">
          <h3 class="text-xl font-semibold text-gray-900">Invitation Link</h3>
          <button @click="showQRModal = false" class="text-gray-400 hover:text-gray-600">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>
        </div>

        <!-- Modal Body -->
        <div class="p-6">
          <div class="mb-4">
            <p class="text-gray-600 mb-2">Share this link with your guests:</p>
            <div class="flex">
              <input type="text"
                x-ref="inviteInput"
                :value="inviteLink"
                readonly
                class="flex-1 p-2 border rounded-l focus:outline-none focus:ring-2 focus:ring-indigo-500">
              <button
                @click="$refs.inviteInput.select(); document.execCommand('copy'); showCopiedMessage()"
                class="bg-indigo-600 text-white px-4 py-2 rounded-r hover:bg-indigo-700 transition">
                Copy
              </button>
            </div>
            <p x-show="copied"
              x-transition
              class="text-green-600 text-sm mt-2">
              Link copied to clipboard!
            </p>
          </div>
        </div>
      </div>
    </div>




  </main>

</body>


</html>
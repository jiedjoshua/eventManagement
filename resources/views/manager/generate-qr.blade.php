<x-manager-layout title="Generate External QR Codes" :active-page="'qr-codes'">
    <h1 class="text-3xl font-bold mb-8">Generate QR Codes for Physical Invitations</h1>

    <div class="max-w-xl mx-auto bg-white rounded-lg shadow-md p-8">
        <form method="POST" action="{{ route('manager.generateExternalQRCodes') }}">
            @csrf

            <!-- 1. Choose Event -->
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Select Event</label>
                <select name="event_id" required class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    <option value="">-- Choose an event --</option>
                    @foreach($events as $event)
                        <option value="{{ $event->id }}">
                            {{ $event->event_name }} ({{ \Carbon\Carbon::parse($event->event_date)->format('F d, Y') }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- 2. Quantity -->
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Number of QR Codes</label>
                <input type="number" name="quantity" min="1" max="500" value="1"
                        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400" required>
            </div>

            <!-- 3. Download Button -->
            <div class="flex justify-end">
                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                    Download ZIP
                </button>
            </div>
        </form>
    </div>
</x-manager-layout> 
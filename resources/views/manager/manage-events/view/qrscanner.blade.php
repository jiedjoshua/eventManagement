<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Event Dashboard with Sidebar and Filters</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Dropdown panel style */
        .dropdown-panel {
            position: absolute;
            background: white;
            border: 1px solid #cbd5e0;
            /* Tailwind gray-300 */
            border-radius: 0.25rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            z-index: 10;
            padding: 0.5rem;
            width: 200px;
        }
    </style>
</head>

<body class="flex h-screen bg-gray-100">

    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-md flex flex-col">
        <div class="p-6 text-2xl font-bold text-indigo-600">Event Panel</div>
        <nav class="flex-1 px-4 space-y-2 text-sm text-gray-700">

            <div>
                <p class="font-semibold text-gray-900">Home</p>
                <a href="{{ route('events.dashboard', ['event' => $event->id]) }}" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Dashboard</a>
            </div>

            <div>
                <p class="mt-4 font-semibold text-gray-900">Check-in Controls</p>
                <a href="{{ route('events.qrScanner', ['event' => $event->id]) }}" class="block pl-4 py-2 rounded bg-indigo-200 font-semibold text-indigo-800">QR Scanner</a>
                <a href="{{ route('events.checkedIn', ['event' => $event->id]) }}" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Manual Check-in</a>
                <a href="{{ route('events.checkedIn', ['event' => $event->id]) }}" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Checked in Guests</a>
            </div>

            <div>
                <p class="font-semibold text-gray-900">Guest List Preview </p>
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
        <!-- QR Scanner Section -->
        <div class="mt-12 bg-white rounded-2xl shadow p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-indigo-700">QR Code Scanner</h2>
                <div class="text-sm text-gray-600 bg-white px-4 py-2 rounded shadow font-medium">
                    Philippine Time: <span id="ph-time" class="font-semibold text-gray-800"></span>
                </div>
            </div>

            <p class="text-sm text-gray-600 mb-4">Align the QR code within the box to scan guest check-ins.</p>

            <div class="flex flex-col md:flex-row gap-6">
                <!-- Video Container -->
                <div class="flex-1">
                    <div class="aspect-video bg-gray-200 rounded-lg overflow-hidden shadow-inner border border-gray-300">
                        <video id="qr-video" class="w-full h-full object-cover" autoplay playsinline></video>
                    </div>
                </div>

                <!-- Scan Result Panel -->
                <div class="md:w-1/3 space-y-4">
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 shadow-sm">
                        <p class="text-sm font-medium text-gray-500">Scan Result:</p>
                        <p id="qr-result" class="mt-2 font-semibold text-gray-800 break-words">Waiting for scan...</p>
                    </div>

                    <button id="start-scan" class="w-full px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition">Start Scanner</button>
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
    </script>

    <script>
        const checkInUrl = "{{ route('checkin.scan') }}";
    </script>
    <script>
        const video = document.getElementById('qr-video');
        const result = document.getElementById('qr-result');
        const startButton = document.getElementById('start-scan');

        let scanning = false;
        let stream = null;

        startButton.addEventListener('click', async () => {
            try {
                if (!scanning) {
                    stream = await navigator.mediaDevices.getUserMedia({
                        video: {
                            facingMode: "environment"
                        }
                    });
                    video.srcObject = stream;
                    scanning = true;
                    result.textContent = 'Scanning...';

                    const track = stream.getVideoTracks()[0];
                    const imageCapture = new ImageCapture(track);

                    const interval = setInterval(async () => {
                        try {
                            const bitmap = await imageCapture.grabFrame();
                            const canvas = document.createElement('canvas');
                            canvas.width = bitmap.width;
                            canvas.height = bitmap.height;
                            const ctx = canvas.getContext('2d');
                            ctx.drawImage(bitmap, 0, 0);

                            const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
                            const code = jsQR(imageData.data, imageData.width, imageData.height);

                            if (code) {
                                result.textContent = 'Checking in...';

                                clearInterval(interval);
                                stream.getTracks().forEach(track => track.stop());
                                scanning = false;

                                // Send QR code data to backend
                                fetch(checkInUrl + '?data=' + encodeURIComponent(code.data), {
                                        method: 'GET',
                                        headers: {
                                            'Accept': 'application/json'
                                        }
                                    })
                                    .then(async response => {
                                        const data = await response.json();

                                        // Clear previous styling
                                        result.classList.remove('text-green-600', 'text-red-600', 'text-gray-800');

                                        if (!response.ok) {
                                            // Handle error responses (status codes 400, 403, 404, etc.)
                                            result.textContent = data.error;
                                            result.classList.add('text-red-600');
                                            if (data.checked_in_at) {
                                                result.textContent += `\nPreviously checked in at: ${data.checked_in_at}`;
                                            }
                                        } else if (data.message) {
                                            // Handle successful check-in
                                            result.textContent = data.message;
                                            result.classList.add('text-green-600');
                                        } else {
                                            // Handle unexpected response
                                            result.textContent = 'Unknown response from server.';
                                            result.classList.add('text-gray-800');
                                        }
                                    })
                                    .catch(err => {
                                        result.textContent = 'Failed to check in: ' + err.message;
                                        result.classList.add('text-red-600');
                                    });
                            }
                        } catch (error) {
                            console.warn("Frame grab failed", error);
                        }
                    }, 500);
                }
            } catch (err) {
                result.textContent = 'Camera access denied.';
                console.error(err);
            }
        });
    </script>

    <!-- jsQR library -->
    <script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.js"></script>




</body>

</html>
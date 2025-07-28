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

            <!-- HTTPS Warning -->
            <div id="https-warning" class="hidden mb-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-yellow-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="text-sm text-yellow-800">
                        <strong>Camera access requires HTTPS.</strong> If you're having trouble with the camera, please ensure you're accessing this page via HTTPS or contact your administrator to enable SSL.
                    </p>
                </div>
            </div>

            <p class="text-sm text-gray-600 mb-4">Align the QR code within the box to scan guest check-ins.</p>

            <div class="flex flex-col md:flex-row gap-6">
                <!-- Video Container -->
                <div class="flex-1">
                    <div class="aspect-video bg-gray-200 rounded-lg overflow-hidden shadow-inner border border-gray-300">
                        <video id="qr-video" class="w-full h-full object-cover" autoplay playsinline></video>
                        <div id="camera-placeholder" class="hidden w-full h-full flex items-center justify-center bg-gray-100">
                            <div class="text-center">
                                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                </svg>
                                <p class="text-gray-600 font-medium">Camera not available</p>
                                <p class="text-sm text-gray-500 mt-1">Try the file upload option below</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Scan Result Panel -->
                <div class="md:w-1/3 space-y-4">
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 shadow-sm">
                        <p class="text-sm font-medium text-gray-500">Scan Result:</p>
                        <p id="qr-result" class="mt-2 font-semibold text-gray-800 break-words">Waiting for scan...</p>
                    </div>

                    <button id="start-scan" class="w-full px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition">Start Scanner</button>
                    
                    <!-- File Upload Option -->
                    <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                        <p class="text-sm font-medium text-green-800 mb-2">Upload QR Code Image</p>
                        <p class="text-xs text-green-600 mb-3">If camera doesn't work, upload a QR code image instead.</p>
                        <input type="file" id="qr-file-input" accept="image/*" class="hidden">
                        <button id="upload-qr-btn" class="w-full px-3 py-2 bg-green-600 text-white text-sm font-medium rounded hover:bg-green-700 transition">
                            Choose QR Image
                        </button>
                    </div>
                    
                    <!-- Manual Entry Option -->
                    <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                        <p class="text-sm font-medium text-blue-800 mb-2">Alternative Check-in Method</p>
                        <p class="text-xs text-blue-600 mb-3">If camera scanning doesn't work, you can manually check in guests.</p>
                        <a href="{{ route('events.checkedIn', ['event' => $event->id]) }}" class="block w-full px-3 py-2 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700 transition text-center">
                            Manual Check-in
                        </a>
                    </div>
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
        const cameraPlaceholder = document.getElementById('camera-placeholder');
        const httpsWarning = document.getElementById('https-warning');
        const fileInput = document.getElementById('qr-file-input');
        const uploadBtn = document.getElementById('upload-qr-btn');

        let scanning = false;
        let stream = null;

        // Check if we're on HTTPS
        if (location.protocol !== 'https:' && location.hostname !== 'localhost' && location.hostname !== '127.0.0.1') {
            httpsWarning.classList.remove('hidden');
        }

        function showCameraPlaceholder() {
            video.style.display = 'none';
            cameraPlaceholder.classList.remove('hidden');
        }

        function hideCameraPlaceholder() {
            video.style.display = 'block';
            cameraPlaceholder.classList.add('hidden');
        }

        function processQRCode(qrData) {
            result.textContent = 'Checking in...';
            
            fetch(checkInUrl + '?data=' + encodeURIComponent(qrData), {
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
                    result.textContent = data.error;
                    result.classList.add('text-red-600');
                    if (data.checked_in_at) {
                        result.textContent += `\nPreviously checked in at: ${data.checked_in_at}`;
                    }
                } else if (data.message) {
                    result.textContent = data.message;
                    result.classList.add('text-green-600');
                } else {
                    result.textContent = 'Unknown response from server.';
                    result.classList.add('text-gray-800');
                }
            })
            .catch(err => {
                result.textContent = 'Failed to check in: ' + err.message;
                result.classList.add('text-red-600');
            });
        }

        // File upload handler
        uploadBtn.addEventListener('click', () => {
            fileInput.click();
        });

        fileInput.addEventListener('change', (event) => {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = new Image();
                    img.onload = function() {
                        const canvas = document.createElement('canvas');
                        const ctx = canvas.getContext('2d');
                        canvas.width = img.width;
                        canvas.height = img.height;
                        ctx.drawImage(img, 0, 0);
                        
                        const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
                        const code = jsQR(imageData.data, imageData.width, imageData.height);
                        
                        if (code) {
                            processQRCode(code.data);
                        } else {
                            result.textContent = 'No QR code found in the image. Please try another image.';
                            result.classList.remove('text-green-600', 'text-red-600');
                            result.classList.add('text-red-600');
                        }
                    };
                    img.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });

        startButton.addEventListener('click', async () => {
            try {
                if (!scanning) {
                    // Stop any existing stream
                    if (stream) {
                        stream.getTracks().forEach(track => track.stop());
                    }

                    result.textContent = 'Requesting camera access...';
                    result.classList.remove('text-green-600', 'text-red-600', 'text-gray-800');
                    result.classList.add('text-gray-800');

                    stream = await navigator.mediaDevices.getUserMedia({
                        video: {
                            facingMode: "environment",
                            width: { ideal: 1280 },
                            height: { ideal: 720 }
                        }
                    });
                    
                    video.srcObject = stream;
                    hideCameraPlaceholder();
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
                                clearInterval(interval);
                                stream.getTracks().forEach(track => track.stop());
                                scanning = false;
                                processQRCode(code.data);
                            }
                        } catch (error) {
                            console.warn("Frame grab failed", error);
                        }
                    }, 500);
                }
            } catch (err) {
                console.error('Camera error:', err);
                
                if (err.name === 'NotAllowedError') {
                    result.textContent = 'Camera access denied. Please allow camera permissions and try again.';
                    result.classList.add('text-red-600');
                    showCameraPlaceholder();
                } else if (err.name === 'NotSupportedError') {
                    result.textContent = 'Camera not supported on this device/browser.';
                    result.classList.add('text-red-600');
                    showCameraPlaceholder();
                } else if (err.name === 'NotFoundError') {
                    result.textContent = 'No camera found on this device.';
                    result.classList.add('text-red-600');
                    showCameraPlaceholder();
                } else {
                    result.textContent = 'Camera error: ' + err.message;
                    result.classList.add('text-red-600');
                    showCameraPlaceholder();
                }
                
                scanning = false;
            }
        });

        // Clean up on page unload
        window.addEventListener('beforeunload', () => {
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
            }
        });
    </script>

    <!-- jsQR library -->
    <script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.js"></script>

</body>

</html>
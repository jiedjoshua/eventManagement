<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>QR Scanner - Event Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .dropdown-panel {
            position: absolute;
            background: white;
            border: 1px solid #cbd5e0;
            border-radius: 0.25rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            z-index: 10;
            padding: 0.5rem;
            width: 200px;
        }
        
        .scanner-container {
            position: relative;
            overflow: hidden;
        }
        
        .scanner-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            pointer-events: none;
        }
        
        .scanner-frame {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 250px;
            height: 250px;
            border: 3px solid #4f46e5;
            border-radius: 20px;
            box-shadow: 0 0 0 9999px rgba(0, 0, 0, 0.5);
        }
        
        .scanner-corners {
            position: absolute;
            width: 30px;
            height: 30px;
            border: 4px solid #4f46e5;
        }
        
        .scanner-corners.top-left {
            top: -4px;
            left: -4px;
            border-right: none;
            border-bottom: none;
            border-radius: 20px 0 0 0;
        }
        
        .scanner-corners.top-right {
            top: -4px;
            right: -4px;
            border-left: none;
            border-bottom: none;
            border-radius: 0 20px 0 0;
        }
        
        .scanner-corners.bottom-left {
            bottom: -4px;
            left: -4px;
            border-right: none;
            border-top: none;
            border-radius: 0 0 0 20px;
        }
        
        .scanner-corners.bottom-right {
            bottom: -4px;
            right: -4px;
            border-left: none;
            border-top: none;
            border-radius: 0 0 20px 0;
        }
        
        .scanning-line {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, #4f46e5, transparent);
            animation: scan 2s linear infinite;
        }
        
        @keyframes scan {
            0% { top: 0; }
            100% { top: 100%; }
        }
        
        .result-card {
            transition: all 0.3s ease;
        }
        
        .result-card.success {
            border-color: #10b981;
            background-color: #f0fdf4;
        }
        
        .result-card.error {
            border-color: #ef4444;
            background-color: #fef2f2;
        }
        
        .result-card.waiting {
            border-color: #6b7280;
            background-color: #f9fafb;
        }
    </style>
</head>

<body class="flex h-screen bg-gray-50">

    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-md flex flex-col">
        <div class="p-6 text-2xl font-bold text-indigo-600">Event Panel</div>
        <nav class="flex-1 px-4 space-y-2 text-sm text-gray-700">
            <div>
                <p class="font-semibold text-gray-900">Home</p>
                <a href="{{ route('events.dashboard', ['event' => $event->id]) }}" class="block pl-4 py-2 hover:bg-indigo-100 rounded transition-colors">Dashboard</a>
            </div>

            <div>
                <p class="mt-4 font-semibold text-gray-900">Check-in Controls</p>
                <a href="{{ route('events.qrScanner', ['event' => $event->id]) }}" class="block pl-4 py-2 rounded bg-indigo-200 font-semibold text-indigo-800 transition-colors">QR Scanner</a>
                <a href="{{ route('events.manualCheckin', ['event' => $event->id]) }}" class="block pl-4 py-2 hover:bg-indigo-100 rounded transition-colors">Manual Check-in</a>
                <a href="{{ route('events.checkedIn', ['event' => $event->id]) }}" class="block pl-4 py-2 hover:bg-indigo-100 rounded transition-colors">Checked in Guests</a>
            </div>

            <div>
                <p class="mt-4 font-semibold text-gray-900">Guest List Preview</p>
                <a href="{{ route('events.guests', ['event' => $event->id]) }}" class="block pl-4 py-2 hover:bg-indigo-100 rounded transition-colors">View full guest list</a>
            </div>
        </nav>

        <div class="px-6 py-4 border-t">
            <a href="{{ route('manager.upcomingEvents') }}" class="block text-red-600 font-semibold hover:underline transition-colors">
                Back to Manager Panel
            </a>
        </div>
    </aside>

    <main class="flex-1 p-6 lg:p-8 overflow-y-auto">
        <!-- Header Section -->
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">QR Code Scanner</h1>
                <p class="text-gray-600">Scan QR codes to check in guests automatically</p>
            </div>
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
                <div class="text-sm text-gray-600 bg-white px-4 py-3 rounded-lg shadow-md font-medium border">
                    <i class="fas fa-clock mr-2 text-indigo-600"></i>
                    <span class="font-semibold text-gray-800" id="ph-time"></span>
                </div>
            </div>
        </div>

        <!-- QR Scanner Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Scanner Container -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-lg p-6 border">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-semibold text-indigo-700 flex items-center">
                            <i class="fas fa-qrcode mr-2"></i>Camera Scanner
                        </h2>
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 bg-red-500 rounded-full animate-pulse"></div>
                            <span class="text-sm text-gray-600" id="status-text">Ready</span>
                        </div>
                    </div>

                    <div class="scanner-container bg-gray-100 rounded-xl overflow-hidden shadow-inner border border-gray-200">
                        <video id="qr-video" class="w-full h-80 object-cover" autoplay playsinline style="display: none;"></video>
                        
                        <!-- Scanner Overlay -->
                        <div class="scanner-overlay" id="scanner-overlay" style="display: none;">
                            <div class="scanner-frame">
                                <div class="scanner-corners top-left"></div>
                                <div class="scanner-corners top-right"></div>
                                <div class="scanner-corners bottom-left"></div>
                                <div class="scanner-corners bottom-right"></div>
                                <div class="scanning-line"></div>
                            </div>
                        </div>
                        
                        <!-- Camera Not Active State -->
                        <div id="camera-placeholder" class="flex flex-col items-center justify-center h-80 text-gray-500">
                            <i class="fas fa-camera text-6xl mb-4 opacity-50"></i>
                            <p class="text-lg font-medium mb-2">Camera Not Active</p>
                            <p class="text-sm text-center">Click "Start Scanner" to begin scanning QR codes</p>
                        </div>
                    </div>

                    <div class="mt-6 flex gap-4">
                        <button id="start-scan" class="flex-1 px-6 py-3 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white font-semibold rounded-lg hover:from-indigo-700 hover:to-indigo-800 transition-all shadow-md flex items-center justify-center">
                            <i class="fas fa-play mr-2"></i>Start Scanner
                        </button>
                        <button id="stop-scan" class="px-6 py-3 bg-gray-600 text-white font-semibold rounded-lg hover:bg-gray-700 transition-all shadow-md flex items-center justify-center" style="display: none;">
                            <i class="fas fa-stop mr-2"></i>Stop Scanner
                        </button>
                    </div>
                </div>
            </div>

            <!-- Scan Result Panel -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-lg p-6 border h-fit">
                    <h3 class="text-lg font-semibold text-indigo-700 mb-4 flex items-center">
                        <i class="fas fa-info-circle mr-2"></i>Scan Results
                    </h3>
                    
                    <div id="result-card" class="result-card waiting p-4 rounded-lg border-2 mb-4">
                        <div class="flex items-start">
                            <i class="fas fa-clock text-gray-400 mt-1 mr-3"></i>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-500 mb-1">Status</p>
                                <p id="qr-result" class="font-semibold text-gray-800 break-words">Waiting for scan...</p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                            <h4 class="font-semibold text-blue-800 mb-2 flex items-center">
                                <i class="fas fa-lightbulb mr-2"></i>Instructions
                            </h4>
                            <ul class="text-sm text-blue-700 space-y-1">
                                <li>• Position QR code within the scanner frame</li>
                                <li>• Ensure good lighting for better scanning</li>
                                <li>• Hold the QR code steady for 1-2 seconds</li>
                                <li>• Wait for confirmation message</li>
                            </ul>
                        </div>

                        <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                            <h4 class="font-semibold text-green-800 mb-2 flex items-center">
                                <i class="fas fa-check-circle mr-2"></i>Quick Actions
                            </h4>
                            <div class="flex gap-2">
                                <a href="{{ route('events.manualCheckin', ['event' => $event->id]) }}" class="flex-1 px-3 py-2 bg-green-600 text-white text-sm font-medium rounded hover:bg-green-700 transition-colors text-center">
                                    Manual Check-in
                                </a>
                                <a href="{{ route('events.checkedIn', ['event' => $event->id]) }}" class="flex-1 px-3 py-2 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700 transition-colors text-center">
                                    View Checked-in
                                </a>
                            </div>
                        </div>
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
        const stopButton = document.getElementById('stop-scan');
        const statusText = document.getElementById('status-text');
        const scannerOverlay = document.getElementById('scanner-overlay');
        const cameraPlaceholder = document.getElementById('camera-placeholder');
        const resultCard = document.getElementById('result-card');

        let scanning = false;
        let stream = null;

        function updateResultCard(type, message) {
            resultCard.className = `result-card ${type} p-4 rounded-lg border-2 mb-4`;
            result.textContent = message;
            
            const icon = resultCard.querySelector('i');
            icon.className = type === 'success' ? 'fas fa-check-circle text-green-500 mt-1 mr-3' :
                           type === 'error' ? 'fas fa-exclamation-circle text-red-500 mt-1 mr-3' :
                           'fas fa-clock text-gray-400 mt-1 mr-3';
        }

        function updateStatus(status, color = 'text-gray-600') {
            statusText.textContent = status;
            statusText.className = `text-sm ${color}`;
        }

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
                    
                    // Update UI
                    startButton.style.display = 'none';
                    stopButton.style.display = 'flex';
                    scannerOverlay.style.display = 'block';
                    cameraPlaceholder.style.display = 'none';
                    video.style.display = 'block';
                    updateStatus('Scanning...', 'text-blue-600');
                    updateResultCard('waiting', 'Scanning for QR codes...');

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
                                updateResultCard('waiting', 'Checking in...');

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

                                        if (!response.ok) {
                                            updateResultCard('error', data.error);
                                            if (data.checked_in_at) {
                                                result.textContent += `\nPreviously checked in at: ${data.checked_in_at}`;
                                            }
                                        } else if (data.message) {
                                            updateResultCard('success', data.message);
                                        } else {
                                            updateResultCard('error', 'Unknown response from server.');
                                        }
                                    })
                                    .catch(err => {
                                        updateResultCard('error', 'Failed to check in: ' + err.message);
                                    });
                            }
                        } catch (error) {
                            console.warn("Frame grab failed", error);
                        }
                    }, 500);
                }
            } catch (err) {
                updateResultCard('error', 'Camera access denied. Please allow camera permissions.');
                console.error(err);
            }
        });

        stopButton.addEventListener('click', () => {
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
            }
            scanning = false;
            
            // Update UI
            startButton.style.display = 'flex';
            stopButton.style.display = 'none';
            scannerOverlay.style.display = 'none';
            cameraPlaceholder.style.display = 'flex';
            video.style.display = 'none';
            updateStatus('Ready', 'text-gray-600');
            updateResultCard('waiting', 'Waiting for scan...');
        });
    </script>

    <!-- jsQR library -->
    <script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.js"></script>

</body>

</html>
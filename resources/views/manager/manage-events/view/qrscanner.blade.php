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
        
        .result-card.success br {
            margin-bottom: 0.5rem;
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

    <!-- Enhanced Sidebar -->
    <aside class="w-64 bg-gradient-to-b from-white to-gray-50 shadow-xl border-r border-gray-200 flex flex-col h-screen">
        <!-- Enhanced Header -->
        <div class="p-6 border-b border-gray-200 flex-shrink-0">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Event Panel</h2>
                    <p class="text-sm text-gray-500">Event Manager</p>
                </div>
            </div>
        </div>
        
        <!-- Enhanced Home Button -->
        <div class="px-4 py-4 border-b border-gray-200">
            <a href="{{ route('home') }}" class="flex items-center space-x-3 bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white px-4 py-3 rounded-xl transition-all duration-200 text-sm font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span>Go to Home</span>
            </a>
        </div>
        
        <!-- Enhanced Navigation -->
        <nav class="flex-1 px-4 space-y-6 py-6 overflow-y-auto">
            <!-- Home Section -->
            <div>
                <div class="flex items-center mb-3">
                    <div class="w-2 h-2 bg-indigo-500 rounded-full mr-3"></div>
                    <p class="font-bold text-gray-900 text-sm uppercase tracking-wide">Home</p>
                </div>
                <a href="{{ route('events.dashboard', ['event' => $event->id]) }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <span>Dashboard</span>
                </a>
            </div>

            <!-- Check-in Controls Section -->
            <div>
                <div class="flex items-center mb-3">
                    <div class="w-2 h-2 bg-green-500 rounded-full mr-3"></div>
                    <p class="font-bold text-gray-900 text-sm uppercase tracking-wide">Check-in Controls</p>
                </div>
                <div class="space-y-2">
                    <a href="{{ route('events.qrScanner', ['event' => $event->id]) }}" 
                       class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 bg-gradient-to-r from-green-100 to-green-200 text-green-700 font-semibold shadow-md">
                        <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V6a1 1 0 00-1-1H5a1 1 0 00-1 1v1a1 1 0 001 1zm12 0h2a1 1 0 001-1V6a1 1 0 00-1-1h-2a1 1 0 00-1 1v1a1 1 0 001 1zM5 20h2a1 1 0 001-1v-1a1 1 0 00-1-1H5a1 1 0 00-1 1v1a1 1 0 001 1z"></path>
                        </svg>
                        <span>QR Scanner</span>
                    </a>
                    <a href="{{ route('events.manualCheckin', ['event' => $event->id]) }}" 
                       class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <span>Manual Check-in</span>
                    </a>
                    <a href="{{ route('events.checkedIn', ['event' => $event->id]) }}" 
                       class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Checked in Guests</span>
                    </a>
                </div>
            </div>

            <!-- Guest List Section -->
            <div>
                <div class="flex items-center mb-3">
                    <div class="w-2 h-2 bg-purple-500 rounded-full mr-3"></div>
                    <p class="font-bold text-gray-900 text-sm uppercase tracking-wide">Guest Management</p>
                </div>
                <a href="{{ route('events.guests', ['event' => $event->id]) }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span>View full guest list</span>
                </a>
            </div>
        </nav>

        <!-- Enhanced Back Button -->
        <div class="px-4 py-4 border-t border-gray-200 flex-shrink-0">
            <a href="{{ route('manager.upcomingEvents') }}" 
               class="w-full flex items-center space-x-3 px-4 py-3 text-red-600 hover:text-red-700 hover:bg-red-50 rounded-xl transition-all duration-200 font-semibold group">
                <svg class="h-5 w-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Back to Manager Panel</span>
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
                                        <div class="flex items-center gap-4">
                    <div class="flex items-center gap-2">
                        <button id="sound-toggle" class="flex items-center gap-2 px-3 py-1 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm transition-colors">
                            <i class="fas fa-volume-up text-green-600" id="sound-icon"></i>
                            <span id="sound-text">Sound On</span>
                        </button>
                        <button id="voice-toggle" class="flex items-center gap-2 px-3 py-1 bg-blue-100 hover:bg-blue-200 rounded-lg text-sm transition-colors">
                            <i class="fas fa-microphone text-blue-600" id="voice-icon"></i>
                            <span id="voice-text">Voice On</span>
                        </button>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 bg-red-500 rounded-full animate-pulse"></div>
                        <span class="text-sm text-gray-600" id="status-text">Ready</span>
                    </div>
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
        
        // Create audio context for sound effects
        let audioContext;
        let scanSound;
        
        // Initialize audio context and create scan sound
        function initAudio() {
            try {
                audioContext = new (window.AudioContext || window.webkitAudioContext)();
                createScanSound();
            } catch (error) {
                console.warn('Audio not supported:', error);
            }
        }
        
        // Create a beep sound for QR code detection
        function createScanSound() {
            if (!audioContext) return;
            
            const oscillator = audioContext.createOscillator();
            const gainNode = audioContext.createGain();
            
            oscillator.connect(gainNode);
            gainNode.connect(audioContext.destination);
            
            oscillator.frequency.setValueAtTime(800, audioContext.currentTime); // 800Hz beep
            oscillator.type = 'sine';
            
            gainNode.gain.setValueAtTime(0, audioContext.currentTime);
            gainNode.gain.linearRampToValueAtTime(0.3, audioContext.currentTime + 0.01);
            gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.3);
            
            oscillator.start(audioContext.currentTime);
            oscillator.stop(audioContext.currentTime + 0.3);
        }
        
        // Create a success sound (higher pitch, longer duration)
        function createSuccessSound() {
            if (!audioContext) return;
            
            const oscillator = audioContext.createOscillator();
            const gainNode = audioContext.createGain();
            
            oscillator.connect(gainNode);
            gainNode.connect(audioContext.destination);
            
            oscillator.frequency.setValueAtTime(1200, audioContext.currentTime); // 1200Hz success tone
            oscillator.type = 'sine';
            
            gainNode.gain.setValueAtTime(0, audioContext.currentTime);
            gainNode.gain.linearRampToValueAtTime(0.4, audioContext.currentTime + 0.01);
            gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.5);
            
            oscillator.start(audioContext.currentTime);
            oscillator.stop(audioContext.currentTime + 0.5);
        }
        
        // Create an error sound (lower pitch, shorter duration)
        function createErrorSound() {
            if (!audioContext) return;
            
            const oscillator = audioContext.createOscillator();
            const gainNode = audioContext.createGain();
            
            oscillator.connect(gainNode);
            gainNode.connect(audioContext.destination);
            
            oscillator.frequency.setValueAtTime(400, audioContext.currentTime); // 400Hz error tone
            oscillator.type = 'sine';
            
            gainNode.gain.setValueAtTime(0, audioContext.currentTime);
            gainNode.gain.linearRampToValueAtTime(0.3, audioContext.currentTime + 0.01);
            gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.2);
            
            oscillator.start(audioContext.currentTime);
            oscillator.stop(audioContext.currentTime + 0.2);
        }
        
        // Play scan sound
        function playScanSound() {
            if (!soundEnabled) return;
            if (audioContext && audioContext.state === 'suspended') {
                audioContext.resume();
            }
            createScanSound();
        }
        
        // Play success sound
        function playSuccessSound() {
            if (!soundEnabled) return;
            if (audioContext && audioContext.state === 'suspended') {
                audioContext.resume();
            }
            createSuccessSound();
        }
        
        // Play error sound
        function playErrorSound() {
            if (!soundEnabled) return;
            if (audioContext && audioContext.state === 'suspended') {
                audioContext.resume();
            }
            createErrorSound();
        }
        
        // Sound toggle functionality
        soundToggle.addEventListener('click', function() {
            soundEnabled = !soundEnabled;
            
            if (soundEnabled) {
                soundIcon.className = 'fas fa-volume-up text-green-600';
                soundText.textContent = 'Sound On';
            } else {
                soundIcon.className = 'fas fa-volume-mute text-gray-500';
                soundText.textContent = 'Sound Off';
            }
        });


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
        const soundToggle = document.getElementById('sound-toggle');
        const soundIcon = document.getElementById('sound-icon');
        const soundText = document.getElementById('sound-text');
        const voiceToggle = document.getElementById('voice-toggle');
        const voiceIcon = document.getElementById('voice-icon');
        const voiceText = document.getElementById('voice-text');

        let scanning = false;
        let stream = null;
        let soundEnabled = true;
        let voiceEnabled = true;
        
        // Initialize audio when page loads
        document.addEventListener('DOMContentLoaded', function() {
            initAudio();
        });

        // Function to speak welcome message
        function speakWelcome(name) {
            if (!voiceEnabled) return;
            
            const utterance = new SpeechSynthesisUtterance();
            utterance.text = `Welcome ${name}!`;
            utterance.rate = 0.9; // Slightly slower for clarity
            utterance.pitch = 1.1; // Slightly higher pitch for friendliness
            utterance.volume = 0.8;
            
            // Try to use a female voice if available
            const voices = speechSynthesis.getVoices();
            const femaleVoice = voices.find(voice => 
                voice.name.includes('female') || 
                voice.name.includes('Female') ||
                voice.name.includes('Samantha') ||
                voice.name.includes('Victoria')
            );
            
            if (femaleVoice) {
                utterance.voice = femaleVoice;
            }
            
            speechSynthesis.speak(utterance);
        }

        // Voice toggle functionality
        voiceToggle.addEventListener('click', function() {
            voiceEnabled = !voiceEnabled;
            
            if (voiceEnabled) {
                voiceIcon.className = 'fas fa-microphone text-blue-600';
                voiceText.textContent = 'Voice On';
            } else {
                voiceIcon.className = 'fas fa-microphone-slash text-gray-500';
                voiceText.textContent = 'Voice Off';
            }
        });

        function updateResultCard(type, message) {
            resultCard.className = `result-card ${type} p-4 rounded-lg border-2 mb-4`;
            
            // Handle multi-line messages (replace \n with <br>)
            if (message.includes('\n')) {
                result.innerHTML = message.replace(/\n/g, '<br>');
            } else {
                result.textContent = message;
            }
            
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
                                // Play scan sound when QR code is detected
                                playScanSound();
                                
                                updateResultCard('waiting', 'Checking in...');

                                clearInterval(interval);
                                stream.getTracks().forEach(track => track.stop());
                                scanning = false;

                                // Send QR code data to backend
                                fetch(checkInUrl + '?data=' + encodeURIComponent(code.data), {
                                        method: 'GET',
                                        headers: {
                                            'Accept': 'application/json',
                                            'Content-Type': 'application/json'
                                        }
                                    })
                                    .then(async response => {
                                        const data = await response.json();

                                        if (!response.ok) {
                                            playErrorSound();
                                            updateResultCard('error', data.error);
                                            if (data.checked_in_at) {
                                                result.textContent += `\nPreviously checked in at: ${data.checked_in_at}`;
                                            }
                                        } else if (data.message) {
                                            // Display success message with user's full name
                                            let successMessage = data.message;
                                            let guestName = '';
                                            
                                            // For registered users, show their full name
                                            if (data.user && data.user.first_name && data.user.last_name) {
                                                const fullName = `${data.user.first_name} ${data.user.last_name}`;
                                                successMessage = `✅ Check-in successful!\n👤 Guest: ${fullName}`;
                                                guestName = data.user.first_name; // Use first name for voice
                                            }
                                            // For external guests, show their name
                                            else if (data.guest && data.guest.name) {
                                                successMessage = `✅ Check-in successful!\n👤 Guest: ${data.guest.name}`;
                                                guestName = data.guest.name; // Use full name for voice
                                            }
                                            
                                            playSuccessSound();
                                            updateResultCard('success', successMessage);
                                            
                                            // Speak welcome message
                                            if (guestName) {
                                                speakWelcome(guestName);
                                            }
                                        } else {
                                            playErrorSound();
                                            updateResultCard('error', 'Unknown response from server.');
                                        }
                                    })
                                    .catch(err => {
                                        playErrorSound();
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
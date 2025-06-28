<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Event Invitation</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        
        * {
            font-family: 'Inter', sans-serif;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            background-size: 400% 400%;
            animation: gradientShift 8s ease infinite;
        }
        
        @keyframes gradientShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.1);
        }
        
        .floating {
            animation: float 6s ease-in-out infinite alternate;
        }
        
        @keyframes float {
            0% { transform: translateY(0px) rotate(0deg); }
            100% { transform: translateY(-20px) rotate(2deg); }
        }
        
        .slide-in {
            animation: slideIn 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
        
        @keyframes slideIn {
            0% {
                opacity: 0;
                transform: translateY(50px) scale(0.9);
            }
            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }
        
        .btn-accept {
            background: linear-gradient(135deg, #10b981, #059669);
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .btn-accept:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(16, 185, 129, 0.4);
        }
        
        .btn-decline {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .btn-decline:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(239, 68, 68, 0.4);
        }
        
        .btn-shine::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }
        
        .btn-shine:hover::before {
            left: 100%;
        }
        
        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 50%;
            pointer-events: none;
        }
        
        .particle-1 { top: 10%; left: 15%; animation: twinkle 2s infinite; }
        .particle-2 { top: 20%; right: 20%; animation: twinkle 2.5s infinite 0.5s; }
        .particle-3 { bottom: 30%; left: 10%; animation: twinkle 3s infinite 1s; }
        .particle-4 { bottom: 40%; right: 15%; animation: twinkle 2.2s infinite 1.5s; }
        .particle-5 { top: 60%; left: 80%; animation: twinkle 2.8s infinite 2s; }
        .particle-6 { top: 80%; left: 60%; animation: twinkle 2.3s infinite 0.8s; }
        
        @keyframes twinkle {
            0%, 100% { opacity: 0; transform: scale(0); }
            50% { opacity: 1; transform: scale(1); }
        }
        
        .glow-text {
            text-shadow: 0 0 20px rgba(255, 255, 255, 0.5);
        }
        
        .event-name {
          color: white;
        }
        
        @keyframes gradientText {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        
        .pulse-ring {
            animation: pulse-ring 2s cubic-bezier(0.455, 0.03, 0.515, 0.955) infinite;
        }
        
        @keyframes pulse-ring {
            0% {
                transform: scale(0.8);
                opacity: 1;
            }
            100% {
                transform: scale(2.5);
                opacity: 0;
            }
        }
        
        .invitation-icon {
            position: relative;
        }
        
        .invitation-icon::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            z-index: -1;
        }
        
        .morphing-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 30% 40%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
                        radial-gradient(circle at 80% 20%, rgba(255, 119, 198, 0.3) 0%, transparent 50%),
                        radial-gradient(circle at 40% 80%, rgba(120, 219, 255, 0.3) 0%, transparent 50%);
            animation: morphBg 10s ease-in-out infinite;
        }
        
        @keyframes morphBg {
            0%, 100% { 
                background: radial-gradient(circle at 30% 40%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
                           radial-gradient(circle at 80% 20%, rgba(255, 119, 198, 0.3) 0%, transparent 50%),
                           radial-gradient(circle at 40% 80%, rgba(120, 219, 255, 0.3) 0%, transparent 50%);
            }
            50% { 
                background: radial-gradient(circle at 70% 60%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
                           radial-gradient(circle at 20% 80%, rgba(255, 119, 198, 0.3) 0%, transparent 50%),
                           radial-gradient(circle at 60% 20%, rgba(120, 219, 255, 0.3) 0%, transparent 50%);
            }
        }
        
        .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: scale(0);
            animation: ripple-animation 0.6s linear;
            pointer-events: none;
        }
        
        @keyframes ripple-animation {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
        
        /* Mobile-specific styles for better scrolling */
        @media (max-width: 768px) {
            body {
                overflow-y: auto;
                overflow-x: hidden;
                min-height: 100vh;
                padding: 1rem;
            }
            
            .glass-card {
                margin: 1rem 0;
                padding: 1.5rem;
            }
            
            .text-5xl {
                font-size: 2.5rem;
            }
            
            .text-3xl {
                font-size: 1.75rem;
            }
            
            .text-xl {
                font-size: 1.125rem;
            }
            
            .px-8 {
                padding-left: 1.5rem;
                padding-right: 1.5rem;
            }
            
            .py-4 {
                padding-top: 0.75rem;
                padding-bottom: 0.75rem;
            }
        }
    </style>
</head>
<body class="gradient-bg min-h-screen p-6 relative overflow-x-hidden">
    
    <!-- Morphing Background -->
    <div class="morphing-bg"></div>
    
    <!-- Floating Particles -->
    <div class="particle particle-1"></div>
    <div class="particle particle-2"></div>
    <div class="particle particle-3"></div>
    <div class="particle particle-4"></div>
    <div class="particle particle-5"></div>
    <div class="particle particle-6"></div>
    
    <!-- Floating Decorative Elements -->
    <div class="absolute top-20 left-20 w-32 h-32 bg-white bg-opacity-10 rounded-full floating blur-sm" style="animation-delay: -2s;"></div>
    <div class="absolute bottom-32 right-16 w-24 h-24 bg-white bg-opacity-5 rounded-full floating blur-sm" style="animation-delay: -4s;"></div>
    <div class="absolute top-1/3 right-32 w-16 h-16 bg-white bg-opacity-15 rounded-full floating blur-sm"></div>
    
    <div class="flex flex-col items-center justify-center min-h-screen py-8">
        <div class="glass-card p-12 rounded-3xl max-w-lg w-full text-center slide-in floating relative z-10 my-8">
        
        <!-- Invitation Icon with Pulse Ring -->
        <div class="invitation-icon mb-8 relative inline-block">
            <div class="pulse-ring absolute inset-0 bg-white bg-opacity-20 rounded-full"></div>
            <div class="relative bg-white bg-opacity-20 p-6 rounded-full">
                 <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 20" xmlns="http://www.w3.org/2000/svg">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8m0 8H3a2 2 0 01-2-2V6a2 2 0 012-2h18a2 2 0 012 2v8a2 2 0 01-2 2z" />
    </svg>
            </div>
        </div>
        
        <!-- Header -->
        <h1 class="text-5xl font-bold text-white mb-6 glow-text">You're Invited!</h1>
        <div class="w-32 h-1 bg-gradient-to-r from-transparent via-white to-transparent mx-auto mb-8 opacity-60"></div>
        
        <!-- Event Question -->
        <div class="bg-white bg-opacity-10 rounded-2xl p-6 mb-10 backdrop-blur-sm">
            <p class="text-xl text-white mb-4 font-light leading-relaxed">
                Do you want to attend the event
            </p>
            <h2 class="text-3xl font-bold event-name mb-2">{{ ucwords($event->event_name) }}</h2>
            
            <!-- Event Details -->
            <div class="space-y-3 text-white text-opacity-90 text-sm mb-4">
                <div class="flex items-center justify-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span>{{ \Carbon\Carbon::parse($event->event_date)->format('F d, Y') }}</span>
                </div>
                
                <div class="flex items-center justify-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>{{ \Carbon\Carbon::parse($event->start_time)->format('g:i A') }}</span>
                </div>
                
                <div class="flex items-center justify-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    @if($event->venue && $event->venue->latitude && $event->venue->longitude)
                        <a href="https://www.google.com/maps/dir/?api=1&destination={{ $event->venue->latitude }},{{ $event->venue->longitude }}" 
                           target="_blank" 
                           class="hover:text-blue-200 hover:underline transition-colors duration-200 cursor-pointer"
                           title="Get directions to {{ ucwords($event->venue_name) }}">
                            {{ ucwords($event->venue_name) }}
                            <svg class="w-3 h-3 inline ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                        </a>
                    @else
                        <span>{{ ucwords($event->venue_name) }}</span>
                    @endif
                </div>
            </div>
            
            <div class="flex items-center justify-center text-white text-opacity-80 text-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span>RSVP Required</span>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-center gap-6">
            <button class="btn-accept btn-shine text-white px-8 py-4 rounded-2xl font-semibold text-lg shadow-lg transform transition-all duration-300 hover:scale-105 flex items-center space-x-2" onclick="createRipple(event, this)">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>Accept</span>
            </button>
            
            <button class="btn-decline btn-shine text-white px-8 py-4 rounded-2xl font-semibold text-lg shadow-lg transform transition-all duration-300 hover:scale-105 flex items-center space-x-2" onclick="createRipple(event, this)">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                <span>Decline</span>
            </button>
        </div>
        
        <!-- Decorative Elements -->
        <div class="absolute -top-2 -left-2 w-8 h-8 border-l-2 border-t-2 border-white border-opacity-30 rounded-tl-2xl"></div>
        <div class="absolute -top-2 -right-2 w-8 h-8 border-r-2 border-t-2 border-white border-opacity-30 rounded-tr-2xl"></div>
        <div class="absolute -bottom-2 -left-2 w-8 h-8 border-l-2 border-b-2 border-white border-opacity-30 rounded-bl-2xl"></div>
        <div class="absolute -bottom-2 -right-2 w-8 h-8 border-r-2 border-b-2 border-white border-opacity-30 rounded-br-2xl"></div>
    </div>
    </div>

    <script>
        // Add interactive effects
        document.addEventListener('DOMContentLoaded', function() {
            const card = document.querySelector('.glass-card');
            
            
        });
        
        // Ripple effect function
        function createRipple(event, element) {
            const circle = document.createElement('span');
            const diameter = Math.max(element.clientWidth, element.clientHeight);
            const radius = diameter / 2;
            
            circle.style.width = circle.style.height = `${diameter}px`;
            circle.style.left = `${event.clientX - element.offsetLeft - radius}px`;
            circle.style.top = `${event.clientY - element.offsetTop - radius}px`;
            circle.classList.add('ripple');
            
            const ripple = element.getElementsByClassName('ripple')[0];
            if (ripple) {
                ripple.remove();
            }
            
            element.appendChild(circle);
            
            // Simulate navigation after animation
            setTimeout(() => {
                if (element.classList.contains('btn-accept')) {
                    console.log('Navigating to accept route...');
                     window.location.href = "{{ route('invite.accept', ['eventId' => $event->id]) }}";
                } else {
                    console.log('Navigating to decline route...');
                    window.location.href = "{{ route('invite.decline',['eventId' => $event->id])}}";
                }
            }, 300);
        }
        
        // Add random sparkle effects
        setInterval(() => {
            createSparkle();
        }, 3000);
        
        function createSparkle() {
            const sparkle = document.createElement('div');
            sparkle.className = 'absolute pointer-events-none';
            sparkle.style.width = '3px';
            sparkle.style.height = '3px';
            sparkle.style.background = 'white';
            sparkle.style.borderRadius = '50%';
            sparkle.style.left = Math.random() * 100 + '%';
            sparkle.style.top = Math.random() * 100 + '%';
            sparkle.style.animation = 'twinkle 2s linear forwards';
            
            document.body.appendChild(sparkle);
            
            setTimeout(() => {
                sparkle.remove();
            }, 2000);
        }
    </script>
</body>
</html>
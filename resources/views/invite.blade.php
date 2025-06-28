@php
use Carbon\Carbon;
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Invitation for Sample Event</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet" />
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
    
    * {
      font-family: 'Inter', sans-serif;
    }

    .qr-wrapper svg {
  width: 100% !important;
  height: 100% !important;
}

    
    .glass-effect {
      background: rgba(255, 255, 255, 0.25);
      backdrop-filter: blur(20px);
      border: 1px solid rgba(255, 255, 255, 0.18);
    }
    
    .gradient-bg {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .floating-animation {
      animation: float 6s ease-in-out infinite;
    }
    
    .pulse-animation {
      animation: pulse-custom 2s infinite;
    }
    
    .slide-up {
      animation: slideUp 0.8s ease-out;
    }
    
    .glow-effect {
      box-shadow: 0 0 30px rgba(102, 126, 234, 0.3);
    }
    
    @keyframes float {
      0%, 100% { transform: translateY(0px); }
      50% { transform: translateY(-20px); }
    }
    
    @keyframes pulse-custom {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.7; }
    }
    
    @keyframes slideUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    
    .sparkle {
      position: absolute;
      width: 4px;
      height: 4px;
      background: white;
      border-radius: 50%;
      animation: sparkle 2s linear infinite;
    }
    
    @keyframes sparkle {
      0%, 100% { opacity: 0; transform: scale(0); }
      50% { opacity: 1; transform: scale(1); }
    }
    
    .btn-hover {
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
    }
    
    .btn-hover:before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
      transition: left 0.5s;
    }
    
    .btn-hover:hover:before {
      left: 100%;
    }
    
    .qr-container {
      background: white;
      padding: 20px;
      border-radius: 20px;
      box-shadow: 0 10px 40px rgba(0,0,0,0.1);
      position: relative;
      overflow: hidden;
    }
    
    .qr-container:before {
      content: '';
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: conic-gradient(from 0deg, #667eea, #764ba2, #667eea);
      animation: rotate 3s linear infinite;
      z-index: -1;
    }
    
    .qr-container:after {
      content: '';
      position: absolute;
      inset: 3px;
      background: white;
      border-radius: 17px;
      z-index: -1;
    }
    
    @keyframes rotate {
      100% { transform: rotate(360deg); }
    }
    
    /* Mobile-specific styles for better scrolling */
    @media (max-width: 768px) {
      body {
        overflow-y: auto;
        overflow-x: hidden;
        min-height: 100vh;
        padding: 1rem;
      }
      
      .glass-effect {
        margin: 1rem 0;
        padding: 1.5rem;
      }
      
      .qr-container {
        padding: 15px;
      }
      
      .qr-wrapper {
        width: 120px !important;
        height: 120px !important;
      }
    }
  </style>
</head>
<body class="gradient-bg min-h-screen p-6 relative overflow-x-hidden">

  <!-- Animated Background Elements -->
  <div class="absolute inset-0 overflow-hidden pointer-events-none">
    <div class="sparkle" style="top: 10%; left: 10%; animation-delay: 0s;"></div>
    <div class="sparkle" style="top: 20%; left: 80%; animation-delay: 0.5s;"></div>
    <div class="sparkle" style="top: 60%; left: 20%; animation-delay: 1s;"></div>
    <div class="sparkle" style="top: 80%; left: 70%; animation-delay: 1.5s;"></div>
    <div class="sparkle" style="top: 30%; left: 90%; animation-delay: 2s;"></div>
    <div class="sparkle" style="top: 70%; left: 5%; animation-delay: 2.5s;"></div>
  </div>

  <!-- Floating Decorative Elements -->
  <div class="absolute top-10 left-10 w-20 h-20 bg-white bg-opacity-10 rounded-full floating-animation" style="animation-delay: -2s;"></div>
  <div class="absolute bottom-20 right-10 w-32 h-32 bg-white bg-opacity-5 rounded-full floating-animation" style="animation-delay: -4s;"></div>
  <div class="absolute top-1/3 right-20 w-16 h-16 bg-white bg-opacity-15 rounded-full floating-animation"></div>

  <div class="flex flex-col items-center justify-center min-h-screen py-8">
    <div class="glass-effect p-10 rounded-3xl shadow-2xl text-center max-w-lg w-full slide-up glow-effect relative my-8">
    
    <!-- Invitation Header -->
    <div class="mb-8">
      <div class="inline-block p-4 rounded-full bg-white bg-opacity-20 mb-4 pulse-animation">
         <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 20" xmlns="http://www.w3.org/2000/svg">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8m0 8H3a2 2 0 01-2-2V6a2 2 0 012-2h18a2 2 0 012 2v8a2 2 0 01-2 2z" />
    </svg>
      </div>
      <h1 class="text-4xl font-bold text-white mb-2 tracking-tight">You're Invited!</h1>
      <div class="w-24 h-1 bg-white bg-opacity-50 mx-auto rounded-full"></div>
    </div>

    <!-- Event Details -->
    <div class="bg-white bg-opacity-15 rounded-2xl p-6 mb-8 backdrop-blur-sm">
      <h2 class="text-2xl font-bold text-black mb-3">{{ ucwords($event->event_name) }}</h2>
      
     <div class="space-y-4 text-black">
        <div class="flex items-center justify-center space-x-3">
          <svg class="w-5 h-5 text-black text-opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
          </svg>
          <span class="font-medium">{{ Carbon::parse($event->event_date)->format('F d, Y') }}</span>
        </div>
        
       <div class="flex items-center justify-center space-x-3  text-black">
          <svg class="w-5 h-5  text-black text-opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
          <span class="font-medium">{{ Carbon::parse($event->start_time)->format('g:i A') }}</span>
        </div>
        
        <div class="flex items-center justify-center space-x-3  text-black">
          <svg class="w-5 h-5  text-black text-opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
          </svg>
          @if($event->venue && $event->venue->latitude && $event->venue->longitude)
            <a href="https://www.google.com/maps/dir/?api=1&destination={{ $event->venue->latitude }},{{ $event->venue->longitude }}" 
               target="_blank" 
               class="font-medium hover:text-blue-600 hover:underline transition-colors duration-200 cursor-pointer"
               title="Get directions to {{ ucwords($event->venue_name) }}">
              {{ ucwords($event->venue_name) }}
              <svg class="w-4 h-4 inline ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
              </svg>
            </a>
          @else
            <span class="font-medium">{{ ucwords($event->venue_name) }}</span>
          @endif
        </div>
      </div>
    </div>

    <!-- QR Code Section -->
  <div class="mb-8">
  <div class="qr-container inline-block">
    <div class="qr-wrapper" style="width: 150px; height: 150px; overflow: hidden;">
  {!! $qrCode !!}
</div>
  </div>
</div>

      <p class="text-white text-opacity-90 mt-4 font-medium">
        Show this QR code at the event entrance
      </p>
    </div>

    <!-- Call to Action Button -->
     <a href="{{ route('user.dashboard') }}" class="btn-hover bg-white text-purple-700 font-bold py-4 px-8 rounded-full shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 text-lg mt-8 inline-block">
  Back to Dashboard
</a>

    <!-- Decorative Corner Elements -->
    <div class="absolute top-4 left-4 w-8 h-8 border-l-2 border-t-2 border-white border-opacity-30 rounded-tl-lg"></div>
    <div class="absolute top-4 right-4 w-8 h-8 border-r-2 border-t-2 border-white border-opacity-30 rounded-tr-lg"></div>
    <div class="absolute bottom-4 left-4 w-8 h-8 border-l-2 border-b-2 border-white border-opacity-30 rounded-bl-lg"></div>
    <div class="absolute bottom-4 right-4 w-8 h-8 border-r-2 border-b-2 border-white border-opacity-30 rounded-br-lg"></div>
  </div>
  </div>

  <script>
    // Add interactive hover effects
    document.addEventListener('DOMContentLoaded', function() {
      const card = document.querySelector('.glass-effect');
      
      card.addEventListener('mouseenter', function() {
        this.style.transform = 'translateY(-5px) scale(1.02)';
      });
      
      card.addEventListener('mouseleave', function() {
        this.style.transform = 'translateY(0) scale(1)';
      });
      
      // Add click ripple effect to button
      const button = document.querySelector('.btn-hover');
      button.addEventListener('click', function(e) {
        const ripple = document.createElement('span');
        const rect = this.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = e.clientX - rect.left - size / 2;
        const y = e.clientY - rect.top - size / 2;
        
        ripple.style.width = ripple.style.height = size + 'px';
        ripple.style.left = x + 'px';
        ripple.style.top = y + 'px';
        ripple.classList.add('ripple-effect');
        
        this.appendChild(ripple);
        
        setTimeout(() => {
          ripple.remove();
        }, 600);
      });
    });
  </script>

  <style>
    .ripple-effect {
      position: absolute;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.3);
      transform: scale(0);
      animation: ripple 0.6s linear;
      pointer-events: none;
    }
    
    @keyframes ripple {
      to {
        transform: scale(4);
        opacity: 0;
      }
    }
  </style>

</body>
</html>
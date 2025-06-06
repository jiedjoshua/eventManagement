<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invitation Declined</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        
        * {
            font-family: 'Inter', sans-serif;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #1e3a8a 0%, #7c3aed 50%, #be185d 100%);
            background-size: 400% 400%;
            animation: gradientShift 10s ease infinite;
        }
        
        @keyframes gradientShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        }
        
        .decline-animation {
            animation: declineEntry 1.2s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        
        @keyframes declineEntry {
            0% {
                opacity: 0;
                transform: scale(0.5) rotate(-10deg);
            }
            50% {
                transform: scale(1.05) rotate(2deg);
            }
            100% {
                opacity: 1;
                transform: scale(1) rotate(0deg);
            }
        }
        
        .floating {
            animation: float 4s ease-in-out infinite alternate;
        }
        
        @keyframes float {
            0% { transform: translateY(0px); }
            100% { transform: translateY(-15px); }
        }
        
        .pulse-glow {
            animation: pulseGlow 3s ease-in-out infinite;
        }
        
        @keyframes pulseGlow {
            0%, 100% {
                box-shadow: 0 0 20px rgba(239, 68, 68, 0.3);
            }
            50% {
                box-shadow: 0 0 40px rgba(239, 68, 68, 0.6);
            }
        }
        
        .shake-icon {
            animation: shake 0.8s ease-in-out;
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }
        
        .particle {
            position: absolute;
            width: 3px;
            height: 3px;
            background: rgba(255, 255, 255, 0.7);
            border-radius: 50%;
            pointer-events: none;
        }
        
        .particle-1 { top: 15%; left: 20%; animation: twinkle 2.5s infinite; }
        .particle-2 { top: 25%; right: 25%; animation: twinkle 3s infinite 0.5s; }
        .particle-3 { bottom: 35%; left: 15%; animation: twinkle 2.8s infinite 1s; }
        .particle-4 { bottom: 45%; right: 20%; animation: twinkle 2.3s infinite 1.5s; }
        .particle-5 { top: 55%; left: 75%; animation: twinkle 2.7s infinite 2s; }
        .particle-6 { top: 75%; left: 65%; animation: twinkle 2.4s infinite 0.8s; }
        
        @keyframes twinkle {
            0%, 100% { opacity: 0; transform: scale(0); }
            50% { opacity: 1; transform: scale(1); }
        }
        
        .morphing-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 25% 35%, rgba(239, 68, 68, 0.2) 0%, transparent 50%),
                        radial-gradient(circle at 75% 25%, rgba(147, 51, 234, 0.2) 0%, transparent 50%),
                        radial-gradient(circle at 45% 75%, rgba(30, 58, 138, 0.2) 0%, transparent 50%);
            animation: morphBg 8s ease-in-out infinite;
        }
        
        @keyframes morphBg {
            0%, 100% { 
                background: radial-gradient(circle at 25% 35%, rgba(239, 68, 68, 0.2) 0%, transparent 50%),
                           radial-gradient(circle at 75% 25%, rgba(147, 51, 234, 0.2) 0%, transparent 50%),
                           radial-gradient(circle at 45% 75%, rgba(30, 58, 138, 0.2) 0%, transparent 50%);
            }
            50% { 
                background: radial-gradient(circle at 65% 55%, rgba(239, 68, 68, 0.2) 0%, transparent 50%),
                           radial-gradient(circle at 25% 75%, rgba(147, 51, 234, 0.2) 0%, transparent 50%),
                           radial-gradient(circle at 75% 35%, rgba(30, 58, 138, 0.2) 0%, transparent 50%);
            }
        }
        
        .text-glow {
            text-shadow: 0 0 15px rgba(255, 255, 255, 0.5);
        }
        
        .decline-icon {
            position: relative;
        }
        
        .decline-icon::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 120px;
            height: 120px;
            background: rgba(239, 68, 68, 0.1);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            z-index: -1;
            animation: iconPulse 2s ease-in-out infinite;
        }
        
        @keyframes iconPulse {
            0%, 100% { transform: translate(-50%, -50%) scale(1); opacity: 0.3; }
            50% { transform: translate(-50%, -50%) scale(1.1); opacity: 0.6; }
        }
        
        .info-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .hover-lift {
            transition: all 0.3s ease;
        }
        
        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body class="gradient-bg flex items-center justify-center min-h-screen relative overflow-hidden">
    
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
    <div class="absolute top-16 left-16 w-24 h-24 bg-white bg-opacity-5 rounded-full floating blur-sm" style="animation-delay: -1s;"></div>
    <div class="absolute bottom-20 right-20 w-32 h-32 bg-white bg-opacity-10 rounded-full floating blur-sm" style="animation-delay: -3s;"></div>
    <div class="absolute top-1/4 right-16 w-16 h-16 bg-red-500 bg-opacity-20 rounded-full floating blur-sm" style="animation-delay: -2s;"></div>
    
    <div class="glass-card p-12 rounded-3xl max-w-lg w-full text-center decline-animation floating hover-lift relative z-10">
        
        <!-- Decline Icon -->
        <div class="decline-icon mb-8 relative inline-block">
            <div class="bg-red-500 bg-opacity-20 p-6 rounded-full pulse-glow">
                <svg class="w-16 h-16 text-red-400 mx-auto shake-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
        
        <!-- Main Message -->
        <h2 class="text-4xl font-bold text-white mb-4 text-glow">Invitation Declined</h2>
        <div class="w-24 h-1 bg-gradient-to-r from-transparent via-red-400 to-transparent mx-auto mb-8 opacity-60"></div>
        
        <!-- Information Card -->
        <div class="info-card rounded-2xl p-6 mb-8">
            <div class="flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-red-300 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-white font-medium">What happens next?</span>
            </div>
            <p class="text-white text-opacity-80 leading-relaxed">
                Your response has been recorded. If this was a mistake, 
                please contact the event organizer to request a new invitation link.
            </p>
        </div>
        
        <!-- Status Badge -->
        <div class="inline-flex items-center px-6 py-3 rounded-full bg-red-500 bg-opacity-20 border border-red-400 border-opacity-30">
            <div class="w-2 h-2 bg-red-400 rounded-full mr-3 animate-pulse"></div>
            <span class="text-red-200 font-medium">RSVP: Declined</span>
        </div>
        
        <!-- Decorative Corner Elements -->
        <div class="absolute -top-2 -left-2 w-8 h-8 border-l-2 border-t-2 border-red-400 border-opacity-30 rounded-tl-2xl"></div>
        <div class="absolute -top-2 -right-2 w-8 h-8 border-r-2 border-t-2 border-red-400 border-opacity-30 rounded-tr-2xl"></div>
        <div class="absolute -bottom-2 -left-2 w-8 h-8 border-l-2 border-b-2 border-red-400 border-opacity-30 rounded-bl-2xl"></div>
        <div class="absolute -bottom-2 -right-2 w-8 h-8 border-r-2 border-b-2 border-red-400 border-opacity-30 rounded-br-2xl"></div>
    </div>

    <script>
        // Add entrance animation delay
        document.addEventListener('DOMContentLoaded', function() {
            const card = document.querySelector('.glass-card');
            
            // Add subtle hover glow effect
            card.addEventListener('mouseenter', function() {
                this.style.boxShadow = '0 25px 50px rgba(239, 68, 68, 0.1), 0 0 0 1px rgba(255, 255, 255, 0.1)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.boxShadow = '0 25px 50px rgba(0, 0, 0, 0.15)';
            });
        });
        
        // Create floating particles
        function createFloatingParticle() {
            const particle = document.createElement('div');
            particle.className = 'absolute pointer-events-none';
            particle.style.width = '2px';
            particle.style.height = '2px';
            particle.style.background = 'rgba(239, 68, 68, 0.6)';
            particle.style.borderRadius = '50%';
            particle.style.left = Math.random() * 100 + '%';
            particle.style.top = '100%';
            
            const floatUp = particle.animate([
                { transform: 'translateY(0px)', opacity: 0 },
                { transform: 'translateY(-100vh)', opacity: 1 },
                { transform: 'translateY(-120vh)', opacity: 0 }
            ], {
                duration: 8000 + Math.random() * 4000,
                easing: 'linear'
            });
            
            document.body.appendChild(particle);
            
            floatUp.addEventListener('finish', () => {
                particle.remove();
            });
        }
        
        // Generate floating particles periodically
        setInterval(createFloatingParticle, 2000);
        
        // Add random sparkles
        setInterval(() => {
            const sparkle = document.createElement('div');
            sparkle.className = 'absolute pointer-events-none';
            sparkle.style.width = '3px';
            sparkle.style.height = '3px';
            sparkle.style.background = 'white';
            sparkle.style.borderRadius = '50%';
            sparkle.style.left = Math.random() * 100 + '%';
            sparkle.style.top = Math.random() * 100 + '%';
            sparkle.style.animation = 'twinkle 1.5s linear forwards';
            
            document.body.appendChild(sparkle);
            
            setTimeout(() => {
                sparkle.remove();
            }, 1500);
        }, 3500);
    </script>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Contact Us - CrwdCtrl</title>
  
  <!-- Favicon -->
  <link rel="icon" type="image/svg+xml" href="/public/favicon.svg">
  <link rel="icon" type="image/x-icon" href="/public/favicon.ico">
  <link rel="shortcut icon" href="/public/favicon.svg">
  <link rel="apple-touch-icon" href="/public/favicon.svg">
  
  <link href="css/home.css" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="font-sans bg-gray-50">

<!-- Navbar -->
<nav class="bg-white/95 backdrop-blur-md shadow-lg fixed top-0 w-full z-50 py-4">
  <div class="container mx-auto px-4 flex items-center justify-between">
    
    <!-- Left: Logo -->
    <a href="{{ route('home') }}" class="text-2xl font-bold bg-gradient-to-r from-[#EF7C79] to-[#D76C69] bg-clip-text text-transparent">
      CrwdCtrl
    </a>

    <!-- Mobile Menu Button -->
    <button id="menu-btn" class="lg:hidden text-gray-700 focus:outline-none hover:text-[#EF7C79] transition-colors">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
      </svg>
    </button>

    <!-- Desktop Navigation -->
    <div class="hidden lg:flex justify-between items-center w-full ml-12">
      <!-- Center Nav Links -->
      <ul class="flex space-x-8 items-center mx-auto">
        <li><a href="{{ route('home') }}" class="nav-link text-gray-700 hover:text-[#EF7C79] font-medium transition-colors">Home</a></li>
        <li><a href="{{ route('services') }}" class="nav-link text-gray-700 hover:text-[#EF7C79] font-medium transition-colors">Services</a></li>
        <li><a href="{{ route('gallery') }}" class="nav-link text-gray-700 hover:text-[#EF7C79] font-medium transition-colors">Gallery</a></li>
        <li><a href="{{ route('about') }}" class="nav-link text-gray-700 hover:text-[#EF7C79] font-medium transition-colors">About</a></li>
        <li><a href="{{ route('contact') }}" class="nav-link text-[#EF7C79] font-semibold">Contact</a></li>
      </ul>

      <!-- Right Buttons -->
      <div class="flex space-x-4 items-center">
        @auth
          @if(auth()->user()->role === 'super_admin')
            <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-[#EF7C79] px-4 py-2 focus:outline-none font-medium transition-colors">Dashboard</a>
          @elseif(auth()->user()->role === 'event_manager')
            <a href="{{ route('manager.dashboard') }}" class="text-gray-700 hover:text-[#EF7C79] px-4 py-2 focus:outline-none font-medium transition-colors">Dashboard</a>
          @else
            <a href="{{ route('user.dashboard') }}" class="text-gray-700 hover:text-[#EF7C79] px-4 py-2 focus:outline-none font-medium transition-colors">Dashboard</a>
          @endif
        @else
          <form action="{{ route('login') }}" method="GET">
            <button type="submit" class="text-gray-700 hover:text-[#EF7C79] px-4 py-2 focus:outline-none font-medium transition-colors">Login</button>
          </form>
        @endauth
        <a href="{{ route('book-now') }}" class="bg-gradient-to-r from-[#EF7C79] to-[#D76C69] hover:from-[#D76C69] hover:to-[#C55A57] text-white rounded-full px-6 py-3 font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300">
          <i class="fas fa-calendar-plus mr-2"></i>Book Now
        </a>
      </div>
    </div>
  </div>

  <!-- Enhanced Mobile Menu -->
  <div id="mobile-menu" class="lg:hidden hidden bg-white/95 backdrop-blur-md border-t border-gray-200 shadow-lg">
    <div class="px-6 py-4 space-y-3">
      <a href="{{ route('home') }}" class="block py-3 text-gray-700 hover:text-[#EF7C79] font-medium transition-colors border-b border-gray-100">Home</a>
      <a href="{{ route('services') }}" class="block py-3 text-gray-700 hover:text-[#EF7C79] font-medium transition-colors border-b border-gray-100">Services</a>
      <a href="{{ route('gallery') }}" class="block py-3 text-gray-700 hover:text-[#EF7C79] font-medium transition-colors border-b border-gray-100">Gallery</a>
      <a href="{{ route('about') }}" class="block py-3 text-gray-700 hover:text-[#EF7C79] font-medium transition-colors border-b border-gray-100">About</a>
      <a href="{{ route('contact') }}" class="block py-3 text-[#EF7C79] font-semibold border-b border-gray-100">Contact</a>
      <div class="pt-4 space-y-3">
        @auth
          @if(auth()->user()->role === 'super_admin')
            <a href="{{ route('admin.dashboard') }}" class="block py-3 text-gray-700 hover:text-[#EF7C79] font-medium transition-colors">Dashboard</a>
          @elseif(auth()->user()->role === 'event_manager')
            <a href="{{ route('manager.dashboard') }}" class="block py-3 text-gray-700 hover:text-[#EF7C79] font-medium transition-colors">Dashboard</a>
          @else
            <a href="{{ route('user.dashboard') }}" class="block py-3 text-gray-700 hover:text-[#EF7C79] font-medium transition-colors">Dashboard</a>
          @endif
        @else
          <form action="{{ route('login') }}" method="GET">
            <button type="submit" class="w-full text-left py-3 text-gray-700 hover:text-[#EF7C79] font-medium transition-colors">Login</button>
          </form>
        @endauth
        <a href="{{ route('book-now') }}" class="block py-3 text-[#EF7C79] font-semibold hover:text-[#D76C69] transition-colors">
          <i class="fas fa-calendar-plus mr-2"></i>Book Now
        </a>
      </div>
    </div>
  </div>
</nav>

<!-- Hero Section -->
<section class="pt-32 pb-16 md:pb-20 bg-gradient-to-br from-[#EF7C79] via-[#D76C69] to-[#C55B58] text-white min-h-[50vh] flex items-center relative overflow-hidden">
  <!-- Background Pattern -->
  <div class="absolute inset-0 opacity-10">
    <div class="absolute top-10 left-10 w-20 h-20 border-2 border-white rounded-full"></div>
    <div class="absolute top-32 right-20 w-16 h-16 border-2 border-white rounded-full"></div>
    <div class="absolute bottom-20 left-1/4 w-12 h-12 border-2 border-white rounded-full"></div>
    <div class="absolute bottom-32 right-1/3 w-24 h-24 border-2 border-white rounded-full"></div>
  </div>
  
  <div class="container mx-auto px-4 text-center w-full relative z-10">
    <div class="max-w-4xl mx-auto">
      <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4 md:mb-6 leading-tight">
        {{ $contactData['hero']['title'] }}
      </h1>
      <p class="text-lg md:text-xl lg:text-2xl mb-8 md:mb-10 opacity-90 leading-relaxed">
        {{ $contactData['hero']['subtitle'] }}
      </p>
      <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
        <div class="flex items-center space-x-2 bg-white/20 backdrop-blur-sm rounded-full px-6 py-3">
          <i class="fas fa-phone text-lg"></i>
          <span class="font-semibold">{{ $contactData['info']['phone'] }}</span>
        </div>
        <div class="flex items-center space-x-2 bg-white/20 backdrop-blur-sm rounded-full px-6 py-3">
          <i class="fas fa-envelope text-lg"></i>
          <span class="font-semibold">{{ $contactData['info']['email'] }}</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Contact Information Section -->
<section class="py-16 md:py-24">
  <div class="container mx-auto px-4">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 md:gap-20">
      <!-- Contact Info -->
      <div class="space-y-8">
        <div>
          <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-6">{{ $contactData['info']['title'] }}</h2>
          <p class="text-lg text-gray-600 leading-relaxed">
            {{ $contactData['info']['description'] }}
          </p>
        </div>
        
        <div class="space-y-6">
          <!-- Phone -->
          <div class="group flex items-center p-6 bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="w-14 h-14 bg-gradient-to-br from-[#EF7C79] to-[#D76C69] rounded-2xl flex items-center justify-center mr-6 group-hover:scale-110 transition-transform duration-300">
              <i class="fas fa-phone text-white text-xl"></i>
            </div>
            <div>
              <h3 class="font-bold text-gray-800 text-lg mb-1">Phone</h3>
              <p class="text-gray-600 text-lg">{{ $contactData['info']['phone'] }}</p>
            </div>
          </div>
          
          <!-- Email -->
          <div class="group flex items-center p-6 bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="w-14 h-14 bg-gradient-to-br from-[#EF7C79] to-[#D76C69] rounded-2xl flex items-center justify-center mr-6 group-hover:scale-110 transition-transform duration-300">
              <i class="fas fa-envelope text-white text-xl"></i>
            </div>
            <div>
              <h3 class="font-bold text-gray-800 text-lg mb-1">Email</h3>
              <p class="text-gray-600 text-lg">{{ $contactData['info']['email'] }}</p>
            </div>
          </div>
          
          <!-- Address -->
          <div class="group flex items-center p-6 bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="w-14 h-14 bg-gradient-to-br from-[#EF7C79] to-[#D76C69] rounded-2xl flex items-center justify-center mr-6 group-hover:scale-110 transition-transform duration-300">
              <i class="fas fa-map-marker-alt text-white text-xl"></i>
            </div>
            <div>
              <h3 class="font-bold text-gray-800 text-lg mb-1">Address</h3>
              <p class="text-gray-600 text-lg">{{ $contactData['info']['address'] }}</p>
            </div>
          </div>
          
          <!-- Business Hours -->
          <div class="group flex items-center p-6 bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="w-14 h-14 bg-gradient-to-br from-[#EF7C79] to-[#D76C69] rounded-2xl flex items-center justify-center mr-6 group-hover:scale-110 transition-transform duration-300">
              <i class="fas fa-clock text-white text-xl"></i>
            </div>
            <div>
              <h3 class="font-bold text-gray-800 text-lg mb-1">Business Hours</h3>
              @php
                $hours = explode("\n", $contactData['info']['business_hours']);
              @endphp
              @foreach($hours as $hour)
                <p class="text-gray-600 text-lg">{{ $hour }}</p>
              @endforeach
            </div>
          </div>
        </div>
      </div>

      <!-- Contact Form -->
      <div class="bg-white rounded-3xl shadow-2xl p-8 md:p-10 border border-gray-100">
        <div class="text-center mb-8">
          <h3 class="text-2xl md:text-3xl font-bold text-gray-800 mb-3">Send us a Message</h3>
          <p class="text-gray-600">We'd love to hear from you! Fill out the form below and we'll get back to you soon.</p>
        </div>
        
        <form class="space-y-6" id="contactForm">
          @csrf
          
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="group">
              <label for="first_name" class="block text-sm font-semibold text-gray-700 mb-2">First Name</label>
              <input type="text" id="first_name" name="first_name" 
                     class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-[#EF7C79] focus:border-[#EF7C79] transition-all duration-300 text-base group-hover:border-gray-300" 
                     required>
            </div>
            <div class="group">
              <label for="last_name" class="block text-sm font-semibold text-gray-700 mb-2">Last Name</label>
              <input type="text" id="last_name" name="last_name" 
                     class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-[#EF7C79] focus:border-[#EF7C79] transition-all duration-300 text-base group-hover:border-gray-300" 
                     required>
            </div>
          </div>

          <div class="group">
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
            <input type="email" id="email" name="email" 
                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-[#EF7C79] focus:border-[#EF7C79] transition-all duration-300 text-base group-hover:border-gray-300" 
                   required>
          </div>

          <div class="group">
            <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">Phone Number</label>
            <input type="tel" id="phone" name="phone" placeholder="09123456789" pattern="[0-9]{11}" maxlength="11" 
                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-[#EF7C79] focus:border-[#EF7C79] transition-all duration-300 text-base group-hover:border-gray-300" 
                   required>
            <p class="text-xs text-gray-500 mt-2 flex items-center">
              <i class="fas fa-info-circle mr-1"></i>
              Enter exactly 11 digits (e.g., 09123456789)
            </p>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="group">
              <label for="event_type" class="block text-sm font-semibold text-gray-700 mb-2">Event Type</label>
              <select id="event_type" name="event_type" 
                      class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-[#EF7C79] focus:border-[#EF7C79] transition-all duration-300 text-base group-hover:border-gray-300" 
                      required>
                <option value="">Select an event type</option>
                <option value="wedding">Wedding</option>
                <option value="birthday">Birthday</option>
                <option value="debut">Debut</option>
                <option value="baptism">Baptism</option>
                <option value="other">Other</option>
              </select>
            </div>

            <div class="group">
              <label for="event_date" class="block text-sm font-semibold text-gray-700 mb-2">Preferred Event Date</label>
              <input type="date" id="event_date" name="event_date" 
                     class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-[#EF7C79] focus:border-[#EF7C79] transition-all duration-300 text-base group-hover:border-gray-300">
            </div>
          </div>

          <div class="group">
            <label for="message" class="block text-sm font-semibold text-gray-700 mb-2">Message</label>
            <textarea id="message" name="message" rows="5" 
                      class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-[#EF7C79] focus:border-[#EF7C79] transition-all duration-300 text-base group-hover:border-gray-300 resize-none" 
                      placeholder="Tell us about your event vision and requirements..."></textarea>
          </div>

          <button type="submit" 
                  class="w-full bg-gradient-to-r from-[#EF7C79] to-[#D76C69] hover:from-[#D76C69] hover:to-[#C55B58] text-white font-bold py-4 px-8 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 text-lg">
            <i class="fas fa-paper-plane mr-2"></i>
            Send Message
          </button>
        </form>
      </div>

    </div>
  </div>
</section>

<!-- Success Modal -->
<div id="successModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
  <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full transform transition-all duration-300 scale-95 opacity-0" id="successModalContent">
    <div class="p-8 text-center">
      <!-- Success Icon -->
      <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-gradient-to-br from-green-100 to-green-200 mb-6">
        <i class="fas fa-check text-3xl text-green-600"></i>
      </div>
      
      <h3 class="text-2xl font-bold text-gray-900 mb-3">Message Sent Successfully!</h3>
      <p class="text-gray-600 mb-8 leading-relaxed">Thank you for your message! We'll get back to you soon with all the details about your special event.</p>
      
      <button onclick="closeSuccessModal()" 
              class="w-full bg-gradient-to-r from-[#EF7C79] to-[#D76C69] hover:from-[#D76C69] hover:to-[#C55B58] text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 transform hover:-translate-y-0.5">
        <i class="fas fa-check mr-2"></i>
        Close
      </button>
    </div>
  </div>
</div>

<!-- Error Modal -->
<div id="errorModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
  <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full transform transition-all duration-300 scale-95 opacity-0" id="errorModalContent">
    <div class="p-8 text-center">
      <!-- Error Icon -->
      <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-gradient-to-br from-red-100 to-red-200 mb-6">
        <i class="fas fa-exclamation-triangle text-3xl text-red-600"></i>
      </div>
      
      <h3 class="text-2xl font-bold text-gray-900 mb-3">Oops! Something went wrong</h3>
      <p class="text-gray-600 mb-8 leading-relaxed">Sorry, there was an error sending your message. Please try again or contact us directly.</p>
      
      <div class="space-y-3">
        <button onclick="closeErrorModal()" 
                class="w-full bg-gradient-to-r from-[#EF7C79] to-[#D76C69] hover:from-[#D76C69] hover:to-[#C55B58] text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 transform hover:-translate-y-0.5">
          <i class="fas fa-redo mr-2"></i>
          Try Again
        </button>
        <button onclick="closeErrorModal()" 
                class="w-full bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-6 rounded-xl transition-all duration-300 transform hover:-translate-y-0.5">
          <i class="fas fa-times mr-2"></i>
          Close
        </button>
      </div>
    </div>
  </div>
</div>

<!-- FAQ Section -->
<section class="py-16 md:py-24 bg-gradient-to-br from-gray-50 to-gray-100">
  <div class="container mx-auto px-4">
    <div class="text-center mb-12 md:mb-16">
      <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">{{ $contactData['faq']['title'] }}</h2>
      <p class="text-lg text-gray-600 max-w-2xl mx-auto">Find answers to commonly asked questions about our event management services</p>
    </div>
    
    <div class="max-w-4xl mx-auto space-y-6">
      @foreach($contactData['faq']['faqs'] as $index => $faq)
        <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-100">
          <div class="flex items-start">
            <div class="w-8 h-8 bg-gradient-to-br from-[#EF7C79] to-[#D76C69] rounded-full flex items-center justify-center mr-4 mt-1 flex-shrink-0">
              <span class="text-white font-bold text-sm">{{ $index + 1 }}</span>
            </div>
            <div>
              <h3 class="text-lg md:text-xl font-bold text-gray-800 mb-3">{{ $faq['question'] }}</h3>
              <p class="text-gray-600 leading-relaxed">
                {{ $faq['answer'] }}
              </p>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>

<!-- Call to Action Section -->
<section class="py-16 md:py-24 bg-gradient-to-br from-[#EF7C79] via-[#D76C69] to-[#C55B58] text-white relative overflow-hidden">
  <!-- Background Pattern -->
  <div class="absolute inset-0 opacity-10">
    <div class="absolute top-10 right-10 w-32 h-32 border-2 border-white rounded-full"></div>
    <div class="absolute bottom-20 left-10 w-24 h-24 border-2 border-white rounded-full"></div>
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-40 h-40 border-2 border-white rounded-full"></div>
  </div>
  
  <div class="container mx-auto px-4 text-center relative z-10">
    <div class="max-w-3xl mx-auto">
      <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-6">{{ $contactData['cta']['title'] }}</h2>
      <p class="text-lg md:text-xl mb-8 md:mb-10 opacity-90 leading-relaxed">{{ $contactData['cta']['subtitle'] }}</p>
      <a href="{{ $contactData['cta']['button_link'] }}" 
         class="inline-flex items-center bg-white text-[#EF7C79] hover:bg-gray-100 rounded-full px-8 py-4 font-bold text-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
        <i class="fas fa-calendar-plus mr-3"></i>
        {{ $contactData['cta']['button_text'] }}
      </a>
    </div>
  </div>
</section>

<!-- Footer -->
<footer class="bg-white text-center py-8 border-t border-gray-200">
  <div class="container mx-auto px-4">
    <p class="text-gray-600">&copy; 2025 CrwdCtrl. All rights reserved.</p>
  </div>
</footer>

<script>
  // Mobile menu toggle
  document.getElementById('menu-btn').addEventListener('click', function() {
    const mobileMenu = document.getElementById('mobile-menu');
    mobileMenu.classList.toggle('hidden');
  });
  
  // Close mobile menu when clicking outside
  document.addEventListener('click', function(event) {
    const mobileMenu = document.getElementById('mobile-menu');
    const menuBtn = document.getElementById('menu-btn');
    if (!mobileMenu.contains(event.target) && !menuBtn.contains(event.target)) {
      mobileMenu.classList.add('hidden');
    }
  });

  // Modal functions
  function showSuccessModal() {
    const modal = document.getElementById('successModal');
    const content = document.getElementById('successModalContent');
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    
    // Trigger animation
    setTimeout(() => {
      content.classList.remove('scale-95', 'opacity-0');
      content.classList.add('scale-100', 'opacity-100');
    }, 10);
  }

  function showErrorModal() {
    const modal = document.getElementById('errorModal');
    const content = document.getElementById('errorModalContent');
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    
    // Trigger animation
    setTimeout(() => {
      content.classList.remove('scale-95', 'opacity-0');
      content.classList.add('scale-100', 'opacity-100');
    }, 10);
  }

  function closeSuccessModal() {
    const modal = document.getElementById('successModal');
    const content = document.getElementById('successModalContent');
    
    content.classList.remove('scale-100', 'opacity-100');
    content.classList.add('scale-95', 'opacity-0');
    
    setTimeout(() => {
      modal.classList.add('hidden');
      modal.classList.remove('flex');
    }, 300);
  }

  function closeErrorModal() {
    const modal = document.getElementById('errorModal');
    const content = document.getElementById('errorModalContent');
    
    content.classList.remove('scale-100', 'opacity-100');
    content.classList.add('scale-95', 'opacity-0');
    
    setTimeout(() => {
      modal.classList.add('hidden');
      modal.classList.remove('flex');
    }, 300);
  }

  // Close modals when clicking outside
  document.getElementById('successModal').addEventListener('click', function(e) {
    if (e.target === this) {
      closeSuccessModal();
    }
  });

  document.getElementById('errorModal').addEventListener('click', function(e) {
    if (e.target === this) {
      closeErrorModal();
    }
  });

  // Contact form enhancement
  document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('contactForm');
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalBtnText = submitBtn.innerHTML;

    // Set minimum date for event date field
    const eventDateInput = document.getElementById('event_date');
    if (eventDateInput) {
      const today = new Date().toISOString().split('T')[0];
      eventDateInput.setAttribute('min', today);
    }

    // Add floating label effect
    const inputs = form.querySelectorAll('input, textarea, select');
    inputs.forEach(input => {
      input.addEventListener('focus', function() {
        this.parentElement.classList.add('focused');
      });
      
      input.addEventListener('blur', function() {
        if (!this.value) {
          this.parentElement.classList.remove('focused');
        }
      });
    });

    form.addEventListener('submit', function(e) {
      e.preventDefault();

      // Basic client-side validation
      const requiredFields = form.querySelectorAll('[required]');
      let isValid = true;

      requiredFields.forEach(field => {
        if (!field.value.trim()) {
          isValid = false;
          field.classList.add('border-red-500', 'focus:border-red-500');
        } else {
          field.classList.remove('border-red-500', 'focus:border-red-500');
        }
      });

      // Email validation
      const emailField = form.querySelector('input[type="email"]');
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (emailField && !emailRegex.test(emailField.value)) {
        isValid = false;
        emailField.classList.add('border-red-500', 'focus:border-red-500');
      }

      // Phone validation
      const phoneField = form.querySelector('input[name="phone"]');
      const phoneRegex = /^[0-9]{11}$/;
      if (phoneField && !phoneRegex.test(phoneField.value)) {
        isValid = false;
        phoneField.classList.add('border-red-500', 'focus:border-red-500');
      }

      if (!isValid) {
        showErrorModal();
        return;
      }

      // Show loading state
      submitBtn.disabled = true;
      submitBtn.innerHTML = `
        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        Sending...
      `;

      // Simulate form submission delay
      setTimeout(() => {
        // Always show success for simulation
        showSuccessModal();
        form.reset();
        
        // Reset button state
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalBtnText;
      }, 2000); // 2 second delay to simulate processing
    });
  });

  // Add scroll animations
  const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
  };

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('animate-fade-in');
      }
    });
  }, observerOptions);

  // Observe elements for animation
  document.addEventListener('DOMContentLoaded', function() {
    const animateElements = document.querySelectorAll('.group, .bg-white.rounded-2xl');
    animateElements.forEach(el => {
      observer.observe(el);
    });
  });
</script>

<style>
  .animate-fade-in {
    animation: fadeInUp 0.6s ease-out forwards;
  }

  @keyframes fadeInUp {
    from {
      opacity: 0;
      transform: translateY(30px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  /* Remove underline animation from navbar */
  .nav-link::after {
    display: none !important;
  }
</style>

</body>
</html> 
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Contact Us - CrwdCtrl Event Management</title>
  <link href="css/home.css" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans">

<!-- Navbar -->
<nav class="bg-white shadow-sm fixed top-0 w-full z-50 py-4 lg:py-6">
  <div class="container mx-auto px-4 flex items-center justify-between">
    <!-- Left: Logo -->
    <a href="{{ route('home') }}" class="text-lg lg:text-xl font-bold">CrwdCtrl</a>
    <!-- Mobile Menu Button -->
    <button id="menu-btn" class="lg:hidden text-gray-700 focus:outline-none">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
      </svg>
    </button>
    <!-- Desktop Navigation -->
    <div class="hidden lg:flex justify-between items-center w-full ml-12">
      <ul class="flex space-x-6 items-center mx-auto">
        <li><a href="{{ route('home') }}" class="nav-link text-gray-700 hover:text-[#EF7C79]">Home</a></li>
        <li><a href="{{ route('services') }}" class="nav-link text-gray-700 hover:text-[#EF7C79]">Services</a></li>
        <li><a href="{{ route('gallery') }}" class="nav-link text-gray-700 hover:text-[#EF7C79]">Gallery</a></li>
        <li><a href="{{ route('about') }}" class="nav-link text-gray-700 hover:text-[#EF7C79]">About</a></li>
        <li><a href="{{ route('contact') }}" class="nav-link text-[#EF7C79] font-semibold">Contact</a></li>
      </ul>
      <div class="flex space-x-3 items-center">
        @auth
          @if(auth()->user()->role === 'super_admin')
            <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-[#EF7C79] px-4 py-2 focus:outline-none">Dashboard</a>
          @elseif(auth()->user()->role === 'event_manager')
            <a href="{{ route('manager.dashboard') }}" class="text-gray-700 hover:text-[#EF7C79] px-4 py-2 focus:outline-none">Dashboard</a>
          @else
            <a href="{{ route('user.dashboard') }}" class="text-gray-700 hover:text-[#EF7C79] px-4 py-2 focus:outline-none">Dashboard</a>
          @endif
        @else
          <form action="{{ route('login') }}" method="GET">
            <button type="submit" class="text-gray-700 hover:text-[#EF7C79] px-4 py-2 focus:outline-none">Login</button>
          </form>
        @endauth
        <a href="{{ route('book-now') }}" class="bg-[#EF7C79] hover:bg-[#D76C69] text-white rounded-full px-4 py-2">Book Now</a>
      </div>
    </div>
  </div>
  <!-- Mobile Menu -->
  <div id="mobile-menu" class="lg:hidden hidden bg-white border-t">
    <div class="px-4 py-2 space-y-1">
      <a href="{{ route('home') }}" class="block py-2 text-gray-700 hover:text-[#EF7C79]">Home</a>
      <a href="{{ route('services') }}" class="block py-2 text-gray-700 hover:text-[#EF7C79]">Services</a>
      <a href="{{ route('gallery') }}" class="block py-2 text-gray-700 hover:text-[#EF7C79]">Gallery</a>
      <a href="{{ route('about') }}" class="block py-2 text-gray-700 hover:text-[#EF7C79]">About</a>
      <a href="{{ route('contact') }}" class="block py-2 text-[#EF7C79] font-semibold">Contact</a>
      <div class="border-t pt-2 mt-2">
        @auth
          @if(auth()->user()->role === 'super_admin')
            <a href="{{ route('admin.dashboard') }}" class="block py-2 text-gray-700 hover:text-[#EF7C79]">Dashboard</a>
          @elseif(auth()->user()->role === 'event_manager')
            <a href="{{ route('manager.dashboard') }}" class="block py-2 text-gray-700 hover:text-[#EF7C79]">Dashboard</a>
          @else
            <a href="{{ route('user.dashboard') }}" class="block py-2 text-gray-700 hover:text-[#EF7C79]">Dashboard</a>
          @endif
        @else
          <form action="{{ route('login') }}" method="GET">
            <button type="submit" class="w-full text-left py-2 text-gray-700 hover:text-[#EF7C79]">Login</button>
          </form>
        @endauth
        <a href="{{ route('book-now') }}" class="block py-2 text-[#EF7C79] font-semibold">Book Now</a>
      </div>
    </div>
  </div>
</nav>

<!-- Hero Section -->
<section class="pt-32 pb-10 md:pb-16 bg-gradient-to-r from-[#EF7C79] to-[#D76C69] text-white min-h-[40vh] flex items-center">
  <div class="container mx-auto px-4 text-center w-full">
    <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-3 md:mb-4">{{ $contactData['hero']['title'] }}</h1>
    <p class="text-base md:text-xl mb-6 md:mb-8">{{ $contactData['hero']['subtitle'] }}</p>
  </div>
</section>

<!-- Contact Information Section -->
<section class="py-10 md:py-20">
  <div class="container mx-auto px-4">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 md:gap-16">
      <!-- Contact Info -->
      <div>
        <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6 md:mb-8">{{ $contactData['info']['title'] }}</h2>
        <p class="text-base md:text-lg text-gray-600 mb-6 md:mb-8">
          {{ $contactData['info']['description'] }}
        </p>
        <div class="space-y-4 md:space-y-6">
          <!-- Phone -->
          <div class="flex items-center">
            <div class="w-10 h-10 md:w-12 md:h-12 bg-[#EF7C79] rounded-full flex items-center justify-center mr-3 md:mr-4">
              <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
              </svg>
            </div>
            <div>
              <h3 class="font-semibold text-gray-800 text-sm md:text-base">Phone</h3>
              <p class="text-gray-600 text-sm md:text-base">{{ $contactData['info']['phone'] }}</p>
            </div>
          </div>
          <!-- Email -->
          <div class="flex items-center">
            <div class="w-10 h-10 md:w-12 md:h-12 bg-[#EF7C79] rounded-full flex items-center justify-center mr-3 md:mr-4">
              <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
              </svg>
            </div>
            <div>
              <h3 class="font-semibold text-gray-800 text-sm md:text-base">Email</h3>
              <p class="text-gray-600 text-sm md:text-base">{{ $contactData['info']['email'] }}</p>
            </div>
          </div>
          <!-- Address -->
          <div class="flex items-center">
            <div class="w-10 h-10 md:w-12 md:h-12 bg-[#EF7C79] rounded-full flex items-center justify-center mr-3 md:mr-4">
              <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
              </svg>
            </div>
            <div>
              <h3 class="font-semibold text-gray-800 text-sm md:text-base">Address</h3>
              <p class="text-gray-600 text-sm md:text-base">{{ $contactData['info']['address'] }}</p>
            </div>
          </div>
          <!-- Business Hours -->
          <div class="flex items-center">
            <div class="w-10 h-10 md:w-12 md:h-12 bg-[#EF7C79] rounded-full flex items-center justify-center mr-3 md:mr-4">
              <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </div>
            <div>
              <h3 class="font-semibold text-gray-800 text-sm md:text-base">Business Hours</h3>
              @php
                $hours = explode("\n", $contactData['info']['business_hours']);
              @endphp
              @foreach($hours as $hour)
                <p class="text-gray-600 text-sm md:text-base">{{ $hour }}</p>
              @endforeach
            </div>
          </div>
        </div>
      </div>

      <!-- Contact Form -->
      <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8">
        <h3 class="text-xl md:text-2xl font-bold text-gray-800 mb-4 md:mb-6">Send us a Message</h3>
        
        <form class="space-y-4 md:space-y-6" id="contactForm">
          @csrf
          
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
            <div>
              <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
              <input type="text" id="first_name" name="first_name" class="w-full px-3 md:px-4 py-2 md:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#EF7C79] focus:border-transparent text-sm md:text-base" required>
            </div>
            <div>
              <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
              <input type="text" id="last_name" name="last_name" class="w-full px-3 md:px-4 py-2 md:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#EF7C79] focus:border-transparent text-sm md:text-base" required>
            </div>
          </div>

          <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
            <input type="email" id="email" name="email" class="w-full px-3 md:px-4 py-2 md:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#EF7C79] focus:border-transparent text-sm md:text-base" required>
          </div>

          <div>
            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
            <input type="tel" id="phone" name="phone" placeholder="09123456789" pattern="[0-9]{11}" maxlength="11" class="w-full px-3 md:px-4 py-2 md:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#EF7C79] focus:border-transparent text-sm md:text-base" required>
            <p class="text-xs text-gray-500 mt-1">Enter exactly 11 digits (e.g., 09123456789)</p>
          </div>

          <div>
            <label for="event_type" class="block text-sm font-medium text-gray-700 mb-2">Event Type</label>
            <select id="event_type" name="event_type" class="w-full px-3 md:px-4 py-2 md:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#EF7C79] focus:border-transparent text-sm md:text-base" required>
              <option value="">Select an event type</option>
              <option value="wedding">Wedding</option>
              <option value="birthday">Birthday</option>
              <option value="debut">Debut</option>
              <option value="baptism">Baptism</option>
              <option value="other">Other</option>
            </select>
          </div>

          <div>
            <label for="event_date" class="block text-sm font-medium text-gray-700 mb-2">Preferred Event Date</label>
            <input type="date" id="event_date" name="event_date" class="w-full px-3 md:px-4 py-2 md:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#EF7C79] focus:border-transparent text-sm md:text-base">
          </div>

          <div>
            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message</label>
            <textarea id="message" name="message" rows="4" class="w-full px-3 md:px-4 py-2 md:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#EF7C79] focus:border-transparent text-sm md:text-base" placeholder="Tell us about your event vision and requirements..."></textarea>
          </div>

          <button type="submit" class="w-full bg-[#EF7C79] hover:bg-[#D76C69] text-white font-semibold py-3 px-6 rounded-lg transition duration-300">
            Send Message
          </button>
        </form>
      </div>

    </div>
  </div>
</section>

<!-- Success Modal -->
<div id="successModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
  <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full transform transition-all duration-300 scale-95 opacity-0" id="successModalContent">
    <div class="p-6 text-center">
      <!-- Success Icon -->
      <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-4">
        <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
      </div>
      
      <h3 class="text-xl font-bold text-gray-900 mb-2">Message Sent Successfully!</h3>
      <p class="text-gray-600 mb-6">Thank you for your message! We'll get back to you soon.</p>
      
      <button onclick="closeSuccessModal()" class="w-full bg-[#EF7C79] hover:bg-[#D76C69] text-white font-semibold py-3 px-6 rounded-lg transition duration-300">
        Close
      </button>
    </div>
  </div>
</div>

<!-- Error Modal -->
<div id="errorModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
  <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full transform transition-all duration-300 scale-95 opacity-0" id="errorModalContent">
    <div class="p-6 text-center">
      <!-- Error Icon -->
      <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-4">
        <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
      </div>
      
      <h3 class="text-xl font-bold text-gray-900 mb-2">Oops! Something went wrong</h3>
      <p class="text-gray-600 mb-6">Sorry, there was an error sending your message. Please try again or contact us directly.</p>
      
      <div class="space-y-3">
        <button onclick="closeErrorModal()" class="w-full bg-[#EF7C79] hover:bg-[#D76C69] text-white font-semibold py-3 px-6 rounded-lg transition duration-300">
          Try Again
        </button>
        <button onclick="closeErrorModal()" class="w-full bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-3 px-6 rounded-lg transition duration-300">
          Close
        </button>
      </div>
    </div>
  </div>
</div>

<!-- FAQ Section -->
<section class="py-10 md:py-20 bg-gray-50">
  <div class="container mx-auto px-4">
    <h2 class="text-2xl md:text-3xl font-bold text-center mb-8 md:mb-12">{{ $contactData['faq']['title'] }}</h2>
    <div class="max-w-3xl mx-auto space-y-4 md:space-y-6">
      @foreach($contactData['faq']['faqs'] as $faq)
        <div class="bg-white rounded-lg shadow-md p-4 md:p-6">
          <h3 class="text-base md:text-lg font-semibold text-gray-800 mb-2 md:mb-3">{{ $faq['question'] }}</h3>
          <p class="text-gray-600 text-sm md:text-base">
            {{ $faq['answer'] }}
          </p>
        </div>
      @endforeach
    </div>
  </div>
</section>

<!-- Call to Action Section -->
<section class="py-10 md:py-20 bg-[#EF7C79] text-white">
  <div class="container mx-auto px-4 text-center">
    <h2 class="text-2xl md:text-3xl font-bold mb-3 md:mb-4">{{ $contactData['cta']['title'] }}</h2>
    <p class="text-base md:text-xl mb-6 md:mb-8">{{ $contactData['cta']['subtitle'] }}</p>
    <a href="{{ $contactData['cta']['button_link'] }}" class="bg-white text-[#EF7C79] hover:bg-gray-100 rounded-full px-6 md:px-8 py-2 md:py-3 font-semibold transition duration-300">{{ $contactData['cta']['button_text'] }}</a>
  </div>
</section>

<!-- Footer -->
<footer class="bg-white text-center py-4 md:py-6 border-t">
  <p class="text-xs md:text-sm text-gray-600">&copy; 2025 CrwdCtrl. All rights reserved.</p>
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
    const originalBtnText = submitBtn.textContent;

    // Set minimum date for event date field
    const eventDateInput = document.getElementById('event_date');
    if (eventDateInput) {
      const today = new Date().toISOString().split('T')[0];
      eventDateInput.setAttribute('min', today);
    }

    form.addEventListener('submit', function(e) {
      e.preventDefault();

      // Basic client-side validation
      const requiredFields = form.querySelectorAll('[required]');
      let isValid = true;

      requiredFields.forEach(field => {
        if (!field.value.trim()) {
          isValid = false;
          field.classList.add('border-red-500');
        } else {
          field.classList.remove('border-red-500');
        }
      });

      // Email validation
      const emailField = form.querySelector('input[type="email"]');
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (emailField && !emailRegex.test(emailField.value)) {
        isValid = false;
        emailField.classList.add('border-red-500');
      }

      // Phone validation
      const phoneField = form.querySelector('input[name="phone"]');
      const phoneRegex = /^[0-9]{11}$/;
      if (phoneField && !phoneRegex.test(phoneField.value)) {
        isValid = false;
        phoneField.classList.add('border-red-500');
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
</script>

</body>
</html> 
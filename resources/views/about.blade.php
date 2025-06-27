<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>About Us - CrwdCtrl Event Management</title>
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
        <li><a href="{{ route('about') }}" class="nav-link text-[#EF7C79] font-semibold">About</a></li>
        <li><a href="{{ route('contact') }}" class="nav-link text-gray-700 hover:text-[#EF7C79]">Contact</a></li>
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
      <a href="{{ route('about') }}" class="block py-2 text-[#EF7C79] font-semibold">About</a>
      <a href="{{ route('contact') }}" class="block py-2 text-gray-700 hover:text-[#EF7C79]">Contact</a>
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
<section class="pt-32 pb-10 md:pb-16 bg-gradient-to-r from-[#EF7C79] to-[#D76C69] text-white">
  <div class="container mx-auto px-4 text-center">
    <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-3 md:mb-4">About CrwdCtrl</h1>
    <p class="text-base md:text-xl mb-6 md:mb-8">Creating unforgettable moments, one event at a time</p>
  </div>
</section>

<!-- Our Story Section -->
<section class="py-10 md:py-20">
  <div class="container mx-auto px-4">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 md:gap-16 items-center">
      <div>
        <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4 md:mb-6">Our Story</h2>
        <p class="text-base md:text-lg text-gray-600 mb-4 md:mb-6">
          Founded with a passion for creating extraordinary experiences, CrwdCtrl began as a small team of event enthusiasts who believed that every celebration deserves to be perfect. What started as a dream to make events more memorable has grown into a trusted name in event management across Bataan and beyond.
        </p>
        <p class="text-base md:text-lg text-gray-600 mb-4 md:mb-6">
          Over the years, we've had the privilege of being part of countless special moments - from intimate family gatherings to grand celebrations. Each event has taught us something new, and every client has become part of our extended family.
        </p>
        <p class="text-base md:text-lg text-gray-600">
          Today, we continue to innovate and push the boundaries of what's possible in event planning, always keeping our core values of creativity, reliability, and personal touch at the heart of everything we do.
        </p>
      </div>
      <div class="relative mt-8 lg:mt-0">
        <img src="{{ asset('public/img/wedding.webp') }}" alt="Our Story" class="w-full h-64 md:h-96 object-cover rounded-2xl shadow-lg">
        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent rounded-2xl"></div>
      </div>
    </div>
  </div>
</section>

<!-- Mission & Vision Section -->
<section class="py-10 md:py-20 bg-gray-50">
  <div class="container mx-auto px-4">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12">
      <!-- Mission -->
      <div class="bg-white rounded-2xl p-6 md:p-8 shadow-lg mb-6 md:mb-0">
        <div class="w-14 h-14 md:w-16 md:h-16 bg-[#EF7C79] rounded-full flex items-center justify-center mb-4 md:mb-6">
          <svg class="w-7 h-7 md:w-8 md:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
          </svg>
        </div>
        <h3 class="text-lg md:text-2xl font-bold text-gray-800 mb-2 md:mb-4">Our Mission</h3>
        <p class="text-gray-600 text-sm md:text-base">
          To transform ordinary moments into extraordinary memories by providing innovative, personalized, and seamless event planning services that exceed expectations and create lasting impressions for our clients and their guests.
        </p>
      </div>
      <!-- Vision -->
      <div class="bg-white rounded-2xl p-6 md:p-8 shadow-lg">
        <div class="w-14 h-14 md:w-16 md:h-16 bg-[#EF7C79] rounded-full flex items-center justify-center mb-4 md:mb-6">
          <svg class="w-7 h-7 md:w-8 md:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
          </svg>
        </div>
        <h3 class="text-lg md:text-2xl font-bold text-gray-800 mb-2 md:mb-4">Our Vision</h3>
        <p class="text-gray-600 text-sm md:text-base">
          To be the leading event management company in the region, known for our creativity, reliability, and commitment to excellence. We aspire to set new standards in the industry while building lasting relationships with our clients and partners.
        </p>
      </div>
    </div>
  </div>
</section>

<!-- Values Section -->
<section class="py-10 md:py-20">
  <div class="container mx-auto px-4">
    <h2 class="text-2xl md:text-3xl font-bold text-center mb-8 md:mb-12">Our Core Values</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">
      <div class="text-center">
        <div class="w-14 h-14 md:w-16 md:h-16 bg-[#EF7C79] rounded-full flex items-center justify-center mx-auto mb-3 md:mb-4">
          <svg class="w-7 h-7 md:w-8 md:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
          </svg>
        </div>
        <h3 class="text-base md:text-lg font-bold text-gray-800 mb-1 md:mb-2">Passion</h3>
        <p class="text-gray-600 text-sm md:text-base">We pour our hearts into every event, treating each celebration as if it were our own.</p>
      </div>

      <div class="text-center">
        <div class="w-14 h-14 md:w-16 md:h-16 bg-[#EF7C79] rounded-full flex items-center justify-center mx-auto mb-3 md:mb-4">
          <svg class="w-7 h-7 md:w-8 md:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
        </div>
        <h3 class="text-base md:text-lg font-bold text-gray-800 mb-1 md:mb-2">Excellence</h3>
        <p class="text-gray-600 text-sm md:text-base">We strive for perfection in every detail, ensuring flawless execution of your vision.</p>
      </div>

      <div class="text-center">
        <div class="w-14 h-14 md:w-16 md:h-16 bg-[#EF7C79] rounded-full flex items-center justify-center mx-auto mb-3 md:mb-4">
          <svg class="w-7 h-7 md:w-8 md:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
          </svg>
        </div>
        <h3 class="text-base md:text-lg font-bold text-gray-800 mb-1 md:mb-2">Trust</h3>
        <p class="text-gray-600 text-sm md:text-base">We build lasting relationships based on transparency, honesty, and mutual respect.</p>
      </div>

      <div class="text-center">
        <div class="w-14 h-14 md:w-16 md:h-16 bg-[#EF7C79] rounded-full flex items-center justify-center mx-auto mb-3 md:mb-4">
          <svg class="w-7 h-7 md:w-8 md:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
          </svg>
        </div>
        <h3 class="text-base md:text-lg font-bold text-gray-800 mb-1 md:mb-2">Innovation</h3>
        <p class="text-gray-600 text-sm md:text-base">We embrace new ideas and technologies to create unique and memorable experiences.</p>
      </div>

    </div>
  </div>
</section>

<!-- Stats Section -->
<section class="py-10 md:py-20 bg-gray-50">
  <div class="container mx-auto px-4">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-8 text-center">
      <div>
        <div class="text-2xl md:text-4xl font-bold text-[#EF7C79] mb-1 md:mb-2">500+</div>
        <p class="text-xs md:text-base text-gray-600">Events Successfully Planned</p>
      </div>
      <div>
        <div class="text-2xl md:text-4xl font-bold text-[#EF7C79] mb-1 md:mb-2">5+</div>
        <p class="text-xs md:text-base text-gray-600">Years of Experience</p>
      </div>
      <div>
        <div class="text-2xl md:text-4xl font-bold text-[#EF7C79] mb-1 md:mb-2">98%</div>
        <p class="text-xs md:text-base text-gray-600">Client Satisfaction Rate</p>
      </div>
      <div>
        <div class="text-2xl md:text-4xl font-bold text-[#EF7C79] mb-1 md:mb-2">50+</div>
        <p class="text-xs md:text-base text-gray-600">Venue Partnerships</p>
      </div>
    </div>
  </div>
</section>

<!-- Call to Action Section -->
<section class="py-10 md:py-20 bg-[#EF7C79] text-white">
  <div class="container mx-auto px-4 text-center">
    <h2 class="text-2xl md:text-3xl font-bold mb-3 md:mb-4">Ready to Create Something Amazing?</h2>
    <p class="text-base md:text-xl mb-6 md:mb-8">Let's work together to make your next event unforgettable</p>
    <div class="flex flex-col sm:flex-row gap-3 md:gap-4 justify-center">
      <a href="{{ route('book-now') }}" class="bg-white text-[#EF7C79] hover:bg-gray-100 rounded-full px-6 md:px-8 py-2 md:py-3 font-semibold transition duration-300">Start Planning</a>
      <a href="{{ route('home') }}#contact" class="border-2 border-white text-white hover:bg-white hover:text-[#EF7C79] rounded-full px-6 md:px-8 py-2 md:py-3 font-semibold transition duration-300">Get in Touch</a>
    </div>
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
</script>

</body>
</html> 
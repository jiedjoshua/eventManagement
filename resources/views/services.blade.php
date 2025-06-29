<?php
use App\Models\HomePageContent;
$content = HomePageContent::getAllActive();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Our Services - CrwdCtrl Event Management</title>
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
      <!-- Center Nav Links -->
      <ul class="flex space-x-6 items-center mx-auto">
        <li><a href="{{ route('home') }}" class="nav-link text-gray-700 hover:text-[#EF7C79]">Home</a></li>
        <li><a href="{{ route('services') }}" class="nav-link text-[#EF7C79] font-semibold">Services</a></li>
        <li><a href="{{ route('gallery') }}" class="nav-link text-gray-700 hover:text-[#EF7C79]">Gallery</a></li>
        <li><a href="{{ route('about') }}" class="nav-link text-gray-700 hover:text-[#EF7C79]">About</a></li>
        <li><a href="{{ route('contact') }}" class="nav-link text-gray-700 hover:text-[#EF7C79]">Contact</a></li>
      </ul>

      <!-- Right Buttons -->
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
      <a href="{{ route('services') }}" class="block py-2 text-[#EF7C79] font-semibold">Services</a>
      <a href="{{ route('gallery') }}" class="block py-2 text-gray-700 hover:text-[#EF7C79]">Gallery</a>
      <a href="{{ route('about') }}" class="block py-2 text-gray-700 hover:text-[#EF7C79]">About</a>
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
@if($content['services_hero']->is_active ?? false)
<section class="pt-32 pb-16 bg-gradient-to-r from-[#EF7C79] to-[#D76C69] text-white">
  <div class="container mx-auto px-4 text-center">
    <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-4">{{ $content['services_hero']->title ?? 'Our Event Services' }}</h1>
    <p class="text-base md:text-xl mb-8">{{ $content['services_hero']->subtitle ?? 'Comprehensive event planning and management for every special occasion' }}</p>
    <a href="{{ $content['services_hero']->button_link ?? route('book-now') }}" class="bg-white text-[#EF7C79] hover:bg-gray-100 rounded-full px-8 py-3 font-semibold transition duration-300">{{ $content['services_hero']->button_text ?? 'Start Planning Your Event' }}</a>
  </div>
</section>
@endif

<!-- Main Services Section -->
@if($content['services_page_services']->is_active ?? false)
<section class="py-10 md:py-20">
  <div class="container mx-auto px-4">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-16">
      
      @if($content['services_page_services']->service_cards ?? false)
        @foreach($content['services_page_services']->service_cards as $service)
          <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            @if(isset($service['image_path']))
              <img src="{{ asset($service['image_path']) }}" alt="{{ $service['title'] }}" class="w-full h-48 md:h-64 object-cover">
            @else
              <div class="w-full h-48 md:h-64 bg-gray-200 flex items-center justify-center">
                <span class="text-gray-500">No Image</span>
              </div>
            @endif
            <div class="p-5 md:p-8">
              <h3 class="text-xl md:text-2xl font-bold text-gray-800 mb-3 md:mb-4">{{ $service['title'] }}</h3>
              <p class="text-gray-600 mb-4 md:mb-6 text-sm md:text-base">{{ $service['description'] }}</p>
              
              <div class="space-y-2 md:space-y-3 mb-4 md:mb-6">
                @if(isset($service['features']))
                  @foreach($service['features'] as $feature)
                    <div class="flex items-center text-sm md:text-base">
                      <svg class="w-5 h-5 text-[#EF7C79] mr-2 md:mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                      </svg>
                      <span class="text-gray-700">{{ $feature }}</span>
                    </div>
                  @endforeach
                @endif
              </div>
              
              <a href="{{ route('book-now') }}" class="inline-block bg-[#EF7C79] hover:bg-[#D76C69] text-white px-6 py-3 rounded-lg font-semibold transition duration-300">Plan Your {{ ucfirst($service['type']) }}</a>
              <a href="{{ route('packages', ['type' => $service['type']]) }}" class="inline-block mt-2 bg-white text-[#EF7C79] border border-[#EF7C79] hover:bg-[#EF7C79] hover:text-white px-6 py-2 rounded-lg font-semibold transition duration-300">View Packages</a>
            </div>
          </div>
        @endforeach
      @else
        <!-- Fallback content if no CMS data -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
          <img src="{{ asset('public/img/wedding.webp') }}" alt="Wedding Planning" class="w-full h-48 md:h-64 object-cover">
          <div class="p-5 md:p-8">
            <h3 class="text-xl md:text-2xl font-bold text-gray-800 mb-3 md:mb-4">Wedding Planning</h3>
            <p class="text-gray-600 mb-4 md:mb-6 text-sm md:text-base">Create the wedding of your dreams with our comprehensive planning services. From intimate ceremonies to grand celebrations, we handle every detail.</p>
            
            <div class="space-y-2 md:space-y-3 mb-4 md:mb-6">
              <div class="flex items-center text-sm md:text-base">
                <svg class="w-5 h-5 text-[#EF7C79] mr-2 md:mr-3" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-gray-700">Venue selection and coordination</span>
              </div>
              <div class="flex items-center text-sm md:text-base">
                <svg class="w-5 h-5 text-[#EF7C79] mr-2 md:mr-3" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-gray-700">Catering and menu planning</span>
              </div>
              <div class="flex items-center text-sm md:text-base">
                <svg class="w-5 h-5 text-[#EF7C79] mr-2 md:mr-3" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-gray-700">Decoration and floral arrangements</span>
              </div>
              <div class="flex items-center text-sm md:text-base">
                <svg class="w-5 h-5 text-[#EF7C79] mr-2 md:mr-3" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-gray-700">Photography and videography</span>
              </div>
              <div class="flex items-center text-sm md:text-base">
                <svg class="w-5 h-5 text-[#EF7C79] mr-2 md:mr-3" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-gray-700">Guest list management</span>
              </div>
            </div>
            
            <a href="{{ route('book-now') }}" class="inline-block bg-[#EF7C79] hover:bg-[#D76C69] text-white px-6 py-3 rounded-lg font-semibold transition duration-300">Plan Your Wedding</a>
            <a href="{{ route('packages', ['type' => 'wedding']) }}" class="inline-block mt-2 bg-white text-[#EF7C79] border border-[#EF7C79] hover:bg-[#EF7C79] hover:text-white px-6 py-2 rounded-lg font-semibold transition duration-300">View Packages</a>
          </div>
        </div>
      @endif

    </div>
  </div>
</section>
@endif

<!-- Coming Soon Section -->
@if($content['services_coming_soon']->is_active ?? false)
<section class="py-10 md:py-20 bg-gray-50">
  <div class="container mx-auto px-4">
    <div class="text-center">
      <h2 class="text-2xl md:text-3xl font-bold mb-6 md:mb-8">{{ $content['services_coming_soon']->title ?? 'More Services Coming Soon' }}</h2>
      <p class="text-base md:text-xl text-gray-600 mb-6 md:mb-8">{{ $content['services_coming_soon']->subtitle ?? 'We\'re constantly expanding our service offerings to better serve your event planning needs.' }}</p>
      
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8 max-w-4xl mx-auto">
        <!-- Corporate Events -->
        <div class="bg-white rounded-xl shadow-md p-6 md:p-8 text-center opacity-60">
          <div class="w-14 h-14 md:w-16 md:h-16 bg-gray-400 rounded-full flex items-center justify-center mx-auto mb-3 md:mb-4">
            <svg class="w-7 h-7 md:w-8 md:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
            </svg>
          </div>
          <h3 class="text-lg md:text-xl font-bold text-gray-800 mb-2 md:mb-3">Corporate Events</h3>
          <p class="text-gray-600 mb-2 md:mb-4 text-sm md:text-base">Professional event planning for conferences, seminars, team building, and corporate celebrations.</p>
          <span class="text-gray-400 font-semibold">Coming Soon</span>
        </div>

        <!-- Anniversary Celebrations -->
        <div class="bg-white rounded-xl shadow-md p-8 text-center opacity-60">
          <div class="w-16 h-16 bg-gray-400 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
            </svg>
          </div>
          <h3 class="text-xl font-bold text-gray-800 mb-3">Anniversary Celebrations</h3>
          <p class="text-gray-600 mb-4">Romantic and meaningful anniversary celebrations to commemorate your special milestones together.</p>
          <span class="text-gray-400 font-semibold">Coming Soon</span>
        </div>

        <!-- Custom Events -->
        <div class="bg-white rounded-xl shadow-md p-8 text-center opacity-60">
          <div class="w-16 h-16 bg-gray-400 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path>
            </svg>
          </div>
          <h3 class="text-xl font-bold text-gray-800 mb-3">Custom Events</h3>
          <p class="text-gray-600 mb-4">Unique and personalized events tailored to your specific vision and requirements.</p>
          <span class="text-gray-400 font-semibold">Coming Soon</span>
        </div>

      </div>
      
      <div class="mt-12">
        <p class="text-gray-600 mb-6">Stay tuned for updates on our expanded service offerings!</p>
        <a href="{{ route('contact') }}" class="inline-block bg-[#EF7C79] hover:bg-[#D76C69] text-white px-6 py-3 rounded-lg font-semibold transition duration-300">Contact Us for Updates</a>
      </div>
    </div>
  </div>
</section>
@endif

<!-- Why Choose Us Section -->
@if($content['services_why_choose']->is_active ?? false)
<section class="py-10 md:py-20">
  <div class="container mx-auto px-4">
    <h2 class="text-2xl md:text-3xl font-bold text-center mb-8 md:mb-12">{{ $content['services_why_choose']->title ?? 'Why Choose CrwdCtrl?' }}</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 md:gap-8">
      <div class="text-center">
        <div class="w-14 h-14 md:w-16 md:h-16 bg-[#EF7C79] rounded-full flex items-center justify-center mx-auto mb-3 md:mb-4">
          <svg class="w-7 h-7 md:w-8 md:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
        </div>
        <h3 class="text-base md:text-lg font-bold text-gray-800 mb-1 md:mb-2">Experience</h3>
        <p class="text-gray-600 text-sm md:text-base">Years of experience in creating memorable events</p>
      </div>

      <div class="text-center">
        <div class="w-16 h-16 bg-[#EF7C79] rounded-full flex items-center justify-center mx-auto mb-4">
          <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
          </svg>
        </div>
        <h3 class="text-lg font-bold text-gray-800 mb-2">Personalized</h3>
        <p class="text-gray-600">Tailored to your unique vision and preferences</p>
      </div>

      <div class="text-center">
        <div class="w-16 h-16 bg-[#EF7C79] rounded-full flex items-center justify-center mx-auto mb-4">
          <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
          </svg>
        </div>
        <h3 class="text-lg font-bold text-gray-800 mb-2">Affordable</h3>
        <p class="text-gray-600">Competitive pricing with transparent packages</p>
      </div>

      <div class="text-center">
        <div class="w-16 h-16 bg-[#EF7C79] rounded-full flex items-center justify-center mx-auto mb-4">
          <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
          </svg>
        </div>
        <h3 class="text-lg font-bold text-gray-800 mb-2">Reliable</h3>
        <p class="text-gray-600">Dedicated support throughout your event journey</p>
      </div>

      <div class="text-center">
        <div class="w-16 h-16 bg-[#EF7C79] rounded-full flex items-center justify-center mx-auto mb-4">
          <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V6a1 1 0 00-1-1H5a1 1 0 00-1 1v1a1 1 0 001 1zm12 0h2a1 1 0 001-1V6a1 1 0 00-1-1h-2a1 1 0 00-1 1v1a1 1 0 001 1zM5 20h2a1 1 0 001-1v-1a1 1 0 00-1-1H5a1 1 0 00-1 1v1a1 1 0 001 1z"></path>
          </svg>
        </div>
        <h3 class="text-lg font-bold text-gray-800 mb-2">QR Check-in</h3>
        <p class="text-gray-600">Modern QR-based guest check-in system</p>
      </div>

    </div>
  </div>
</section>
@endif

<!-- CTA Section -->
@if($content['services_cta']->is_active ?? false)
<section class="py-10 md:py-20 bg-[#EF7C79] text-white">
  <div class="container mx-auto px-4 text-center">
    <h2 class="text-2xl md:text-3xl font-bold mb-3 md:mb-4">{{ $content['services_cta']->title ?? 'Ready to Start Planning?' }}</h2>
    <p class="text-base md:text-xl mb-6 md:mb-8">{{ $content['services_cta']->subtitle ?? 'Let\'s create something extraordinary together' }}</p>
    <div class="flex flex-col sm:flex-row gap-3 md:gap-4 justify-center">
      <a href="{{ $content['services_cta']->button_link ?? route('book-now') }}" class="bg-white text-[#EF7C79] hover:bg-gray-100 rounded-full px-6 md:px-8 py-2 md:py-3 font-semibold transition duration-300">{{ $content['services_cta']->button_text ?? 'Book Your Event' }}</a>
      <a href="{{ $content['services_cta']->service_cards['secondary_button_link'] ?? route('home') . '#contact' }}" class="border-2 border-white text-white hover:bg-white hover:text-[#EF7C79] rounded-full px-6 md:px-8 py-2 md:py-3 font-semibold transition duration-300">{{ $content['services_cta']->service_cards['secondary_button_text'] ?? 'Contact Us' }}</a>
    </div>
  </div>
</section>
@endif

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
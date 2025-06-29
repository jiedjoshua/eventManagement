<?php
// Get CMS data for about page
$aboutHero = \App\Models\HomePageContent::where('section', 'about_hero')->first();
$aboutStory = \App\Models\HomePageContent::where('section', 'about_story')->first();
$aboutMissionVision = \App\Models\HomePageContent::where('section', 'about_mission_vision')->first();
$aboutValues = \App\Models\HomePageContent::where('section', 'about_values')->first();
$aboutStats = \App\Models\HomePageContent::where('section', 'about_stats')->first();
$aboutCTA = \App\Models\HomePageContent::where('section', 'about_cta')->first();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>About Us - CrwdCtrl Event Management</title>
  <link href="{{ asset('css/home.css') }}" rel="stylesheet">
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
@if($aboutHero && $aboutHero->is_active)
<section class="pt-32 pb-10 md:pb-16 bg-gradient-to-r from-[#EF7C79] to-[#D76C69] text-white min-h-[40vh] flex items-center">
  <div class="container mx-auto px-4 text-center w-full">
    <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-3 md:mb-4">{{ $aboutHero->title }}</h1>
    <p class="text-base md:text-xl mb-6 md:mb-8">{{ $aboutHero->subtitle }}</p>
  </div>
</section>
@endif

<!-- Our Story Section -->
@if($aboutStory && $aboutStory->is_active)
<section class="py-10 md:py-20">
  <div class="container mx-auto px-4">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 md:gap-16 items-center">
      <div>
        <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4 md:mb-6">{{ $aboutStory->title }}</h2>
        <div class="text-base md:text-lg text-gray-600 space-y-4 md:mb-6">
          {!! nl2br(e($aboutStory->description)) !!}
        </div>
      </div>
      <div class="relative mt-8 lg:mt-0">
        @if($aboutStory->image_path)
          <img src="/public{{ str_replace('/public', '', $aboutStory->image_path) }}" alt="Our Story" class="w-full h-64 md:h-96 object-cover rounded-2xl shadow-lg">
        @else
          <div class="w-full h-64 md:h-96 bg-gray-200 flex items-center justify-center rounded-2xl shadow-lg">
            <span class="text-gray-500 text-lg font-medium">No Image</span>
          </div>
        @endif
        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent rounded-2xl"></div>
      </div>
    </div>
  </div>
</section>
@endif

<!-- Mission & Vision Section -->
@if($aboutMissionVision && $aboutMissionVision->is_active)
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
        <h3 class="text-lg md:text-2xl font-bold text-gray-800 mb-2 md:mb-4">{{ $aboutMissionVision->service_cards['mission_title'] ?? 'Our Mission' }}</h3>
        <p class="text-gray-600 text-sm md:text-base">
          {{ $aboutMissionVision->service_cards['mission_content'] ?? 'To transform ordinary moments into extraordinary memories by providing innovative, personalized, and seamless event planning services that exceed expectations and create lasting impressions for our clients and their guests.' }}
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
        <h3 class="text-lg md:text-2xl font-bold text-gray-800 mb-2 md:mb-4">{{ $aboutMissionVision->service_cards['vision_title'] ?? 'Our Vision' }}</h3>
        <p class="text-gray-600 text-sm md:text-base">
          {{ $aboutMissionVision->service_cards['vision_content'] ?? 'To be the leading event management company in the region, known for our creativity, reliability, and commitment to excellence. We aspire to set new standards in the industry while building lasting relationships with our clients and partners.' }}
        </p>
      </div>
    </div>
  </div>
</section>
@endif

<!-- Values Section -->
@if($aboutValues && $aboutValues->is_active)
<section class="py-10 md:py-20">
  <div class="container mx-auto px-4">
    <h2 class="text-2xl md:text-3xl font-bold text-center mb-8 md:mb-12">{{ $aboutValues->title }}</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">
      @foreach($aboutValues->service_cards as $value)
      <div class="text-center">
        <div class="w-14 h-14 md:w-16 md:h-16 bg-[#EF7C79] rounded-full flex items-center justify-center mx-auto mb-3 md:mb-4">
          <svg class="w-7 h-7 md:w-8 md:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
          </svg>
        </div>
          <h3 class="text-base md:text-lg font-bold text-gray-800 mb-1 md:mb-2">{{ $value['title'] }}</h3>
          <p class="text-gray-600 text-sm md:text-base">{{ $value['description'] }}</p>
        </div>
      @endforeach
    </div>
  </div>
</section>
@endif

<!-- Stats Section -->
@if($aboutStats && $aboutStats->is_active)
<section class="py-10 md:py-20 bg-gray-50">
  <div class="container mx-auto px-4">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-8 text-center">
      @foreach($aboutStats->service_cards as $stat)
      <div>
          <div class="text-2xl md:text-4xl font-bold text-[#EF7C79] mb-1 md:mb-2">{{ $stat['number'] }}</div>
          <p class="text-xs md:text-base text-gray-600">{{ $stat['label'] }}</p>
      </div>
      @endforeach
    </div>
  </div>
</section>
@endif

<!-- Call to Action Section -->
@if($aboutCTA && $aboutCTA->is_active)
<section class="py-10 md:py-20 bg-[#EF7C79] text-white">
  <div class="container mx-auto px-4 text-center">
    <h2 class="text-2xl md:text-3xl font-bold mb-3 md:mb-4">{{ $aboutCTA->title }}</h2>
    <p class="text-base md:text-xl mb-6 md:mb-8">{{ $aboutCTA->subtitle }}</p>
    <div class="flex flex-col sm:flex-row gap-3 md:gap-4 justify-center">
      <a href="{{ $aboutCTA->button_link }}" class="bg-white text-[#EF7C79] hover:bg-gray-100 rounded-full px-6 md:px-8 py-2 md:py-3 font-semibold transition duration-300">{{ $aboutCTA->button_text }}</a>
      <a href="{{ $aboutCTA->service_cards['secondary_button_link'] ?? route('home') . '#contact' }}" class="border-2 border-white text-white hover:bg-white hover:text-[#EF7C79] rounded-full px-6 md:px-8 py-2 md:py-3 font-semibold transition duration-300">{{ $aboutCTA->service_cards['secondary_button_text'] ?? 'Get in Touch' }}</a>
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
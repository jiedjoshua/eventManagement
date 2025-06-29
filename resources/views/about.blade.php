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
  <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
  <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
  <link href="{{ asset('css/home.css') }}" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <style>
    /* Remove underline animation */
    .nav-link::after {
      display: none !important;
    }

    .story-card {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      cursor: pointer;
    }

    .story-card:hover {
      transform: scale(1.02);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
      z-index: 10;
    }

    .mission-vision-card {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      cursor: pointer;
    }

    .mission-vision-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
      z-index: 10;
    }

    .value-card {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      cursor: pointer;
    }

    .value-card:hover {
      transform: scale(1.05);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
      z-index: 10;
    }

    .stat-card {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      cursor: pointer;
    }

    .stat-card:hover {
      transform: scale(1.05);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
      z-index: 10;
    }
  </style>
</head>
<body class="font-sans bg-gray-50">

<!-- Enhanced Navbar -->
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
        <li><a href="{{ route('about') }}" class="nav-link text-[#EF7C79] font-semibold">About</a></li>
        <li><a href="{{ route('contact') }}" class="nav-link text-gray-700 hover:text-[#EF7C79] font-medium transition-colors">Contact</a></li>
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
      <a href="{{ route('about') }}" class="block py-3 text-[#EF7C79] font-semibold border-b border-gray-100">About</a>
      <a href="{{ route('contact') }}" class="block py-3 text-gray-700 hover:text-[#EF7C79] font-medium transition-colors border-b border-gray-100">Contact</a>
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

<!-- Enhanced Hero Section -->
@if($aboutHero && $aboutHero->is_active)
<section class="pt-32 pb-20 bg-gradient-to-br from-[#EF7C79] via-[#D76C69] to-[#C55A57] text-white relative overflow-hidden">
  <div class="absolute inset-0 bg-black/10"></div>
  <div class="absolute top-0 left-0 w-full h-full">
    <div class="absolute top-10 left-10 w-20 h-20 bg-white/10 rounded-full"></div>
    <div class="absolute top-20 right-20 w-32 h-32 bg-white/5 rounded-full"></div>
    <div class="absolute bottom-10 left-1/4 w-16 h-16 bg-white/10 rounded-full"></div>
  </div>
  <div class="container mx-auto px-4 text-center relative z-10">
    <div class="max-w-4xl mx-auto">
      <div class="mb-8">
        <div class="inline-flex items-center space-x-2 bg-white/20 backdrop-blur-sm rounded-full px-6 py-3 mb-6">
          <i class="fas fa-heart text-yellow-300"></i>
          <span class="font-medium">Our Story</span>
        </div>
      </div>
      <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight">
        {{ $aboutHero->title }}
      </h1>
      <p class="text-xl md:text-2xl mb-8 text-white/90 leading-relaxed max-w-3xl mx-auto">
        {{ $aboutHero->subtitle }}
      </p>
    </div>
  </div>
</section>
@endif

<!-- Enhanced Our Story Section -->
@if($aboutStory && $aboutStory->is_active)
<section class="py-20 md:py-28 bg-gradient-to-b from-gray-50 to-white">
  <div class="container mx-auto px-4">
    <div class="text-center mb-16">
      <div class="inline-flex items-center space-x-2 bg-white/80 backdrop-blur-sm rounded-full px-6 py-3 shadow-lg mb-6">
        <i class="fas fa-book-open text-[#EF7C79]"></i>
        <span class="font-semibold text-gray-700">Our Journey</span>
      </div>
      <h2 class="text-4xl md:text-5xl font-bold mb-6 text-gray-900">Our Story</h2>
      <p class="text-xl text-gray-600 max-w-3xl mx-auto">Discover the passion and dedication behind our commitment to creating extraordinary events.</p>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
      <div class="story-card bg-white rounded-3xl p-8 shadow-xl border border-gray-100">
        <h3 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6">{{ $aboutStory->title }}</h3>
        <div class="text-lg text-gray-600 space-y-4 leading-relaxed">
          {!! nl2br(e($aboutStory->description)) !!}
        </div>
      </div>
      <div class="relative mt-8 lg:mt-0">
        @if($aboutStory->image_path)
          <div class="story-card relative overflow-hidden rounded-3xl shadow-xl">
            <img src="/public{{ str_replace('/public', '', $aboutStory->image_path) }}" alt="Our Story" class="w-full h-80 md:h-96 object-cover transition-transform duration-500 hover:scale-110">
            <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
          </div>
        @else
          <div class="story-card w-full h-80 md:h-96 bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center rounded-3xl shadow-xl">
            <i class="fas fa-image text-gray-400 text-6xl"></i>
          </div>
        @endif
      </div>
    </div>
  </div>
</section>
@endif

<!-- Enhanced Mission & Vision Section -->
@if($aboutMissionVision && $aboutMissionVision->is_active)
<section class="py-20 md:py-28 bg-gradient-to-br from-gray-50 to-gray-100">
  <div class="container mx-auto px-4">
    <div class="text-center mb-16">
      <div class="inline-flex items-center space-x-2 bg-white/80 backdrop-blur-sm rounded-full px-6 py-3 shadow-lg mb-6">
        <i class="fas fa-compass text-[#EF7C79]"></i>
        <span class="font-semibold text-gray-700">Mission & Vision</span>
      </div>
      <h2 class="text-4xl md:text-5xl font-bold mb-6 text-gray-900">Our Purpose</h2>
      <p class="text-xl text-gray-600 max-w-3xl mx-auto">Guided by our mission and vision, we strive to create exceptional experiences that leave lasting impressions.</p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12">
      <!-- Mission -->
      <div class="mission-vision-card bg-white rounded-3xl p-8 shadow-xl border border-gray-100">
        <div class="w-20 h-20 bg-gradient-to-br from-[#EF7C79] to-[#D76C69] rounded-2xl flex items-center justify-center mb-6 shadow-lg">
          <i class="fas fa-bolt text-white text-2xl"></i>
        </div>
        <h3 class="text-2xl font-bold text-gray-900 mb-4">{{ $aboutMissionVision->service_cards['mission_title'] ?? 'Our Mission' }}</h3>
        <p class="text-gray-600 text-lg leading-relaxed">
          {{ $aboutMissionVision->service_cards['mission_content'] ?? 'To transform ordinary moments into extraordinary memories by providing innovative, personalized, and seamless event planning services that exceed expectations and create lasting impressions for our clients and their guests.' }}
        </p>
      </div>
      <!-- Vision -->
      <div class="mission-vision-card bg-white rounded-3xl p-8 shadow-xl border border-gray-100">
        <div class="w-20 h-20 bg-gradient-to-br from-[#EF7C79] to-[#D76C69] rounded-2xl flex items-center justify-center mb-6 shadow-lg">
          <i class="fas fa-eye text-white text-2xl"></i>
        </div>
        <h3 class="text-2xl font-bold text-gray-900 mb-4">{{ $aboutMissionVision->service_cards['vision_title'] ?? 'Our Vision' }}</h3>
        <p class="text-gray-600 text-lg leading-relaxed">
          {{ $aboutMissionVision->service_cards['vision_content'] ?? 'To be the leading event management company in the region, known for our creativity, reliability, and commitment to excellence. We aspire to set new standards in the industry while building lasting relationships with our clients and partners.' }}
        </p>
      </div>
    </div>
  </div>
</section>
@endif

<!-- Enhanced Values Section -->
@if($aboutValues && $aboutValues->is_active)
<section class="py-20 md:py-28 bg-white">
  <div class="container mx-auto px-4">
    <div class="text-center mb-16">
      <div class="inline-flex items-center space-x-2 bg-gray-100 rounded-full px-6 py-3 mb-6">
        <i class="fas fa-star text-[#EF7C79]"></i>
        <span class="font-semibold text-gray-700">Our Values</span>
      </div>
      <h2 class="text-4xl md:text-5xl font-bold mb-6 text-gray-900">{{ $aboutValues->title }}</h2>
      <p class="text-xl text-gray-600 max-w-3xl mx-auto">The core principles that guide everything we do and every event we create.</p>
    </div>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
      @foreach($aboutValues->service_cards as $value)
      <div class="value-card text-center bg-white rounded-2xl p-8 shadow-lg border border-gray-100">
        <div class="w-20 h-20 bg-gradient-to-br from-[#EF7C79] to-[#D76C69] rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg">
          <i class="fas fa-heart text-white text-2xl"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-4">{{ $value['title'] }}</h3>
        <p class="text-gray-600 leading-relaxed">{{ $value['description'] }}</p>
      </div>
      @endforeach
    </div>
  </div>
</section>
@endif

<!-- Enhanced Stats Section -->
@if($aboutStats && $aboutStats->is_active)
<section class="py-20 md:py-28 bg-gradient-to-br from-[#EF7C79] via-[#D76C69] to-[#C55A57] text-white relative overflow-hidden">
  <div class="absolute inset-0 bg-black/10"></div>
  <div class="absolute top-0 left-0 w-full h-full">
    <div class="absolute top-10 left-10 w-20 h-20 bg-white/10 rounded-full"></div>
    <div class="absolute top-20 right-20 w-32 h-32 bg-white/5 rounded-full"></div>
    <div class="absolute bottom-10 left-1/4 w-16 h-16 bg-white/10 rounded-full"></div>
  </div>
  <div class="container mx-auto px-4 relative z-10">
    <div class="text-center mb-16">
      <div class="inline-flex items-center space-x-2 bg-white/20 backdrop-blur-sm rounded-full px-6 py-3 mb-6">
        <i class="fas fa-chart-line text-yellow-300"></i>
        <span class="font-medium">Our Achievements</span>
      </div>
      <h2 class="text-4xl md:text-5xl font-bold mb-6">By The Numbers</h2>
      <p class="text-xl text-white/90 max-w-3xl mx-auto">The milestones and achievements that reflect our commitment to excellence.</p>
    </div>
    
    <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
      @foreach($aboutStats->service_cards as $stat)
      <div class="stat-card bg-white/10 backdrop-blur-sm rounded-2xl p-8 border border-white/20">
        <div class="text-4xl md:text-5xl font-bold text-white mb-3">{{ $stat['number'] }}</div>
        <p class="text-lg text-white/90 font-medium">{{ $stat['label'] }}</p>
      </div>
      @endforeach
    </div>
  </div>
</section>
@endif

<!-- Enhanced Call to Action Section -->
@if($aboutCTA && $aboutCTA->is_active)
<section class="py-20 md:py-28 bg-gradient-to-br from-gray-50 to-white">
  <div class="container mx-auto px-4 text-center">
    <div class="max-w-4xl mx-auto">
      <div class="mb-8">
        <div class="inline-flex items-center space-x-2 bg-white/80 backdrop-blur-sm rounded-full px-6 py-3 shadow-lg mb-6">
          <i class="fas fa-handshake text-[#EF7C79]"></i>
          <span class="font-semibold text-gray-700">Let's Connect</span>
        </div>
      </div>
      <h2 class="text-4xl md:text-5xl font-bold mb-6 text-gray-900">{{ $aboutCTA->title }}</h2>
      <p class="text-xl md:text-2xl mb-8 text-gray-600">{{ $aboutCTA->subtitle }}</p>
      <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a href="{{ $aboutCTA->button_link }}" class="bg-gradient-to-r from-[#EF7C79] to-[#D76C69] hover:from-[#D76C69] hover:to-[#C55A57] text-white rounded-full px-8 py-4 text-lg font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
          <i class="fas fa-calendar-check mr-3"></i>{{ $aboutCTA->button_text }}
        </a>
        <a href="{{ $aboutCTA->service_cards['secondary_button_link'] ?? route('home') . '#contact' }}" class="bg-white text-[#EF7C79] border-2 border-[#EF7C79] hover:bg-[#EF7C79] hover:text-white rounded-full px-8 py-4 text-lg font-semibold transition-all duration-300">
          <i class="fas fa-envelope mr-3"></i>{{ $aboutCTA->service_cards['secondary_button_text'] ?? 'Get in Touch' }}
        </a>
      </div>
    </div>
  </div>
</section>
@endif

<!-- Enhanced Footer -->
<footer class="bg-white text-center py-12 border-t border-gray-200">
  <div class="container mx-auto px-4">
    <div class="flex items-center justify-center space-x-2 mb-6">
      <div class="w-10 h-10 bg-gradient-to-r from-[#EF7C79] to-[#D76C69] rounded-xl flex items-center justify-center">
        <span class="text-white font-bold text-lg">C</span>
      </div>
      <span class="text-2xl font-bold text-gray-900">CrwdCtrl</span>
    </div>
    <p class="text-gray-600 mb-4">Creating unforgettable moments, one event at a time.</p>
    <p class="text-sm text-gray-500">&copy; 2025 CrwdCtrl. All rights reserved.</p>
  </div>
</footer>

<script>
  // Enhanced mobile menu toggle
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

  // Smooth scroll for anchor links
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      e.preventDefault();
      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
        target.scrollIntoView({
          behavior: 'smooth',
          block: 'start'
        });
      }
    });
  });
</script>

</body>
</html> 
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
  <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
  <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
  <link href="css/home.css" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <style>
    /* Match home page animations */
    .nav-link {
      position: relative;
      transition: color 0.3s;
    }

    /* Remove underline animation */
    .nav-link::after {
      display: none !important;
    }

    .service-card {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      cursor: pointer;
    }

    .service-card:hover {
      transform: scale(1.05);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
      z-index: 10;
    }

    .feature-card {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      cursor: pointer;
    }

    .feature-card:hover {
      transform: scale(1.05);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
      z-index: 10;
    }

    .coming-soon-card {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      cursor: pointer;
    }

    .coming-soon-card:hover {
      transform: scale(1.05);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
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
        <li><a href="{{ route('home') }}" class="nav-link text-gray-700 hover:text-[#EF7C79] font-medium">Home</a></li>
        <li><a href="{{ route('services') }}" class="nav-link text-[#EF7C79] font-semibold">Services</a></li>
        <li><a href="{{ route('gallery') }}" class="nav-link text-gray-700 hover:text-[#EF7C79] font-medium">Gallery</a></li>
        <li><a href="{{ route('about') }}" class="nav-link text-gray-700 hover:text-[#EF7C79] font-medium">About</a></li>
        <li><a href="{{ route('contact') }}" class="nav-link text-gray-700 hover:text-[#EF7C79] font-medium">Contact</a></li>
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
      <a href="{{ route('services') }}" class="block py-3 text-[#EF7C79] font-semibold border-b border-gray-100">Services</a>
      <a href="{{ route('gallery') }}" class="block py-3 text-gray-700 hover:text-[#EF7C79] font-medium transition-colors border-b border-gray-100">Gallery</a>
      <a href="{{ route('about') }}" class="block py-3 text-gray-700 hover:text-[#EF7C79] font-medium transition-colors border-b border-gray-100">About</a>
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
@if($content['services_hero']->is_active ?? false)
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
          <i class="fas fa-star text-yellow-300"></i>
          <span class="font-medium">Professional Event Services</span>
        </div>
      </div>
      <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight">
        {{ $content['services_hero']->title ?? 'Our Event Services' }}
      </h1>
      <p class="text-xl md:text-2xl mb-8 text-white/90 leading-relaxed max-w-3xl mx-auto">
        {{ $content['services_hero']->subtitle ?? 'Comprehensive event planning and management for every special occasion' }}
      </p>
      <a href="{{ $content['services_hero']->button_link ?? route('book-now') }}" class="bg-white text-[#EF7C79] hover:bg-gray-100 rounded-full px-8 py-4 text-lg font-semibold shadow-2xl hover:shadow-3xl transform hover:-translate-y-1 transition-all duration-300">
        <i class="fas fa-calendar-check mr-3"></i>{{ $content['services_hero']->button_text ?? 'Start Planning Your Event' }}
      </a>
    </div>
  </div>
</section>
@endif

<!-- Enhanced Main Services Section -->
@if($content['services_page_services']->is_active ?? false)
<section class="py-20 md:py-28 bg-gradient-to-b from-gray-50 to-white">
  <div class="container mx-auto px-4">
    <div class="text-center mb-16">
      <div class="inline-flex items-center space-x-2 bg-white/80 backdrop-blur-sm rounded-full px-6 py-3 shadow-lg mb-6">
        <i class="fas fa-gift text-[#EF7C79]"></i>
        <span class="font-semibold text-gray-700">Our Services</span>
      </div>
      <h2 class="text-4xl md:text-5xl font-bold mb-6 text-gray-900">Comprehensive Event Planning</h2>
      <p class="text-xl text-gray-600 max-w-3xl mx-auto">From intimate gatherings to grand celebrations, we provide complete event planning services tailored to your vision.</p>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
      
      @if($content['services_page_services']->service_cards ?? false)
        @foreach($content['services_page_services']->service_cards as $service)
          <div class="service-card group bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
            <div class="relative overflow-hidden">
              @if(isset($service['image_path']))
                <img src="{{ asset($service['image_path']) }}" alt="{{ $service['title'] }}" class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500">
              @else
                <div class="w-full h-64 bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center group-hover:scale-110 transition-transform duration-500">
                  <i class="fas fa-image text-gray-400 text-4xl"></i>
                </div>
              @endif
              <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            </div>
            <div class="p-8">
              <h3 class="text-2xl font-bold text-gray-900 mb-4 group-hover:text-[#EF7C79] transition-colors">{{ $service['title'] }}</h3>
              <p class="text-gray-600 mb-6 leading-relaxed">{{ $service['description'] }}</p>
              
              <div class="space-y-3 mb-8">
                @if(isset($service['features']))
                  @foreach($service['features'] as $feature)
                    <div class="flex items-center">
                      <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                        <i class="fas fa-check text-green-600 text-sm"></i>
                      </div>
                      <span class="text-gray-700 font-medium">{{ $feature }}</span>
                    </div>
                  @endforeach
                @endif
              </div>
              
              <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('book-now') }}" class="flex-1 bg-gradient-to-r from-[#EF7C79] to-[#D76C69] hover:from-[#D76C69] hover:to-[#C55A57] text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 text-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                  <i class="fas fa-calendar-check mr-2"></i>Plan Your {{ ucfirst($service['type']) }}
                </a>
                <a href="{{ route('packages', ['type' => $service['type']]) }}" class="flex-1 bg-white text-[#EF7C79] border-2 border-[#EF7C79] hover:bg-[#EF7C79] hover:text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 text-center">
                  <i class="fas fa-eye mr-2"></i>View Packages
                </a>
              </div>
            </div>
          </div>
        @endforeach
      @else
        <!-- Enhanced Fallback content if no CMS data -->
        <div class="service-card group bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
          <div class="relative overflow-hidden">
            <img src="{{ asset('public/img/wedding.webp') }}" alt="Wedding Planning" class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500">
            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
          </div>
          <div class="p-8">
            <h3 class="text-2xl font-bold text-gray-900 mb-4 group-hover:text-[#EF7C79] transition-colors">Wedding Planning</h3>
            <p class="text-gray-600 mb-6 leading-relaxed">Create the wedding of your dreams with our comprehensive planning services. From intimate ceremonies to grand celebrations, we handle every detail.</p>
            
            <div class="space-y-3 mb-8">
              <div class="flex items-center">
                <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                  <i class="fas fa-check text-green-600 text-sm"></i>
                </div>
                <span class="text-gray-700 font-medium">Venue selection and coordination</span>
              </div>
              <div class="flex items-center">
                <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                  <i class="fas fa-check text-green-600 text-sm"></i>
                </div>
                <span class="text-gray-700 font-medium">Catering and menu planning</span>
              </div>
              <div class="flex items-center">
                <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                  <i class="fas fa-check text-green-600 text-sm"></i>
                </div>
                <span class="text-gray-700 font-medium">Decoration and floral arrangements</span>
              </div>
              <div class="flex items-center">
                <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                  <i class="fas fa-check text-green-600 text-sm"></i>
                </div>
                <span class="text-gray-700 font-medium">Photography and videography</span>
              </div>
              <div class="flex items-center">
                <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                  <i class="fas fa-check text-green-600 text-sm"></i>
                </div>
                <span class="text-gray-700 font-medium">Guest list management</span>
              </div>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-4">
              <a href="{{ route('book-now') }}" class="flex-1 bg-gradient-to-r from-[#EF7C79] to-[#D76C69] hover:from-[#D76C69] hover:to-[#C55A57] text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 text-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <i class="fas fa-calendar-check mr-2"></i>Plan Your Wedding
              </a>
              <a href="{{ route('packages', ['type' => 'wedding']) }}" class="flex-1 bg-white text-[#EF7C79] border-2 border-[#EF7C79] hover:bg-[#EF7C79] hover:text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 text-center">
                <i class="fas fa-eye mr-2"></i>View Packages
              </a>
            </div>
          </div>
        </div>
      @endif

    </div>
  </div>
</section>
@endif

<!-- Enhanced Coming Soon Section -->
@if($content['services_coming_soon']->is_active ?? false)
<section class="py-20 md:py-28 bg-gradient-to-br from-gray-50 to-gray-100">
  <div class="container mx-auto px-4">
    <div class="text-center mb-16">
      <div class="inline-flex items-center space-x-2 bg-white/80 backdrop-blur-sm rounded-full px-6 py-3 shadow-lg mb-6">
        <i class="fas fa-clock text-[#EF7C79]"></i>
        <span class="font-semibold text-gray-700">Coming Soon</span>
      </div>
      <h2 class="text-4xl md:text-5xl font-bold mb-6 text-gray-900">{{ $content['services_coming_soon']->title ?? 'More Services Coming Soon' }}</h2>
      <p class="text-xl text-gray-600 max-w-3xl mx-auto">{{ $content['services_coming_soon']->subtitle ?? 'We\'re constantly expanding our service offerings to better serve your event planning needs.' }}</p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
      <!-- Corporate Events -->
      <div class="coming-soon-card group bg-white rounded-2xl shadow-lg p-8 text-center opacity-60 hover:opacity-100 transition-all duration-300">
        <div class="w-20 h-20 bg-gradient-to-br from-gray-400 to-gray-500 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
          <i class="fas fa-building text-white text-2xl"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-800 mb-4">Corporate Events</h3>
        <p class="text-gray-600 mb-6 leading-relaxed">Professional event planning for conferences, seminars, team building, and corporate celebrations.</p>
        <span class="inline-flex items-center space-x-2 bg-gray-100 text-gray-500 px-4 py-2 rounded-full text-sm font-semibold">
          <i class="fas fa-clock"></i>
          <span>Coming Soon</span>
        </span>
      </div>

      <!-- Anniversary Celebrations -->
      <div class="coming-soon-card group bg-white rounded-2xl shadow-lg p-8 text-center opacity-60 hover:opacity-100 transition-all duration-300">
        <div class="w-20 h-20 bg-gradient-to-br from-gray-400 to-gray-500 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
          <i class="fas fa-heart text-white text-2xl"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-800 mb-4">Anniversary Celebrations</h3>
        <p class="text-gray-600 mb-6 leading-relaxed">Romantic and meaningful anniversary celebrations to commemorate your special milestones together.</p>
        <span class="inline-flex items-center space-x-2 bg-gray-100 text-gray-500 px-4 py-2 rounded-full text-sm font-semibold">
          <i class="fas fa-clock"></i>
          <span>Coming Soon</span>
        </span>
      </div>

      <!-- Custom Events -->
      <div class="coming-soon-card group bg-white rounded-2xl shadow-lg p-8 text-center opacity-60 hover:opacity-100 transition-all duration-300">
        <div class="w-20 h-20 bg-gradient-to-br from-gray-400 to-gray-500 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
          <i class="fas fa-magic text-white text-2xl"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-800 mb-4">Custom Events</h3>
        <p class="text-gray-600 mb-6 leading-relaxed">Unique and personalized events tailored to your specific vision and requirements.</p>
        <span class="inline-flex items-center space-x-2 bg-gray-100 text-gray-500 px-4 py-2 rounded-full text-sm font-semibold">
          <i class="fas fa-clock"></i>
          <span>Coming Soon</span>
        </span>
      </div>
    </div>
    
    <div class="text-center mt-16">
      <p class="text-gray-600 mb-8 text-lg">Stay tuned for updates on our expanded service offerings!</p>
      <a href="{{ route('contact') }}" class="bg-gradient-to-r from-[#EF7C79] to-[#D76C69] hover:from-[#D76C69] hover:to-[#C55A57] text-white px-8 py-4 rounded-full font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
        <i class="fas fa-envelope mr-3"></i>Contact Us for Updates
      </a>
    </div>
  </div>
</section>
@endif

<!-- Enhanced Why Choose Us Section -->
@if($content['services_why_choose']->is_active ?? false)
<section class="py-20 md:py-28 bg-white">
  <div class="container mx-auto px-4">
    <div class="text-center mb-16">
      <div class="inline-flex items-center space-x-2 bg-gray-100 rounded-full px-6 py-3 mb-6">
        <i class="fas fa-star text-[#EF7C79]"></i>
        <span class="font-semibold text-gray-700">Why Choose Us</span>
      </div>
      <h2 class="text-4xl md:text-5xl font-bold mb-6 text-gray-900">{{ $content['services_why_choose']->title ?? 'Why Choose CrwdCtrl?' }}</h2>
      <p class="text-xl text-gray-600 max-w-3xl mx-auto">We combine experience, creativity, and dedication to deliver exceptional events that exceed your expectations.</p>
    </div>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-8">
      <div class="feature-card group text-center">
        <div class="w-20 h-20 bg-gradient-to-br from-[#EF7C79] to-[#D76C69] rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
          <i class="fas fa-award text-white text-2xl"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-3">Experience</h3>
        <p class="text-gray-600 leading-relaxed">Years of experience in creating memorable events</p>
      </div>

      <div class="feature-card group text-center">
        <div class="w-20 h-20 bg-gradient-to-br from-[#EF7C79] to-[#D76C69] rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
          <i class="fas fa-user-cog text-white text-2xl"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-3">Personalized</h3>
        <p class="text-gray-600 leading-relaxed">Tailored to your unique vision and preferences</p>
      </div>

      <div class="feature-card group text-center">
        <div class="w-20 h-20 bg-gradient-to-br from-[#EF7C79] to-[#D76C69] rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
          <i class="fas fa-dollar-sign text-white text-2xl"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-3">Affordable</h3>
        <p class="text-gray-600 leading-relaxed">Competitive pricing with transparent packages</p>
      </div>

      <div class="feature-card group text-center">
        <div class="w-20 h-20 bg-gradient-to-br from-[#EF7C79] to-[#D76C69] rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
          <i class="fas fa-shield-alt text-white text-2xl"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-3">Reliable</h3>
        <p class="text-gray-600 leading-relaxed">Dedicated support throughout your event journey</p>
      </div>

      <div class="feature-card group text-center">
        <div class="w-20 h-20 bg-gradient-to-br from-[#EF7C79] to-[#D76C69] rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
          <i class="fas fa-qrcode text-white text-2xl"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-3">QR Check-in</h3>
        <p class="text-gray-600 leading-relaxed">Modern QR-based guest check-in system</p>
      </div>
    </div>
  </div>
</section>
@endif

<!-- Enhanced CTA Section -->
@if($content['services_cta']->is_active ?? false)
<section class="py-20 md:py-28 bg-gradient-to-br from-[#EF7C79] via-[#D76C69] to-[#C55A57] text-white relative overflow-hidden">
  <div class="absolute inset-0 bg-black/10"></div>
  <div class="absolute top-0 left-0 w-full h-full">
    <div class="absolute top-10 left-10 w-20 h-20 bg-white/10 rounded-full"></div>
    <div class="absolute top-20 right-20 w-32 h-32 bg-white/5 rounded-full"></div>
    <div class="absolute bottom-10 left-1/4 w-16 h-16 bg-white/10 rounded-full"></div>
  </div>
  <div class="container mx-auto px-4 text-center relative z-10">
    <div class="max-w-4xl mx-auto">
      <h2 class="text-4xl md:text-5xl font-bold mb-6">{{ $content['services_cta']->title ?? 'Ready to Start Planning?' }}</h2>
      <p class="text-xl md:text-2xl mb-8 text-white/90">{{ $content['services_cta']->subtitle ?? 'Let\'s create something extraordinary together' }}</p>
      <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a href="{{ $content['services_cta']->button_link ?? route('book-now') }}" class="bg-white text-[#EF7C79] hover:bg-gray-100 rounded-full px-8 py-4 text-lg font-semibold shadow-2xl hover:shadow-3xl transform hover:-translate-y-1 transition-all duration-300">
          <i class="fas fa-calendar-check mr-3"></i>{{ $content['services_cta']->button_text ?? 'Book Your Event' }}
        </a>
        <a href="{{ $content['services_cta']->service_cards['secondary_button_link'] ?? route('home') . '#contact' }}" class="bg-white/20 backdrop-blur-sm hover:bg-white/30 text-white border-2 border-white hover:bg-white hover:text-[#EF7C79] rounded-full px-8 py-4 text-lg font-semibold transition-all duration-300">
          <i class="fas fa-envelope mr-3"></i>{{ $content['services_cta']->service_cards['secondary_button_text'] ?? 'Contact Us' }}
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
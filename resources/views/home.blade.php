<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>CrwdCtrl</title>
  <!-- Favicon -->
  <link rel="icon" type="image/svg+xml" href="/public/favicon.svg">
  <link rel="icon" type="image/x-icon" href="/public/favicon.ico">
  <link rel="shortcut icon" href="/public/favicon.svg">
  <link rel="apple-touch-icon" href="/public/favicon.svg">
  <!-- Styles -->
  <link href="{{ asset('/public/css/home.css') }}" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
        <li><a href="{{ route('about') }}" class="nav-link text-gray-700 hover:text-[#EF7C79] font-medium transition-colors">About</a></li>
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
      <a href="#home" class="block py-3 text-gray-700 hover:text-[#EF7C79] font-medium transition-colors border-b border-gray-100">Home</a>
      <a href="{{ route('services') }}" class="block py-3 text-gray-700 hover:text-[#EF7C79] font-medium transition-colors border-b border-gray-100">Services</a>
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
@if($content['hero'] ?? false)
<section class="flex items-center justify-center text-center text-white relative overflow-hidden" style="background: url('{{ $content['hero']->image_path ? asset($content['hero']->image_path) : asset('img/car1.jpg') }}') no-repeat center center/cover; height: 100vh; margin-top: 0;">
  <div class="absolute inset-0 bg-gradient-to-br from-black/60 via-black/40 to-black/60"></div>
  <div class="absolute inset-0">
    <div class="absolute top-20 left-20 w-32 h-32 bg-white/10 rounded-full blur-xl"></div>
    <div class="absolute top-40 right-20 w-24 h-24 bg-white/5 rounded-full blur-lg"></div>
    <div class="absolute bottom-20 left-1/3 w-40 h-40 bg-white/10 rounded-full blur-xl"></div>
  </div>
  <div class="relative z-10 px-4 max-w-5xl mx-auto">
    <div class="mb-8">
      <div class="inline-flex items-center space-x-2 bg-white/20 backdrop-blur-sm rounded-full px-6 py-3 mb-6">
        <i class="fas fa-star text-yellow-300"></i>
        <span class="font-medium">Creating Unforgettable Moments</span>
      </div>
    </div>
    <h1 class="text-4xl md:text-5xl lg:text-7xl font-bold mb-6 leading-tight">
      {{ $content['hero']->title ?? 'Celebrate Life\'s Special Moments' }}
    </h1>
    <p class="text-lg md:text-xl lg:text-2xl mt-4 mb-8 text-white/90 leading-relaxed max-w-3xl mx-auto">
      {{ $content['hero']->subtitle ?? 'We make your dream events come true — weddings, birthdays, and more!' }}
    </p>
    <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
      <a href="{{ $content['hero']->button_link ?? route('book-now') }}" class="bg-gradient-to-r from-[#EF7C79] to-[#D76C69] hover:from-[#D76C69] hover:to-[#C55A57] text-white rounded-full px-8 py-4 text-lg font-semibold shadow-2xl hover:shadow-3xl transform hover:-translate-y-1 transition-all duration-300">
        <i class="fas fa-calendar-check mr-3"></i>{{ $content['hero']->button_text ?? 'Book Now' }}
      </a>
      <a href="{{ route('services') }}" class="bg-white/20 backdrop-blur-sm hover:bg-white/30 text-white rounded-full px-8 py-4 text-lg font-semibold border border-white/30 transition-all duration-300">
        <i class="fas fa-eye mr-3"></i>View Services
      </a>
    </div>
  </div>
</section>
@else
<!-- Enhanced Fallback Hero Section -->
<section class="flex items-center justify-center text-center text-white relative overflow-hidden" style="background: url('{{ asset('img/car1.jpg') }}') no-repeat center center/cover; height: 100vh; margin-top: 0;">
  <div class="absolute inset-0 bg-gradient-to-br from-black/60 via-black/40 to-black/60"></div>
  <div class="absolute inset-0">
    <div class="absolute top-20 left-20 w-32 h-32 bg-white/10 rounded-full blur-xl"></div>
    <div class="absolute top-40 right-20 w-24 h-24 bg-white/5 rounded-full blur-lg"></div>
    <div class="absolute bottom-20 left-1/3 w-40 h-40 bg-white/10 rounded-full blur-xl"></div>
  </div>
  <div class="relative z-10 px-4 max-w-5xl mx-auto">
    <div class="mb-8">
      <div class="inline-flex items-center space-x-2 bg-white/20 backdrop-blur-sm rounded-full px-6 py-3 mb-6">
        <i class="fas fa-star text-yellow-300"></i>
        <span class="font-medium">Creating Unforgettable Moments</span>
      </div>
    </div>
    <h1 class="text-4xl md:text-5xl lg:text-7xl font-bold mb-6 leading-tight">
      Celebrate Life's Special Moments
    </h1>
    <p class="text-lg md:text-xl lg:text-2xl mt-4 mb-8 text-white/90 leading-relaxed max-w-3xl mx-auto">
      We make your dream events come true — weddings, birthdays, and more!
    </p>
    <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
      <a href="{{ route('book-now') }}" class="bg-gradient-to-r from-[#EF7C79] to-[#D76C69] hover:from-[#D76C69] hover:to-[#C55A57] text-white rounded-full px-8 py-4 text-lg font-semibold shadow-2xl hover:shadow-3xl transform hover:-translate-y-1 transition-all duration-300">
        <i class="fas fa-calendar-check mr-3"></i>Book Now
      </a>
      <a href="{{ route('services') }}" class="bg-white/20 backdrop-blur-sm hover:bg-white/30 text-white rounded-full px-8 py-4 text-lg font-semibold border border-white/30 transition-all duration-300">
        <i class="fas fa-eye mr-3"></i>View Services
      </a>
    </div>
  </div>
</section>
@endif

<!-- Enhanced Event Services -->
@if($content['services'] ?? false)
<section class="py-20 md:py-28 bg-gradient-to-b from-gray-50 to-white">
  <div class="container mx-auto px-4">
    <div class="text-center mb-16">
      <div class="inline-flex items-center space-x-2 bg-white/80 backdrop-blur-sm rounded-full px-6 py-3 shadow-lg mb-6">
        <i class="fas fa-gift text-[#EF7C79]"></i>
        <span class="font-semibold text-gray-700">Our Services</span>
      </div>
      <h2 class="text-4xl md:text-5xl font-bold mb-6 text-gray-900">{{ $content['services']->title ?? 'Our Event Services' }}</h2>
      <p class="text-xl text-gray-600 max-w-3xl mx-auto">Discover our comprehensive range of event planning services designed to make your special occasions truly unforgettable.</p>
    </div>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
      @if($content['services']->service_cards ?? false)
        @foreach($content['services']->service_cards as $service)
          <a href="{{ $service['link'] ?? route('packages') . '?type=' . strtolower($service['type']) }}" class="group bg-white rounded-3xl shadow-xl hover:shadow-2xl p-6 transform hover:-translate-y-3 transition-all duration-500 border border-gray-100">
            <div class="relative overflow-hidden rounded-2xl mb-6">
              @if(isset($service['image_path']))
                <img src="{{ asset($service['image_path']) }}" alt="{{ $service['title'] }}" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500" />
              @elseif(isset($service['image']))
                <img src="{{ asset('img/' . $service['image']) }}" alt="{{ $service['title'] }}" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500" />
              @else
                <div class="w-full h-48 bg-gradient-to-br from-gray-200 to-gray-300 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-500">
                  <i class="fas fa-image text-gray-400 text-3xl"></i>
                </div>
              @endif
              <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            </div>
            <div class="text-center">
              <h5 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-[#EF7C79] transition-colors">{{ $service['title'] }}</h5>
              <p class="text-gray-600 text-sm leading-relaxed">{{ $service['description'] }}</p>
            </div>
          </a>
        @endforeach
      @else
        <!-- Enhanced Fallback Service Cards -->
        <a href="{{ route('packages') }}?type=wedding" class="group bg-white rounded-3xl shadow-xl hover:shadow-2xl p-6 transform hover:-translate-y-3 transition-all duration-500 border border-gray-100">
          <div class="relative overflow-hidden rounded-2xl mb-6">
            <img src="{{ asset('img/wedding.webp') }}" alt="Weddings" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500" />
            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
          </div>
          <div class="text-center">
            <h5 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-[#EF7C79] transition-colors">Weddings</h5>
            <p class="text-gray-600 text-sm leading-relaxed">Beautiful and memorable wedding event planning tailored to your dreams.</p>
          </div>
        </a>

        <a href="{{ route('packages') }}?type=birthday" class="group bg-white rounded-3xl shadow-xl hover:shadow-2xl p-6 transform hover:-translate-y-3 transition-all duration-500 border border-gray-100">
          <div class="relative overflow-hidden rounded-2xl mb-6">
            <img src="{{ asset('img/birthday.jpg') }}" alt="Birthdays" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500" />
            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
          </div>
          <div class="text-center">
            <h5 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-[#EF7C79] transition-colors">Birthdays</h5>
            <p class="text-gray-600 text-sm leading-relaxed">Fun and exciting birthday celebrations customized for all ages.</p>
          </div>
        </a>

        <a href="{{ route('packages') }}?type=debut" class="group bg-white rounded-3xl shadow-xl hover:shadow-2xl p-6 transform hover:-translate-y-3 transition-all duration-500 border border-gray-100">
          <div class="relative overflow-hidden rounded-2xl mb-6">
            <img src="{{ asset('img/debut.webp') }}" alt="Debuts" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500" />
            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
          </div>
          <div class="text-center">
            <h5 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-[#EF7C79] transition-colors">Debuts</h5>
            <p class="text-gray-600 text-sm leading-relaxed">Elegant debut parties that mark this special milestone with style.</p>
          </div>
        </a>

        <a href="{{ route('packages') }}?type=baptism" class="group bg-white rounded-3xl shadow-xl hover:shadow-2xl p-6 transform hover:-translate-y-3 transition-all duration-500 border border-gray-100">
          <div class="relative overflow-hidden rounded-2xl mb-6">
            <img src="{{ asset('img/baptism.jpg') }}" alt="Baptisms" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500" />
            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
          </div>
          <div class="text-center">
            <h5 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-[#EF7C79] transition-colors">Baptisms</h5>
            <p class="text-gray-600 text-sm leading-relaxed">Graceful baptism events that celebrate faith and family.</p>
          </div>
        </a>
      @endif
    </div>
  </div>
</section>
@else
<!-- Enhanced Fallback Services Section -->
<section class="py-20 md:py-28 bg-gradient-to-b from-gray-50 to-white">
  <div class="container mx-auto px-4">
    <div class="text-center mb-16">
      <div class="inline-flex items-center space-x-2 bg-white/80 backdrop-blur-sm rounded-full px-6 py-3 shadow-lg mb-6">
        <i class="fas fa-gift text-[#EF7C79]"></i>
        <span class="font-semibold text-gray-700">Our Services</span>
      </div>
      <h2 class="text-4xl md:text-5xl font-bold mb-6 text-gray-900">Our Event Services</h2>
      <p class="text-xl text-gray-600 max-w-3xl mx-auto">Discover our comprehensive range of event planning services designed to make your special occasions truly unforgettable.</p>
    </div>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
      <!-- Enhanced Wedding Card -->
      <a href="{{ route('packages') }}?type=wedding" class="group bg-white rounded-3xl shadow-xl hover:shadow-2xl p-6 transform hover:-translate-y-3 transition-all duration-500 border border-gray-100">
        <div class="relative overflow-hidden rounded-2xl mb-6">
          <img src="{{ asset('img/wedding.webp') }}" alt="Weddings" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500" />
          <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        </div>
        <div class="text-center">
          <h5 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-[#EF7C79] transition-colors">Weddings</h5>
          <p class="text-gray-600 text-sm leading-relaxed">Beautiful and memorable wedding event planning tailored to your dreams.</p>
        </div>
      </a>

      <!-- Enhanced Birthday Card -->
      <a href="{{ route('packages') }}?type=birthday" class="group bg-white rounded-3xl shadow-xl hover:shadow-2xl p-6 transform hover:-translate-y-3 transition-all duration-500 border border-gray-100">
        <div class="relative overflow-hidden rounded-2xl mb-6">
          <img src="{{ asset('img/birthday.jpg') }}" alt="Birthdays" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500" />
          <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        </div>
        <div class="text-center">
          <h5 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-[#EF7C79] transition-colors">Birthdays</h5>
          <p class="text-gray-600 text-sm leading-relaxed">Fun and exciting birthday celebrations customized for all ages.</p>
        </div>
      </a>

      <!-- Enhanced Debut Card -->
      <a href="{{ route('packages') }}?type=debut" class="group bg-white rounded-3xl shadow-xl hover:shadow-2xl p-6 transform hover:-translate-y-3 transition-all duration-500 border border-gray-100">
        <div class="relative overflow-hidden rounded-2xl mb-6">
          <img src="{{ asset('img/debut.webp') }}" alt="Debuts" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500" />
          <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        </div>
        <div class="text-center">
          <h5 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-[#EF7C79] transition-colors">Debuts</h5>
          <p class="text-gray-600 text-sm leading-relaxed">Elegant debut parties that mark this special milestone with style.</p>
        </div>
      </a>

      <!-- Enhanced Baptism Card -->
      <a href="{{ route('packages') }}?type=baptism" class="group bg-white rounded-3xl shadow-xl hover:shadow-2xl p-6 transform hover:-translate-y-3 transition-all duration-500 border border-gray-100">
        <div class="relative overflow-hidden rounded-2xl mb-6">
          <img src="{{ asset('img/baptism.jpg') }}" alt="Baptisms" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500" />
          <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        </div>
        <div class="text-center">
          <h5 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-[#EF7C79] transition-colors">Baptisms</h5>
          <p class="text-gray-600 text-sm leading-relaxed">Graceful baptism events that celebrate faith and family.</p>
        </div>
      </a>
    </div>
  </div>
</section>
@endif

<!-- Enhanced Who We Are -->
@if($content['about'] ?? false)
<section class="py-20 md:py-28 bg-white">
  <div class="container mx-auto px-4">
    <div class="max-w-4xl mx-auto text-center">
      <div class="inline-flex items-center space-x-2 bg-gray-100 rounded-full px-6 py-3 mb-8">
        <i class="fas fa-heart text-[#EF7C79]"></i>
        <span class="font-semibold text-gray-700">About Us</span>
      </div>
      <h2 class="text-4xl md:text-5xl font-bold mb-8 text-gray-900">{{ $content['about']->title ?? 'Who We Are' }}</h2>
      <p class="text-xl text-gray-600 leading-relaxed max-w-3xl mx-auto">{{ $content['about']->description ?? 'We\'re passionate about delivering the best service to our customers with honesty and integrity.' }}</p>
    </div>
  </div>
</section>
@else
<!-- Enhanced Fallback About Section -->
<section class="py-20 md:py-28 bg-white">
  <div class="container mx-auto px-4">
    <div class="max-w-4xl mx-auto text-center">
      <div class="inline-flex items-center space-x-2 bg-gray-100 rounded-full px-6 py-3 mb-8">
        <i class="fas fa-heart text-[#EF7C79]"></i>
        <span class="font-semibold text-gray-700">About Us</span>
      </div>
      <h2 class="text-4xl md:text-5xl font-bold mb-8 text-gray-900">Who We Are</h2>
      <p class="text-xl text-gray-600 leading-relaxed max-w-3xl mx-auto">We're passionate about delivering the best service to our customers with honesty and integrity.</p>
    </div>
  </div>
</section>
@endif

<!-- Enhanced Contact Section -->
@if($content['contact'] ?? false)
<section id="contact" class="py-20 md:py-28 bg-gradient-to-br from-gray-50 to-gray-100">
  <div class="container mx-auto px-4">
    <div class="max-w-4xl mx-auto text-center">
      <div class="inline-flex items-center space-x-2 bg-white/80 backdrop-blur-sm rounded-full px-6 py-3 shadow-lg mb-8">
        <i class="fas fa-phone text-[#EF7C79]"></i>
        <span class="font-semibold text-gray-700">Contact Us</span>
      </div>
      <h2 class="text-4xl md:text-5xl font-bold mb-12 text-gray-900">{{ $content['contact']->title ?? 'Get in Touch' }}</h2>
      
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow duration-300">
          <div class="w-16 h-16 bg-gradient-to-br from-[#EF7C79] to-[#D76C69] rounded-2xl flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-phone text-white text-2xl"></i>
          </div>
          <h3 class="text-xl font-bold text-gray-900 mb-2">Phone</h3>
          <p class="text-gray-600">{{ $content['contact']->contact_phone ?? '+63 912 345 6789' }}</p>
        </div>
        
        <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow duration-300">
          <div class="w-16 h-16 bg-gradient-to-br from-[#EF7C79] to-[#D76C69] rounded-2xl flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-envelope text-white text-2xl"></i>
          </div>
          <h3 class="text-xl font-bold text-gray-900 mb-2">Email</h3>
          <p class="text-gray-600">{{ $content['contact']->contact_email ?? 'hello@crwdctrl.space' }}</p>
        </div>
        
        <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow duration-300">
          <div class="w-16 h-16 bg-gradient-to-br from-[#EF7C79] to-[#D76C69] rounded-2xl flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-map-marker-alt text-white text-2xl"></i>
          </div>
          <h3 class="text-xl font-bold text-gray-900 mb-2">Location</h3>
          <p class="text-gray-600">{{ $content['contact']->contact_address ?? 'Bataan, Philippines' }}</p>
        </div>
      </div>
    </div>
  </div>
</section>
@else
<!-- Enhanced Fallback Contact Section -->
<section id="contact" class="py-20 md:py-28 bg-gradient-to-br from-gray-50 to-gray-100">
  <div class="container mx-auto px-4">
    <div class="max-w-4xl mx-auto text-center">
      <div class="inline-flex items-center space-x-2 bg-white/80 backdrop-blur-sm rounded-full px-6 py-3 shadow-lg mb-8">
        <i class="fas fa-phone text-[#EF7C79]"></i>
        <span class="font-semibold text-gray-700">Contact Us</span>
      </div>
      <h2 class="text-4xl md:text-5xl font-bold mb-12 text-gray-900">Get in Touch</h2>
      
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow duration-300">
          <div class="w-16 h-16 bg-gradient-to-br from-[#EF7C79] to-[#D76C69] rounded-2xl flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-phone text-white text-2xl"></i>
          </div>
          <h3 class="text-xl font-bold text-gray-900 mb-2">Phone</h3>
          <p class="text-gray-600">+63 912 345 6789</p>
        </div>
        
        <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow duration-300">
          <div class="w-16 h-16 bg-gradient-to-br from-[#EF7C79] to-[#D76C69] rounded-2xl flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-envelope text-white text-2xl"></i>
          </div>
          <h3 class="text-xl font-bold text-gray-900 mb-2">Email</h3>
          <p class="text-gray-600">hello@crwdctrl.space</p>
        </div>
        
        <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow duration-300">
          <div class="w-16 h-16 bg-gradient-to-br from-[#EF7C79] to-[#D76C69] rounded-2xl flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-map-marker-alt text-white text-2xl"></i>
          </div>
          <h3 class="text-xl font-bold text-gray-900 mb-2">Location</h3>
          <p class="text-gray-600">Bataan, Philippines</p>
        </div>
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
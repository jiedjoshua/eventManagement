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
<nav class="bg-white shadow-sm fixed top-0 w-full z-50 py-6">
  <div class="container mx-auto px-4 flex items-center justify-between">
    
    <!-- Left: Logo -->
    <a href="{{ route('home') }}" class="text-xl font-bold">CrwdCtrl</a>

    <!-- Mobile Menu Button -->
    <button id="menu-btn" class="lg:hidden text-gray-700 focus:outline-none">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
      </svg>
    </button>

    <!-- Center Nav + Right Buttons -->
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
</nav>

<!-- Hero Section -->
<section class="pt-32 pb-16 bg-gradient-to-r from-[#EF7C79] to-[#D76C69] text-white">
  <div class="container mx-auto px-4 text-center">
    <h1 class="text-4xl md:text-5xl font-bold mb-4">Our Event Services</h1>
    <p class="text-xl mb-8">Comprehensive event planning and management for every special occasion</p>
    <a href="{{ route('book-now') }}" class="bg-white text-[#EF7C79] hover:bg-gray-100 rounded-full px-8 py-3 font-semibold transition duration-300">Start Planning Your Event</a>
  </div>
</section>

<!-- Main Services Section -->
<section class="py-20">
  <div class="container mx-auto px-4">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
      
      <!-- Wedding Services -->
      <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <img src="{{ asset('public/img/wedding.webp') }}" alt="Wedding Planning" class="w-full h-64 object-cover">
        <div class="p-8">
          <h3 class="text-2xl font-bold text-gray-800 mb-4">Wedding Planning</h3>
          <p class="text-gray-600 mb-6">Create the wedding of your dreams with our comprehensive planning services. From intimate ceremonies to grand celebrations, we handle every detail.</p>
          
          <div class="space-y-3 mb-6">
            <div class="flex items-center">
              <svg class="w-5 h-5 text-[#EF7C79] mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
              </svg>
              <span class="text-gray-700">Venue selection and coordination</span>
            </div>
            <div class="flex items-center">
              <svg class="w-5 h-5 text-[#EF7C79] mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
              </svg>
              <span class="text-gray-700">Catering and menu planning</span>
            </div>
            <div class="flex items-center">
              <svg class="w-5 h-5 text-[#EF7C79] mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
              </svg>
              <span class="text-gray-700">Decoration and floral arrangements</span>
            </div>
            <div class="flex items-center">
              <svg class="w-5 h-5 text-[#EF7C79] mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
              </svg>
              <span class="text-gray-700">Photography and videography</span>
            </div>
            <div class="flex items-center">
              <svg class="w-5 h-5 text-[#EF7C79] mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
              </svg>
              <span class="text-gray-700">Guest list management</span>
            </div>
          </div>
          
          <a href="{{ route('book-now') }}" class="inline-block bg-[#EF7C79] hover:bg-[#D76C69] text-white px-6 py-3 rounded-lg font-semibold transition duration-300">Plan Your Wedding</a>
          <a href="{{ route('packages', ['type' => 'wedding']) }}" class="inline-block mt-2 bg-white text-[#EF7C79] border border-[#EF7C79] hover:bg-[#EF7C79] hover:text-white px-6 py-2 rounded-lg font-semibold transition duration-300">View Packages</a>
        </div>
      </div>

      <!-- Birthday Services -->
      <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <img src="{{ asset('public/img/birthday.jpg') }}" alt="Birthday Celebrations" class="w-full h-64 object-cover">
        <div class="p-8">
          <h3 class="text-2xl font-bold text-gray-800 mb-4">Birthday Celebrations</h3>
          <p class="text-gray-600 mb-6">Make every birthday unforgettable with our creative and personalized celebration planning. From kids' parties to milestone birthdays.</p>
          
          <div class="space-y-3 mb-6">
            <div class="flex items-center">
              <svg class="w-5 h-5 text-[#EF7C79] mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
              </svg>
              <span class="text-gray-700">Theme-based party planning</span>
            </div>
            <div class="flex items-center">
              <svg class="w-5 h-5 text-[#EF7C79] mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
              </svg>
              <span class="text-gray-700">Entertainment and activities</span>
            </div>
            <div class="flex items-center">
              <svg class="w-5 h-5 text-[#EF7C79] mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
              </svg>
              <span class="text-gray-700">Custom cake and dessert setup</span>
            </div>
            <div class="flex items-center">
              <svg class="w-5 h-5 text-[#EF7C79] mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
              </svg>
              <span class="text-gray-700">Party favors and decorations</span>
            </div>
            <div class="flex items-center">
              <svg class="w-5 h-5 text-[#EF7C79] mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
              </svg>
              <span class="text-gray-700">Photography and memories</span>
            </div>
          </div>
          
          <a href="{{ route('book-now') }}" class="inline-block bg-[#EF7C79] hover:bg-[#D76C69] text-white px-6 py-3 rounded-lg font-semibold transition duration-300">Plan Birthday Party</a>
          <a href="{{ route('packages', ['type' => 'birthday']) }}" class="inline-block mt-2 bg-white text-[#EF7C79] border border-[#EF7C79] hover:bg-[#EF7C79] hover:text-white px-6 py-2 rounded-lg font-semibold transition duration-300">View Packages</a>
        </div>
      </div>

      <!-- Debut Services -->
      <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <img src="{{ asset('img/debut.webp') }}" alt="Debut Planning" class="w-full h-64 object-cover">
        <div class="p-8">
          <h3 class="text-2xl font-bold text-gray-800 mb-4">Debut Planning</h3>
          <p class="text-gray-600 mb-6">Celebrate the transition to adulthood with an elegant and memorable debut celebration. We create sophisticated events that honor this important milestone.</p>
          
          <div class="space-y-3 mb-6">
            <div class="flex items-center">
              <svg class="w-5 h-5 text-[#EF7C79] mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
              </svg>
              <span class="text-gray-700">Elegant venue selection</span>
            </div>
            <div class="flex items-center">
              <svg class="w-5 h-5 text-[#EF7C79] mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
              </svg>
              <span class="text-gray-700">Formal dinner and reception</span>
            </div>
            <div class="flex items-center">
              <svg class="w-5 h-5 text-[#EF7C79] mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
              </svg>
              <span class="text-gray-700">Traditional 18 roses and 18 candles</span>
            </div>
            <div class="flex items-center">
              <svg class="w-5 h-5 text-[#EF7C79] mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
              </svg>
              <span class="text-gray-700">Professional photography</span>
            </div>
            <div class="flex items-center">
              <svg class="w-5 h-5 text-[#EF7C79] mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
              </svg>
              <span class="text-gray-700">Live entertainment and music</span>
            </div>
          </div>
          
          <a href="{{ route('book-now') }}" class="inline-block bg-[#EF7C79] hover:bg-[#D76C69] text-white px-6 py-3 rounded-lg font-semibold transition duration-300">Plan Your Debut</a>
          <a href="{{ route('packages', ['type' => 'debut']) }}" class="inline-block mt-2 bg-white text-[#EF7C79] border border-[#EF7C79] hover:bg-[#EF7C79] hover:text-white px-6 py-2 rounded-lg font-semibold transition duration-300">View Packages</a>
        </div>
      </div>

      <!-- Baptism Services -->
      <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <img src="{{ asset('img/baptism.jpg') }}" alt="Baptism Planning" class="w-full h-64 object-cover">
        <div class="p-8">
          <h3 class="text-2xl font-bold text-gray-800 mb-4">Baptism Planning</h3>
          <p class="text-gray-600 mb-6">Celebrate the spiritual journey with a beautiful baptism ceremony and reception. We coordinate with churches and create meaningful celebrations.</p>
          
          <div class="space-y-3 mb-6">
            <div class="flex items-center">
              <svg class="w-5 h-5 text-[#EF7C79] mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
              </svg>
              <span class="text-gray-700">Church coordination</span>
            </div>
            <div class="flex items-center">
              <svg class="w-5 h-5 text-[#EF7C79] mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
              </svg>
              <span class="text-gray-700">Reception venue planning</span>
            </div>
            <div class="flex items-center">
              <svg class="w-5 h-5 text-[#EF7C79] mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
              </svg>
              <span class="text-gray-700">Catering and refreshments</span>
            </div>
            <div class="flex items-center">
              <svg class="w-5 h-5 text-[#EF7C79] mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
              </svg>
              <span class="text-gray-700">Baptism souvenirs and favors</span>
            </div>
            <div class="flex items-center">
              <svg class="w-5 h-5 text-[#EF7C79] mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
              </svg>
              <span class="text-gray-700">Documentation and photography</span>
            </div>
          </div>
          
          <a href="{{ route('book-now') }}" class="inline-block bg-[#EF7C79] hover:bg-[#D76C69] text-white px-6 py-3 rounded-lg font-semibold transition duration-300">Plan Baptism</a>
          <a href="{{ route('packages', ['type' => 'baptism']) }}" class="inline-block mt-2 bg-white text-[#EF7C79] border border-[#EF7C79] hover:bg-[#EF7C79] hover:text-white px-6 py-2 rounded-lg font-semibold transition duration-300">View Packages</a>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- Coming Soon Section -->
<section class="py-20 bg-gray-50">
  <div class="container mx-auto px-4">
    <div class="text-center">
      <h2 class="text-3xl font-bold mb-8">More Services Coming Soon</h2>
      <p class="text-xl text-gray-600 mb-8">We're constantly expanding our service offerings to better serve your event planning needs.</p>
      
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-4xl mx-auto">
        
        <!-- Corporate Events -->
        <div class="bg-white rounded-xl shadow-md p-8 text-center opacity-60">
          <div class="w-16 h-16 bg-gray-400 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
            </svg>
          </div>
          <h3 class="text-xl font-bold text-gray-800 mb-3">Corporate Events</h3>
          <p class="text-gray-600 mb-4">Professional event planning for conferences, seminars, team building, and corporate celebrations.</p>
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
        <a href="{{ route('home') }}#contact" class="inline-block bg-[#EF7C79] hover:bg-[#D76C69] text-white px-6 py-3 rounded-lg font-semibold transition duration-300">Contact Us for Updates</a>
      </div>
    </div>
  </div>
</section>

<!-- Why Choose Us Section -->
<section class="py-20">
  <div class="container mx-auto px-4">
    <h2 class="text-3xl font-bold text-center mb-12">Why Choose CrwdCtrl?</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8">
      
      <div class="text-center">
        <div class="w-16 h-16 bg-[#EF7C79] rounded-full flex items-center justify-center mx-auto mb-4">
          <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
        </div>
        <h3 class="text-lg font-bold text-gray-800 mb-2">Experience</h3>
        <p class="text-gray-600">Years of experience in creating memorable events</p>
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

<!-- CTA Section -->
<section class="py-20 bg-[#EF7C79] text-white">
  <div class="container mx-auto px-4 text-center">
    <h2 class="text-3xl font-bold mb-4">Ready to Start Planning?</h2>
    <p class="text-xl mb-8">Let's create something extraordinary together</p>
    <div class="flex flex-col sm:flex-row gap-4 justify-center">
      <a href="{{ route('book-now') }}" class="bg-white text-[#EF7C79] hover:bg-gray-100 rounded-full px-8 py-3 font-semibold transition duration-300">Book Your Event</a>
      <a href="{{ route('home') }}#contact" class="border-2 border-white text-white hover:bg-white hover:text-[#EF7C79] rounded-full px-8 py-3 font-semibold transition duration-300">Contact Us</a>
    </div>
  </div>
</section>

<!-- Footer -->
<footer class="bg-white text-center py-6 border-t">
  <p class="text-sm text-gray-600">&copy; 2025 CrwdCtrl. All rights reserved.</p>
</footer>

<script>
  // Basic mobile menu toggle
  document.getElementById('menu-btn').addEventListener('click', function() {
    document.getElementById('menu').classList.toggle('hidden');
  });
</script>

</body>
</html> 
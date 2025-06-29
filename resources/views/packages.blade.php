<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Event Packages - CrwdCtrl</title>
  <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
  <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
  <link href="/css/home.css" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="font-sans bg-gray-50">

<!-- Enhanced Navbar -->
<nav class="bg-white/95 backdrop-blur-md shadow-lg fixed top-0 w-full z-50 py-4">
  <div class="container mx-auto px-4 flex items-center justify-between">
    <a href="{{ route('home') }}" class="text-2xl font-bold bg-gradient-to-r from-[#EF7C79] to-[#D76C69] bg-clip-text text-transparent">
      CrwdCtrl
    </a>
    <button id="menu-btn" class="lg:hidden text-gray-700 focus:outline-none hover:text-[#EF7C79] transition-colors">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
      </svg>
    </button>
    <div class="hidden lg:flex justify-between items-center w-full ml-12">
      <ul class="flex space-x-8 items-center mx-auto">
        <li><a href="{{ route('home') }}" class="nav-link text-gray-700 hover:text-[#EF7C79] font-medium transition-colors">Home</a></li>
        <li><a href="{{ route('services') }}" class="nav-link text-gray-700 hover:text-[#EF7C79] font-medium transition-colors">Services</a></li>
        <li><a href="{{ route('gallery') }}" class="nav-link text-gray-700 hover:text-[#EF7C79] font-medium transition-colors">Gallery</a></li>
        <li><a href="{{ route('about') }}" class="nav-link text-gray-700 hover:text-[#EF7C79] font-medium transition-colors">About</a></li>
        <li><a href="{{ route('contact') }}" class="nav-link text-gray-700 hover:text-[#EF7C79] font-medium transition-colors">Contact</a></li>
      </ul>
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
</nav>

<!-- Enhanced Hero Section -->
<section class="pt-32 pb-20 bg-gradient-to-br from-[#EF7C79] via-[#D76C69] to-[#C55A57] text-white relative overflow-hidden">
  <div class="absolute inset-0 bg-black/10"></div>
  <div class="absolute top-0 left-0 w-full h-full">
    <div class="absolute top-10 left-10 w-20 h-20 bg-white/10 rounded-full"></div>
    <div class="absolute top-20 right-20 w-32 h-32 bg-white/5 rounded-full"></div>
    <div class="absolute bottom-10 left-1/4 w-16 h-16 bg-white/10 rounded-full"></div>
  </div>
  <div class="container mx-auto px-4 text-center relative z-10">
    <div class="max-w-4xl mx-auto">
      <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight">
        Event Packages
      </h1>
      <p class="text-xl md:text-2xl mb-8 text-white/90 leading-relaxed">
        Choose the perfect package for your special occasion and create unforgettable memories
      </p>
      <div class="flex flex-wrap justify-center gap-4">
        <div class="bg-white/20 backdrop-blur-sm rounded-full px-6 py-3">
          <i class="fas fa-heart mr-2"></i>
          <span class="font-medium">Wedding</span>
        </div>
        <div class="bg-white/20 backdrop-blur-sm rounded-full px-6 py-3">
          <i class="fas fa-birthday-cake mr-2"></i>
          <span class="font-medium">Birthday</span>
        </div>
        <div class="bg-white/20 backdrop-blur-sm rounded-full px-6 py-3">
          <i class="fas fa-star mr-2"></i>
          <span class="font-medium">Debut</span>
        </div>
        <div class="bg-white/20 backdrop-blur-sm rounded-full px-6 py-3">
          <i class="fas fa-cross mr-2"></i>
          <span class="font-medium">Baptism</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Enhanced Packages Section -->
<section class="py-20 bg-gradient-to-b from-gray-50 to-white min-h-[60vh]">
  <div class="container mx-auto px-4 py-16">
    @php
      $type = request('type');
    @endphp

    @if($type && isset($packagesData[$type]))
      <div class="mb-16 text-center">
        <div class="inline-flex items-center space-x-2 bg-white/80 backdrop-blur-sm rounded-full px-6 py-3 shadow-lg mb-6">
          <i class="fas fa-gift text-[#EF7C79]"></i>
          <span class="font-semibold text-gray-700 capitalize">{{ $type }} Packages</span>
        </div>
        <h2 class="text-4xl font-bold mb-4 text-gray-900 capitalize">{{ $type }} Celebration Packages</h2>
        <p class="text-xl text-gray-600 max-w-2xl mx-auto">Choose from our carefully curated packages designed to make your {{ $type }} celebration truly special and memorable.</p>
      </div>
      
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($packagesData[$type] as $index => $package)
          <div class="group bg-white rounded-3xl shadow-xl hover:shadow-2xl p-8 flex flex-col items-center transform hover:-translate-y-2 transition-all duration-500 border border-gray-100">
            <!-- Package Header -->
            <div class="text-center mb-6">
              <div class="w-16 h-16 bg-gradient-to-br from-[#EF7C79] to-[#D76C69] rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                <i class="fas fa-crown text-white text-xl"></i>
              </div>
              <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $package['name'] }}</h3>
              <div class="text-3xl font-bold bg-gradient-to-r from-[#EF7C79] to-[#D76C69] bg-clip-text text-transparent mb-2">{{ $package['price'] }}</div>
              <div class="w-16 h-0.5 bg-gradient-to-r from-[#EF7C79] to-[#D76C69] mx-auto"></div>
            </div>
            
            <!-- Package Features -->
            <ul class="mb-8 text-gray-600 space-y-3 flex-1">
              @foreach(array_slice($package['features'], 0, 3) as $feature)
                <li class="flex items-start space-x-3">
                  <i class="fas fa-check-circle text-green-500 mt-1 flex-shrink-0"></i>
                  <span class="text-sm">{{ $feature }}</span>
                </li>
              @endforeach
              @if(count($package['features']) > 3)
                <li class="flex items-center space-x-3 text-gray-500 italic">
                  <i class="fas fa-plus-circle text-[#EF7C79]"></i>
                  <span class="text-sm">+{{ count($package['features']) - 3 }} more features</span>
                </li>
              @endif
            </ul>
            
            <!-- Package Actions -->
            <div class="flex space-x-3 w-full">
              <button onclick="openPackageModal('{{ $package['name'] }}', '{{ $package['price'] }}', {{ json_encode($package['features']) }}, '{{ $type }}')" 
                      class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-3 rounded-xl font-semibold transition-all duration-300 group-hover:shadow-md">
                <i class="fas fa-eye mr-2"></i>View Details
              </button>
              <a href="{{ route('book-now') }}" class="flex-1 bg-gradient-to-r from-[#EF7C79] to-[#D76C69] hover:from-[#D76C69] hover:to-[#C55A57] text-white px-4 py-3 rounded-xl font-semibold transition-all duration-300 text-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <i class="fas fa-calendar-check mr-2"></i>Book Now
              </a>
            </div>
          </div>
        @endforeach
      </div>
    @else
      <!-- Enhanced Service Selection -->
      <div class="text-center py-20">
        <div class="max-w-4xl mx-auto">
          <div class="w-24 h-24 bg-gradient-to-br from-[#EF7C79] to-[#D76C69] rounded-full flex items-center justify-center mx-auto mb-8">
            <i class="fas fa-gift text-white text-3xl"></i>
          </div>
          <h2 class="text-4xl font-bold mb-6 text-gray-900">Select Your Event Type</h2>
          <p class="text-xl text-gray-600 mb-12 max-w-2xl mx-auto">Choose from our specialized packages designed for different types of celebrations and events.</p>
          
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <a href="{{ route('packages', ['type' => 'wedding']) }}" class="group bg-white rounded-2xl shadow-lg hover:shadow-xl p-8 text-center transform hover:-translate-y-2 transition-all duration-300 border border-gray-100">
              <div class="w-16 h-16 bg-gradient-to-br from-pink-500 to-red-500 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                <i class="fas fa-heart text-white text-2xl"></i>
              </div>
              <h3 class="text-xl font-bold text-gray-900 mb-2">Wedding</h3>
              <p class="text-gray-600 text-sm">Perfect packages for your special day</p>
            </a>
            
            <a href="{{ route('packages', ['type' => 'birthday']) }}" class="group bg-white rounded-2xl shadow-lg hover:shadow-xl p-8 text-center transform hover:-translate-y-2 transition-all duration-300 border border-gray-100">
              <div class="w-16 h-16 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                <i class="fas fa-birthday-cake text-white text-2xl"></i>
              </div>
              <h3 class="text-xl font-bold text-gray-900 mb-2">Birthday</h3>
              <p class="text-gray-600 text-sm">Celebrate in style with our birthday packages</p>
            </a>
            
            <a href="{{ route('packages', ['type' => 'debut']) }}" class="group bg-white rounded-2xl shadow-lg hover:shadow-xl p-8 text-center transform hover:-translate-y-2 transition-all duration-300 border border-gray-100">
              <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                <i class="fas fa-star text-white text-2xl"></i>
              </div>
              <h3 class="text-xl font-bold text-gray-900 mb-2">Debut</h3>
              <p class="text-gray-600 text-sm">Make your debut celebration unforgettable</p>
            </a>
            
            <a href="{{ route('packages', ['type' => 'baptism']) }}" class="group bg-white rounded-2xl shadow-lg hover:shadow-xl p-8 text-center transform hover:-translate-y-2 transition-all duration-300 border border-gray-100">
              <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-500 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                <i class="fas fa-cross text-white text-2xl"></i>
              </div>
              <h3 class="text-xl font-bold text-gray-900 mb-2">Baptism</h3>
              <p class="text-gray-600 text-sm">Sacred and beautiful baptism celebrations</p>
            </a>
          </div>
        </div>
      </div>
    @endif
  </div>
</section>

<!-- Enhanced Package Details Modal -->
<div id="packageModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden">
  <div class="flex items-center justify-center min-h-screen p-4">
    <div class="bg-white rounded-3xl max-w-2xl w-full max-h-[90vh] overflow-y-auto shadow-2xl transform transition-all duration-300 scale-95 opacity-0" id="modalContent">
      <!-- Modal Header -->
      <div class="relative p-8 border-b border-gray-100">
        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-[#EF7C79] to-[#D76C69] rounded-t-3xl"></div>
        <div class="flex justify-between items-start">
          <div class="flex-1">
            <h2 id="modalTitle" class="text-3xl font-bold text-gray-900 mb-2"></h2>
            <div id="modalPrice" class="text-4xl font-bold bg-gradient-to-r from-[#EF7C79] to-[#D76C69] bg-clip-text text-transparent"></div>
          </div>
          <button onclick="closePackageModal()" class="text-gray-400 hover:text-gray-600 p-2 hover:bg-gray-100 rounded-full transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>
        </div>
        
        <!-- Package Type Badge -->
        <div class="mt-4">
          <span id="modalType" class="inline-flex items-center space-x-2 bg-gradient-to-r from-[#EF7C79] to-[#D76C69] text-white px-4 py-2 rounded-full text-sm font-semibold capitalize">
            <i class="fas fa-gift"></i>
            <span></span>
          </span>
        </div>
      </div>
      
      <!-- Modal Content -->
      <div class="p-8">
        <!-- Detailed Inclusions -->
        <div class="mb-8">
          <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
            <i class="fas fa-list-check text-[#EF7C79] mr-3"></i>
            Package Inclusions
          </h3>
          <div id="modalFeatures" class="space-y-4">
            <!-- Features will be populated by JavaScript -->
          </div>
        </div>
      </div>
      
      <!-- Modal Footer -->
      <div class="flex justify-end space-x-4 p-8 border-t border-gray-100 bg-gray-50 rounded-b-3xl">
        <button onclick="closePackageModal()" class="px-8 py-3 text-gray-600 hover:text-gray-800 font-semibold hover:bg-gray-200 rounded-xl transition-all duration-300">
          <i class="fas fa-times mr-2"></i>Close
        </button>
        <a id="modalBookButton" href="{{ route('book-now') }}" class="bg-gradient-to-r from-[#EF7C79] to-[#D76C69] hover:from-[#D76C69] hover:to-[#C55A57] text-white px-8 py-3 rounded-xl font-semibold transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
          <i class="fas fa-calendar-check mr-2"></i>Book This Package
        </a>
      </div>
    </div>
  </div>
</div>

<!-- Enhanced Footer -->
<footer class="bg-white text-center py-12 border-t border-gray-200">
  <div class="container mx-auto px-4">
    <div class="flex items-center justify-center space-x-2 mb-4">
      <div class="w-8 h-8 bg-gradient-to-r from-[#EF7C79] to-[#D76C69] rounded-lg flex items-center justify-center">
        <span class="text-white font-bold text-sm">C</span>
      </div>
      <span class="text-xl font-bold text-gray-900">CrwdCtrl</span>
    </div>
    <p class="text-gray-600">&copy; 2025 CrwdCtrl. All rights reserved.</p>
  </div>
</footer>

<script>
  document.getElementById('menu-btn').addEventListener('click', function() {
    document.getElementById('menu').classList.toggle('hidden');
  });

  // Enhanced Package Modal Functions
  function openPackageModal(packageName, packagePrice, packageFeatures, packageType) {
    // Set modal content
    document.getElementById('modalTitle').textContent = packageName;
    document.getElementById('modalPrice').textContent = packagePrice;
    document.getElementById('modalType').querySelector('span').textContent = packageType + ' Package';
    
    // Populate features
    const featuresContainer = document.getElementById('modalFeatures');
    featuresContainer.innerHTML = '';
    packageFeatures.forEach(feature => {
      const featureDiv = document.createElement('div');
      featureDiv.className = 'flex items-start space-x-4 p-4 bg-white rounded-xl border border-gray-100 shadow-sm';
      featureDiv.innerHTML = `
        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
          <i class="fas fa-check text-green-600 text-sm"></i>
        </div>
        <span class="text-gray-700 font-medium">${feature}</span>
      `;
      featuresContainer.appendChild(featureDiv);
    });
    
    // Update book button with package info
    const bookButton = document.getElementById('modalBookButton');
    bookButton.href = `{{ route('book-now') }}?type=${packageType}&package=${encodeURIComponent(packageName)}`;
    
    // Show modal with animation
    const modal = document.getElementById('packageModal');
    const modalContent = document.getElementById('modalContent');
    modal.classList.remove('hidden');
    
    // Trigger animation
    setTimeout(() => {
      modalContent.classList.remove('scale-95', 'opacity-0');
      modalContent.classList.add('scale-100', 'opacity-100');
    }, 10);
    
    document.body.style.overflow = 'hidden'; // Prevent background scrolling
  }

  function closePackageModal() {
    const modal = document.getElementById('packageModal');
    const modalContent = document.getElementById('modalContent');
    
    // Trigger close animation
    modalContent.classList.remove('scale-100', 'opacity-100');
    modalContent.classList.add('scale-95', 'opacity-0');
    
    setTimeout(() => {
      modal.classList.add('hidden');
      document.body.style.overflow = 'auto'; // Restore scrolling
    }, 300);
  }

  // Close modal when clicking outside
  document.getElementById('packageModal').addEventListener('click', function(e) {
    if (e.target === this) {
      closePackageModal();
    }
  });

  // Close modal with Escape key
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && !document.getElementById('packageModal').classList.contains('hidden')) {
      closePackageModal();
    }
  });
</script>

</body>
</html> 
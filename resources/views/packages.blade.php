<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Event Packages - CrwdCtrl</title>
  <link href="/css/home.css" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans">

<!-- Navbar -->
<nav class="bg-white shadow-sm fixed top-0 w-full z-50 py-6">
  <div class="container mx-auto px-4 flex items-center justify-between">
    <a href="{{ route('home') }}" class="text-xl font-bold">CrwdCtrl</a>
    <button id="menu-btn" class="lg:hidden text-gray-700 focus:outline-none">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
      </svg>
    </button>
    <div class="hidden lg:flex justify-between items-center w-full ml-12">
      <ul class="flex space-x-6 items-center mx-auto">
        <li><a href="{{ route('home') }}" class="nav-link text-gray-700 hover:text-[#EF7C79]">Home</a></li>
        <li><a href="{{ route('services') }}" class="nav-link text-gray-700 hover:text-[#EF7C79]">Services</a></li>
        <li><a href="{{ route('gallery') }}" class="nav-link text-gray-700 hover:text-[#EF7C79]">Gallery</a></li>
        <li><a href="{{ route('about') }}" class="nav-link text-gray-700 hover:text-[#EF7C79]">About</a></li>
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
</nav>

<!-- Hero Section -->
<section class="pt-40 pb-12 bg-gradient-to-r from-[#EF7C79] to-[#D76C69] text-white">
  <div class="container mx-auto px-4 text-center">
    <h1 class="text-4xl md:text-5xl font-bold mb-4">Event Packages</h1>
    <p class="text-xl mb-8">Choose the perfect package for your special occasion</p>
  </div>
</section>

<!-- Packages Section -->
<section class="py-20 bg-gray-50 min-h-[40vh]">
  <div class="container mx-auto px-4 py-16">
    @php
      $type = request('type');
    @endphp

    @if($type && isset($packagesData[$type]))
      <div class="mb-12 text-center">
        <h2 class="text-3xl font-bold mb-2 capitalize">{{ $type }} Packages</h2>
        <p class="text-gray-600">Choose from our curated packages for your {{ $type }} celebration.</p>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @foreach($packagesData[$type] as $index => $package)
          <div class="bg-white rounded-2xl shadow-lg p-8 flex flex-col items-center">
            <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $package['name'] }}</h3>
            <div class="text-2xl font-bold text-[#EF7C79] mb-4">{{ $package['price'] }}</div>
            <ul class="mb-6 text-gray-600 space-y-2">
              @foreach(array_slice($package['features'], 0, 3) as $feature)
                <li>• {{ $feature }}</li>
              @endforeach
              @if(count($package['features']) > 3)
                <li class="text-gray-500 italic">+{{ count($package['features']) - 3 }} more features</li>
              @endif
            </ul>
            <div class="flex space-x-3 w-full">
              <button onclick="openPackageModal('{{ $package['name'] }}', '{{ $package['price'] }}', {{ json_encode($package['features']) }}, '{{ $type }}')" 
                      class="flex-1 bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-semibold transition duration-300">
                View Package
              </button>
              <a href="{{ route('book-now') }}" class="flex-1 bg-[#EF7C79] hover:bg-[#D76C69] text-white px-4 py-2 rounded-lg font-semibold transition duration-300 text-center">
                Book Now
              </a>
            </div>
          </div>
        @endforeach
      </div>
    @else
      <div class="text-center py-20">
        <h2 class="text-2xl font-bold mb-4">Select a Service to View Packages</h2>
        <div class="flex flex-wrap justify-center gap-4">
          <a href="{{ route('packages', ['type' => 'wedding']) }}" class="bg-[#EF7C79] hover:bg-[#D76C69] text-white px-6 py-3 rounded-full font-semibold transition duration-300">Wedding Packages</a>
          <a href="{{ route('packages', ['type' => 'birthday']) }}" class="bg-[#EF7C79] hover:bg-[#D76C69] text-white px-6 py-3 rounded-full font-semibold transition duration-300">Birthday Packages</a>
          <a href="{{ route('packages', ['type' => 'debut']) }}" class="bg-[#EF7C79] hover:bg-[#D76C69] text-white px-6 py-3 rounded-full font-semibold transition duration-300">Debut Packages</a>
          <a href="{{ route('packages', ['type' => 'baptism']) }}" class="bg-[#EF7C79] hover:bg-[#D76C69] text-white px-6 py-3 rounded-full font-semibold transition duration-300">Baptism Packages</a>
        </div>
      </div>
    @endif
  </div>
</section>

<!-- Package Details Modal -->
<div id="packageModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
  <div class="flex items-center justify-center min-h-screen p-4">
    <div class="bg-white rounded-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
      <!-- Modal Header -->
      <div class="flex justify-between items-center p-6 border-b border-gray-200">
        <h2 id="modalTitle" class="text-2xl font-bold text-gray-900"></h2>
        <button onclick="closePackageModal()" class="text-gray-400 hover:text-gray-600">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
      </div>
      
      <!-- Modal Content -->
      <div class="p-6">
        <!-- Package Price -->
        <div class="text-center mb-6">
          <div id="modalPrice" class="text-3xl font-bold text-[#EF7C79]"></div>
        </div>
        
        <!-- Package Type Badge -->
        <div class="text-center mb-6">
          <span id="modalType" class="inline-block bg-[#EF7C79] text-white px-4 py-2 rounded-full text-sm font-semibold capitalize"></span>
        </div>
        
        <!-- Detailed Inclusions -->
        <div class="mb-6">
          <h3 class="text-xl font-semibold text-gray-900 mb-4">Package Inclusions</h3>
          <div id="modalFeatures" class="space-y-3">
            <!-- Features will be populated by JavaScript -->
          </div>
        </div>
      </div>
      
      <!-- Modal Footer -->
      <div class="flex justify-end space-x-3 p-6 border-t border-gray-200">
        <button onclick="closePackageModal()" class="px-6 py-2 text-gray-600 hover:text-gray-800 font-semibold">
          Close
        </button>
        <a id="modalBookButton" href="{{ route('book-now') }}" class="bg-[#EF7C79] hover:bg-[#D76C69] text-white px-6 py-2 rounded-lg font-semibold transition duration-300">
          Book This Package
        </a>
      </div>
    </div>
  </div>
</div>

<!-- Footer -->
<footer class="bg-white text-center py-6 border-t">
  <p class="text-sm text-gray-600">&copy; 2025 CrwdCtrl. All rights reserved.</p>
</footer>

<script>
  document.getElementById('menu-btn').addEventListener('click', function() {
    document.getElementById('menu').classList.toggle('hidden');
  });

  // Package Modal Functions
  function openPackageModal(packageName, packagePrice, packageFeatures, packageType) {
    // Set modal content
    document.getElementById('modalTitle').textContent = packageName;
    document.getElementById('modalPrice').textContent = packagePrice;
    document.getElementById('modalType').textContent = packageType + ' Package';
    
    // Populate features
    const featuresContainer = document.getElementById('modalFeatures');
    featuresContainer.innerHTML = '';
    packageFeatures.forEach(feature => {
      const featureDiv = document.createElement('div');
      featureDiv.className = 'flex items-start space-x-3';
      featureDiv.innerHTML = `
        <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
        <span class="text-gray-700">${feature}</span>
      `;
      featuresContainer.appendChild(featureDiv);
    });
    
    // Update book button with package info
    const bookButton = document.getElementById('modalBookButton');
    bookButton.href = `{{ route('book-now') }}?type=${packageType}&package=${encodeURIComponent(packageName)}`;
    
    // Show modal
    document.getElementById('packageModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden'; // Prevent background scrolling
  }

  function closePackageModal() {
    document.getElementById('packageModal').classList.add('hidden');
    document.body.style.overflow = 'auto'; // Restore scrolling
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
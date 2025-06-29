<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Gallery - CrwdCtrl Event Management</title>
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
        <li><a href="{{ route('gallery') }}" class="nav-link text-[#EF7C79] font-semibold">Gallery</a></li>
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
  <!-- Mobile Menu -->
  <div id="mobile-menu" class="lg:hidden hidden bg-white border-t">
    <div class="px-4 py-2 space-y-1">
      <a href="{{ route('home') }}" class="block py-2 text-gray-700 hover:text-[#EF7C79]">Home</a>
      <a href="{{ route('services') }}" class="block py-2 text-gray-700 hover:text-[#EF7C79]">Services</a>
      <a href="{{ route('gallery') }}" class="block py-2 text-[#EF7C79] font-semibold">Gallery</a>
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
<section class="pt-32 pb-10 md:pb-16 bg-gradient-to-r from-[#EF7C79] to-[#D76C69] text-white min-h-[40vh] flex items-center">
  <div class="container mx-auto px-4 text-center w-full">
    <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-3 md:mb-4">{{ $galleryData['hero']['title'] }}</h1>
    <p class="text-base md:text-xl mb-6 md:mb-8">{{ $galleryData['hero']['subtitle'] }}</p>
  </div>
</section>

<!-- Filter Section -->
<section class="py-6 md:py-8 bg-gray-50">
  <div class="container mx-auto px-4">
    <div class="flex flex-wrap justify-center gap-3 md:gap-4">
      <button class="filter-btn active bg-[#EF7C79] text-white px-4 md:px-6 py-2 rounded-full font-semibold transition duration-300 text-sm md:text-base" data-filter="all">
        All Events
      </button>
      <button class="filter-btn bg-white text-gray-700 hover:bg-[#EF7C79] hover:text-white px-4 md:px-6 py-2 rounded-full font-semibold transition duration-300 text-sm md:text-base" data-filter="wedding">
        Weddings
      </button>
      <button class="filter-btn bg-white text-gray-700 hover:bg-[#EF7C79] hover:text-white px-4 md:px-6 py-2 rounded-full font-semibold transition duration-300 text-sm md:text-base" data-filter="birthday">
        Birthdays
      </button>
      <button class="filter-btn bg-white text-gray-700 hover:bg-[#EF7C79] hover:text-white px-4 md:px-6 py-2 rounded-full font-semibold transition duration-300 text-sm md:text-base" data-filter="debut">
        Debuts
      </button>
      <button class="filter-btn bg-white text-gray-700 hover:bg-[#EF7C79] hover:text-white px-4 md:px-6 py-2 rounded-full font-semibold transition duration-300 text-sm md:text-base" data-filter="baptism">
        Baptisms
      </button>
    </div>
  </div>
</section>

<!-- Gallery Grid -->
<section class="py-10 md:py-16">
  <div class="container mx-auto px-4">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-6" id="gallery-grid">
      
      @foreach($galleryData['images'] as $image)
        <div class="gallery-item {{ $image['category'] }}" data-category="{{ $image['category'] }}">
          <div class="group relative overflow-hidden rounded-lg shadow-lg cursor-pointer">
            <img src="{{ asset($image['image_path'] ?? '/img/placeholder.jpg') }}" alt="{{ $image['alt_text'] ?? 'Gallery Image' }}" class="w-full h-48 md:h-64 object-cover transition duration-300 group-hover:scale-110">
            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition duration-300 flex items-center justify-center">
              <div class="text-white text-center opacity-0 group-hover:opacity-100 transition duration-300">
                <h3 class="text-base md:text-lg font-bold mb-1 md:mb-2">{{ $image['title'] ?? 'Gallery Image' }}</h3>
                <p class="text-xs md:text-sm">{{ $image['description'] ?? 'Beautiful event' }}</p>
              </div>
            </div>
          </div>
        </div>
      @endforeach

    </div>
  </div>
</section>

<!-- Call to Action Section -->
<section class="py-10 md:py-20 bg-[#EF7C79] text-white">
  <div class="container mx-auto px-4 text-center">
    <h2 class="text-2xl md:text-3xl font-bold mb-3 md:mb-4">{{ $galleryData['cta']['title'] }}</h2>
    <p class="text-base md:text-xl mb-6 md:mb-8">{{ $galleryData['cta']['subtitle'] }}</p>
    <div class="flex flex-col sm:flex-row gap-3 md:gap-4 justify-center">
      <a href="{{ $galleryData['cta']['primary_button_link'] }}" class="bg-white text-[#EF7C79] hover:bg-gray-100 rounded-full px-6 md:px-8 py-2 md:py-3 font-semibold transition duration-300">{{ $galleryData['cta']['primary_button_text'] }}</a>
      <a href="{{ $galleryData['cta']['secondary_button_link'] }}" class="border-2 border-white text-white hover:bg-white hover:text-[#EF7C79] rounded-full px-6 md:px-8 py-2 md:py-3 font-semibold transition duration-300">{{ $galleryData['cta']['secondary_button_text'] }}</a>
    </div>
  </div>
</section>

<!-- Footer -->
<footer class="bg-white text-center py-4 md:py-6 border-t">
  <p class="text-xs md:text-sm text-gray-600">&copy; 2025 CrwdCtrl. All rights reserved.</p>
</footer>

<!-- Lightbox Modal -->
<div id="lightbox" class="fixed inset-0 bg-black bg-opacity-90 hidden z-50 flex items-center justify-center">
  <div class="relative max-w-4xl max-h-full mx-4">
    <img id="lightbox-img" src="" alt="" class="max-w-full max-h-full object-contain">
    <button id="close-lightbox" class="absolute top-4 right-4 text-white text-4xl hover:text-gray-300">&times;</button>
  </div>
</div>

<script>
  // Filter functionality
  const filterButtons = document.querySelectorAll('.filter-btn');
  const galleryItems = document.querySelectorAll('.gallery-item');

  filterButtons.forEach(button => {
    button.addEventListener('click', () => {
      const filter = button.getAttribute('data-filter');
      
      // Update active button
      filterButtons.forEach(btn => {
        btn.classList.remove('active', 'bg-[#EF7C79]', 'text-white');
        btn.classList.add('bg-white', 'text-gray-700');
      });
      button.classList.add('active', 'bg-[#EF7C79]', 'text-white');
      button.classList.remove('bg-white', 'text-gray-700');
      
      // Filter gallery items
      galleryItems.forEach(item => {
        if (filter === 'all' || item.getAttribute('data-category') === filter) {
          item.style.display = 'block';
        } else {
          item.style.display = 'none';
        }
      });
    });
  });

  // Lightbox functionality
  const lightbox = document.getElementById('lightbox');
  const lightboxImg = document.getElementById('lightbox-img');
  const closeLightbox = document.getElementById('close-lightbox');
  const galleryImages = document.querySelectorAll('.gallery-item img');

  galleryImages.forEach(img => {
    img.addEventListener('click', () => {
      lightboxImg.src = img.src;
      lightboxImg.alt = img.alt;
      lightbox.classList.remove('hidden');
    });
  });

  closeLightbox.addEventListener('click', () => {
    lightbox.classList.add('hidden');
  });

  lightbox.addEventListener('click', (e) => {
    if (e.target === lightbox) {
      lightbox.classList.add('hidden');
    }
  });

  // Close lightbox with Escape key
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && !lightbox.classList.contains('hidden')) {
      lightbox.classList.add('hidden');
    }
  });

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
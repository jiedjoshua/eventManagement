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
        <li><a href="{{ route('services') }}" class="nav-link text-gray-700 hover:text-[#EF7C79]">Services</a></li>
        <li><a href="{{ route('gallery') }}" class="nav-link text-[#EF7C79] font-semibold">Gallery</a></li>
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
<section class="pt-36 pb-16 bg-gradient-to-r from-[#EF7C79] to-[#D76C69] text-white">
  <div class="container mx-auto px-4 text-center">
    <h1 class="text-4xl md:text-5xl font-bold mb-4">Our Event Gallery</h1>
    <p class="text-xl mb-8">Explore our collection of beautiful events and celebrations we've helped create</p>
  </div>
</section>

<!-- Filter Section -->
<section class="py-8 bg-gray-50">
  <div class="container mx-auto px-4">
    <div class="flex flex-wrap justify-center gap-4">
      <button class="filter-btn active bg-[#EF7C79] text-white px-6 py-2 rounded-full font-semibold transition duration-300" data-filter="all">
        All Events
      </button>
      <button class="filter-btn bg-white text-gray-700 hover:bg-[#EF7C79] hover:text-white px-6 py-2 rounded-full font-semibold transition duration-300" data-filter="wedding">
        Weddings
      </button>
      <button class="filter-btn bg-white text-gray-700 hover:bg-[#EF7C79] hover:text-white px-6 py-2 rounded-full font-semibold transition duration-300" data-filter="birthday">
        Birthdays
      </button>
      <button class="filter-btn bg-white text-gray-700 hover:bg-[#EF7C79] hover:text-white px-6 py-2 rounded-full font-semibold transition duration-300" data-filter="debut">
        Debuts
      </button>
      <button class="filter-btn bg-white text-gray-700 hover:bg-[#EF7C79] hover:text-white px-6 py-2 rounded-full font-semibold transition duration-300" data-filter="baptism">
        Baptisms
      </button>
    </div>
  </div>
</section>

<!-- Gallery Grid -->
<section class="py-16">
  <div class="container mx-auto px-4">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="gallery-grid">
      
      <!-- Wedding Images -->
      <div class="gallery-item wedding" data-category="wedding">
        <div class="group relative overflow-hidden rounded-lg shadow-lg cursor-pointer">
          <img src="{{ asset('public/img/wedding.webp') }}" alt="Wedding Celebration" class="w-full h-64 object-cover transition duration-300 group-hover:scale-110">
          <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition duration-300 flex items-center justify-center">
            <div class="text-white text-center opacity-0 group-hover:opacity-100 transition duration-300">
              <h3 class="text-lg font-bold mb-2">Elegant Wedding</h3>
              <p class="text-sm">Beautiful outdoor ceremony</p>
            </div>
          </div>
        </div>
      </div>

      <div class="gallery-item wedding" data-category="wedding">
        <div class="group relative overflow-hidden rounded-lg shadow-lg cursor-pointer">
          <img src="{{ asset('public/img/wedding.png') }}" alt="Wedding Reception" class="w-full h-64 object-cover transition duration-300 group-hover:scale-110">
          <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition duration-300 flex items-center justify-center">
            <div class="text-white text-center opacity-0 group-hover:opacity-100 transition duration-300">
              <h3 class="text-lg font-bold mb-2">Wedding Reception</h3>
              <p class="text-sm">Magical evening celebration</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Birthday Images -->
      <div class="gallery-item birthday" data-category="birthday">
        <div class="group relative overflow-hidden rounded-lg shadow-lg cursor-pointer">
          <img src="{{ asset('public/img/birthday.jpg') }}" alt="Birthday Party" class="w-full h-64 object-cover transition duration-300 group-hover:scale-110">
          <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition duration-300 flex items-center justify-center">
            <div class="text-white text-center opacity-0 group-hover:opacity-100 transition duration-300">
              <h3 class="text-lg font-bold mb-2">Birthday Celebration</h3>
              <p class="text-sm">Fun and colorful party</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Debut Images -->
      <div class="gallery-item debut" data-category="debut">
        <div class="group relative overflow-hidden rounded-lg shadow-lg cursor-pointer">
          <img src="{{ asset('public/img/debut.webp') }}" alt="Debut Celebration" class="w-full h-64 object-cover transition duration-300 group-hover:scale-110">
          <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition duration-300 flex items-center justify-center">
            <div class="text-white text-center opacity-0 group-hover:opacity-100 transition duration-300">
              <h3 class="text-lg font-bold mb-2">18th Debut</h3>
              <p class="text-sm">Elegant coming-of-age celebration</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Baptism Images -->
      <div class="gallery-item baptism" data-category="baptism">
        <div class="group relative overflow-hidden rounded-lg shadow-lg cursor-pointer">
          <img src="{{ asset('public/img/baptism.jpg') }}" alt="Baptism Ceremony" class="w-full h-64 object-cover transition duration-300 group-hover:scale-110">
          <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition duration-300 flex items-center justify-center">
            <div class="text-white text-center opacity-0 group-hover:opacity-100 transition duration-300">
              <h3 class="text-lg font-bold mb-2">Baptism Ceremony</h3>
              <p class="text-sm">Sacred family celebration</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Additional Wedding Images (using car1.jpg as placeholder) -->
      <div class="gallery-item wedding" data-category="wedding">
        <div class="group relative overflow-hidden rounded-lg shadow-lg cursor-pointer">
          <img src="{{ asset('public/img/car1.jpg') }}" alt="Wedding Transportation" class="w-full h-64 object-cover transition duration-300 group-hover:scale-110">
          <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition duration-300 flex items-center justify-center">
            <div class="text-white text-center opacity-0 group-hover:opacity-100 transition duration-300">
              <h3 class="text-lg font-bold mb-2">Wedding Transportation</h3>
              <p class="text-sm">Luxury wedding car service</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Additional Birthday Images -->
      <div class="gallery-item birthday" data-category="birthday">
        <div class="group relative overflow-hidden rounded-lg shadow-lg cursor-pointer">
          <img src="{{ asset('public/img/birthday.jpg') }}" alt="Kids Birthday Party" class="w-full h-64 object-cover transition duration-300 group-hover:scale-110">
          <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition duration-300 flex items-center justify-center">
            <div class="text-white text-center opacity-0 group-hover:opacity-100 transition duration-300">
              <h3 class="text-lg font-bold mb-2">Kids Birthday</h3>
              <p class="text-sm">Magical children's party</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Additional Debut Images -->
      <div class="gallery-item debut" data-category="debut">
        <div class="group relative overflow-hidden rounded-lg shadow-lg cursor-pointer">
          <img src="{{ asset('public/img/debut.webp') }}" alt="Debut Reception" class="w-full h-64 object-cover transition duration-300 group-hover:scale-110">
          <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition duration-300 flex items-center justify-center">
            <div class="text-white text-center opacity-0 group-hover:opacity-100 transition duration-300">
              <h3 class="text-lg font-bold mb-2">Debut Reception</h3>
              <p class="text-sm">Formal dinner celebration</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Additional Baptism Images -->
      <div class="gallery-item baptism" data-category="baptism">
        <div class="group relative overflow-hidden rounded-lg shadow-lg cursor-pointer">
          <img src="{{ asset('public/img/baptism.jpg') }}" alt="Baptism Reception" class="w-full h-64 object-cover transition duration-300 group-hover:scale-110">
          <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition duration-300 flex items-center justify-center">
            <div class="text-white text-center opacity-0 group-hover:opacity-100 transition duration-300">
              <h3 class="text-lg font-bold mb-2">Baptism Reception</h3>
              <p class="text-sm">Family gathering celebration</p>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- Call to Action Section -->
<section class="py-20 bg-[#EF7C79] text-white">
  <div class="container mx-auto px-4 text-center">
    <h2 class="text-3xl font-bold mb-4">Inspired by Our Work?</h2>
    <p class="text-xl mb-8">Let's create your own beautiful memories together</p>
    <div class="flex flex-col sm:flex-row gap-4 justify-center">
      <a href="{{ route('book-now') }}" class="bg-white text-[#EF7C79] hover:bg-gray-100 rounded-full px-8 py-3 font-semibold transition duration-300">Start Planning Your Event</a>
      <a href="{{ route('home') }}#contact" class="border-2 border-white text-white hover:bg-white hover:text-[#EF7C79] rounded-full px-8 py-3 font-semibold transition duration-300">Contact Us</a>
    </div>
  </div>
</section>

<!-- Footer -->
<footer class="bg-white text-center py-6 border-t">
  <p class="text-sm text-gray-600">&copy; 2025 CrwdCtrl. All rights reserved.</p>
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
</script>

</body>
</html> 
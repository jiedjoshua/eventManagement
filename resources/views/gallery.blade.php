<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Gallery - CrwdCtrl</title>
  
  <!-- Favicon -->
  <link rel="icon" type="image/svg+xml" href="/public/favicon.svg">
  <link rel="icon" type="image/x-icon" href="/public/favicon.ico">
  <link rel="shortcut icon" href="/public/favicon.svg">
  <link rel="apple-touch-icon" href="/public/favicon.svg">
  
  <link href="/public/css/home.css" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <style>
    /* Remove underline animation */
    .nav-link::after {
      display: none !important;
    }

    .gallery-item {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      cursor: pointer;
    }

    .gallery-item:hover {
      transform: scale(1.05);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
      z-index: 10;
    }

    .filter-btn {
      transition: all 0.3s ease;
    }

    .filter-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(239, 124, 121, 0.3);
    }

    .filter-btn.active {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(239, 124, 121, 0.3);
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
        <li><a href="{{ route('gallery') }}" class="nav-link text-[#EF7C79] font-semibold">Gallery</a></li>
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
      <a href="{{ route('home') }}" class="block py-3 text-gray-700 hover:text-[#EF7C79] font-medium transition-colors border-b border-gray-100">Home</a>
      <a href="{{ route('services') }}" class="block py-3 text-gray-700 hover:text-[#EF7C79] font-medium transition-colors border-b border-gray-100">Services</a>
      <a href="{{ route('gallery') }}" class="block py-3 text-[#EF7C79] font-semibold border-b border-gray-100">Gallery</a>
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
          <i class="fas fa-images text-yellow-300"></i>
          <span class="font-medium">Our Event Gallery</span>
        </div>
      </div>
      <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight">
        {{ $galleryData['hero']['title'] }}
      </h1>
      <p class="text-xl md:text-2xl mb-8 text-white/90 leading-relaxed max-w-3xl mx-auto">
        {{ $galleryData['hero']['subtitle'] }}
      </p>
    </div>
  </div>
</section>

<!-- Enhanced Filter Section -->
<section class="py-12 bg-gradient-to-b from-gray-50 to-white">
  <div class="container mx-auto px-4">
    <div class="text-center mb-8">
      <div class="inline-flex items-center space-x-2 bg-white/80 backdrop-blur-sm rounded-full px-6 py-3 shadow-lg mb-6">
        <i class="fas fa-filter text-[#EF7C79]"></i>
        <span class="font-semibold text-gray-700">Filter Gallery</span>
      </div>
      <h2 class="text-3xl md:text-4xl font-bold mb-4 text-gray-900">Browse Our Events</h2>
      <p class="text-lg text-gray-600 max-w-2xl mx-auto">Explore our collection of beautifully captured moments from various events and celebrations.</p>
    </div>
    
    <div class="flex flex-wrap justify-center gap-4">
      <button class="filter-btn active bg-gradient-to-r from-[#EF7C79] to-[#D76C69] text-white px-6 py-3 rounded-full font-semibold transition-all duration-300 text-base shadow-lg" data-filter="all">
        <i class="fas fa-th-large mr-2"></i>All Events
      </button>
      <button class="filter-btn bg-white text-gray-700 hover:bg-[#EF7C79] hover:text-white px-6 py-3 rounded-full font-semibold transition-all duration-300 text-base shadow-md border border-gray-200" data-filter="wedding">
        <i class="fas fa-heart mr-2"></i>Weddings
      </button>
      <button class="filter-btn bg-white text-gray-700 hover:bg-[#EF7C79] hover:text-white px-6 py-3 rounded-full font-semibold transition-all duration-300 text-base shadow-md border border-gray-200" data-filter="birthday">
        <i class="fas fa-birthday-cake mr-2"></i>Birthdays
      </button>
      <button class="filter-btn bg-white text-gray-700 hover:bg-[#EF7C79] hover:text-white px-6 py-3 rounded-full font-semibold transition-all duration-300 text-base shadow-md border border-gray-200" data-filter="debut">
        <i class="fas fa-crown mr-2"></i>Debuts
      </button>
      <button class="filter-btn bg-white text-gray-700 hover:bg-[#EF7C79] hover:text-white px-6 py-3 rounded-full font-semibold transition-all duration-300 text-base shadow-md border border-gray-200" data-filter="baptism">
        <i class="fas fa-dove mr-2"></i>Baptisms
      </button>
    </div>
  </div>
</section>

<!-- Enhanced Gallery Grid -->
<section class="py-16 md:py-24 bg-white">
  <div class="container mx-auto px-4">
    @if(count($galleryData['images']) > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 md:gap-8" id="gallery-grid">
      
        @foreach($galleryData['images'] as $image)
          <div class="gallery-item {{ $image['category'] }}" data-category="{{ $image['category'] }}">
            <div class="group relative overflow-hidden rounded-2xl shadow-xl cursor-pointer bg-white">
              @if(isset($image['image_path']) && $image['image_path'])
                <img src="/public{{ str_replace('/public', '', $image['image_path']) }}" alt="{{ $image['alt_text'] ?? 'Gallery Image' }}" class="w-full h-56 md:h-64 object-cover transition duration-500 group-hover:scale-110">
              @else
                <div class="w-full h-56 md:h-64 bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center">
                  <i class="fas fa-image text-gray-400 text-4xl"></i>
                </div>
              @endif
              <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition duration-500 flex items-end justify-center pb-6">
                <div class="text-white text-center transform translate-y-4 group-hover:translate-y-0 transition duration-500">
                  <h3 class="text-lg font-bold mb-2">{{ $image['title'] ?? 'Gallery Image' }}</h3>
                  <p class="text-sm opacity-90">{{ $image['description'] ?? 'Beautiful event' }}</p>
                  <div class="mt-3">
                    <i class="fas fa-expand-alt text-white/80 text-lg"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endforeach

      </div>
    @else
      <div class="text-center py-20">
        <div class="bg-gradient-to-br from-gray-50 to-white rounded-3xl p-12 max-w-lg mx-auto shadow-xl border border-gray-100">
          <div class="w-20 h-20 bg-gradient-to-br from-gray-200 to-gray-300 rounded-2xl flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-images text-gray-400 text-3xl"></i>
          </div>
          <h3 class="text-2xl font-bold text-gray-900 mb-4">No Images Available</h3>
          <p class="text-gray-600 mb-8 leading-relaxed">No gallery images have been uploaded yet. Please check back later or contact us for more information.</p>
          <a href="{{ route('contact') }}" class="bg-gradient-to-r from-[#EF7C79] to-[#D76C69] hover:from-[#D76C69] hover:to-[#C55A57] text-white px-8 py-3 rounded-full font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
            <i class="fas fa-envelope mr-2"></i>Contact Us
          </a>
        </div>
      </div>
    @endif
  </div>
</section>

<!-- Enhanced Call to Action Section -->
<section class="py-20 md:py-28 bg-gradient-to-br from-[#EF7C79] via-[#D76C69] to-[#C55A57] text-white relative overflow-hidden">
  <div class="absolute inset-0 bg-black/10"></div>
  <div class="absolute top-0 left-0 w-full h-full">
    <div class="absolute top-10 left-10 w-20 h-20 bg-white/10 rounded-full"></div>
    <div class="absolute top-20 right-20 w-32 h-32 bg-white/5 rounded-full"></div>
    <div class="absolute bottom-10 left-1/4 w-16 h-16 bg-white/10 rounded-full"></div>
  </div>
  <div class="container mx-auto px-4 text-center relative z-10">
    <div class="max-w-4xl mx-auto">
      <h2 class="text-4xl md:text-5xl font-bold mb-6">{{ $galleryData['cta']['title'] }}</h2>
      <p class="text-xl md:text-2xl mb-8 text-white/90">{{ $galleryData['cta']['subtitle'] }}</p>
      <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a href="{{ $galleryData['cta']['primary_button_link'] }}" class="bg-white text-[#EF7C79] hover:bg-gray-100 rounded-full px-8 py-4 text-lg font-semibold shadow-2xl hover:shadow-3xl transform hover:-translate-y-1 transition-all duration-300">
          <i class="fas fa-calendar-check mr-3"></i>{{ $galleryData['cta']['primary_button_text'] }}
        </a>
        <a href="{{ $galleryData['cta']['secondary_button_link'] }}" class="bg-white/20 backdrop-blur-sm hover:bg-white/30 text-white border-2 border-white hover:bg-white hover:text-[#EF7C79] rounded-full px-8 py-4 text-lg font-semibold transition-all duration-300">
          <i class="fas fa-envelope mr-3"></i>{{ $galleryData['cta']['secondary_button_text'] }}
        </a>
      </div>
    </div>
  </div>
</section>

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

<!-- Enhanced Lightbox Modal -->
<div id="lightbox" class="fixed inset-0 bg-black/95 backdrop-blur-sm hidden z-50 flex items-center justify-center p-4">
  <div class="relative max-w-5xl max-h-full w-full">
    <div class="relative bg-white rounded-2xl overflow-hidden shadow-2xl">
      <img id="lightbox-img" src="" alt="" class="w-full h-auto max-h-[80vh] object-contain">
      <div class="absolute top-4 right-4 flex space-x-2">
        <button id="close-lightbox" class="bg-white/20 backdrop-blur-sm hover:bg-white/30 text-white rounded-full w-10 h-10 flex items-center justify-center transition-all duration-300">
          <i class="fas fa-times text-lg"></i>
        </button>
      </div>
      <div class="absolute bottom-4 left-4 right-4">
        <div class="bg-black/50 backdrop-blur-sm rounded-xl p-4 text-white">
          <h3 id="lightbox-title" class="text-lg font-bold mb-2"></h3>
          <p id="lightbox-description" class="text-sm opacity-90"></p>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  // Enhanced Filter functionality
  const filterButtons = document.querySelectorAll('.filter-btn');
  const galleryItems = document.querySelectorAll('.gallery-item');

  filterButtons.forEach(button => {
    button.addEventListener('click', () => {
      const filter = button.getAttribute('data-filter');
      
      // Update active button
      filterButtons.forEach(btn => {
        btn.classList.remove('active', 'bg-gradient-to-r', 'from-[#EF7C79]', 'to-[#D76C69]', 'text-white', 'shadow-lg');
        btn.classList.add('bg-white', 'text-gray-700', 'shadow-md', 'border', 'border-gray-200');
      });
      button.classList.add('active', 'bg-gradient-to-r', 'from-[#EF7C79]', 'to-[#D76C69]', 'text-white', 'shadow-lg');
      button.classList.remove('bg-white', 'text-gray-700', 'shadow-md', 'border', 'border-gray-200');
      
      // Filter gallery items with animation
      galleryItems.forEach(item => {
        if (filter === 'all' || item.getAttribute('data-category') === filter) {
          item.style.display = 'block';
          item.style.animation = 'fadeIn 0.5s ease';
        } else {
          item.style.display = 'none';
        }
      });
    });
  });

  // Enhanced Lightbox functionality
  const lightbox = document.getElementById('lightbox');
  const lightboxImg = document.getElementById('lightbox-img');
  const lightboxTitle = document.getElementById('lightbox-title');
  const lightboxDescription = document.getElementById('lightbox-description');
  const closeLightbox = document.getElementById('close-lightbox');
  const galleryImages = document.querySelectorAll('.gallery-item img');

  galleryImages.forEach(img => {
    img.addEventListener('click', () => {
      lightboxImg.src = img.src;
      lightboxImg.alt = img.alt;
      
      // Get title and description from parent elements
      const titleElement = img.closest('.gallery-item').querySelector('h3');
      const descriptionElement = img.closest('.gallery-item').querySelector('p');
      
      lightboxTitle.textContent = titleElement ? titleElement.textContent : 'Gallery Image';
      lightboxDescription.textContent = descriptionElement ? descriptionElement.textContent : 'Beautiful event';
      
      lightbox.classList.remove('hidden');
      document.body.style.overflow = 'hidden';
    });
  });

  closeLightbox.addEventListener('click', () => {
    lightbox.classList.add('hidden');
    document.body.style.overflow = 'auto';
  });

  lightbox.addEventListener('click', (e) => {
    if (e.target === lightbox) {
      lightbox.classList.add('hidden');
      document.body.style.overflow = 'auto';
    }
  });

  // Close lightbox with Escape key
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && !lightbox.classList.contains('hidden')) {
      lightbox.classList.add('hidden');
      document.body.style.overflow = 'auto';
    }
  });

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

  // Add fadeIn animation
  const style = document.createElement('style');
  style.textContent = `
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
  `;
  document.head.appendChild(style);
</script>

</body>
</html> 
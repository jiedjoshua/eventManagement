<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>CrwdCtrl</title>
  <link href="css/home.css" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans">

<!-- Navbar -->
<nav class="bg-white shadow-sm fixed top-0 w-full z-50 py-6">
  <div class="container mx-auto px-4 flex items-center justify-between">
    
    <!-- Left: Logo -->
    <a href="#" class="text-xl font-bold">CrwdCtrl</a>

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
        <li><a href="#home" class="nav-link text-gray-700 hover:text-[#EF7C79]">Home</a></li>
        <li><a href="{{ route('services') }}" class="nav-link text-gray-700 hover:text-[#EF7C79]">Services</a></li>
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
<section class="hero-image flex items-center justify-center text-center text-white relative">
  <div class="absolute inset-0 bg-black bg-opacity-40"></div>
  <div class="relative z-10">
    <h1 class="text-4xl md:text-5xl font-bold">Celebrate Life's Special Moments</h1>
    <p class="text-lg mt-2">We make your dream events come true — weddings, birthdays, and more!</p>
    <a href="{{ route('book-now') }}" class="inline-block mt-4 bg-[#EF7C79] hover:bg-[#D76C69] text-white rounded-full px-6 py-2">Book Now</a>
  </div>
</section>

<!-- Event Services -->
<section class="py-20 bg-gray-100 text-center">
  <div class="container mx-auto px-4">
    <h2 class="text-3xl font-bold mb-10">Our Event Services</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
      <!-- Card -->
      <div class="bg-white rounded shadow hover:shadow-lg transition duration-300 cursor-pointer">
        <img src="{{ asset('img/wedding.webp') }}" alt="Weddings" class="w-full h-52 object-cover rounded-t" />
        <div class="p-4">
          <h5 class="text-xl font-semibold">Weddings</h5>
          <p class="text-gray-600 text-sm mt-2">Beautiful and memorable wedding event planning tailored to your dreams.</p>
        </div>
      </div>

      <div class="bg-white rounded shadow hover:shadow-lg transition duration-300 cursor-pointer">
        <img src="{{ asset('img/birthday.jpg') }}" alt="Birthdays" class="w-full h-52 object-cover rounded-t" />
        <div class="p-4">
          <h5 class="text-xl font-semibold">Birthdays</h5>
          <p class="text-gray-600 text-sm mt-2">Fun and exciting birthday celebrations customized for all ages.</p>
        </div>
      </div>

      <div class="bg-white rounded shadow hover:shadow-lg transition duration-300 cursor-pointer">
        <img src="{{ asset('img/debut.webp') }}" alt="Debuts" class="w-full h-52 object-cover rounded-t" />
        <div class="p-4">
          <h5 class="text-xl font-semibold">Debuts</h5>
          <p class="text-gray-600 text-sm mt-2">Elegant debut parties that mark this special milestone with style.</p>
        </div>
      </div>

      <div class="bg-white rounded shadow hover:shadow-lg transition duration-300 cursor-pointer">
        <img src="{{ asset('img/baptism.jpg') }}" alt="Baptisms" class="w-full h-52 object-cover rounded-t" />
        <div class="p-4">
          <h5 class="text-xl font-semibold">Baptisms</h5>
          <p class="text-gray-600 text-sm mt-2">Graceful baptism events that celebrate faith and family.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Who We Are -->
<section class="py-20 text-center">
  <div class="container mx-auto px-4">
    <h2 class="text-3xl font-bold mb-4">Who We Are</h2>
    <p class="text-lg text-gray-600">We're passionate about delivering the best service to our customers with honesty and integrity.</p>
  </div>
</section>




<!-- Contact Section -->
<section id="contact" class="py-20 bg-gray-100">
  <div class="max-w-4xl mx-auto px-4 text-center">
    <h2 class="text-3xl font-bold mb-6">Get in Touch</h2>
    <p class="text-lg mb-4">📞 +63 912 345 6789</p>
    <p class="text-lg mb-4">✉️ hello@crwdctrl.ph</p>
    <p class="text-lg">📍 Bataan, Philippines</p>
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
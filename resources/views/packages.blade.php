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
  <div class="container mx-auto px-4">
    @php
      $type = request('type');
      $packages = [
        'wedding' => [
          ['name' => 'Classic Wedding', 'price' => '₱50,000', 'features' => ['Venue coordination', 'Basic decor', 'On-the-day coordination']],
          ['name' => 'Elegant Wedding', 'price' => '₱100,000', 'features' => ['Premium venue', 'Full floral design', 'Photo & video coverage']],
          ['name' => 'Luxury Wedding', 'price' => '₱200,000', 'features' => ['5-star venue', 'Luxury styling', 'Live band & emcee']],
        ],
        'birthday' => [
          ['name' => 'Kids Party', 'price' => '₱15,000', 'features' => ['Theme decor', 'Party host', 'Games & prizes']],
          ['name' => 'Teen Bash', 'price' => '₱25,000', 'features' => ['DJ & lights', 'Photo booth', 'Custom cake']],
          ['name' => 'Milestone Birthday', 'price' => '₱40,000', 'features' => ['Venue rental', 'Catering', 'Live entertainment']],
        ],
        'debut' => [
          ['name' => 'Simple Debut', 'price' => '₱30,000', 'features' => ['Venue setup', '18 roses/candles', 'Basic program']],
          ['name' => 'Glam Debut', 'price' => '₱60,000', 'features' => ['Photo & video', 'Full program', 'Host & DJ']],
          ['name' => 'Grand Debut', 'price' => '₱120,000', 'features' => ['Luxury venue', 'Live band', 'Full event styling']],
        ],
        'baptism' => [
          ['name' => 'Basic Baptism', 'price' => '₱10,000', 'features' => ['Church coordination', 'Reception decor', 'Souvenirs']],
          ['name' => 'Family Baptism', 'price' => '₱18,000', 'features' => ['Catering', 'Photo coverage', 'Host']],
          ['name' => 'Premium Baptism', 'price' => '₱30,000', 'features' => ['Premium venue', 'Full styling', 'Live music']],
        ],
      ];
    @endphp

    @if($type && isset($packages[$type]))
      <div class="mb-12 text-center">
        <h2 class="text-3xl font-bold mb-2 capitalize">{{ $type }} Packages</h2>
        <p class="text-gray-600">Choose from our curated packages for your {{ $type }} celebration.</p>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @foreach($packages[$type] as $package)
          <div class="bg-white rounded-2xl shadow-lg p-8 flex flex-col items-center">
            <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $package['name'] }}</h3>
            <div class="text-2xl font-bold text-[#EF7C79] mb-4">{{ $package['price'] }}</div>
            <ul class="mb-6 text-gray-600 space-y-2">
              @foreach($package['features'] as $feature)
                <li>• {{ $feature }}</li>
              @endforeach
            </ul>
            <a href="{{ route('book-now') }}" class="bg-[#EF7C79] hover:bg-[#D76C69] text-white px-6 py-2 rounded-lg font-semibold transition duration-300">Book This Package</a>
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

<!-- Footer -->
<footer class="bg-white text-center py-6 border-t">
  <p class="text-sm text-gray-600">&copy; 2025 CrwdCtrl. All rights reserved.</p>
</footer>

<script>
  document.getElementById('menu-btn').addEventListener('click', function() {
    document.getElementById('menu').classList.toggle('hidden');
  });
</script>

</body>
</html> 
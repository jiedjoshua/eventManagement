<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Contact Us - CrwdCtrl Event Management</title>
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
        <li><a href="{{ route('gallery') }}" class="nav-link text-gray-700 hover:text-[#EF7C79]">Gallery</a></li>
        <li><a href="{{ route('about') }}" class="nav-link text-gray-700 hover:text-[#EF7C79]">About</a></li>
        <li><a href="{{ route('contact') }}" class="nav-link text-[#EF7C79] font-semibold">Contact</a></li>
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
<section class="pt-40 pb-16 bg-gradient-to-r from-[#EF7C79] to-[#D76C69] text-white">
  <div class="container mx-auto px-4 text-center">
    <h1 class="text-4xl md:text-5xl font-bold mb-4">Get in Touch</h1>
    <p class="text-xl mb-8">Ready to start planning your perfect event? We'd love to hear from you!</p>
  </div>
</section>

<!-- Contact Information Section -->
<section class="py-20">
  <div class="container mx-auto px-4">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
      
      <!-- Contact Info -->
      <div>
        <h2 class="text-3xl font-bold text-gray-800 mb-8">Let's Start Planning Together</h2>
        <p class="text-lg text-gray-600 mb-8">
          Whether you're planning a wedding, birthday celebration, or any special event, our team is here to help bring your vision to life. Reach out to us and let's create something extraordinary together.
        </p>
        
        <div class="space-y-6">
          <!-- Phone -->
          <div class="flex items-center">
            <div class="w-12 h-12 bg-[#EF7C79] rounded-full flex items-center justify-center mr-4">
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
              </svg>
            </div>
            <div>
              <h3 class="font-semibold text-gray-800">Phone</h3>
              <p class="text-gray-600">+63 912 345 6789</p>
            </div>
          </div>

          <!-- Email -->
          <div class="flex items-center">
            <div class="w-12 h-12 bg-[#EF7C79] rounded-full flex items-center justify-center mr-4">
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
              </svg>
            </div>
            <div>
              <h3 class="font-semibold text-gray-800">Email</h3>
              <p class="text-gray-600">hello@crwdctrl.ph</p>
            </div>
          </div>

          <!-- Address -->
          <div class="flex items-center">
            <div class="w-12 h-12 bg-[#EF7C79] rounded-full flex items-center justify-center mr-4">
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
              </svg>
            </div>
            <div>
              <h3 class="font-semibold text-gray-800">Address</h3>
              <p class="text-gray-600">Bataan, Philippines</p>
            </div>
          </div>

          <!-- Business Hours -->
          <div class="flex items-center">
            <div class="w-12 h-12 bg-[#EF7C79] rounded-full flex items-center justify-center mr-4">
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </div>
            <div>
              <h3 class="font-semibold text-gray-800">Business Hours</h3>
              <p class="text-gray-600">Monday - Friday: 9:00 AM - 6:00 PM</p>
              <p class="text-gray-600">Saturday: 9:00 AM - 4:00 PM</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Contact Form -->
      <div class="bg-white rounded-2xl shadow-lg p-8">
        <h3 class="text-2xl font-bold text-gray-800 mb-6">Send us a Message</h3>
        
        <form class="space-y-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
              <input type="text" id="first_name" name="first_name" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#EF7C79] focus:border-transparent" required>
            </div>
            <div>
              <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
              <input type="text" id="last_name" name="last_name" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#EF7C79] focus:border-transparent" required>
            </div>
          </div>

          <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
            <input type="email" id="email" name="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#EF7C79] focus:border-transparent" required>
          </div>

          <div>
            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
            <input type="tel" id="phone" name="phone" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#EF7C79] focus:border-transparent" required>
          </div>

          <div>
            <label for="event_type" class="block text-sm font-medium text-gray-700 mb-2">Event Type</label>
            <select id="event_type" name="event_type" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#EF7C79] focus:border-transparent" required>
              <option value="">Select an event type</option>
              <option value="wedding">Wedding</option>
              <option value="birthday">Birthday</option>
              <option value="debut">Debut</option>
              <option value="baptism">Baptism</option>
              <option value="corporate">Corporate Event</option>
              <option value="other">Other</option>
            </select>
          </div>

          <div>
            <label for="event_date" class="block text-sm font-medium text-gray-700 mb-2">Preferred Event Date</label>
            <input type="date" id="event_date" name="event_date" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#EF7C79] focus:border-transparent">
          </div>

          <div>
            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message</label>
            <textarea id="message" name="message" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#EF7C79] focus:border-transparent" placeholder="Tell us about your event vision and requirements..."></textarea>
          </div>

          <button type="submit" class="w-full bg-[#EF7C79] hover:bg-[#D76C69] text-white font-semibold py-3 px-6 rounded-lg transition duration-300">
            Send Message
          </button>
        </form>
      </div>

    </div>
  </div>
</section>

<!-- FAQ Section -->
<section class="py-20 bg-gray-50">
  <div class="container mx-auto px-4">
    <h2 class="text-3xl font-bold text-center mb-12">Frequently Asked Questions</h2>
    
    <div class="max-w-3xl mx-auto space-y-6">
      
      <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-3">How far in advance should I book my event?</h3>
        <p class="text-gray-600">
          We recommend booking at least 3-6 months in advance for weddings and large events, and 1-2 months for smaller celebrations. However, we can accommodate last-minute requests depending on availability.
        </p>
      </div>


      <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-3">What's included in your event planning packages?</h3>
        <p class="text-gray-600">
          Our packages include venue coordination, vendor management, timeline planning, day-of coordination, and ongoing support throughout the planning process. Specific inclusions vary by package - contact us for details!
        </p>
      </div>

      <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-3">Can I customize a package to fit my specific needs?</h3>
        <p class="text-gray-600">
          Absolutely! We believe every event is unique. We offer customizable packages and can work with you to create a plan that perfectly fits your vision and budget.
        </p>
      </div>

    </div>
  </div>
</section>

<!-- Call to Action Section -->
<section class="py-20 bg-[#EF7C79] text-white">
  <div class="container mx-auto px-4 text-center">
    <h2 class="text-3xl font-bold mb-4">Ready to Start Planning?</h2>
    <p class="text-xl mb-8">Let's turn your dream event into reality</p>
    <a href="{{ route('book-now') }}" class="bg-white text-[#EF7C79] hover:bg-gray-100 rounded-full px-8 py-3 font-semibold transition duration-300">Book Your Event Now</a>
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
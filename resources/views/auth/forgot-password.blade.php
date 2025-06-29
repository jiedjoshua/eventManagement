<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Forgot Password - CrwdCtrl</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .nav-link {
      transition: color 0.3s ease;
    }
    .nav-link:hover {
      color: #EF7C79;
    }
  </style>
</head>
<body class="font-sans bg-gray-50">

<!-- Navbar -->
<nav class="bg-white shadow-sm fixed top-0 w-full z-50 py-4 lg:py-6">
  <div class="container mx-auto px-4 flex items-center justify-between">
    
    <!-- Left: Logo -->
    <a href="{{ route('home') }}" class="text-lg lg:text-xl font-bold">CrwdCtrl</a>

    <!-- Desktop Navigation -->
    <div class="hidden lg:flex justify-between items-center w-full ml-12">
      <!-- Center Nav Links -->
      <ul class="flex space-x-6 items-center mx-auto">
        <li><a href="{{ route('home') }}" class="nav-link text-gray-700 hover:text-[#EF7C79]">Home</a></li>
        <li><a href="{{ route('services') }}" class="nav-link text-gray-700 hover:text-[#EF7C79]">Services</a></li>
        <li><a href="{{ route('gallery') }}" class="nav-link text-gray-700 hover:text-[#EF7C79]">Gallery</a></li>
        <li><a href="{{ route('about') }}" class="nav-link text-gray-700 hover:text-[#EF7C79]">About</a></li>
        <li><a href="{{ route('contact') }}" class="nav-link text-gray-700 hover:text-[#EF7C79]">Contact</a></li>
      </ul>

      <!-- Right Buttons -->
      <div class="flex space-x-3 items-center">
        <a href="{{ route('login') }}" class="text-gray-700 hover:text-[#EF7C79] px-4 py-2 focus:outline-none">Back to Login</a>
      </div>
    </div>
  </div>
</nav>

<!-- Main Content -->
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8" style="margin-top: 60px;">
  <div class="max-w-md w-full space-y-8">
    <div>
      <!-- Icon -->
      <div class="mx-auto h-16 w-16 flex items-center justify-center rounded-full bg-[#EF7C79] bg-opacity-10">
        <svg class="h-8 w-8 text-[#EF7C79]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
        </svg>
      </div>
      
      <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
        Forgot your password?
      </h2>
      <p class="mt-2 text-center text-sm text-gray-600">
        No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
      </p>
    </div>

    <!-- Session Status -->
    @if (session('status'))
      <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline">{{ session('status') }}</span>
      </div>
    @endif

    <form class="mt-8 space-y-6" method="POST" action="{{ route('password.email') }}">
      @csrf

      <!-- Email Address -->
      <div>
        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
          Email Address
        </label>
        <div class="relative">
          <input id="email" name="email" type="email" autocomplete="email" required 
                 class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#EF7C79] focus:border-[#EF7C79] focus:z-10 sm:text-sm @error('email') border-red-500 @enderror"
                 placeholder="Enter your email address"
                 value="{{ old('email') }}">
          <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
            </svg>
          </div>
        </div>
        @error('email')
          <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <button type="submit" 
                class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-[#EF7C79] hover:bg-[#D76C69] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#EF7C79] transition duration-200 ease-in-out">
          <span class="absolute left-0 inset-y-0 flex items-center pl-3">
            <svg class="h-5 w-5 text-[#EF7C79] group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
            </svg>
          </span>
          Send Password Reset Link
        </button>
      </div>

      <div class="text-center">
        <a href="{{ route('login') }}" class="font-medium text-[#EF7C79] hover:text-[#D76C69] transition duration-200">
          ← Back to Login
        </a>
      </div>
    </form>

    <!-- Additional Help -->
    <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-4">
      <div class="flex">
        <div class="flex-shrink-0">
          <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
        </div>
        <div class="ml-3">
          <h3 class="text-sm font-medium text-blue-800">
            Need help?
          </h3>
          <div class="mt-2 text-sm text-blue-700">
            <p>If you're having trouble accessing your account, contact our support team at <a href="mailto:hello@crwdctrl.space" class="underline">hello@crwdctrl.space</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Footer -->
<footer class="bg-white text-center py-6 border-t mt-16">
  <p class="text-sm text-gray-600">&copy; 2025 CrwdCtrl. All rights reserved.</p>
</footer>

</body>
</html>

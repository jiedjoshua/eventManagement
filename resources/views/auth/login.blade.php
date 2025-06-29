<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
  <title>Login - CrwdCtrl</title>
  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50">
  <div class="flex min-h-screen flex-col md:flex-row">
    <!-- Left Side: Login Form -->
    <div class="w-full md:w-1/2 flex flex-col justify-center items-center p-6 md:p-10 bg-white">
      <div class="w-full max-w-md">
        <!-- Logo and Title -->
        <div class="text-center mb-8">
          <div class="flex items-center justify-center space-x-2 mb-4">
            <div class="w-10 h-10 bg-gradient-to-r from-[#EF7C79] to-[#D76C69] rounded-xl flex items-center justify-center">
              <span class="text-white font-bold text-lg">C</span>
            </div>
            <h1 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-[#EF7C79] to-[#D76C69] bg-clip-text text-transparent">
              CrwdCtrl
            </h1>
          </div>
          <h2 class="text-xl md:text-2xl font-semibold text-gray-800">Welcome Back</h2>
          <p class="text-gray-600 mt-2">Sign in to your account</p>
        </div>

        <!-- Validation Errors -->
        @if ($errors->any())
          <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl shadow-sm">
            <div class="flex items-center space-x-2 mb-2">
              <i class="fas fa-exclamation-circle text-red-500"></i>
              <span class="font-medium">Please fix the following errors:</span>
            </div>
            <ul class="list-disc list-inside space-y-1 text-sm">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
          @csrf
          
          <!-- Email Field -->
          <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
              <i class="fas fa-envelope mr-2 text-[#EF7C79]"></i>Email Address
            </label>
            <input type="email" name="email" id="email" required
              class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-[#EF7C79] focus:border-[#EF7C79] text-base transition-all duration-200 bg-white"
              placeholder="Enter your email address" />
          </div>

          <!-- Password Field -->
          <div>
            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
              <i class="fas fa-lock mr-2 text-[#EF7C79]"></i>Password
            </label>
            <input type="password" name="password" id="password" required
              class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-[#EF7C79] focus:border-[#EF7C79] text-base transition-all duration-200 bg-white"
              placeholder="Enter your password" />
          </div>

          <!-- Remember Me & Forgot Password -->
          <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <label class="flex items-center group cursor-pointer">
              <input type="checkbox" name="remember" class="h-4 w-4 text-[#EF7C79] border-gray-300 rounded focus:ring-[#EF7C79] transition-colors" />
              <span class="ml-3 text-sm text-gray-600 group-hover:text-gray-800 transition-colors">Remember me</span>
            </label>

            <a href="{{ route('password.request') }}" class="text-sm text-[#EF7C79] hover:text-[#D76C69] font-medium transition-colors hover:underline">
              <i class="fas fa-key mr-1"></i>Forgot password?
            </a>
          </div>

          <!-- Login Button -->
          <button type="submit"
            class="w-full bg-gradient-to-r from-[#EF7C79] to-[#D76C69] hover:from-[#D76C69] hover:to-[#C55A57] text-white py-3 rounded-xl font-semibold text-base shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300">
            <i class="fas fa-sign-in-alt mr-2"></i>Sign In
          </button>
        </form>

        <!-- Mobile: Sign Up Link -->
        <div class="mt-8 text-center md:hidden">
          <p class="text-gray-600 text-sm mb-2">Don't have an account?</p>
          <a href="{{ route('register') }}" class="inline-flex items-center text-[#EF7C79] hover:text-[#D76C69] font-semibold text-sm transition-colors">
            <i class="fas fa-user-plus mr-2"></i>Create Account
          </a>
        </div>
      </div>
    </div>

    <!-- Right Side: Background Image with Text Overlay -->
    <div class="hidden md:flex md:w-1/2 relative bg-cover bg-center"
        style="background-image: url('/public/img/login.jpeg');">
      <!-- Overlay -->
      <div class="absolute inset-0 bg-gradient-to-br from-black/60 via-black/40 to-black/60"></div>

      <!-- Content -->
      <div class="relative z-10 flex flex-col justify-center items-center text-center text-white p-10 h-full w-full">
        <div class="mb-8">
          <div class="inline-flex items-center space-x-2 bg-white/20 backdrop-blur-sm rounded-full px-6 py-3 mb-6">
            <i class="fas fa-star text-yellow-300"></i>
            <span class="font-medium">Welcome to CrwdCtrl</span>
          </div>
        </div>
        <h2 class="text-4xl md:text-5xl font-bold mb-6">Welcome Back</h2>
        <p class="mb-8 text-lg md:text-xl text-white/90 leading-relaxed max-w-md">
          To keep connected with us please login with your personal information
        </p>
        <a href="{{ route('register') }}">
          <button class="bg-white/20 backdrop-blur-sm hover:bg-white/30 text-white rounded-full px-8 py-4 text-lg font-semibold border border-white/30 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
            <i class="fas fa-user-plus mr-3"></i>Create Account
          </button>
        </a>
      </div>
    </div>
  </div>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
  <title>Login - CrwdCtrl</title>
  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
  <div class="flex min-h-screen flex-col md:flex-row">
    <!-- Left Side: Login Form -->
    <div class="w-full md:w-1/2 flex flex-col justify-center items-center p-6 md:p-10 bg-white">
      <div class="w-full max-w-md">
        <h1 class="text-3xl md:text-4xl font-bold mb-4 md:mb-6 text-center">CrwdCtrl</h1>
        <h2 class="text-xl md:text-2xl font-semibold mb-4 md:mb-6 text-center">Sign In</h2>

        <!-- Validation Errors -->
        @if ($errors->any())
          <div class="mb-4 p-3 md:p-4 bg-red-100 border border-red-400 text-red-700 rounded text-sm">
            <ul class="list-disc list-inside space-y-1">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-4 md:space-y-6">
          @csrf
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" name="email" id="email" required
              class="w-full px-3 md:px-4 py-3 md:py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-base"
              placeholder="Enter your email" />
          </div>

          <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input type="password" name="password" id="password" required
              class="w-full px-3 md:px-4 py-3 md:py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-base"
              placeholder="Enter your password" />
          </div>

          <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <label class="flex items-center">
              <input type="checkbox" name="remember" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" />
              <span class="ml-2 text-sm text-gray-600">Remember me</span>
            </label>

            <a href="/password/reset" class="text-sm text-blue-600 hover:underline hover:text-blue-800 transition">Forgot your password?</a>
          </div>

          <button type="submit"
            class="w-full bg-blue-600 text-white py-3 md:py-2 rounded-lg hover:bg-blue-700 transition duration-200 font-medium text-base shadow-sm">
            Log In
          </button>
        </form>

        <!-- Mobile: Sign Up Link -->
        <div class="mt-6 text-center md:hidden">
          <p class="text-gray-600 text-sm">Don't have an account?</p>
          <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm hover:underline transition">
            Sign Up
          </a>
        </div>
      </div>
    </div>

    <!-- Right Side: Background Image with Text Overlay -->
    <div class="hidden md:flex md:w-1/2 relative bg-cover bg-center"
        style="background-image: url('/public/img/login.jpeg');">
      <!-- Overlay -->
      <div class="absolute inset-0 bg-black bg-opacity-50 z-0"></div>

      <!-- Content -->
      <div class="relative z-10 flex flex-col justify-center items-center text-center text-white p-10 h-full w-full">
        <h2 class="text-3xl font-bold mb-4">Welcome Back</h2>
        <p class="mb-6 text-lg">To keep connected with us provide us with your information</p>
        <a href="{{ route('register') }}">
          <button class="bg-white text-blue-600 px-6 py-3 rounded-full font-semibold hover:bg-blue-100 transition duration-200 shadow-sm">
            Sign Up
          </button>
        </a>
      </div>
    </div>
  </div>
</body>
</html>

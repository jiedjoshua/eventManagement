<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login - CrwdCtrl</title>
  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
  <div class="flex min-h-screen">
    <!-- Left Side: Login Form -->
    <div class="w-full md:w-1/2 flex flex-col justify-center items-center p-10 bg-white">
      <div class="w-full max-w-md">
        <h1 class="text-4xl font-bold mb-6 text-center">CrwdCtrl</h1>
        <h2 class="text-2xl font-semibold mb-6 text-center">Sign In</h2>

        <!-- Validation Errors -->
        @if ($errors->any())
          <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            <ul class="list-disc list-inside">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
          @csrf
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" id="email" required
              class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" />
          </div>

          <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" name="password" id="password" required
              class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" />
          </div>

          <div class="flex items-center justify-between">
            <label class="flex items-center">
              <input type="checkbox" name="remember" class="h-4 w-4 text-blue-600 border-gray-300 rounded" />
              <span class="ml-2 text-sm text-gray-600">Remember me</span>
            </label>

            <a href="/password/reset" class="text-sm text-blue-600 hover:underline">Forgot your password?</a>
          </div>

          <button type="submit"
            class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition">Log In</button>
        </form>
      </div>
    </div>

   
    <!-- Right Side: Background Image with Text Overlay -->
    <div class="hidden md:flex md:w-1/2 relative bg-cover bg-center"
        style="background-image: url('img/login.jpeg');">
    <!-- Overlay -->
    <div class="absolute inset-0 bg-black bg-opacity-50 z-0"></div>

    <!-- Content -->
    <div class="relative z-10 flex flex-col justify-center items-center text-center text-white p-10 h-full w-full">
        <h2 class="text-3xl font-bold mb-4">Welcome Back</h2>
        <p class="mb-6">To keep connected with us provide us with your information</p>
        <a href="/register">
        <button class="bg-white text-blue-600 px-6 py-2 rounded-full font-semibold hover:bg-blue-100 transition">
            Sign Up
        </button>
        </a>
    </div>
    </div>

  </div>
</body>
</html>

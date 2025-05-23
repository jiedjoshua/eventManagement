<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Register - CrwdCtrl</title>
  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Intl Tel Input CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@17/build/css/intlTelInput.min.css" />
</head>
<body>
    <div class="flex min-h-screen">
  <!-- Left Side: Background Image -->
<div class="hidden md:flex md:w-1/2 relative bg-cover bg-center min-h-screen"
     style="background-image: url('img/login.jpeg');">
  <div class="absolute inset-0 bg-black bg-opacity-50 z-0"></div>
  <div class="relative z-10 flex flex-1 items-center justify-center text-center text-white p-10">
    <div>
      <h2 class="text-3xl font-bold mb-4">Welcome to CrwdCtrl</h2>
      <p class="mb-6">Join us and start your journey!</p>
      <a href="/login">
        <button class="bg-white text-blue-600 px-6 py-2 rounded-full font-semibold hover:bg-blue-100 transition">
          Sign In
        </button>
      </a>
    </div>
  </div>
</div>
  

    <!-- Right Side: Registration Form -->
    <div class="w-full md:w-1/2 flex flex-col justify-center items-center p-10 bg-white">
      <div class="w-full max-w-md">
        <h1 class="text-4xl font-bold mb-6 text-center">CrwdCtrl</h1>
        <h2 class="text-2xl font-semibold mb-6 text-center">Sign Up</h2>
        
        <form method="POST" action="{{ route('register') }}" class="space-y-4">
          @csrf

          @if ($errors->any())
            <div class="mb-4 text-red-600">
              <ul class="list-disc pl-5 text-sm">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
              <input type="text" name="first_name" id="first_name" required
                value="{{ old('first_name') }}"
                class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" />
              @error('first_name')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
              <input type="text" name="last_name" id="last_name" required
                value="{{ old('last_name') }}"
                class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" />
              @error('last_name')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" id="email" required
              value="{{ old('email') }}"
              class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" />
            @error('email')
              <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone Number</label>
            <input type="tel" name="phone_number" id="phone" required
              value="{{ old('phone_number') }}"
              class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" />
            @error('phone_number')
              <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" name="password" id="password" required
              class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" />
            @error('password')
              <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required
              class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" />
          </div>

          <button type="submit"
            class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition">Sign Up</button>
        </form>
      </div>
    </div>
  </div>

  <!-- Intl Tel Input JS -->
  <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@17/build/js/intlTelInput.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@17/build/js/utils.js"></script>
  <script>
    const phoneInputField = document.querySelector("#phone");
    window.intlTelInput(phoneInputField, {
      initialCountry: "ph",
      utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@17/build/js/utils.js"
    });
  </script>
</body>
</html>

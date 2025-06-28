<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
  <title>Register - CrwdCtrl</title>
  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Intl Tel Input CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@17/build/css/intlTelInput.min.css" />
</head>
<body class="bg-gray-50">
  <div class="flex min-h-screen flex-col md:flex-row">
    <!-- Left Side: Background Image -->
    <div class="hidden md:flex md:w-1/2 relative bg-cover bg-center min-h-screen"
         style="background-image: url('/public/img/login.jpeg');">
      <div class="absolute inset-0 bg-black bg-opacity-50 z-0"></div>
      <div class="relative z-10 flex flex-1 items-center justify-center text-center text-white p-10">
        <div>
          <h2 class="text-3xl font-bold mb-4">Welcome to CrwdCtrl</h2>
          <p class="mb-6 text-lg">Join us and start your journey!</p>
          <a href="{{ route('login') }}">
            <button class="bg-white text-blue-600 px-6 py-3 rounded-full font-semibold hover:bg-blue-100 transition duration-200 shadow-sm">
              Sign In
            </button>
          </a>
        </div>
      </div>
    </div>

    <!-- Right Side: Registration Form -->
    <div class="w-full md:w-1/2 flex flex-col justify-center items-center p-6 md:p-10 bg-white">
      <div class="w-full max-w-md">
        <h1 class="text-3xl md:text-4xl font-bold mb-4 md:mb-6 text-center">CrwdCtrl</h1>
        <h2 class="text-xl md:text-2xl font-semibold mb-4 md:mb-6 text-center">Sign Up</h2>
        
        <form method="POST" action="{{ route('register') }}" class="space-y-4 md:space-y-6" id="registerForm">
          @csrf

          @if ($errors->any())
            <div class="mb-4 p-3 md:p-4 bg-red-100 border border-red-400 text-red-700 rounded text-sm">
              <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
              <input type="text" name="first_name" id="first_name" required
                value="{{ old('first_name') }}"
                class="w-full px-3 md:px-4 py-3 md:py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-base"
                placeholder="First name" />
              @error('first_name')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
              <input type="text" name="last_name" id="last_name" required
                value="{{ old('last_name') }}"
                class="w-full px-3 md:px-4 py-3 md:py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-base"
                placeholder="Last name" />
              @error('last_name')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" name="email" id="email" required
              value="{{ old('email') }}"
              class="w-full px-3 md:px-4 py-3 md:py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-base"
              placeholder="Enter your email" />
            @error('email')
              <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
            <input type="tel" name="phone_number" id="phone" required
              value="{{ old('phone_number') }}"
              class="w-full px-3 md:px-4 py-3 md:py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-base"
              placeholder="Enter phone number (10-11 digits)"
              maxlength="11"
              pattern="[0-9]{10,11}"
              title="Please enter a valid phone number (10-11 digits)"
              oninput="validatePhone(this)" />
            <p class="text-xs text-gray-500 mt-1">Enter 10-11 digit phone number</p>
            @error('phone_number')
              <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input type="password" name="password" id="password" required
              class="w-full px-3 md:px-4 py-3 md:py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-base"
              placeholder="Create a password" />
            @error('password')
              <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required
              class="w-full px-3 md:px-4 py-3 md:py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-base"
              placeholder="Confirm your password" />
          </div>

          <button type="submit"
            class="w-full bg-blue-600 text-white py-3 md:py-2 rounded-lg hover:bg-blue-700 transition duration-200 font-medium text-base shadow-sm">
            Sign Up
          </button>
        </form>

        <!-- Mobile: Sign In Link -->
        <div class="mt-6 text-center md:hidden">
          <p class="text-gray-600 text-sm">Already have an account?</p>
          <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm hover:underline transition">
            Sign In
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Intl Tel Input JS -->
  <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@17/build/js/intlTelInput.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@17/build/js/utils.js"></script>
  <script>
    // Phone number validation function
    function validatePhone(input) {
      // Remove any non-digit characters
      let value = input.value.replace(/\D/g, '');
      
      // Limit to 11 digits
      if (value.length > 11) {
        value = value.substring(0, 11);
      }
      
      // Update input value
      input.value = value;
      
      // Validate length
      if (value.length > 0 && (value.length < 10 || value.length > 11)) {
        input.setCustomValidity('Phone number must be 10-11 digits');
        input.classList.add('border-red-500');
        input.classList.remove('border-gray-300');
      } else {
        input.setCustomValidity('');
        input.classList.remove('border-red-500');
        input.classList.add('border-gray-300');
      }
    }

    // Initialize phone input with custom validation
    const phoneInputField = document.querySelector("#phone");
    const iti = window.intlTelInput(phoneInputField, {
      initialCountry: "ph",
      utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@17/build/js/utils.js",
      preferredCountries: ["ph", "us", "gb"],
      separateDialCode: true,
      formatOnDisplay: true,
      autoHideDialCode: false,
      autoPlaceholder: "polite"
    });

    // Override the intl-tel-input validation with our custom validation
    phoneInputField.addEventListener('input', function() {
      validatePhone(this);
    });

    // Form submission validation
    document.getElementById('registerForm').addEventListener('submit', function(e) {
      const phoneInput = document.getElementById('phone');
      const phoneValue = phoneInput.value.replace(/\D/g, '');
      
      if (phoneValue.length < 10 || phoneValue.length > 11) {
        e.preventDefault();
        alert('Please enter a valid phone number (10-11 digits)');
        phoneInput.focus();
        return false;
      }
    });
  </script>
</body>
</html>

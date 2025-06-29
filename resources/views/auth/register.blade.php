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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50">
  <div class="flex min-h-screen flex-col md:flex-row">
    <!-- Left Side: Background Image -->
    <div class="hidden md:flex md:w-1/2 relative bg-cover bg-center min-h-screen"
         style="background-image: url('/public/img/login.jpeg');">
      <div class="absolute inset-0 bg-gradient-to-br from-black/60 via-black/40 to-black/60 z-0"></div>
      <div class="relative z-10 flex flex-1 items-center justify-center text-center text-white p-10">
        <div>
          <div class="mb-8">
            <div class="inline-flex items-center space-x-2 bg-white/20 backdrop-blur-sm rounded-full px-6 py-3 mb-6">
              <i class="fas fa-star text-yellow-300"></i>
              <span class="font-medium">Join CrwdCtrl</span>
            </div>
          </div>
          <h2 class="text-4xl md:text-5xl font-bold mb-6">Welcome to CrwdCtrl</h2>
          <p class="mb-8 text-lg md:text-xl text-white/90 leading-relaxed max-w-md">
            Join us and start your journey to creating unforgettable moments!
          </p>
          <a href="{{ route('login') }}">
            <button class="bg-white/20 backdrop-blur-sm hover:bg-white/30 text-white rounded-full px-8 py-4 text-lg font-semibold border border-white/30 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
              <i class="fas fa-sign-in-alt mr-3"></i>Sign In
            </button>
          </a>
        </div>
      </div>
    </div>

    <!-- Right Side: Registration Form -->
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
          <h2 class="text-xl md:text-2xl font-semibold text-gray-800">Create Account</h2>
          <p class="text-gray-600 mt-2">Join our community today</p>
        </div>
        
        <form method="POST" action="{{ route('register') }}" class="space-y-6" id="registerForm">
          @csrf

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

          <!-- Name Fields -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label for="first_name" class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="fas fa-user mr-2 text-[#EF7C79]"></i>First Name
              </label>
              <input type="text" name="first_name" id="first_name" required
                value="{{ old('first_name') }}"
                class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-[#EF7C79] focus:border-[#EF7C79] text-base transition-all duration-200 bg-white"
                placeholder="First name" />
              @error('first_name')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label for="last_name" class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="fas fa-user mr-2 text-[#EF7C79]"></i>Last Name
              </label>
              <input type="text" name="last_name" id="last_name" required
                value="{{ old('last_name') }}"
                class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-[#EF7C79] focus:border-[#EF7C79] text-base transition-all duration-200 bg-white"
                placeholder="Last name" />
              @error('last_name')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <!-- Email Field -->
          <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
              <i class="fas fa-envelope mr-2 text-[#EF7C79]"></i>Email Address
            </label>
            <input type="email" name="email" id="email" required
              value="{{ old('email') }}"
              class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-[#EF7C79] focus:border-[#EF7C79] text-base transition-all duration-200 bg-white"
              placeholder="Enter your email address" />
            @error('email')
              <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
          </div>

          <!-- Phone Field -->
          <div>
            <label for="phone_number" class="block text-sm font-semibold text-gray-700 mb-2">
              <i class="fas fa-phone mr-2 text-[#EF7C79]"></i>Phone Number
            </label>
            <input type="tel" name="phone_number" id="phone" required
              value="{{ old('phone_number') }}"
              class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-[#EF7C79] focus:border-[#EF7C79] text-base transition-all duration-200 bg-white"
              placeholder="Enter phone number (10-11 digits)"
              maxlength="11"
              pattern="[0-9]{10,11}"
              title="Please enter a valid phone number (10-11 digits)"
              oninput="validatePhone(this)" />
            <p class="text-xs text-gray-500 mt-1 flex items-center">
              <i class="fas fa-info-circle mr-1 text-[#EF7C79]"></i>
              Enter 10-11 digit phone number
            </p>
            @error('phone_number')
              <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
          </div>

          <!-- Password Field -->
          <div>
            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
              <i class="fas fa-lock mr-2 text-[#EF7C79]"></i>Password
            </label>
            <input type="password" name="password" id="password" required
              class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-[#EF7C79] focus:border-[#EF7C79] text-base transition-all duration-200 bg-white"
              placeholder="Create a strong password" />
            @error('password')
              <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
          </div>

          <!-- Confirm Password Field -->
          <div>
            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
              <i class="fas fa-lock mr-2 text-[#EF7C79]"></i>Confirm Password
            </label>
            <input type="password" name="password_confirmation" id="password_confirmation" required
              class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-[#EF7C79] focus:border-[#EF7C79] text-base transition-all duration-200 bg-white"
              placeholder="Confirm your password" />
          </div>

          <!-- Register Button -->
          <button type="submit"
            class="w-full bg-gradient-to-r from-[#EF7C79] to-[#D76C69] hover:from-[#D76C69] hover:to-[#C55A57] text-white py-3 rounded-xl font-semibold text-base shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300">
            <i class="fas fa-user-plus mr-2"></i>Create Account
          </button>
        </form>

        <!-- Mobile: Sign In Link -->
        <div class="mt-8 text-center md:hidden">
          <p class="text-gray-600 text-sm mb-2">Already have an account?</p>
          <a href="{{ route('login') }}" class="inline-flex items-center text-[#EF7C79] hover:text-[#D76C69] font-semibold text-sm transition-colors">
            <i class="fas fa-sign-in-alt mr-2"></i>Sign In
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

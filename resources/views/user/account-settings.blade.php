<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Account Settings</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex h-screen bg-gray-100">

   <!-- Sidebar -->
  <aside class="w-64 bg-white shadow-md flex flex-col">
    <div class="p-6 text-2xl font-bold text-indigo-600">Customer Panel</div>
    <nav class="flex-1 px-4 space-y-2 text-sm text-gray-700">
      <!-- Menu -->
      <div>
        <p class="font-semibold text-gray-900">Home</p>
        <a href="{{ route('user.dashboard') }}" class="block pl-4 py-2 rounded hover:bg-indigo-100 font-semibold">Dashboard</a>
      </div>

      <div>
        <p class="mt-4 font-semibold text-gray-900">My Events</p>
        <a href="{{ route('user.bookedEvents') }}" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Booked Events</a>
        <a href="{{ route('user.attendingEvents') }}" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Attending Events</a>
        <a href="#" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Guest List</a>
      </div>

      <div>
        <p class="mt-4 font-semibold text-gray-900">Payment</p>
        <a href="{{ route('user.payments') }}" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Payments</a>
        <a href="{{ route('user.paymentHistory') }}" class="block pl-4 py-2 hover:bg-indigo-100 rounded">Payment History</a>
      </div>

      <div>
        <p class="mt-4 font-semibold text-gray-900">Settings</p>
        <a href="{{ route('user.accountSettings') }}" class="block pl-4 py-2 rounded bg-indigo-200 font-semibold text-indigo-800">Account Settings</a>
      </div>
    </nav>

    <div class="px-6 py-4 border-t">
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="block text-red-600 font-semibold hover:underline">
          Logout
        </button>
      </form>
    </div>
  </aside>


 <!-- Main Content -->
  <main class="flex-1 p-6 md:p-10 overflow-auto">
    <h1 class="text-3xl font-bold mb-8">Account Settings</h1>

    <div class="space-y-8">
      <!-- Update Profile Information Card -->
      <div class="bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-xl font-bold mb-4 text-gray-800">Profile Information</h2>
        <p class="mb-6 text-gray-600">Update your account's profile information and email address.</p>
        
        <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
          @csrf
          @method('patch')

          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
              <input id="first_name" name="first_name" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ old('first_name', $user->first_name) }}" required autofocus>
              @error('first_name')
                  <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
              @enderror
            </div>
            <div>
              <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
              <input id="last_name" name="last_name" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ old('last_name', $user->last_name) }}" required>
              @error('last_name')
                  <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <div>
            <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone Number</label>
            <input id="phone_number" name="phone_number" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ old('phone_number', $user->phone_number) }}">
            @error('phone_number')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input id="email" name="email" type="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ old('email', $user->email) }}" required>
            @error('email')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
            @enderror
          </div>
          
          <div class="flex items-center gap-4">
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white font-semibold rounded-md shadow-sm hover:bg-indigo-700">Save</button>
            @if (session('status') === 'profile-updated')
                <p class="text-sm text-green-600">Saved.</p>
            @endif
          </div>
        </form>
      </div>

      <!-- Update Password Card -->
      <div class="bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-xl font-bold mb-4 text-gray-800">Update Password</h2>
        <p class="mb-6 text-gray-600">Ensure your account is using a long, random password to stay secure.</p>

        <form method="post" action="{{ route('password.update') }}" class="space-y-6">
          @csrf
          @method('put')

          <div>
            <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
            <input id="current_password" name="current_password" type="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" autocomplete="current-password">
            @error('current_password', 'updatePassword')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
            <input id="password" name="password" type="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" autocomplete="new-password">
            @error('password', 'updatePassword')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
            <input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" autocomplete="new-password">
            @error('password_confirmation', 'updatePassword')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
            @enderror
          </div>

          <div class="flex items-center gap-4">
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white font-semibold rounded-md shadow-sm hover:bg-indigo-700">Save</button>
            @if (session('status') === 'password-updated')
                <p class="text-sm text-green-600">Saved.</p>
            @endif
          </div>
        </form>
      </div>
    </div>
  </main>
</body>
</html>
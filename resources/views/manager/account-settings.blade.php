<x-manager-layout title="Account Settings" :active-page="'account-settings'">
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
                        <input id="first_name" name="first_name" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('first_name', $user->first_name) }}" required autofocus>
                        @error('first_name')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                        <input id="last_name" name="last_name" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('last_name', $user->last_name) }}" required>
                        @error('last_name')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone Number</label>
                    <input id="phone_number" name="phone_number" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('phone_number', $user->phone_number) }}">
                    @error('phone_number')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input id="email" name="email" type="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="flex items-center gap-4">
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white font-semibold rounded-md shadow-sm hover:bg-indigo-700 transition-colors">
                        Save Changes
                    </button>
                    @if (session('status') === 'profile-updated')
                        <p class="text-sm text-green-600">Profile updated successfully.</p>
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
                    <input id="current_password" name="current_password" type="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" autocomplete="current-password">
                    @error('current_password', 'updatePassword')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                    <input id="password" name="password" type="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" autocomplete="new-password">
                    @error('password', 'updatePassword')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" autocomplete="new-password">
                    @error('password_confirmation', 'updatePassword')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-4">
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white font-semibold rounded-md shadow-sm hover:bg-indigo-700 transition-colors">
                        Update Password
                    </button>
                    @if (session('status') === 'password-updated')
                        <p class="text-sm text-green-600">Password updated successfully.</p>
                    @endif
                </div>
            </form>
        </div>

        <!-- Danger Zone Card -->
        <div class="bg-white p-8 rounded-lg shadow-md border border-red-200">
            <h2 class="text-xl font-bold mb-4 text-red-800">Danger Zone</h2>
            <p class="mb-6 text-gray-600">Permanent and destructive actions for your account.</p>

            <div class="space-y-4">
                <div class="flex items-center justify-between p-4 border border-red-200 rounded-lg bg-red-50">
                    <div>
                        <h3 class="font-medium text-red-900">Delete Account</h3>
                        <p class="text-sm text-red-700">Permanently delete your account and all associated data</p>
                    </div>
                    <button class="px-4 py-2 bg-red-600 text-white font-medium rounded-md hover:bg-red-700 transition-colors">
                        Delete Account
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-manager-layout> 
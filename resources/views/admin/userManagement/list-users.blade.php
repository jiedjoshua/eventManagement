<x-admin-layout title="User Management" active-page="{{ request('action') === 'create' ? 'create-user' : 'users' }}">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">User Management</h1>
                <p class="text-gray-600 mt-1">Manage all users in the system</p>
            </div>

            <!-- Stats Cards -->
            <div class="flex gap-4">
                <div class="bg-white px-4 py-3 rounded-lg shadow-sm border border-gray-200">
                    <div class="text-2xl font-bold text-indigo-600">{{ $users->total() }}</div>
                    <div class="text-sm text-gray-600">Total Users</div>
                </div>
                <div class="bg-white px-4 py-3 rounded-lg shadow-sm border border-gray-200">
                    <div class="text-2xl font-bold text-green-600">{{ $users->where('role', 'regular_user')->count() }}</div>
                    <div class="text-sm text-gray-600">Customers</div>
                </div>
                <div class="bg-white px-4 py-3 rounded-lg shadow-sm border border-gray-200">
                    <div class="text-2xl font-bold text-blue-600">{{ $users->where('role', 'event_manager')->count() }}</div>
                    <div class="text-sm text-gray-600">Event Managers</div>
                </div>
                <div class="bg-white px-4 py-3 rounded-lg shadow-sm border border-gray-200">
                    <div class="text-2xl font-bold text-red-600">{{ $users->where('role', 'super_admin')->count() }}</div>
                    <div class="text-sm text-gray-600">Admins</div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-between items-center mb-6">
            <div class="flex gap-3">
                <button onclick="createUser()"
                    class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition-colors font-medium">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add New User
                </button>
            </div>

            <!-- Search and Filter -->
            <div class="flex gap-4">
                <div class="relative">
                    <input type="text" id="searchInput" placeholder="Search users..."
                        class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <svg class="w-5 h-5 absolute left-3 top-2.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <select id="roleFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">All Roles</option>
                    <option value="regular_user">Customers</option>
                    <option value="event_manager">Event Managers</option>
                    <option value="super_admin">Admins</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            User
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Role
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Contact
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Joined
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                        <span class="text-indigo-600 font-semibold text-sm">
                                            {{ strtoupper(substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1)) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $user->first_name }} {{ $user->last_name }}
                                    </div>
                                    <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($user->role === 'super_admin')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                Admin
                            </span>
                            @elseif($user->role === 'event_manager')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                Event Manager
                            </span>
                            @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Customer
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <div>{{ $user->phone_number ?? 'N/A' }}</div>
                            <div class="text-gray-500">{{ $user->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $user->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex gap-2">
                                <button onclick="viewUser('{{ $user->id }}', '{{ $user->first_name }}', '{{ $user->last_name }}', '{{ $user->email }}', '{{ $user->phone_number }}', '{{ $user->role }}', '{{ $user->created_at->format('M d, Y') }}')"
                                    class="text-indigo-600 hover:text-indigo-900">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                                <button onclick="editUser('{{ $user->id }}', '{{ $user->first_name }}', '{{ $user->last_name }}', '{{ $user->email }}', '{{ $user->phone_number }}', '{{ $user->role }}')"
                                    class="text-yellow-600 hover:text-yellow-900">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                                @if($user->id !== auth()->id())
                                <button onclick="deleteUser('{{ $user->id }}', '{{ $user->first_name }} {{ $user->last_name }}')"
                                    class="text-red-600 hover:text-red-900">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            No users found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($users->hasPages())
    <div class="mt-6 flex justify-center">
        <div class="bg-white px-4 py-3 rounded-lg shadow-sm border border-gray-200">
            {{ $users->appends(request()->query())->links() }}
        </div>
    </div>
    @endif

    @push('modals')
        <!-- Modals -->
  <!-- Create User Modal -->
  <div id="createUserModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-1/2 lg:w-2/3 shadow-lg rounded-md bg-white">
      <div class="flex justify-between items-center mb-4">
        <h3 class="text-xl font-bold text-gray-900">Create New User</h3>
        <button onclick="closeCreateModal()" class="text-gray-500 hover:text-gray-700">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
      </div>

      <form id="createUserForm" method="POST" class="space-y-4">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label for="createFirstName" class="block text-sm font-medium text-gray-700">First Name *</label>
            <input type="text" id="createFirstName" name="first_name" required
              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            <div id="createFirstNameError" class="text-red-500 text-sm mt-1 hidden"></div>
          </div>

          <div>
            <label for="createLastName" class="block text-sm font-medium text-gray-700">Last Name *</label>
            <input type="text" id="createLastName" name="last_name" required
              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            <div id="createLastNameError" class="text-red-500 text-sm mt-1 hidden"></div>
          </div>

          <div>
            <label for="createEmail" class="block text-sm font-medium text-gray-700">Email Address *</label>
            <input type="email" id="createEmail" name="email" required
              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            <div id="createEmailError" class="text-red-500 text-sm mt-1 hidden"></div>
          </div>

          <div>
            <label for="createPhone" class="block text-sm font-medium text-gray-700">Phone Number</label>
            <input type="tel" id="createPhone" name="phone_number"
              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            <div id="createPhoneError" class="text-red-500 text-sm mt-1 hidden"></div>
          </div>

          <div>
            <label for="createRole" class="block text-sm font-medium text-gray-700">Role *</label>
            <select id="createRole" name="role" required
              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
              <option value="">Select a role</option>
              <option value="regular_user">Customer</option>
              <option value="event_manager">Event Manager</option>
              <option value="super_admin">Admin</option>
            </select>
            <div id="createRoleError" class="text-red-500 text-sm mt-1 hidden"></div>
          </div>

          <div class="md:col-span-2">
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
              <div class="flex">
                <svg class="w-5 h-5 text-blue-400 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
                <div>
                  <h4 class="text-sm font-medium text-blue-800">Temporary Password</h4>
                  <p class="text-sm text-blue-700 mt-1">A secure temporary password will be automatically generated and sent to the user's email address.</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="flex gap-3 pt-4">
          <button type="button" onclick="closeCreateModal()"
            class="flex-1 bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition-colors font-medium">
            Cancel
          </button>
          <button type="submit"
            class="flex-1 bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition-colors font-medium">
            Create User
          </button>
        </div>
      </form> 
    </div>
  </div>

  <!-- View User Modal -->
  <div id="viewUserModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-1/2 lg:w-1/3 shadow-lg rounded-md bg-white">
      <div class="flex justify-between items-center mb-4">
        <h3 class="text-xl font-bold text-gray-900">User Details</h3>
        <button onclick="closeViewModal()" class="text-gray-500 hover:text-gray-700">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
      </div>

      <div class="space-y-4">
        <div class="flex items-center space-x-4">
          <div class="h-16 w-16 rounded-full bg-indigo-100 flex items-center justify-center">
            <span class="text-indigo-600 font-semibold text-lg" id="viewUserInitials"></span>
          </div>
          <div>
            <h4 class="text-lg font-semibold text-gray-900" id="viewUserName"></h4>
            <p class="text-gray-600" id="viewUserEmail"></p>
          </div>
        </div>

        <div class="grid grid-cols-1 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">Full Name</label>
            <p class="mt-1 text-sm text-gray-900" id="viewUserFullName"></p>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700">Email Address</label>
            <p class="mt-1 text-sm text-gray-900" id="viewUserEmailDetail"></p>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700">Phone Number</label>
            <p class="mt-1 text-sm text-gray-900" id="viewUserPhone"></p>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700">Role</label>
            <p class="mt-1 text-sm text-gray-900" id="viewUserRole"></p>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700">Member Since</label>
            <p class="mt-1 text-sm text-gray-900" id="viewUserJoined"></p>
          </div>
        </div>
      </div>

      <div class="flex gap-3 pt-6">
        <button onclick="closeViewModal()"
          class="flex-1 bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition-colors font-medium">
          Close
        </button>
      </div>
    </div>
  </div>

  <!-- Edit User Modal -->
  <div id="editUserModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-1/2 lg:w-2/3 shadow-lg rounded-md bg-white">
      <div class="flex justify-between items-center mb-4">
        <h3 class="text-xl font-bold text-gray-900">Edit User</h3>
        <button onclick="closeEditModal()" class="text-gray-500 hover:text-gray-700">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
      </div>

      <form id="editUserForm" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label for="editFirstName" class="block text-sm font-medium text-gray-700">First Name</label>
            <input type="text" id="editFirstName" name="first_name" required
              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
          </div>

          <div>
            <label for="editLastName" class="block text-sm font-medium text-gray-700">Last Name</label>
            <input type="text" id="editLastName" name="last_name" required
              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
          </div>

          <div>
            <label for="editEmail" class="block text-sm font-medium text-gray-700">Email Address</label>
            <input type="email" id="editEmail" name="email" required
              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
          </div>

          <div>
            <label for="editPhone" class="block text-sm font-medium text-gray-700">Phone Number</label>
            <input type="tel" id="editPhone" name="phone_number"
              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
          </div>

          <div>
            <label for="editRole" class="block text-sm font-medium text-gray-700">Role</label>
            <select id="editRole" name="role" required
              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
              <option value="regular_user">Customer</option>
              <option value="event_manager">Event Manager</option>
              <option value="super_admin">Admin</option>
            </select>
          </div>
        </div>

        <div class="flex gap-3 pt-4">
          <button type="button" onclick="closeEditModal()"
            class="flex-1 bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition-colors font-medium">
            Cancel
          </button>
          <button type="submit"
            class="flex-1 bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition-colors font-medium">
            Update User
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Delete User Modal -->
  <div id="deleteUserModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-1/2 lg:w-1/3 shadow-lg rounded-md bg-white">
      <div class="flex justify-between items-center mb-4">
        <h3 class="text-xl font-bold text-gray-900">Delete User</h3>
        <button onclick="closeDeleteModal()" class="text-gray-500 hover:text-gray-700">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
      </div>

      <div class="mb-6">
        <p class="text-gray-700 mb-4">Are you sure you want to delete this user?</p>
        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
          <div class="flex">
            <svg class="w-5 h-5 text-red-400 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
            </svg>
            <div>
              <h4 class="text-sm font-medium text-red-800">User to Delete:</h4>
              <p class="text-sm text-red-700 mt-1" id="deleteUserName"></p>
            </div>
          </div>
        </div>
      </div>

      <form id="deleteUserForm" method="POST" class="space-y-4">
        @csrf
        @method('DELETE')

        <div class="flex gap-3 pt-4">
          <button type="button" onclick="closeDeleteModal()"
            class="flex-1 bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition-colors font-medium">
            Cancel
          </button>
          <button type="submit"
            class="flex-1 bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors font-medium">
            Delete User
          </button>
        </div>
      </form>
    </div>
  </div>

 

    @endpush

    @push('notifications')
       <!-- Notifications -->
  <div id="successNotification" class="hidden fixed top-4 right-4 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg transform transition-transform duration-300 ease-in-out">
    <div class="flex items-center space-x-2">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
      </svg>
      <span id="notificationMessage"></span>
    </div>
  </div>

  <div id="errorNotification" class="hidden fixed top-4 right-4 bg-red-500 text-white px-6 py-4 rounded-lg shadow-lg transform transition-transform duration-300 ease-in-out">
    <div class="flex items-center space-x-2">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
      </svg>
      <span id="errorMessage"></span>
    </div>
  </div>
    @endpush

    @push('scripts')
    <script>
          // Notification functions
    function showNotification(message) {
      const notification = document.getElementById('successNotification');
      const messageElement = document.getElementById('notificationMessage');
      messageElement.textContent = message;

      notification.classList.remove('hidden');
      notification.classList.add('transform', 'translate-y-0');

      setTimeout(() => {
        notification.classList.add('transform', '-translate-y-full');
        setTimeout(() => {
          notification.classList.add('hidden');
        }, 300);
      }, 3500);
    }

    function showErrorNotification(message) {
      const notification = document.getElementById('errorNotification');
      const messageElement = document.getElementById('errorMessage');
      messageElement.textContent = message;

      notification.classList.remove('hidden');
      notification.classList.add('transform', 'translate-y-0');

      setTimeout(() => {
        notification.classList.add('transform', '-translate-y-full');
        setTimeout(() => {
          notification.classList.add('hidden');
        }, 300);
      }, 3500);
    }

    // User management functions
    function createUser() {
            const modal = document.getElementById('createUserModal');
            const form = document.getElementById('createUserForm');
            
            // Reset form
            form.reset();
            clearCreateFormErrors();
            
            // Set form action
            form.action = '{{ route("admin.users.store") }}';
            
            modal.classList.remove('hidden');
        }

    function viewUser(userId, firstName, lastName, email, phone, role, joined) {
            const modal = document.getElementById('viewUserModal');
            
            // Set user data in modal
            document.getElementById('viewUserInitials').textContent = (firstName.charAt(0) + lastName.charAt(0)).toUpperCase();
            document.getElementById('viewUserName').textContent = firstName + ' ' + lastName;
            document.getElementById('viewUserEmail').textContent = email;
            document.getElementById('viewUserFullName').textContent = firstName + ' ' + lastName;
            document.getElementById('viewUserEmailDetail').textContent = email;
            document.getElementById('viewUserPhone').textContent = phone || 'N/A';
            document.getElementById('viewUserRole').textContent = getRoleDisplayName(role);
            document.getElementById('viewUserJoined').textContent = joined;
            
            modal.classList.remove('hidden');
        }

    function editUser(userId, firstName, lastName, email, phone, role) {
            const modal = document.getElementById('editUserModal');
            const form = document.getElementById('editUserForm');
            
            // Set form action
            form.action = '{{ route("admin.users.update", ":id") }}'.replace(':id', userId);
            
            // Populate form fields
            document.getElementById('editFirstName').value = firstName;
            document.getElementById('editLastName').value = lastName;
            document.getElementById('editEmail').value = email;
            document.getElementById('editPhone').value = phone || '';
            document.getElementById('editRole').value = role;
            
            modal.classList.remove('hidden');
        }
    
        function deleteUser(userId, userName) {
            const modal = document.getElementById('deleteUserModal');
            const form = document.getElementById('deleteUserForm');
            const userNameElement = document.getElementById('deleteUserName');
            
            if (!modal || !form || !userNameElement) {
                showErrorNotification('Modal elements not found!');
                return;
            }
            
            userNameElement.textContent = userName;
            form.action = '{{ route("admin.users.destroy", ":id") }}'.replace(':id', userId);
            modal.classList.remove('hidden');
        }

    function closeCreateModal() {
      const modal = document.getElementById('createUserModal');
      if (modal) {
        modal.classList.add('hidden');
        clearCreateFormErrors();
      }
    }

    function closeViewModal() {
      const modal = document.getElementById('viewUserModal');
      if (modal) {
        modal.classList.add('hidden');
      }
    }

    function closeEditModal() {
      const modal = document.getElementById('editUserModal');
      if (modal) {
        modal.classList.add('hidden');
      }
    }

    function closeDeleteModal() {
      const modal = document.getElementById('deleteUserModal');
      if (modal) {
        modal.classList.add('hidden');
      }
    }

    function clearCreateFormErrors() {
      const errorElements = [
        'createFirstNameError',
        'createLastNameError',
        'createEmailError',
        'createPhoneError',
        'createRoleError',
        'createPasswordError',
        'createPasswordConfirmationError'
      ];

      errorElements.forEach(id => {
        const element = document.getElementById(id);
        if (element) {
          element.classList.add('hidden');
          element.textContent = '';
        }
      });
    }

    function getRoleDisplayName(role) {
      switch (role) {
        case 'super_admin':
          return 'Admin';
        case 'event_manager':
          return 'Event Manager';
        case 'regular_user':
          return 'Customer';
        default:
          return role;
      }
    }

    // Search and filter functionality
    document.getElementById('searchInput').addEventListener('input', function() {
      const searchTerm = this.value.toLowerCase();
      const rows = document.querySelectorAll('tbody tr');

      rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
      });
    });

    document.getElementById('roleFilter').addEventListener('change', function() {
      const selectedRole = this.value;
      const rows = document.querySelectorAll('tbody tr');

      rows.forEach(row => {
        if (!selectedRole) {
          row.style.display = '';
          return;
        }

        // Get the role span element within the role cell
        const roleCell = row.querySelector('td:nth-child(2)');
        if (roleCell) {
          const roleSpan = roleCell.querySelector('span');
          if (roleSpan) {
            const roleText = roleSpan.textContent.trim();
            const displayName = getRoleDisplayName(selectedRole);
            row.style.display = roleText === displayName ? '' : 'none';
          }
        }
      });
    });

    // Handle create form submission
    document.getElementById('createUserForm').addEventListener('submit', function(e) {
      e.preventDefault();

      const formData = new FormData(this);
      const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
        document.querySelector('input[name="_token"]')?.value;

      if (!csrfToken) {
        showErrorNotification('CSRF token not found. Please refresh the page.');
        return;
      }

      // Clear previous errors
      clearCreateFormErrors();

      fetch(this.action, {
          method: 'POST',
          body: formData,
          headers: {
            'X-CSRF-TOKEN': csrfToken
          }
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            showNotification(data.message || 'User created successfully!');
            closeCreateModal();
            setTimeout(() => {
              window.location.reload();
            }, 1500);
          } else {
            if (data.errors) {
              // Display validation errors
              Object.keys(data.errors).forEach(field => {
                const errorElement = document.getElementById(`create${field.charAt(0).toUpperCase() + field.slice(1)}Error`);
                if (errorElement) {
                  errorElement.textContent = data.errors[field][0];
                  errorElement.classList.remove('hidden');
                }
              });
            } else {
              showErrorNotification(data.message || 'Failed to create user.');
            }
          }
        })
        .catch(error => {
          console.error('Error creating user:', error);
          showErrorNotification('An error occurred while creating the user.');
        });
    });

    // Handle edit form submission
    document.getElementById('editUserForm').addEventListener('submit', function(e) {
      e.preventDefault();

      const formData = new FormData(this);
      const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
        document.querySelector('input[name="_token"]')?.value;

      if (!csrfToken) {
        showErrorNotification('CSRF token not found. Please refresh the page.');
        return;
      }

      fetch(this.action, {
          method: 'POST',
          body: formData,
          headers: {
            'X-CSRF-TOKEN': csrfToken
          }
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            showNotification(data.message || 'User updated successfully!');
            closeEditModal();
            setTimeout(() => {
              window.location.reload();
            }, 1500);
          } else {
            showErrorNotification(data.message || 'Failed to update user.');
          }
        })
        .catch(error => {
          console.error('Error updating user:', error);
          showErrorNotification('An error occurred while updating the user.');
        });
    });

    // Handle delete form submission
    document.getElementById('deleteUserForm').addEventListener('submit', function(e) {
      e.preventDefault();

      const formData = new FormData(this);
      const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
        document.querySelector('input[name="_token"]')?.value;

      if (!csrfToken) {
        showErrorNotification('CSRF token not found. Please refresh the page.');
        return;
      }

      fetch(this.action, {
          method: 'POST',
          body: formData,
          headers: {
            'X-CSRF-TOKEN': csrfToken
          }
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            showNotification(data.message || 'User deleted successfully!');
            closeDeleteModal();
            setTimeout(() => {
              window.location.reload();
            }, 1500);
          } else {
            showErrorNotification(data.message || 'Failed to delete user.');
          }
        })
        .catch(error => {
          console.error('Error deleting user:', error);
          showErrorNotification('An error occurred while deleting the user.');
        });
    });

    // Show session messages
    @if(session('error'))
    showErrorNotification("{{ session('error') }}");
    @endif

    @if(session('success'))
    showNotification("{{ session('success') }}");
    @endif

    document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const action = urlParams.get('action');
    
    if (action === 'create') {
        // Small delay to ensure page is fully loaded
        setTimeout(() => {
            createUser();
        }, 100);
    }
});
    </script>
    @endpush
</x-admin-layout>
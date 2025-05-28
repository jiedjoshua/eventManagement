<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>List Users - Super Admin Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    /* Sidebar fixed height and scroll */
    #sidebar {
      height: 100vh;
      overflow-y: auto;
    }
    /* Active link style */
    .active {
      background-color: #4f46e5; /* Indigo-600 */
      color: white;
    }
  </style>
</head>
<body class="bg-gray-100 font-sans">

  <div class="flex h-screen">

    <!-- Sidebar -->
    <aside id="sidebar" class="w-64 bg-white shadow-lg flex flex-col">

      <div class="p-6 text-2xl font-bold text-indigo-600 border-b border-gray-200">
        EventAdmin
      </div>

      <nav class="flex-1 overflow-y-auto mt-6">
        <ul class="space-y-1 px-4">

          <li>
            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 rounded-md hover:bg-indigo-50 hover:text-indigo-700 active">
              User Management
            </a>
            <ul class="pl-6 mt-1 space-y-1 text-gray-600 text-sm">
              <li><a href="{{ route('admin.listusers') }}" class="hover:text-indigo-600">List Users</a></li>
                <a href="{{ route('admin.listusers') }}?openModal=addUser" class="hover:text-indigo-600">Create User</a>
              <li><a href="#" class="hover:text-indigo-600">Activity Logs</a></li>
            </ul>
          </li>

          <li>
            <a href="#" class="block px-4 py-2 rounded-md hover:bg-indigo-50 hover:text-indigo-700">
              Event Management Overview
            </a>
            <ul class="pl-6 mt-1 space-y-1 text-gray-600 text-sm">
              <li><a href="#" class="hover:text-indigo-600">List Events</a></li>
              <li><a href="#" class="hover:text-indigo-600">Create Event</a></li>
              <li><a href="#" class="hover:text-indigo-600">Event Status</a></li>
              <li><a href="#" class="hover:text-indigo-600">Event Statistics</a></li>
            </ul>
          </li>

          <li>
            <a href="#" class="block px-4 py-2 rounded-md hover:bg-indigo-50 hover:text-indigo-700">
              Company Settings
            </a>
            <ul class="pl-6 mt-1 space-y-1 text-gray-600 text-sm">
              <li><a href="#" class="hover:text-indigo-600">Manage Details</a></li>
              <li><a href="#" class="hover:text-indigo-600">Branding Settings</a></li>
            </ul>
          </li>

          <li>
            <a href="#" class="block px-4 py-2 rounded-md hover:bg-indigo-50 hover:text-indigo-700">
              Role & Permission Management
            </a>
            <ul class="pl-6 mt-1 space-y-1 text-gray-600 text-sm">
              <li><a href="#" class="hover:text-indigo-600">Define Roles</a></li>
              <li><a href="#" class="hover:text-indigo-600">Modify Permissions</a></li>
              <li><a href="#" class="hover:text-indigo-600">Permission Audit Logs</a></li>
            </ul>
          </li>

          <li>
            <a href="#" class="block px-4 py-2 rounded-md hover:bg-indigo-50 hover:text-indigo-700">
              System Analytics & Reports
            </a>
            <ul class="pl-6 mt-1 space-y-1 text-gray-600 text-sm">
              <li><a href="#" class="hover:text-indigo-600">Dashboard Stats</a></li>
              <li><a href="#" class="hover:text-indigo-600">Export Reports</a></li>
            </ul>
          </li>

          <li>
            <a href="#" class="block px-4 py-2 rounded-md hover:bg-indigo-50 hover:text-indigo-700">
              Notifications & Alerts
            </a>
            <ul class="pl-6 mt-1 space-y-1 text-gray-600 text-sm">
              <li><a href="#" class="hover:text-indigo-600">Pending Approvals</a></li>
              <li><a href="#" class="hover:text-indigo-600">Manage Notifications</a></li>
            </ul>
          </li>

          <li>
            <a href="#" class="block px-4 py-2 rounded-md hover:bg-indigo-50 hover:text-indigo-700">
              Audit Logs
            </a>
            <ul class="pl-6 mt-1 space-y-1 text-gray-600 text-sm">
              <li><a href="#" class="hover:text-indigo-600">User & Event Changes</a></li>
              <li><a href="#" class="hover:text-indigo-600">Login History</a></li>
            </ul>
          </li>

          <li>
            <a href="#" class="block px-4 py-2 rounded-md hover:bg-indigo-50 hover:text-indigo-700">
              Support & Feedback
            </a>
            <ul class="pl-6 mt-1 space-y-1 text-gray-600 text-sm">
              <li><a href="#" class="hover:text-indigo-600">View Feedback</a></li>
              <li><a href="#" class="hover:text-indigo-600">Manage Tickets</a></li>
            </ul>
          </li>

        </ul>
      </nav>

    </aside>

    <!-- Main content wrapper -->
    <div class="flex-1 flex flex-col min-h-screen">

      <!-- Topbar -->
      <header class="flex justify-between items-center bg-white shadow px-6 py-4">
        <h1 class="text-xl font-semibold text-gray-700">User Management &raquo; List Users</h1>

        <div class="flex items-center space-x-4">
          <span class="text-gray-600">Hello, <strong>Super Admin</strong></span>
          <form action="{{ route('logout') }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="bg-indigo-600 text-white px-3 py-1 rounded hover:bg-indigo-700">
              Logout
            </button>
          </form>
        </div>
      </header>

    <!-- Content -->
    <main class="flex-1 p-6">
      <div class="bg-white rounded-lg shadow p-6 overflow-auto">
        <div class="flex justify-between items-center mb-4">
          <h2 class="text-lg font-semibold text-gray-700">List of Registered Users</h2>
          <!-- Changed from link to button to open modal -->
          <button 
            onclick="openAddModal()" 
            class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700"
          >
            + Add User
          </button>
        </div>

        <table class="w-full text-left border-collapse">
          <thead>
            <tr class="bg-gray-100 border-b">
              <th class="py-2 px-4">No.</th>
              <th class="py-2 px-4">First Name</th>
              <th class="py-2 px-4">Last Name</th>
              <th class="py-2 px-4">Phone Number</th>
              <th class="py-2 px-4">Email</th>
              <th class="py-2 px-4">Role</th>
              <th class="py-2 px-4">Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($users as $user)
            <tr class="border-b hover:bg-indigo-50">
             <td style="text-align: center;">{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</td>
              <td class="py-2 px-4">{{ $user->first_name }}</td>
              <td class="py-2 px-4">{{ $user->last_name }}</td>
              <td class="py-2 px-4">{{ $user->phone_number }}</td>
              <td class="py-2 px-4">{{ $user->email }}</td>
              <td class="py-2 px-4">{{ $user->role ?? 'N/A' }}</td>
              <td class="py-2 px-4 space-x-2">
                <!-- Edit button triggers modal -->
                <button 
                  class="text-blue-600 hover:underline"
                  onclick='openEditModal(@json($user))'
                >
                  Edit
                </button>

                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Delete this user?')">Delete</button>
                </form>
              </td>
            </tr>
            @endforeach

            @if($users->isEmpty())
            <tr>
              <td colspan="7" class="py-4 text-center text-gray-500">No users found.</td>
            </tr>
            @endif
          </tbody>
        </table>
      </div>
    </main>
  </div>

  <!-- Add User Modal -->
<div id="addUserModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
  <div class="bg-white rounded-lg p-6 w-96 shadow-lg relative">
    <h3 class="text-lg font-semibold mb-4">Add New User</h3>

    <form id="addUserForm" method="POST" action="{{ route('admin.store') }}">
      @csrf

      <label class="block mb-1 font-medium" for="addFirstName">First Name</label>
      <input id="addFirstName" name="first_name" type="text" class="border p-2 mb-3 w-full" required />

      <label class="block mb-1 font-medium" for="addLastName">Last Name</label>
      <input id="addLastName" name="last_name" type="text" class="border p-2 mb-3 w-full" required />

      <label class="block mb-1 font-medium" for="addPhone">Phone Number</label>
      <input id="addPhone" name="phone_number" type="text" class="border p-2 mb-3 w-full" />

      <label class="block mb-1 font-medium" for="addEmail">Email</label>
      <input id="addEmail" name="email" type="email" class="border p-2 mb-3 w-full" required />

      <label class="block mb-1 font-medium" for="addRole">Role</label>
      <select id="addRole" name="role" class="border p-2 mb-3 w-full" required>
        <option value="regular_user">User</option>
        <option value="event_manager">Event Manager</option>
        <option value="super_admin">Super Admin</option>
      </select>

    <label class="block mb-1 font-medium" for="tempPassword">Temporary Password</label>
<div class="flex space-x-2 mb-4">
    <input
        id="tempPassword"
        name="password"
        type="text"
        readonly
        class="border p-2 flex-grow"
        placeholder="Generate password"
        required
    />
    <button type="button" onclick="generateAndShowPassword()" class="bg-indigo-600 text-white px-4 rounded hover:bg-indigo-700">
        Generate
    </button>
</div>

<!-- Update password confirmation input to match Laravel's validation -->
<input type="hidden" name="password_confirmation" id="passwordConfirmation" />



      <div class="flex justify-end space-x-2">
        <button type="button" onclick="closeAddModal()" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Add User</button>
      </div>
    </form>

    <button onclick="closeAddModal()" class="absolute top-2 right-2 text-gray-600 hover:text-gray-900 text-2xl font-bold">&times;</button>
  </div>
</div>

  <!-- Edit User Modal -->
  <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg p-6 w-96 shadow-lg relative">
      <h3 class="text-lg font-semibold mb-4">Edit User</h3>

      <form id="editUserForm" method="POST" action="">
        @csrf
        @method('PUT')

        <input type="hidden" name="user_id" id="editUserId" />

        <label class="block mb-1 font-medium" for="editFirstName">First Name</label>
        <input id="editFirstName" name="first_name" type="text" class="border p-2 mb-3 w-full" required />

        <label class="block mb-1 font-medium" for="editLastName">Last Name</label>
        <input id="editLastName" name="last_name" type="text" class="border p-2 mb-3 w-full" required />

        <label class="block mb-1 font-medium" for="editPhone">Phone Number</label>
        <input id="editPhone" name="phone_number" type="text" class="border p-2 mb-3 w-full" />

        <label class="block mb-1 font-medium" for="editEmail">Email</label>
        <input id="editEmail" name="email" type="email" class="border p-2 mb-4 w-full" required />

        <label class="block mb-1 font-medium" for="editRole">Role</label>
        <select id="editRole" name="role" class="border p-2 mb-4 w-full" required>
          <option value="regular_user">User</option>
          <option value="event_manager">Event Manager</option>
          <option value="super_admin">Super Admin</option>
        </select>

        <div class="flex justify-end space-x-2">
          <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
          <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Save</button>
        </div>
      </form>

      <button onclick="closeModal()" class="absolute top-2 right-2 text-gray-600 hover:text-gray-900 text-2xl font-bold">&times;</button>
    </div>
  </div>

  <script>
    function openAddModal() {
  document.getElementById('addUserModal').classList.remove('hidden');
  // Reset form
  document.getElementById('addUserForm').reset();
  // Clear password input (adjust if needed)
  document.getElementById('tempPassword').value = '';
}

function closeAddModal() {
  document.getElementById('addUserModal').classList.add('hidden');
}


    // Open Edit User modal with user data filled in
    function openEditModal(user) {
      document.getElementById('editModal').classList.remove('hidden');
      document.getElementById('editUserId').value = user.id;
      document.getElementById('editFirstName').value = user.first_name;
      document.getElementById('editLastName').value = user.last_name;
      document.getElementById('editPhone').value = user.phone_number || '';
      document.getElementById('editEmail').value = user.email;
      document.getElementById('editRole').value = user.role || 'user';

      // Set form action dynamically to the update route
      const form = document.getElementById('editUserForm');
      form.action = `/users/${user.id}`;
    }

    // Close Edit User modal
    function closeModal() {
      document.getElementById('editModal').classList.add('hidden');
    }


    function generateAndShowPassword() {
  const password = Math.random().toString(36).slice(-10);
  document.getElementById('tempPassword').value = password;
  document.getElementById('passwordConfirmation').value = password;
}




    // Attach event to generate password button
    document.getElementById('generateTempPassBtn').addEventListener('click', () => {
      const password = generateTempPassword();
      const display = document.getElementById('tempPasswordDisplay');
      const hiddenInput = document.getElementById('tempPasswordHidden');

      display.style.display = 'block';
      display.value = password;
      hiddenInput.value = password;
    });

    // Close modals when clicking outside modal content
    window.addEventListener('click', (e) => {
      const addModal = document.getElementById('addModal');
      const editModal = document.getElementById('editModal');

      if (!addModal.classList.contains('hidden') && !addModal.querySelector('.bg-white').contains(e.target)) {
        closeAddModal();
      }
      if (!editModal.classList.contains('hidden') && !editModal.querySelector('.bg-white').contains(e.target)) {
        closeModal();
      }
    });

    

    
  </script>
@if(session('status'))
<div id="toast" class="fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded shadow-lg z-50">
  {{ session('status') }}
</div>

<script>
  setTimeout(() => {
    const toast = document.getElementById('toast');
    if (toast) toast.remove();
  }, 3000);
</script>
@endif

<script>
  // Check for query parameter ?openModal=addUser
  window.addEventListener('DOMContentLoaded', () => {
    const urlParams = new URLSearchParams(window.location.search);
    const openModal = urlParams.get('openModal');

    if (openModal === 'addUser') {
      openAddModal();
    }
  });

  // Your existing modal open function
  function openAddModal() {
    document.getElementById('addUserModal').classList.remove('hidden');
  }

  function closeAddModal() {
    document.getElementById('addUserModal').classList.add('hidden');
  }
</script>



</body>
</html>

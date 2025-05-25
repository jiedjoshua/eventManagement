<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Super Admin Dashboard - Event Management</title>
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
            <a href="#" class="block px-4 py-2 rounded-md hover:bg-indigo-50 hover:text-indigo-700 active">
              User Management
            </a>
            <ul class="pl-6 mt-1 space-y-1 text-gray-600 text-sm">
              <li><a href="{{ route('admin.listusers') }}" class="hover:text-indigo-600">List Users</a></li>
              <li><a href="#" class="hover:text-indigo-600">Create User</a></li>
              <li><a href="#" class="hover:text-indigo-600">Assign Roles</a></li>
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

    <!-- Main content -->
    <div class="flex-1 flex flex-col">

      <!-- Topbar -->
      <header class="flex justify-between items-center bg-white shadow px-6 py-4">
        <h1 class="text-xl font-semibold text-gray-700">Super Admin Dashboard</h1>

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

      <!-- Content area -->
      <main class="flex-1 overflow-y-auto p-6">
        <section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

          <!-- Total Users Widget -->
          <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold mb-4">Total Users</h2>
            <p class="text-4xl font-bold text-indigo-600">{{ $totalUsers }}</p>
          </div>

          <!-- Active Events Widget -->
          <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold mb-4">Active Events</h2>
            <p class="text-4xl font-bold text-indigo-600">56</p>
          </div>

          <!-- Revenue Widget -->
          <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold mb-4">Earnings (This Month)</h2>
            <p class="text-4xl font-bold text-indigo-600">$42,500</p>
          </div>

        </section>

        <section class="grid grid-cols-1 md:grid-cols-2 gap-6">

          <!-- Latest User Activity -->
          <div class="bg-white rounded-lg shadow p-6 overflow-auto max-h-96">
            <h2 class="text-lg font-semibold mb-4">Latest User Activity</h2>
            <table class="w-full text-left border-collapse">
              <thead>
                <tr class="border-b">
                  <th class="py-2 px-3">User</th>
                  <th class="py-2 px-3">Activity</th>
                  <th class="py-2 px-3">Last Login</th>
                </tr>
              </thead>
              <tbody>
                <tr class="border-b hover:bg-indigo-50">
                  <td class="py-2 px-3">John Doe</td>
                  <td class="py-2 px-3">Created Event "Launch Party"</td>
                  <td class="py-2 px-3">2025-05-22 14:32</td>
                </tr>
                <tr class="border-b hover:bg-indigo-50">
                  <td class="py-2 px-3">Jane Smith</td>
                  <td class="py-2 px-3">Updated User Role</td>
                  <td class="py-2 px-3">2025-05-22 12:10</td>
                </tr>
                <!-- More rows -->
              </tbody>
            </table>
          </div>

          <!-- Recent Notifications -->
          <div class="bg-white rounded-lg shadow p-6 overflow-auto max-h-96">
            <h2 class="text-lg font-semibold mb-4">Recent Notifications</h2>
            <ul class="list-disc list-inside text-gray-700 space-y-2">
              <li>New user registration pending approval.</li>
              <li>Event "Annual Gala" is starting soon.</li>
              <li>System backup completed successfully.</li>
              <li>New support ticket submitted.</li>
              <!-- More notifications -->
            </ul>
          </div>

        </section>

      </main>

    </div>

  </div>

</body>
</html>

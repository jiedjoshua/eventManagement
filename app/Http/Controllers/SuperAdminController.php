<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Services\ResendService;

class SuperAdminController extends Controller
{

    public function index()
    {
        // Basic statistics
        $totalUsers = User::count();
        $totalEvents = \App\Models\Event::count();
        $totalBookings = \App\Models\Booking::count();
        $pendingBookings = \App\Models\Booking::where('status', 'pending')->count();
        
        // Upcoming events (next 30 days)
        $upcomingEvents = \App\Models\Event::where('event_date', '>=', now())
            ->where('event_date', '<=', now()->addDays(30))
            ->count();
        
        // Total revenue from paid bookings
        $totalRevenue = \App\Models\Booking::where('payment_status', 'paid')
            ->sum('total_price');
        
        // Recent bookings (last 5)
        $recentBookings = \App\Models\Booking::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Upcoming events list (next 10)
        $upcomingEventsList = \App\Models\Event::with('venue')->withCount('guests')
            ->where('event_date', '>=', now())
            ->orderBy('event_date', 'asc')
            ->limit(10)
            ->get();
        
        // Chart data - Events by month (last 6 months)
        $eventsChartData = $this->getEventsChartData();
        
        // Chart data - Revenue by month (last 6 months)
        $revenueChartData = $this->getRevenueChartData();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalEvents', 
            'totalBookings',
            'pendingBookings',
            'upcomingEvents',
            'totalRevenue',
            'recentBookings',
            'upcomingEventsList',
            'eventsChartData',
            'revenueChartData'
        ));
    }

    private function getEventsChartData()
    {
        $months = [];
        $data = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months[] = $date->format('M Y');
            
            $count = \App\Models\Event::whereYear('event_date', $date->year)
                ->whereMonth('event_date', $date->month)
                ->count();
            
            $data[] = $count;
        }
        
        return [
            'labels' => $months,
            'data' => $data
        ];
    }

    private function getRevenueChartData()
    {
        $months = [];
        $data = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months[] = $date->format('M Y');
            
            $revenue = \App\Models\Booking::where('payment_status', 'paid')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('total_price');
            
            $data[] = $revenue;
        }
        
        return [
            'labels' => $months,
            'data' => $data
        ];
    }

    public function listUsers(Request $request)
    {
        $query = User::query();

        // Apply search filter
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Apply role filter
        if ($request->has('role') && $request->role != '') {
            $query->where('role', $request->role);
        }

        // Apply sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $users = $query->paginate(15)->withQueryString();

        return view('admin.userManagement.list-users', compact('users'));
    }

    public function create()
    {
        return view('admin.userManagement.list-users');
    }

    // Save new user with temporary password
    public function store(Request $request)
    {
        Log::info('Store method called');
        Log::info('Request data:', $request->all());

        $request->validate([
            'first_name'   => 'required|string|max:255',
            'last_name'    => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'email'        => 'required|email|unique:users,email',
            'role'         => 'required|string|in:regular_user,event_manager,super_admin',
        ]);

        try {
            // Generate a temporary password
            $temporaryPassword = $this->generateTemporaryPassword();

            $user = User::create([
                'first_name'   => $request->first_name,
                'last_name'    => $request->last_name,
                'phone_number' => $request->phone_number,
                'email'        => $request->email,
                'password'     => Hash::make($temporaryPassword),
                'role'         => $request->role,
            ]);

            // Use ResendService instead of sendPulseService
            $resendService = new \App\Services\ResendService();
            $emailSent = $resendService->sendTemporaryPassword(
                $request->email,
                $request->first_name . ' ' . $request->last_name,
                $temporaryPassword
            );

            Log::info('User created', [
                'user_id' => $user->id,
                'email_sent' => $emailSent
            ]);

            if ($emailSent) {
                return response()->json([
                    'success' => true,
                    'message' => 'User created successfully. Temporary password has been sent to their email.'
                ]);
            } else {
                return response()->json([
                    'success' => true,
                    'message' => 'User created successfully, but there was an issue sending the temporary password email. Please contact the user directly.'
                ]);
            }
        } catch (\Exception $e) {
            Log::error('User creation failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to create user. Please try again.'
            ], 500);
        }
    }

    // Show user details
    public function show(User $user)
    {
        return response()->json([
            'success' => true,
            'user' => $user
        ]);
    }

    // Show form to edit existing user
    public function edit(User $user)
    {
        return response()->json([
            'success' => true,
            'user' => [
                'id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'phone_number' => $user->phone_number,
                'role' => $user->role,
            ]
        ]);
    }

    // Update existing user
    public function update(Request $request, User $user)
    {
        try {
            // Validate the inputs to match your form
            $data = $request->validate([
                'first_name'   => 'required|string|max:255',
                'last_name'    => 'required|string|max:255',
                'phone_number' => 'nullable|string|max:20',
                'email'        => 'required|email|unique:users,email,' . $user->id,
                'role'         => 'required|string|in:regular_user,event_manager,super_admin',
            ]);

            // Update the user with the validated data
            $user->update($data);

            return response()->json([
                'success' => true,
                'message' => 'User updated successfully.'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('User update failed', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'request' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'User update failed. Please try again.'
            ], 500);
        }
    }
    // Delete a user
    public function destroy(User $user)
    {
        try {
            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'User deleted successfully.'
            ]);
        } catch (\Exception $e) {
            Log::error('User deletion failed', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'User deletion failed. Please try again.'
            ], 500);
        }
    }

    /**
     * Generate a secure temporary password
     */
    private function generateTemporaryPassword()
    {
        // Generate a 12-character password with mixed case, numbers, and symbols
        $length = 12;
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*';
        $password = '';

        // Ensure at least one character from each category
        $password .= Str::random(1, 'abcdefghijklmnopqrstuvwxyz'); // lowercase
        $password .= Str::random(1, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'); // uppercase
        $password .= Str::random(1, '0123456789'); // number
        $password .= Str::random(1, '!@#$%^&*'); // symbol

        // Fill the rest randomly
        $password .= Str::random($length - 4, $chars);

        // Shuffle the password to make it more random
        return str_shuffle($password);
    }

    public function accountSettings()
    {
        return view('admin.account-settings', [
            'user' => Auth::user()
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class SuperAdminController extends Controller
{
    public function index()
    {

       $totalUsers = User::count();            // Total users count
        $users = User::paginate(15);            // Paginated users list

        return view('admin.dashboard', compact('totalUsers', 'users'));
    }

    public function listUsers()
    {
        $users = User::paginate(15);

        return view('admin.userManagement.list-users', compact('users')); // Make sure your view path matches
    }


    public function create()
    {
        return view('admin.userManagement.list-users');
    }

    // Save new user
   public function store(Request $request)
{
    Log::info('Store method called');
    Log::info('Request data:', $request->all());

    $request->validate([
        'first_name'   => 'required|string|max:255',
        'last_name'    => 'required|string|max:255',
        'phone_number' => 'nullable|string|max:20',
        'email'        => 'required|email|unique:users,email',
        'password'     => 'required|string|confirmed|min:6',
        'role'         => 'required|string|in:regular_user,event_manager,super_admin',
    ]);

    try {
        $user = User::create([
            'first_name'   => $request->first_name,
            'last_name'    => $request->last_name,
            'phone_number' => $request->phone_number,
            'email'        => $request->email,
            'password'     => Hash::make($request->password),
            'role'         => $request->role,
        ]);

        Log::info('User created', ['user_id' => $user->id]);
        session()->flash('status', 'User created successfully.');

        return redirect()->route('admin.listUsers')->with('success', 'User created successfully.');
        
    } catch (\Exception $e) {
        Log::error('User creation failed: ' . $e->getMessage());
        return back()->withErrors('Failed to create user. Please try again.');
    }
}

    // Show form to edit existing user
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    // Update existing user
    public function update(Request $request, User $user)
{
    // Validate the inputs
    $data = $request->validate([
        'first_name'   => 'required|string|max:255',
        'last_name'    => 'required|string|max:255',
        'phone_number' => 'nullable|string|max:20',
        'email'        => 'required|email|unique:users,email,' . $user->id,
        'role'         => 'required|string|in:regular_user,event_manager,super_admin',
    ]);

    // Update the user
    $user->update($data);

    // Redirect back with success message or wherever you want
    session()->flash('status', 'User updated successfully.');
    return redirect()->route('admin.listusers')->with('success', 'User updated successfully.');
}


    // Delete a user
    public function destroy(User $user)
    {
        $user->delete();
        session()->flash('status', 'User deleted successfully.');
        return redirect()->route('admin.listusers')->with('success', 'User deleted successfully.');
    }

}

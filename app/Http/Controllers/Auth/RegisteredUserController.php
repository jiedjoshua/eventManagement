<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
   public function store(Request $request): RedirectResponse
{
    // Validate form input
    $request->validate([
        'first_name'   => ['required', 'string', 'max:255'],
        'last_name'    => ['required', 'string', 'max:255'],
        'email'        => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
        'phone_number' => ['required', 'string', 'regex:/^[0-9]{10,11}$/', 'max:11'],
        'password'     => ['required', 'confirmed', Rules\Password::defaults()],
    ], [
        'phone_number.regex' => 'The phone number must be 10-11 digits.',
        'phone_number.max' => 'The phone number cannot exceed 11 digits.',
    ]);

    // Create the user
    $user = User::create([
        'first_name'   => $request->first_name,
        'last_name'    => $request->last_name,
        'email'        => $request->email,
        'phone_number' => $request->phone_number,
        'password'     => Hash::make($request->password),
        // Optional: explicitly set role here if you want, but your model default already handles it
        // 'role'      => 'regular_user',
    ]);

    // Fire Registered event
    event(new Registered($user));

    // Log the user in
    Auth::login($user);

    // Check if there's an intended URL (like from invitation page)
    $intended = session('url.intended');
    if ($intended) {
        session()->forget('url.intended');
        return redirect($intended);
    }

    // Redirect based on role if no intended URL
    switch ($user->role) {
        case 'super_admin':
            return redirect()->route('superadmin.dashboard');
        case 'event_manager':
            return redirect()->route('eventmanager.dashboard');
        default:
            return redirect()->route('user.dashboard');
    }
}

}

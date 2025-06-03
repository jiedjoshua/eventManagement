<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;


class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();
                $intended = $request->session()->get('url.intended');
                
                // If there's an intended URL (like the book events page), go there
                if ($intended) {
                    return redirect($intended);
                }
                
                // Otherwise redirect based on role
                if ($user->role === 'super_admin') {
                    return redirect()->route('admin.dashboard');
                } elseif ($user->role === 'event_manager') {
                    return redirect()->route('manager.dashboard');
                } else {
                    return redirect()->route('user.dashboard');
                }
            }
        }

        return $next($request);
    }
} 
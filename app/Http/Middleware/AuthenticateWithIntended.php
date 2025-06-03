<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateWithIntended
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            // Store the intended URL before redirecting to login
            return redirect()->route('login')->with('url.intended', $request->url());
        }

        return $next($request);
    }
} 
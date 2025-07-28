<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CSPMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only add CSP headers for HTML responses
        if ($response->headers->get('Content-Type') && 
            str_contains($response->headers->get('Content-Type'), 'text/html')) {
            
            $csp = [
                "default-src 'self'",
                "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.tailwindcss.com https://cdn.jsdelivr.net",
                "style-src 'self' 'unsafe-inline' https://cdn.tailwindcss.com",
                "font-src 'self' data: https:",
                "img-src 'self' data: https: blob:",
                "connect-src 'self' https:",
                "media-src 'self' blob:",
                "object-src 'none'",
                "frame-src 'self'",
                "worker-src 'self' blob:",
                "manifest-src 'self'",
                "form-action 'self'",
                "base-uri 'self'",
                "frame-ancestors 'self'",
                "camera 'self'",
                "microphone 'self'",
                "geolocation 'self'"
            ];

            $response->headers->set('Content-Security-Policy', implode('; ', $csp));
        }

        return $response;
    }
} 
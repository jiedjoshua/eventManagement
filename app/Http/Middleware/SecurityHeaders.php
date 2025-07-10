<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Content Security Policy
        $csp = $this->buildCSP();
        $headerName = config('security.csp_report_only') ? 'Content-Security-Policy-Report-Only' : 'Content-Security-Policy';
        $response->headers->set($headerName, $csp);

        // Security headers from configuration
        $headers = config('security.headers');
        
        $response->headers->set('X-Frame-Options', $headers['x_frame_options']);
        $response->headers->set('X-Content-Type-Options', $headers['x_content_type_options']);
        $response->headers->set('X-XSS-Protection', $headers['x_xss_protection']);
        $response->headers->set('Referrer-Policy', $headers['referrer_policy']);
        $response->headers->set('Permissions-Policy', $headers['permissions_policy']);
        
        // HSTS header (only for HTTPS)
        if ($request->isSecure()) {
            $response->headers->set('Strict-Transport-Security', $headers['strict_transport_security']);
        }

        return $response;
    }

    /**
     * Build the Content Security Policy string
     */
    private function buildCSP(): string
    {
        $cspConfig = config('security.csp');
        $policies = [];

        foreach ($cspConfig as $directive => $sources) {
            if (!empty($sources)) {
                $policies[] = $directive . ' ' . implode(' ', $sources);
            }
        }

        // Add report-uri if configured
        if (config('security.csp_report_uri')) {
            $policies[] = 'report-uri ' . config('security.csp_report_uri');
        }

        return implode('; ', $policies);
    }
} 
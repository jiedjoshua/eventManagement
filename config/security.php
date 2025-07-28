<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Security Headers Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration for various security headers
    | including Content Security Policy and anti-clickjacking headers.
    |
    */

    'headers' => [
        // Anti-clickjacking headers
        'x_frame_options' => env('X_FRAME_OPTIONS', 'DENY'),
        'x_content_type_options' => env('X_CONTENT_TYPE_OPTIONS', 'nosniff'),
        'x_xss_protection' => env('X_XSS_PROTECTION', '1; mode=block'),
        'referrer_policy' => env('REFERRER_POLICY', 'strict-origin-when-cross-origin'),
        
        // Additional security headers
        'permissions_policy' => env('PERMISSIONS_POLICY', 'geolocation=(), microphone=(), camera=()'),
        'strict_transport_security' => env('STRICT_TRANSPORT_SECURITY', 'max-age=31536000; includeSubDomains'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Content Security Policy Configuration
    |--------------------------------------------------------------------------
    |
    | Configure the Content Security Policy directives. You can customize
    | these based on your application's needs.
    |
    | For this event management application, you might need to add:
    | - Payment gateway domains (Stripe, PayPal, etc.)
    | - Map service domains (Google Maps, etc.)
    | - Social media domains (for sharing features)
    | - Analytics domains (Google Analytics, etc.)
    |
    */

    'csp' => [
        'default-src' => ["'self'"],
        'script-src' => [
            "'self'",
            "'unsafe-inline'", // Consider removing in production
            "'unsafe-eval'",   // Consider removing in production
            'https://cdn.jsdelivr.net',
            'https://unpkg.com',
            // Add payment gateway domains here if needed
            // 'https://js.stripe.com',
            // 'https://www.paypal.com',
        ],
        'style-src' => [
            "'self'",
            "'unsafe-inline'", // Consider removing in production
            'https://fonts.googleapis.com',
            'https://cdn.jsdelivr.net',
            'https://unpkg.com',
        ],
        'font-src' => [
            "'self'",
            'https://fonts.gstatic.com',
            'https://cdn.jsdelivr.net',
            'https://unpkg.com',
        ],
        'img-src' => [
            "'self'",
            'data:',
            'https:',
            'http:',
            // Add map service domains here if needed
            // 'https://maps.googleapis.com',
            // 'https://maps.gstatic.com',
        ],
        'connect-src' => [
            "'self'",
            'https:',
            'wss:',
            // Add API domains here if needed
            // 'https://api.stripe.com',
            // 'https://api.paypal.com',
        ],
        'media-src' => ["'self'"],
        'object-src' => ["'none'"],
        'frame-src' => [
            "'self'",
            // Add payment gateway frame domains here if needed
            // 'https://js.stripe.com',
            // 'https://www.paypal.com',
        ],
        'worker-src' => ["'self'"],
        'manifest-src' => ["'self'"],
        'form-action' => ["'self'"],
        'base-uri' => ["'self'"],
        'frame-ancestors' => ["'none'"],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSP Report Only Mode
    |--------------------------------------------------------------------------
    |
    | When enabled, CSP violations will be reported but not blocked.
    | Useful for testing CSP policies before enforcing them.
    |
    */

    'csp_report_only' => env('CSP_REPORT_ONLY', false),

    /*
    |--------------------------------------------------------------------------
    | CSP Report URI
    |--------------------------------------------------------------------------
    |
    | URI where CSP violations should be reported when in report-only mode
    | or when using report-uri directive.
    |
    */

    'csp_report_uri' => env('CSP_REPORT_URI', null),
]; 
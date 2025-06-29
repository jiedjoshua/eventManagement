<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Add fallback for mb_strcut if mbstring extension is not available
        if (!function_exists('mb_strcut')) {
            function mb_strcut($str, $start, $length = null, $encoding = null) {
                // Simple fallback implementation
                if ($length === null) {
                    return substr($str, $start);
                }
                return substr($str, $start, $length);
            }
        }
    }
}

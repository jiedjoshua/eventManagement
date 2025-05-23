<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Auth\Middleware\Authenticate;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Pass an array of aliases to alias()
        $middleware->alias([
            'auth' => Authenticate::class,
            'role' => RoleMiddleware::class,
            // add other aliases as needed
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\AddAcceptApplicationJsonHeader;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckEmailIsVerified;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        using: function () {
            Route::middleware(['api'])
                ->prefix('api/v1/')
                ->group(base_path('routes/api.php'));
     
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
            
            Route::middleware(['api'])
                ->prefix('api/v1/auth/')
                ->group(base_path('routes/auth.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->api(prepend: [
            AddAcceptApplicationJsonHeader::class
        ]);

        $middleware->alias([
            'email.verified' => CheckEmailIsVerified::class,
            'accepts.json' => AddAcceptApplicationJsonHeader::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Middleware\CheckEmailIsVerified;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\AddAcceptApplicationJsonHeader;

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

            Route::middleware(['api'])
                ->prefix('api/v1/user/preferences')
                ->group(base_path('routes/user-preferences-management.php'));

            Route::middleware(['api'])
                ->prefix('api/v1/news')
                ->group(base_path('routes/news-management.php'));
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

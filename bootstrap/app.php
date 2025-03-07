<?php

use App\Http\Middleware\CentralAppAuthenticate;
use App\Http\Middleware\EnsureHasSubscription;
use App\Http\Middleware\LocalizationMiddleware;
use App\Http\Middleware\SetApiLocale;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'auth-central' => CentralAppAuthenticate::class
        ]);
        $middleware->web(append: [
            LocalizationMiddleware::class,
            EnsureHasSubscription::class
        ]);
        $middleware->api(append: [
            SetApiLocale::class,
            EnsureHasSubscription::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

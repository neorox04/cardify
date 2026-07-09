<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Stripe posts to the webhook without a CSRF token — it must be
        // exempt, otherwise every webhook is rejected with 419 and the
        // subscription never syncs locally after a successful payment.
        $middleware->validateCsrfTokens(except: [
            'stripe/webhook',
        ]);

        $middleware->alias([
            'active.user' => \App\Http\Middleware\EnsureUserIsActive::class,
            'company.admin' => \App\Http\Middleware\EnsureUserIsCompanyAdmin::class,
            'super.admin' => \App\Http\Middleware\EnsureUserIsSuperAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

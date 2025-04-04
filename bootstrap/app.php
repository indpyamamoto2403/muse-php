<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\EnsureRoleIsArtist;
use App\Http\Middleware\EnsureRoleIsCompany;
use App\Http\Middleware\EnsureRoleIsAdmin;
use App\Http\Middleware\CheckEvaluationExists;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            \App\Http\Middleware\HandleInertiaRequests::class,
            \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
        ]);
        $middleware->alias([
            'artist' => EnsureRoleIsArtist::class,
            'company' => EnsureRoleIsCompany::class,
            'admin' => EnsureRoleIsAdmin::class,
            'evaluation.exists' => \App\Http\Middleware\CheckEvaluationExists::class,
        ]);
        
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

<?php

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\CheckMaintenanceMode;
use App\Http\Middleware\CustomerMiddleware;
use App\Http\Middleware\SetLocale;
use App\Http\Middleware\TrackVisitor;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Console\Scheduling\Schedule;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => AdminMiddleware::class,
            'customer' => CustomerMiddleware::class,
        ]);

        // Ajouter le middleware de tracking des visiteurs et de maintenance aux routes web
        $middleware->web(append: [
            CheckMaintenanceMode::class,
            SetLocale::class,
            TrackVisitor::class,
        ]);
    })
    ->withSchedule(function (Schedule $schedule) {
        // Publier les articles planifiés toutes les 5 minutes
        $schedule->command('blog:publish-scheduled')
            ->everyFiveMinutes()
            ->withoutOverlapping();
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

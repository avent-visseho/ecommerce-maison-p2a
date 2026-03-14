<?php

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\CheckMaintenanceMode;
use App\Http\Middleware\CustomerMiddleware;
use App\Http\Middleware\SetLocale;
use App\Http\Middleware\TrackVisitor;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;

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

        // Exclure les webhooks de la vérification CSRF
        $middleware->validateCsrfTokens(except: [
            'payment/webhook',
            'stripe/webhook',
        ]);
    })
    ->withSchedule(function (Schedule $schedule) {
        // Publier les articles planifiés toutes les 5 minutes
        $schedule->command('blog:publish-scheduled')
            ->everyFiveMinutes()
            ->withoutOverlapping();
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Gestionnaire d'erreurs personnalisé pour afficher des messages conviviaux

        // Gestion des erreurs de base de données
        $exceptions->renderable(function (QueryException $e, Request $request) {
            Log::error('Database Error: ' . $e->getMessage(), [
                'sql' => $e->getSql(),
                'bindings' => $e->getBindings(),
                'url' => $request->url(),
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => __('errors.database_error'),
                    'error' => true,
                ], 500);
            }

            return redirect()->back()
                ->withInput()
                ->with('modal_error', [
                    'title' => __('errors.error_occurred'),
                    'message' => __('errors.database_error'),
                    'showRetry' => true,
                    'showHome' => false,
                ]);
        });

        // Gestion des erreurs 404
        $exceptions->renderable(function (NotFoundHttpException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => __('errors.not_found'),
                    'error' => true,
                ], 404);
            }

            return response()->view('errors.404', [
                'title' => __('errors.not_found'),
                'message' => __('errors.not_found'),
            ], 404);
        });

        // Gestion des erreurs d'accès interdit
        $exceptions->renderable(function (AccessDeniedHttpException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => __('errors.forbidden'),
                    'error' => true,
                ], 403);
            }

            return redirect()->back()
                ->with('modal_error', [
                    'title' => __('errors.error_occurred'),
                    'message' => __('errors.forbidden'),
                    'showRetry' => false,
                    'showHome' => true,
                ]);
        });

        // Gestion des erreurs d'authentification
        $exceptions->renderable(function (AuthenticationException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => __('errors.unauthorized'),
                    'error' => true,
                ], 401);
            }

            return redirect()->route('login')
                ->with('modal_error', [
                    'title' => __('errors.error_occurred'),
                    'message' => __('errors.unauthorized'),
                    'showRetry' => false,
                    'showHome' => false,
                ]);
        });

        // Gestion des erreurs HTTP génériques (500, etc.)
        $exceptions->renderable(function (HttpException $e, Request $request) {
            $statusCode = $e->getStatusCode();

            Log::error('HTTP Error ' . $statusCode . ': ' . $e->getMessage(), [
                'url' => $request->url(),
                'method' => $request->method(),
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => __('errors.server_error'),
                    'error' => true,
                ], $statusCode);
            }

            if ($statusCode === 503) {
                return response()->view('errors.503', [
                    'message' => __('errors.service_unavailable'),
                ], 503);
            }

            if ($statusCode >= 500) {
                return redirect()->back()
                    ->with('modal_error', [
                        'title' => __('errors.error_occurred'),
                        'message' => __('errors.server_error'),
                        'showRetry' => true,
                        'showHome' => true,
                    ]);
            }
        });

        // Gestion de toutes les autres exceptions
        $exceptions->renderable(function (Throwable $e, Request $request) {
            // Ne pas intercepter les exceptions de validation (elles ont leur propre gestion)
            if ($e instanceof ValidationException) {
                return null;
            }

            // Logger l'erreur pour le débogage
            Log::error('Unhandled Exception: ' . $e->getMessage(), [
                'exception' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'url' => $request->url(),
                'method' => $request->method(),
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => __('errors.generic'),
                    'error' => true,
                ], 500);
            }

            // En mode debug, laisser Laravel afficher l'erreur complète
            if (config('app.debug')) {
                return null;
            }

            return redirect()->back()
                ->withInput()
                ->with('modal_error', [
                    'title' => __('errors.error_occurred'),
                    'message' => __('errors.generic'),
                    'showRetry' => true,
                    'showHome' => true,
                ]);
        });
    })->create();

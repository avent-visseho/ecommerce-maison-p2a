<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if maintenance mode is enabled
        if (env('MAINTENANCE_MODE', false)) {
            // Don't redirect if already on maintenance page
            if (!$request->is('maintenance')) {
                return redirect()->route('maintenance');
            }
        }

        return $next($request);
    }
}

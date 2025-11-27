<?php

namespace App\Http\Middleware;

use App\Models\SiteVisit;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($this->shouldTrack($request)) {
            try {
                SiteVisit::create([
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'url' => $request->fullUrl(),
                    'referer' => $request->header('referer'),
                    'session_id' => session()->getId(),
                    'user_id' => auth()->id(),
                    'visited_at' => now(),
                ]);
            } catch (\Exception $e) {
                // Silently fail to not disrupt the application
                logger()->error('Failed to track visitor: ' . $e->getMessage());
            }
        }

        return $next($request);
    }

    private function shouldTrack(Request $request): bool
    {
        // Ne pas tracker les routes admin, API, ou les assets
        $excludedPaths = [
            'admin/*',
            'api/*',
            'livewire/*',
            'build/*',
            'storage/*',
            'css/*',
            'js/*',
            'fonts/*',
            'images/*',
        ];

        foreach ($excludedPaths as $pattern) {
            if ($request->is($pattern)) {
                return false;
            }
        }

        // Ne pas tracker les bots connus
        $userAgent = strtolower($request->userAgent() ?? '');
        $bots = ['bot', 'crawler', 'spider', 'scraper'];

        foreach ($bots as $bot) {
            if (str_contains($userAgent, $bot)) {
                return false;
            }
        }

        return true;
    }
}

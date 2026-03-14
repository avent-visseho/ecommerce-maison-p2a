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
                $this->trackVisit($request);
            } catch (\Exception $e) {
                // Silently fail to not disrupt the application
                logger()->error('Failed to track visitor: '.$e->getMessage());
            }
        }

        return $next($request);
    }

    /**
     * Track the visit - only count unique visitors within 30 minutes window
     */
    private function trackVisit(Request $request): void
    {
        $ipAddress = $request->ip();
        $userAgent = $request->userAgent();
        $sessionId = session()->getId();

        // Vérifier si cette IP a déjà visité dans les 30 dernières minutes
        $recentVisit = SiteVisit::where('ip_address', $ipAddress)
            ->where('user_agent', $userAgent)
            ->where('visited_at', '>=', now()->subMinutes(30))
            ->first();

        if ($recentVisit) {
            // Visiteur déjà compté - juste mettre à jour la dernière page vue
            $recentVisit->update([
                'url' => $request->fullUrl(),
                'visited_at' => now(),
                'page_views' => $recentVisit->page_views + 1,
            ]);
        } else {
            // Nouveau visiteur unique
            SiteVisit::create([
                'ip_address' => $ipAddress,
                'user_agent' => $userAgent,
                'url' => $request->fullUrl(),
                'referer' => $request->header('referer'),
                'session_id' => $sessionId,
                'user_id' => auth()->id(),
                'visited_at' => now(),
                'is_unique_visit' => true,
                'page_views' => 1,
            ]);
        }
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

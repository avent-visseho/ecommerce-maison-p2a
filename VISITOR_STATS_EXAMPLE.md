# 📈 Exemple d'utilisation dans le Dashboard Admin

## Dans votre contrôleur Admin

```php
<?php

namespace App\Http\Controllers\Admin;

use App\Models\SiteVisit;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'today' => [
                'unique_visitors' => SiteVisit::countUniqueVisitors('today'),
                'page_views' => SiteVisit::countPageViews('today'),
            ],
            'week' => [
                'unique_visitors' => SiteVisit::countUniqueVisitors('week'),
                'page_views' => SiteVisit::countPageViews('week'),
            ],
            'month' => [
                'unique_visitors' => SiteVisit::countUniqueVisitors('month'),
                'page_views' => SiteVisit::countPageViews('month'),
            ],
            'total' => [
                'unique_visitors' => SiteVisit::countUniqueVisitors(),
                'page_views' => SiteVisit::countPageViews(),
            ],
        ];

        // Taux de pages par visiteur (engagement)
        if ($stats['today']['unique_visitors'] > 0) {
            $stats['today']['avg_pages_per_visitor'] = round(
                $stats['today']['page_views'] / $stats['today']['unique_visitors'],
                2
            );
        } else {
            $stats['today']['avg_pages_per_visitor'] = 0;
        }

        // Top 10 des pages les plus visitées aujourd'hui
        $topPages = SiteVisit::today()
            ->selectRaw('url, SUM(page_views) as total_views')
            ->groupBy('url')
            ->orderByDesc('total_views')
            ->limit(10)
            ->get();

        // Visiteurs en temps réel (dernières 5 minutes)
        $liveVisitors = SiteVisit::where('visited_at', '>=', now()->subMinutes(5))
            ->count();

        return view('admin.dashboard', compact('stats', 'topPages', 'liveVisitors'));
    }

    public function analytics()
    {
        // Graphique des 30 derniers jours
        $last30Days = collect(range(0, 29))->map(function ($daysAgo) {
            $date = now()->subDays($daysAgo)->startOfDay();

            return [
                'date' => $date->format('Y-m-d'),
                'unique_visitors' => SiteVisit::whereDate('visited_at', $date)
                    ->where('is_unique_visit', true)
                    ->count(),
                'page_views' => SiteVisit::whereDate('visited_at', $date)
                    ->sum('page_views'),
            ];
        })->reverse()->values();

        // Répartition par heure (aujourd'hui)
        $hourlyStats = collect(range(0, 23))->map(function ($hour) {
            $start = today()->setHour($hour);
            $end = $start->copy()->addHour();

            return [
                'hour' => str_pad($hour, 2, '0', STR_PAD_LEFT) . ':00',
                'visitors' => SiteVisit::whereBetween('visited_at', [$start, $end])
                    ->where('is_unique_visit', true)
                    ->count(),
            ];
        });

        // Statistiques par appareil (basé sur user_agent)
        $deviceStats = [
            'mobile' => SiteVisit::today()
                ->where('is_unique_visit', true)
                ->where('user_agent', 'LIKE', '%Mobile%')
                ->count(),
            'tablet' => SiteVisit::today()
                ->where('is_unique_visit', true)
                ->where('user_agent', 'LIKE', '%Tablet%')
                ->count(),
            'desktop' => SiteVisit::today()
                ->where('is_unique_visit', true)
                ->where('user_agent', 'NOT LIKE', '%Mobile%')
                ->where('user_agent', 'NOT LIKE', '%Tablet%')
                ->count(),
        ];

        return view('admin.analytics', compact('last30Days', 'hourlyStats', 'deviceStats'));
    }
}
```

## Dans votre vue Blade (admin/dashboard.blade.php)

```blade
<div class="row">
    <!-- Aujourd'hui -->
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Aujourd'hui</h5>
                <h2>{{ $stats['today']['unique_visitors'] }}</h2>
                <p class="text-muted">Visiteurs uniques</p>
                <small>{{ $stats['today']['page_views'] }} pages vues</small>
                <br>
                <small class="text-success">
                    {{ $stats['today']['avg_pages_per_visitor'] }} pages/visiteur
                </small>
            </div>
        </div>
    </div>

    <!-- Cette semaine -->
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Cette semaine</h5>
                <h2>{{ $stats['week']['unique_visitors'] }}</h2>
                <p class="text-muted">Visiteurs uniques</p>
                <small>{{ $stats['week']['page_views'] }} pages vues</small>
            </div>
        </div>
    </div>

    <!-- Ce mois -->
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Ce mois</h5>
                <h2>{{ $stats['month']['unique_visitors'] }}</h2>
                <p class="text-muted">Visiteurs uniques</p>
                <small>{{ $stats['month']['page_views'] }} pages vues</small>
            </div>
        </div>
    </div>

    <!-- En direct -->
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">En direct</h5>
                <h2>{{ $liveVisitors }}</h2>
                <p class="text-muted">Visiteurs actifs</p>
                <small class="text-success">
                    <i class="fas fa-circle"></i> Dernières 5 min
                </small>
            </div>
        </div>
    </div>
</div>

<!-- Top pages -->
<div class="card mt-4">
    <div class="card-header">
        <h5>Pages les plus visitées (aujourd'hui)</h5>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>URL</th>
                    <th>Vues</th>
                </tr>
            </thead>
            <tbody>
                @foreach($topPages as $page)
                    <tr>
                        <td>{{ $page->url }}</td>
                        <td><span class="badge bg-primary">{{ $page->total_views }}</span></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
```

## Exemple avec Chart.js (graphique)

```blade
<canvas id="visitorsChart"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('visitorsChart').getContext('2d');
const chart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: @json($last30Days->pluck('date')),
        datasets: [
            {
                label: 'Visiteurs uniques',
                data: @json($last30Days->pluck('unique_visitors')),
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            },
            {
                label: 'Pages vues',
                data: @json($last30Days->pluck('page_views')),
                borderColor: 'rgb(255, 99, 132)',
                tension: 0.1
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            title: {
                display: true,
                text: 'Statistiques des 30 derniers jours'
            }
        }
    }
});
</script>
```

## API pour récupérer les stats en temps réel (AJAX)

```php
// routes/web.php
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/api/live-stats', [DashboardController::class, 'liveStats']);
});

// DashboardController.php
public function liveStats()
{
    return response()->json([
        'live_visitors' => SiteVisit::where('visited_at', '>=', now()->subMinutes(5))->count(),
        'today_unique' => SiteVisit::countUniqueVisitors('today'),
        'today_views' => SiteVisit::countPageViews('today'),
    ]);
}
```

```javascript
// Mettre à jour les stats toutes les 30 secondes
setInterval(async () => {
    const response = await fetch('/admin/api/live-stats');
    const data = await response.json();

    document.getElementById('live-visitors').textContent = data.live_visitors;
    document.getElementById('today-unique').textContent = data.today_unique;
    document.getElementById('today-views').textContent = data.today_views;
}, 30000);
```

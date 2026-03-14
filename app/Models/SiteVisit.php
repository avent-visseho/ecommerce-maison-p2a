<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SiteVisit extends Model
{
    protected $fillable = [
        'ip_address',
        'user_agent',
        'url',
        'referer',
        'session_id',
        'user_id',
        'visited_at',
        'is_unique_visit',
        'page_views',
    ];

    protected $casts = [
        'visited_at' => 'datetime',
        'is_unique_visit' => 'boolean',
        'page_views' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('visited_at', today());
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('visited_at', [now()->startOfWeek(), now()->endOfWeek()]);
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('visited_at', now()->month)
            ->whereYear('visited_at', now()->year);
    }

    public function scopeUniqueVisitors($query)
    {
        return $query->where('is_unique_visit', true);
    }

    /**
     * Compter les visiteurs uniques
     */
    public static function countUniqueVisitors($period = null)
    {
        $query = static::where('is_unique_visit', true);

        return match ($period) {
            'today' => $query->today()->count(),
            'week' => $query->thisWeek()->count(),
            'month' => $query->thisMonth()->count(),
            default => $query->count(),
        };
    }

    /**
     * Compter les pages vues totales
     */
    public static function countPageViews($period = null)
    {
        $query = static::query();

        return match ($period) {
            'today' => $query->today()->sum('page_views'),
            'week' => $query->thisWeek()->sum('page_views'),
            'month' => $query->thisMonth()->sum('page_views'),
            default => $query->sum('page_views'),
        };
    }
}

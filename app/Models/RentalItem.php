<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class RentalItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'long_description',
        'daily_rate',
        'weekly_rate',
        'monthly_rate',
        'min_rental_days',
        'max_rental_days',
        'deposit_amount',
        'sku',
        'quantity',
        'rental_category_id',
        'main_image',
        'images',
        'is_active',
        'is_featured',
        'views',
    ];

    protected $casts = [
        'daily_rate' => 'decimal:2',
        'weekly_rate' => 'decimal:2',
        'monthly_rate' => 'decimal:2',
        'deposit_amount' => 'decimal:2',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'images' => 'array',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($item) {
            if (empty($item->slug)) {
                $item->slug = Str::slug($item->name);
            }
            if (empty($item->sku)) {
                $item->sku = 'RENT-' . strtoupper(Str::random(8));
            }
        });
    }

    /**
     * Get the rental category that owns the rental item.
     */
    public function rentalCategory(): BelongsTo
    {
        return $this->belongsTo(RentalCategory::class);
    }

    /**
     * Get the reservations for the rental item.
     */
    public function reservations(): HasMany
    {
        return $this->hasMany(RentalReservation::class);
    }

    /**
     * Get the order items for the rental item.
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get available quantity for given date range.
     *
     * @param Carbon $start
     * @param Carbon $end
     * @return int
     */
    public function getAvailableQuantity(Carbon $start, Carbon $end): int
    {
        // Calculate reserved quantity for overlapping reservations
        $reserved = $this->reservations()
            ->whereIn('status', ['confirmed', 'active'])
            ->where(function ($query) use ($start, $end) {
                $query->whereBetween('start_date', [$start, $end])
                    ->orWhereBetween('end_date', [$start, $end])
                    ->orWhere(function ($q) use ($start, $end) {
                        $q->where('start_date', '<=', $start)
                          ->where('end_date', '>=', $end);
                    });
            })
            ->sum('quantity_reserved');

        return max(0, $this->quantity - $reserved);
    }

    /**
     * Check if rental item is available for given date range and quantity.
     *
     * @param Carbon $start
     * @param Carbon $end
     * @param int $qty
     * @return bool
     */
    public function isAvailable(Carbon $start, Carbon $end, int $qty = 1): bool
    {
        return $this->getAvailableQuantity($start, $end) >= $qty;
    }

    /**
     * Calculate optimal price for given number of days.
     *
     * @param int $days
     * @return array
     */
    public function calculatePrice(int $days): array
    {
        // Try monthly rate first (28+ days)
        if ($days >= 28 && $this->monthly_rate) {
            $months = ceil($days / 28);
            return [
                'rate_type' => 'monthly',
                'rate' => $this->monthly_rate,
                'units' => $months,
                'subtotal' => $this->monthly_rate * $months
            ];
        }

        // Try weekly rate (7+ days)
        if ($days >= 7 && $this->weekly_rate) {
            $weeks = ceil($days / 7);
            $weeklyTotal = $this->weekly_rate * $weeks;
            $dailyTotal = $this->daily_rate * $days;

            // Use weekly if it's cheaper
            if ($weeklyTotal <= $dailyTotal) {
                return [
                    'rate_type' => 'weekly',
                    'rate' => $this->weekly_rate,
                    'units' => $weeks,
                    'subtotal' => $weeklyTotal
                ];
            }
        }

        // Default to daily rate
        return [
            'rate_type' => 'daily',
            'rate' => $this->daily_rate,
            'units' => $days,
            'subtotal' => $this->daily_rate * $days
        ];
    }

    /**
     * Get minimum rate for display.
     */
    public function getMinRateAttribute()
    {
        return $this->daily_rate;
    }

    /**
     * Check if rental item is low on availability
     */
    public function isLowAvailability(): bool
    {
        return $this->quantity <= 2;
    }

    /**
     * Check if rental item is fully booked for a date range
     */
    public function isFullyBooked(Carbon $start, Carbon $end): bool
    {
        return $this->getAvailableQuantity($start, $end) === 0;
    }

    /**
     * Scope a query to only include active rental items.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include featured rental items.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope a query to only include rental items with availability.
     */
    public function scopeAvailable($query)
    {
        return $query->where('quantity', '>', 0);
    }

    /**
     * Increment rental item views
     */
    public function incrementViews()
    {
        $this->increment('views');
    }
}

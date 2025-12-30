<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class RentalReservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_number',
        'rental_item_id',
        'order_id',
        'order_item_id',
        'start_date',
        'end_date',
        'duration_days',
        'quantity_reserved',
        'rate_type',
        'rate_applied',
        'subtotal',
        'deposit',
        'status',
        'actual_return_date',
        'return_notes',
        'return_condition',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'actual_return_date' => 'date',
        'rate_applied' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'deposit' => 'decimal:2',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($reservation) {
            if (empty($reservation->reservation_number)) {
                $reservation->reservation_number = 'RES-' . strtoupper(Str::random(10));
            }
        });
    }

    /**
     * Get the rental item that owns the reservation.
     */
    public function rentalItem(): BelongsTo
    {
        return $this->belongsTo(RentalItem::class);
    }

    /**
     * Get the order that owns the reservation.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the order item that owns the reservation.
     */
    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class);
    }

    /**
     * Scope a query to only include active reservations (confirmed or active status).
     */
    public function scopeActive($query)
    {
        return $query->whereIn('status', ['confirmed', 'active']);
    }

    /**
     * Scope a query to include reservations that overlap with given date range.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param Carbon $start
     * @param Carbon $end
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOverlapping($query, Carbon $start, Carbon $end)
    {
        return $query->where(function ($q) use ($start, $end) {
            $q->whereBetween('start_date', [$start, $end])
              ->orWhereBetween('end_date', [$start, $end])
              ->orWhere(function ($subQuery) use ($start, $end) {
                  $subQuery->where('start_date', '<=', $start)
                           ->where('end_date', '>=', $end);
              });
        });
    }

    /**
     * Scope a query by status.
     */
    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Check if reservation is confirmed.
     */
    public function isConfirmed(): bool
    {
        return $this->status === 'confirmed';
    }

    /**
     * Check if reservation is active (currently rented).
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Check if reservation is completed.
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Check if reservation is cancelled.
     */
    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    /**
     * Check if reservation is overdue.
     */
    public function isOverdue(): bool
    {
        return $this->status === 'active'
            && $this->end_date->isPast()
            && !$this->actual_return_date;
    }
}

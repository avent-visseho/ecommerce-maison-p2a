<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BlogNewsletter extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'token',
        'is_active',
        'verified_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'verified_at' => 'datetime',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($newsletter) {
            if (empty($newsletter->token)) {
                $newsletter->token = Str::random(32);
            }
        });
    }

    /**
     * Scope a query to only include active subscribers.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->whereNotNull('verified_at');
    }

    /**
     * Scope a query to only include unverified subscribers.
     */
    public function scopeUnverified($query)
    {
        return $query->whereNull('verified_at');
    }

    /**
     * Check if subscriber is verified.
     */
    public function isVerified(): bool
    {
        return $this->verified_at !== null;
    }

    /**
     * Verify the subscription.
     */
    public function verify()
    {
        $this->update([
            'is_active' => true,
            'verified_at' => now(),
        ]);
    }

    /**
     * Unsubscribe.
     */
    public function unsubscribe()
    {
        $this->update(['is_active' => false]);
    }
}

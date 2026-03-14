<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    /**
     * Get the users for the role.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Check if role is admin
     */
    public function isAdmin(): bool
    {
        return $this->slug === 'admin';
    }

    /**
     * Check if role is customer
     */
    public function isCustomer(): bool
    {
        return $this->slug === 'customer';
    }
}

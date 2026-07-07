<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'website',
        'email',
        'phone',
        'address',
        'logo',
        'industry',
        'size',
        'founded_year',
        'nif',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'founded_year' => 'integer',
    ];

    /**
     * Get the business cards for the company.
     */
    public function businessCards(): HasMany
    {
        return $this->hasMany(BusinessCard::class);
    }

    /**
     * Get the users associated with the company.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'company_user')
                    ->withPivot('role', 'is_admin')
                    ->withTimestamps();
    }

    /**
     * Get the company admins.
     */
    public function admins(): BelongsToMany
    {
        return $this->users()->wherePivot('is_admin', true);
    }

    /**
     * Number of paid seats — the quantity of the active company subscription
     * held by any admin. Zero when the company has no active subscription.
     * Each company card consumes one seat.
     */
    public function seatLimit(): int
    {
        foreach ($this->admins as $admin) {
            if ($admin->subscribed('default')) {
                $subscription = $admin->subscription('default');
                return (int) ($subscription->quantity ?? 1);
            }
        }

        return 0;
    }

    /**
     * Company cards currently in use (each counts as one seat).
     */
    public function companyCardCount(): int
    {
        return $this->businessCards()->count();
    }

    /**
     * Seats still available for new company cards.
     */
    public function availableSeats(): int
    {
        return max(0, $this->seatLimit() - $this->companyCardCount());
    }

    /**
     * Get the route key name for Laravel model binding.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
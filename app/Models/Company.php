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
     * Get the route key name for Laravel model binding.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
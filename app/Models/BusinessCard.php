<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusinessCard extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'company_id',
        'title',
        'slug',
        'full_name',
        'position',
        'department',
        'email',
        'phone',
        'mobile',
        'website',
        'bio',
        'avatar',
        'cover_image',
        'linkedin_url',
        'twitter_url',
        'facebook_url',
        'instagram_url',
        'github_url',
        'custom_fields',
        'theme',
        'is_public',
        'is_active',
        'views_count',
        'qr_code',
    ];

    protected $casts = [
        'custom_fields' => 'array',
        'is_public' => 'boolean',
        'is_active' => 'boolean',
        'views_count' => 'integer',
    ];

    /**
     * Get the user that owns the business card.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the company that owns the business card.
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the route key name for Laravel model binding.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Get the full URL for the business card.
     */
    public function getUrlAttribute(): string
    {
        return url("/card/{$this->slug}");
    }

    /**
     * Get the QR code URL.
     */
    public function getQrCodeUrlAttribute(): string
    {
        return $this->qr_code ? asset("storage/qr-codes/{$this->qr_code}") : '';
    }

    /**
     * Increment the views count.
     */
    public function incrementViews(): void
    {
        $this->increment('views_count');
    }
}
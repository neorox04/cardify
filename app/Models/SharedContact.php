<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SharedContact extends Model
{
    protected $fillable = [
        'business_card_id', 'recipient_user_id', 'token',
        'full_name', 'email', 'phone', 'method', 'expires_at',
    ];

    protected $casts = ['expires_at' => 'datetime'];

    public function businessCard(): BelongsTo
    {
        return $this->belongsTo(BusinessCard::class);
    }

    public function recipient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recipient_user_id');
    }

    public function isExpired(): bool
    {
        return $this->expires_at !== null && $this->expires_at->isPast();
    }
}

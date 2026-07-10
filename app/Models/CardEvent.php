<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CardEvent extends Model
{
    public const TYPES    = ['view', 'scan', 'save'];
    public const CHANNELS = ['qr', 'nfc', 'link'];

    protected $fillable = ['business_card_id', 'type', 'channel'];

    public function businessCard(): BelongsTo
    {
        return $this->belongsTo(BusinessCard::class);
    }
}

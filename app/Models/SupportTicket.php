<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    public const STATUSES = [
        'received'    => 'Recebido',
        'in_progress' => 'A tratar',
        'done'        => 'Tratado',
    ];

    protected $fillable = ['name', 'email', 'subject', 'message', 'status'];
}

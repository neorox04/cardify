<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoadmapItem extends Model
{
    public const STATUSES = [
        'todo'  => 'A fazer',
        'doing' => 'Em curso',
        'done'  => 'Concluído',
    ];

    public const PRIORITIES = ['low' => 'Baixa', 'medium' => 'Média', 'high' => 'Alta'];

    protected $fillable = ['title', 'description', 'status', 'priority'];
}

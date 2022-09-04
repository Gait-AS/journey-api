<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

    const STATUS = [
        'todo',
        'doing',
        'review',
        'done'
    ];

    use HasFactory;


    protected $fillable = [
        'name',
        'content',
        'created_by',
        'assigned_to',
        'status',
        'completed_at',
        'team_id'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatInteraction extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'answer',
        'ip_address',
        'user_agent',
        'session_id',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentChunk extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'embedding' => 'array',
        'metadata' => 'array',
    ];

    // Accessor to handle null embeddings gracefully
    public function getEmbeddingAttribute($value)
    {
        return json_decode($value, true) ?? [];
    }
}

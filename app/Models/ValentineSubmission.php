<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use App\Traits\UploadFileTrait;

class ValentineSubmission extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'meta_data' => 'array',
        'accepted_at' => 'datetime',
        'rejected_at' => 'datetime',
    ];

    /**
     * Boot the model and generate UUID on creation.
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

    /**
     * Get the shareable URL for this submission.
     */
    public function getShareUrlAttribute(): string
    {
        return route('valentine.show', $this->uuid);
    }

    /**
     * Increment the open count.
     */
    public function incrementOpenCount(): void
    {
        $this->increment('open_count');
    }

    /**
     * Increment the like count.
     */
    public function incrementLikesCount(): void
    {
        $this->increment('likes_count');
    }

    /**
     * Mark as accepted.
     */
    public function markAsAccepted(): void
    {
        $this->update([
            'status' => 'accepted',
            'accepted_at' => now(),
        ]);
    }

    /**
     * Mark as rejected.
     */
    public function markAsRejected(): void
    {
        $this->update([
            'status' => 'rejected',
            'rejected_at' => now(),
        ]);
    }

    /**
     * Get day configuration (emoji, color theme, etc.)
     */
    public static function getDayConfig(): array
    {
        return [
            'rose' => [
                'name' => 'Rose Day',
                'emoji' => '🌹',
                'date' => '02-07',
                'theme' => 'from-rose-500 to-red-600',
                'bg_color' => '#ff4d6d',
            ],
            'propose' => [
                'name' => 'Propose Day',
                'emoji' => '💍',
                'date' => '02-08',
                'theme' => 'from-pink-500 to-rose-600',
                'bg_color' => '#ff758f',
            ],
            'chocolate' => [
                'name' => 'Chocolate Day',
                'emoji' => '🍫',
                'date' => '02-09',
                'theme' => 'from-amber-700 to-yellow-900',
                'bg_color' => '#7c4a03',
            ],
            'teddy' => [
                'name' => 'Teddy Day',
                'emoji' => '🧸',
                'date' => '02-10',
                'theme' => 'from-amber-300 to-orange-400',
                'bg_color' => '#ffb347',
            ],
            'promise' => [
                'name' => 'Promise Day',
                'emoji' => '🤝',
                'date' => '02-11',
                'theme' => 'from-purple-500 to-indigo-600',
                'bg_color' => '#a855f7',
            ],
            'hug' => [
                'name' => 'Hug Day',
                'emoji' => '🤗',
                'date' => '02-12',
                'theme' => 'from-orange-400 to-pink-500',
                'bg_color' => '#ff8fab',
            ],
            'kiss' => [
                'name' => 'Kiss Day',
                'emoji' => '💋',
                'date' => '02-13',
                'theme' => 'from-red-500 to-pink-600',
                'bg_color' => '#e63946',
            ],
            'valentine' => [
                'name' => "Valentine's Day",
                'emoji' => '❤️',
                'date' => '02-14',
                'theme' => 'from-red-600 to-rose-700',
                'bg_color' => '#dc2626',
            ],
        ];
    }
}

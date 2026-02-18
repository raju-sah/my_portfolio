<?php

namespace App\Models;

use App\Enums\ArticleType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Traits\UploadFileTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Article extends Model
{
    use HasFactory;
    use UploadFileTrait;

    protected $guarded = [];

    protected $casts = [
        'type' => ArticleType::class,
    ];

    public function getImagePathAttribute(): string
    {
        return $this->image ? asset('uploaded-images/article-images/' . $this->image) : 'https://upload.wikimedia.org/wikipedia/commons/a/ac/No_image_available.svg';
    }

    public function ipAddresses(): MorphMany
    {
        return $this->morphMany(IpAddress::class, 'ip_addressable');
    }

    public function scopeArticles($query)
    {
        return $query->where('type', ArticleType::Article);
    }

    public function scopeStories($query)
    {
        return $query->where('type', ArticleType::Story);
    }

    public function scopeWithAvgRating($query)
    {
        return $query->addSelect([
            'reviews_avg_rating' => function ($query) {
                $query->selectRaw('CEIL(COALESCE(AVG(rating), 0))')->from('reviews')->where('reviews.status', 1)->whereColumn('reviews.article_id', 'articles.id');
            },
        ]);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function getPDFFileName($filename): string
    {
        return $filename . now()->format('Y-m-d') . '.pdf';
    }
}

<?php

namespace App\Enums;

enum ArticleType: string
{
    case Article = 'article';
    case Story = 'story';

    public function label(): string
    {
        return match ($this) {
            self::Article => 'Article',
            self::Story   => 'Story',
        };
    }

    public static function labels(): array
    {
        return array_reduce(self::cases(), function ($carry, $item) {
            $carry[$item->value] = $item->label();
            return $carry;
        }, []);
    }
}

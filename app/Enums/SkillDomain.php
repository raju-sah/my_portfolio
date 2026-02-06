<?php

namespace App\Enums;

enum SkillDomain: int
{
    case Frontend = 1;
    case Backend = 2;
    case Database = 3;
    case Mobile = 4;
    case DevOps = 5;
    case Tools = 6;

    public function label(): string
    {
        return match ($this) {
            self::Frontend => 'Frontend',
            self::Backend => 'Backend',
            self::Database => 'Database',
            self::Mobile => 'Mobile',
            self::DevOps => 'DevOps',
            self::Tools => 'Tools',
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

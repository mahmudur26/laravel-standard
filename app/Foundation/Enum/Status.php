<?php

namespace App\Foundation\Enum;

use App\Foundation\Trait\EnumSafe;

enum Status: int
{
    use EnumSafe;
    case INACTIVE = 0;
    case ACTIVE = 1;
    case DELETED = 10;

    public static function default(): self
    {
        return self::INACTIVE;
    }
    public function name(): string
    {
        return match ($this) {
            self::ACTIVE => 'Active',
            self::INACTIVE => 'Inactive',
            self::DELETED => 'Deleted',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::ACTIVE => '<span class="material-symbols-outlined positive-icon-color">check_circle</span>',
            self::INACTIVE => '<span class="material-symbols-outlined negative-icon-color">cancel</span>',
            self::DELETED => '<span class="material-symbols-outlined negative-icon-color">block</span>',
        };
    }

    public function icon_color(): string
    {
        return match ($this) {
            self::ACTIVE => 'positive-icon-color',
            self::INACTIVE => 'negative-icon-color',
            self::DELETED => 'negative-icon-color',
        };
    }
}

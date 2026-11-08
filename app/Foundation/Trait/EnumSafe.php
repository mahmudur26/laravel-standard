<?php

namespace App\Foundation\Trait;

trait EnumSafe
{
    public static function safeTryFrom($key)
    {
        return static::tryFrom($key) ?? static::default();
    }
}

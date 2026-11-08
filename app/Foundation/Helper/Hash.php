<?php

namespace App\Foundation\Helper;

class Hash{
    public static function generate(string $key, string $time = NULL): string
    {
        return hash('sha256', $key . $time);
    }

    public static function check(string $hash, string $key, string $time = NULL): bool
    {
        $generatedHash = hash('sha256', $key . $time);
        return hash_equals($generatedHash, $hash);
    }
}

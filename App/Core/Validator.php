<?php
namespace App\Core;

final class Validator
{
    public static function required(string $value): bool
    {
        return trim($value) !== '';
    }

    public static function email(string $value): bool
    {
        return filter_var(trim($value), FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function lengthBetween(string $value, int $min, int $max): bool
    {
        $length = mb_strlen(trim($value), 'UTF-8');
        return $length >= $min && $length <= $max;
    }

    public static function safeText(string $value): string
    {
        return trim(strip_tags($value));
    }
}

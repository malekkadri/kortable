<?php

namespace App\Support\Localization;

final class Locale
{
    public const SUPPORTED = ['fr', 'ar', 'en'];

    public static function isSupported(string $locale): bool
    {
        return in_array($locale, self::SUPPORTED, true);
    }

    public static function fallback(): string
    {
        return config('app.fallback_locale', 'en');
    }
}

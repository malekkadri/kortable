<?php

namespace App\Support\Localization;

final class Locale
{
    public static function all(): array
    {
        return config('kortable.locales', ['fr', 'ar', 'en']);
    }

    public static function isSupported(string $locale): bool
    {
        return in_array($locale, self::all(), true);
    }

    public static function fallback(): string
    {
        return config('app.fallback_locale', 'fr');
    }

    public static function direction(?string $locale = null): string
    {
        $locale ??= app()->getLocale();

        return in_array($locale, config('kortable.rtl_locales', ['ar']), true) ? 'rtl' : 'ltr';
    }

    public static function isRtl(?string $locale = null): bool
    {
        return self::direction($locale) === 'rtl';
    }
}

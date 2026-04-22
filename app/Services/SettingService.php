<?php

namespace App\Services;

use App\Models\Setting;

class SettingService
{
    public function get(string $key, string $locale = null, mixed $default = null): mixed
    {
        $setting = Setting::where('key', $key)->first();

        if (! $setting) {
            return $default;
        }

        if (! $setting->is_translatable) {
            return $setting->value['default'] ?? $default;
        }

        $locale = $locale ?? app()->getLocale();

        return $setting->value[$locale]
            ?? $setting->value[config('app.fallback_locale')]
            ?? $default;
    }

    public function set(string $group, string $key, array $value, bool $isTranslatable = true): Setting
    {
        return Setting::updateOrCreate(
            ['key' => $key],
            [
                'group' => $group,
                'value' => $value,
                'is_translatable' => $isTranslatable,
            ]
        );
    }
}

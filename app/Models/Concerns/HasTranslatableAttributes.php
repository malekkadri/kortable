<?php

namespace App\Models\Concerns;

use App\Support\Localization\Locale;

trait HasTranslatableAttributes
{
    public function getTranslated(string $attribute, ?string $locale = null, mixed $fallback = null): mixed
    {
        $locale ??= app()->getLocale();
        $values = $this->{$attribute} ?? [];

        if (! is_array($values)) {
            return $values ?? $fallback;
        }

        $fallbackLocale = Locale::fallback();

        return $values[$locale] ?? $values[$fallbackLocale] ?? $fallback;
    }

    public function translatedAttributes(array $attributes, ?string $locale = null): array
    {
        return collect($attributes)
            ->mapWithKeys(fn (string $attribute) => [$attribute => $this->getTranslated($attribute, $locale)])
            ->all();
    }
}

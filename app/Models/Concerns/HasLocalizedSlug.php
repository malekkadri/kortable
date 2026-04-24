<?php

namespace App\Models\Concerns;

use App\Support\Localization\Locale;

trait HasLocalizedSlug
{
    public function localizedSlug(?string $locale = null): string
    {
        $locale ??= app()->getLocale();
        $fallback = Locale::fallback();

        return $this->slug_translations[$locale]
            ?? $this->slug_translations[$fallback]
            ?? $this->slug;
    }
}

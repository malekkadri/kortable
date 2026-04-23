<?php

namespace App\Support\Seo;

use App\Models\SiteSetting;
use App\Support\Localization\Locale;

class SeoData
{
    public static function forContent(array $contentSeo, ?string $title = null, ?string $description = null, ?string $image = null): array
    {
        $locale = app()->getLocale();
        $settings = SiteSetting::query()->first();
        $defaults = $settings?->seo_defaults ?? [];

        $metaTitle = $contentSeo['meta_title'][$locale]
            ?? $contentSeo['meta_title'][Locale::fallback()]
            ?? $title
            ?? $defaults['title'][$locale]
            ?? $defaults['title'][Locale::fallback()]
            ?? $settings?->site_name[$locale]
            ?? config('app.name');

        $metaDescription = $contentSeo['meta_description'][$locale]
            ?? $contentSeo['meta_description'][Locale::fallback()]
            ?? $description
            ?? $defaults['description'][$locale]
            ?? $defaults['description'][Locale::fallback()]
            ?? $settings?->tagline[$locale]
            ?? null;

        $ogImage = $contentSeo['og_image']
            ?? $image
            ?? $defaults['og_image']
            ?? null;

        return [
            'title' => $metaTitle,
            'description' => $metaDescription,
            'og_image' => $ogImage,
            'site_name' => $settings?->site_name[$locale] ?? config('app.name'),
        ];
    }
}

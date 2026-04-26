@php
    $siteSetting = \App\Models\SiteSetting::query()->first();
    $seo = $seo ?? [];
    $locale = app()->getLocale();
    $allLocales = \App\Support\Localization\Locale::all();

    $path = request()->path();
    $segments = explode('/', trim($path, '/'));

    if (! empty($segments) && in_array($segments[0], $allLocales, true)) {
        array_shift($segments);
    }

    $localizedPath = implode('/', $segments);
    $canonical = $seo['canonical'] ?? url()->current();
    $ogImage = $seo['og_image'] ?? ($siteSetting?->seo_defaults['og_image'] ?? null);
@endphp

<title>{{ $seo['title'] ?? ($siteSetting?->seo_defaults['title'][$locale] ?? $siteSetting?->site_name[$locale] ?? config('app.name')) }}</title>
<meta name="description" content="{{ $seo['description'] ?? ($siteSetting?->seo_defaults['description'][$locale] ?? $siteSetting?->tagline[$locale] ?? '') }}">
<meta property="og:locale" content="{{ str_replace('-', '_', $locale) }}">
<meta property="og:type" content="website">
<meta property="og:title" content="{{ $seo['title'] ?? ($siteSetting?->seo_defaults['title'][$locale] ?? $siteSetting?->site_name[$locale] ?? config('app.name')) }}">
<meta property="og:description" content="{{ $seo['description'] ?? ($siteSetting?->seo_defaults['description'][$locale] ?? $siteSetting?->tagline[$locale] ?? '') }}">
<meta property="og:site_name" content="{{ $seo['site_name'] ?? ($siteSetting?->site_name[$locale] ?? config('app.name')) }}">
<meta property="og:url" content="{{ $canonical }}">
@if (! empty($ogImage))
<meta property="og:image" content="{{ str_starts_with($ogImage, 'http') ? $ogImage : asset('storage/' . $ogImage) }}">
@endif
<link rel="canonical" href="{{ $canonical }}">
@foreach ($allLocales as $altLocale)
    <link rel="alternate" hreflang="{{ $altLocale }}" href="{{ url($altLocale . ($localizedPath ? '/' . $localizedPath : '')) }}">
@endforeach
<link rel="alternate" hreflang="x-default" href="{{ url(\App\Support\Localization\Locale::fallback() . ($localizedPath ? '/' . $localizedPath : '')) }}">

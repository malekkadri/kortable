@php
    use App\Support\Localization\Locale;
    use App\Models\SiteSetting;

    $siteSetting = SiteSetting::query()->first();
    $seo = $seo ?? [];
    $locale = app()->getLocale();
    $allLocales = Locale::all();
    $path = request()->path();
    $segments = explode('/', trim($path, '/'));
    if (! empty($segments) && in_array($segments[0], $allLocales, true)) {
        array_shift($segments);
    }
    $localizedPath = implode('/', $segments);
    $canonical = $seo['canonical'] ?? url()->current();
@endphp

<title>{{ $seo['title'] ?? ($siteSetting?->seo_defaults['title'][$locale] ?? $siteSetting?->site_name[$locale] ?? config('app.name')) }}</title>
<meta name="description" content="{{ $seo['description'] ?? ($siteSetting?->seo_defaults['description'][$locale] ?? $siteSetting?->tagline[$locale] ?? '') }}">
<meta property="og:locale" content="{{ str_replace('-', '_', $locale) }}">
<meta property="og:type" content="website">
<meta property="og:title" content="{{ $seo['title'] ?? ($siteSetting?->seo_defaults['title'][$locale] ?? $siteSetting?->site_name[$locale] ?? config('app.name')) }}">
<meta property="og:description" content="{{ $seo['description'] ?? ($siteSetting?->seo_defaults['description'][$locale] ?? $siteSetting?->tagline[$locale] ?? '') }}">
<meta property="og:site_name" content="{{ $seo['site_name'] ?? ($siteSetting?->site_name[$locale] ?? config('app.name')) }}">
<meta property="og:url" content="{{ $canonical }}">
@php($ogImage = $seo['og_image'] ?? ($siteSetting?->seo_defaults['og_image'] ?? null))
@if(!empty($ogImage))
<meta property="og:image" content="{{ str_starts_with($ogImage, 'http') ? $ogImage : asset('storage/'.$ogImage) }}">
@endif
<link rel="canonical" href="{{ $canonical }}">
@foreach($allLocales as $altLocale)
    @php
        $altUrl = url($altLocale.($localizedPath ? '/'.$localizedPath : ''));
    @endphp
    <link rel="alternate" hreflang="{{ $altLocale }}" href="{{ $altUrl }}">
@endforeach
<link rel="alternate" hreflang="x-default" href="{{ url(Locale::fallback().($localizedPath ? '/'.$localizedPath : '')) }}">

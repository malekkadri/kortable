@php
    use App\Models\Menu;
    use App\Models\SiteSetting;
    use App\Support\Localization\Locale;

    $locale = app()->getLocale();
    $isRtl = Locale::isRtl($locale);
    $siteSetting = SiteSetting::first();
    $headerMenu = Menu::where('location', 'header')->where('is_active', true)->with(['items' => fn($q) => $q->whereNull('parent_id')->where('is_active', true)->with(['children' => fn ($childQuery) => $childQuery->where('is_active', true), 'page'])])->first();
    $footerMenu = Menu::where('location', 'footer')->where('is_active', true)->with(['items' => fn($q) => $q->whereNull('parent_id')->where('is_active', true)->with(['children' => fn ($childQuery) => $childQuery->where('is_active', true), 'page'])])->first();
@endphp

<!DOCTYPE html>
<html lang="{{ $locale }}" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? ($siteSetting?->site_name[$locale] ?? config('app.name')) }}</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-900 min-h-screen {{ $isRtl ? 'text-right' : 'text-left' }}">
    <header class="border-b bg-white">
        <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center gap-6">
            <a href="{{ route('front.home', ['locale' => $locale]) }}" class="font-semibold text-lg flex items-center gap-2">
                @if($siteSetting?->logo)
                    <img src="{{ asset('storage/'.$siteSetting->logo) }}" class="h-8" alt="logo">
                @endif
                <span>{{ $siteSetting?->site_name[$locale] ?? config('app.name') }}</span>
            </a>
            <nav class="flex gap-6 text-sm">
                @foreach($headerMenu?->items ?? [] as $item)
                    @php($url = $item->resolveUrl($locale))
                    <div class="relative" x-data="{ open: false }">
                        @if($item->children->isNotEmpty())
                            <button type="button" @mouseenter="open = true" @mouseleave="open = false" class="flex items-center gap-1">
                                {{ $item->label[$locale] ?? $item->label['en'] ?? '' }}
                            </button>
                            <div x-show="open" @mouseenter="open = true" @mouseleave="open = false" x-cloak class="absolute z-10 mt-2 min-w-48 bg-white border rounded shadow p-2">
                                @foreach($item->children as $child)
                                    @php($childUrl = $child->resolveUrl($locale))
                                    @if($childUrl)
                                        <a class="block px-2 py-1 rounded hover:bg-slate-50" href="{{ $childUrl }}">{{ $child->label[$locale] ?? $child->label['en'] ?? '' }}</a>
                                    @endif
                                @endforeach
                            </div>
                        @elseif($url)
                            <a href="{{ $url }}">{{ $item->label[$locale] ?? $item->label['en'] ?? '' }}</a>
                        @endif
                    </div>
                @endforeach
            </nav>
            <x-language-switcher />
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-4 py-10">
        @yield('content')
    </main>

    <footer class="border-t bg-white mt-10">
        <div class="max-w-6xl mx-auto px-4 py-8 grid md:grid-cols-3 gap-4 text-sm">
            <div>{{ $siteSetting?->footer_content[$locale] ?? '' }}</div>
            <div>
                <p>{{ $siteSetting?->contact_email }}</p>
                <p>{{ $siteSetting?->phone }}</p>
            </div>
            <div class="space-y-1">
                @foreach($footerMenu?->items ?? [] as $item)
                    @php($url = $item->resolveUrl($locale))
                    @if($url)
                        <a class="block" href="{{ $url }}">{{ $item->label[$locale] ?? $item->label['en'] ?? '' }}</a>
                    @endif
                    @foreach($item->children as $child)
                        @php($childUrl = $child->resolveUrl($locale))
                        @if($childUrl)
                            <a class="block {{ $isRtl ? 'mr-3' : 'ml-3' }} text-slate-500" href="{{ $childUrl }}">{{ $child->label[$locale] ?? $child->label['en'] ?? '' }}</a>
                        @endif
                    @endforeach
                @endforeach
            </div>
        </div>
    </footer>
</body>
</html>

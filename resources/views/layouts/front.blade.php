@php
    use App\Models\Menu;
    use App\Models\SiteSetting;
    use App\Support\Localization\Locale;

    $locale = app()->getLocale();
    $isRtl = Locale::isRtl($locale);
    $siteSetting = SiteSetting::first();
    $headerMenu = Menu::where('location', 'header')->where('is_active', true)->with(['items' => fn($q) => $q->whereNull('parent_id')->where('is_active', true)->with('children')])->first();
    $footerMenu = Menu::where('location', 'footer')->where('is_active', true)->with(['items' => fn($q) => $q->whereNull('parent_id')->where('is_active', true)->with('children')])->first();
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
            <nav class="flex gap-4 text-sm">
                @foreach($headerMenu?->items ?? [] as $item)
                    @php
                        $url = $item->type === 'page' && $item->page ? route('front.pages.show', ['locale' => $locale, 'slug' => $item->page->slug]) : $item->custom_url;
                    @endphp
                    <a href="{{ $url }}">{{ $item->label[$locale] ?? $item->label['en'] ?? '' }}</a>
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
                    @php $url = $item->type === 'page' && $item->page ? route('front.pages.show', ['locale' => $locale, 'slug' => $item->page->slug]) : $item->custom_url; @endphp
                    <a class="block" href="{{ $url }}">{{ $item->label[$locale] ?? $item->label['en'] ?? '' }}</a>
                @endforeach
            </div>
        </div>
    </footer>
</body>
</html>

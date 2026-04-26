@php
    use App\Models\Menu;
    use App\Models\SiteSetting;
    use App\Support\Localization\Locale;

    $locale = app()->getLocale();
    $isRtl = Locale::isRtl($locale);
    $siteSetting = SiteSetting::first();
    $siteName = $siteSetting?->getLocalized('site_name', $locale) ?: config('app.name');
    $headerMenu = Menu::where('location', 'header')->where('is_active', true)->with(['items' => fn ($q) => $q->whereNull('parent_id')->where('is_active', true)->with(['children' => fn ($childQuery) => $childQuery->where('is_active', true)->with(['page', 'blogCategory']), 'page', 'blogCategory'])])->first();
    $footerMenu = Menu::where('location', 'footer')->where('is_active', true)->with(['items' => fn ($q) => $q->whereNull('parent_id')->where('is_active', true)->with(['children' => fn ($childQuery) => $childQuery->where('is_active', true)->with(['page', 'blogCategory']), 'page', 'blogCategory'])])->first();
@endphp

<!DOCTYPE html>
<html lang="{{ $locale }}" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @if($siteSetting?->favicon)
    <link rel="icon" type="image/x-icon" href="{{ \App\Support\Media\MediaManager::url($siteSetting->favicon, 'images/placeholders/avatar.svg') }}">
    @endif
    @include('front.partials.seo')
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
        .reveal { opacity: 0; transform: translateY(18px); transition: opacity .5s ease, transform .5s ease; }
        .reveal.show { opacity: 1; transform: translateY(0); }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-b from-slate-50 via-white to-slate-100 text-slate-900 {{ $isRtl ? 'text-right' : 'text-left' }}">
    <div x-data="{ mobileOpen: false }" class="relative isolate">
        <header class="sticky top-0 z-40 border-b border-slate-200/70 bg-white/90 backdrop-blur">
            <div class="mx-auto flex w-full max-w-6xl items-center justify-between gap-4 px-4 py-3 md:px-6">
                <a href="{{ route('front.home', ['locale' => $locale]) }}" class="flex items-center gap-3 font-semibold text-slate-900">
                    <img src="{{ \App\Support\Media\MediaManager::url($siteSetting?->logo, 'images/placeholders/avatar.svg') }}" class="h-10 w-10 rounded-full border border-slate-200 object-cover" alt="{{ $siteName }} logo">
                    <span class="text-base md:text-lg">{{ $siteName }}</span>
                </a>

                <button type="button" @click="mobileOpen = !mobileOpen" class="rounded-lg border border-slate-300 p-2 md:hidden" aria-label="Toggle menu">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                </button>

                <nav class="hidden items-center gap-1 text-sm md:flex">
                    @forelse($headerMenu?->items ?? [] as $item)
                        @php($url = $item->resolveUrl($locale))
                        <div class="relative" x-data="{ open: false }">
                            @if($item->children->isNotEmpty())
                                <button type="button" @mouseenter="open = true" @mouseleave="open = false" class="inline-flex items-center gap-1 rounded-lg px-3 py-2 text-slate-700 transition hover:bg-slate-100">
                                    {{ $item->label[$locale] ?? $item->label['en'] ?? '' }}
                                </button>
                                <div x-show="open" @mouseenter="open = true" @mouseleave="open = false" x-cloak class="absolute {{ $isRtl ? 'left-0' : 'right-0' }} z-20 mt-2 min-w-56 space-y-1 rounded-xl border border-slate-200 bg-white p-2 shadow-lg">
                                    @foreach($item->children as $child)
                                        @php($childUrl = $child->resolveUrl($locale))
                                        @if($childUrl)
                                            <a class="block rounded-lg px-3 py-2 text-slate-700 transition hover:bg-slate-50" href="{{ $childUrl }}">{{ $child->label[$locale] ?? $child->label['en'] ?? '' }}</a>
                                        @endif
                                    @endforeach
                                </div>
                            @elseif($url)
                                <a href="{{ $url }}" class="rounded-lg px-3 py-2 text-slate-700 transition hover:bg-slate-100">{{ $item->label[$locale] ?? $item->label['en'] ?? '' }}</a>
                            @endif
                        </div>
                    @empty
                        <a href="{{ route('front.home', ['locale' => $locale]) }}" class="rounded-lg px-3 py-2 text-slate-700 transition hover:bg-slate-100">{{ __('Home') }}</a>
                    @endforelse
                </nav>

                <div class="hidden md:block">
                    <x-language-switcher />
                </div>
            </div>

            <div x-show="mobileOpen" x-cloak x-transition class="border-t border-slate-200 bg-white md:hidden">
                <div class="space-y-1 px-4 py-3">
                    @foreach($headerMenu?->items ?? [] as $item)
                        @php($url = $item->resolveUrl($locale))
                        @if($url)
                            <a href="{{ $url }}" @click="mobileOpen = false" class="block rounded-lg px-3 py-2 text-slate-700 hover:bg-slate-100">{{ $item->label[$locale] ?? $item->label['en'] ?? '' }}</a>
                        @endif
                        @foreach($item->children as $child)
                            @php($childUrl = $child->resolveUrl($locale))
                            @if($childUrl)
                                <a href="{{ $childUrl }}" @click="mobileOpen = false" class="{{ $isRtl ? 'mr-4' : 'ml-4' }} block rounded-lg px-3 py-2 text-slate-600 hover:bg-slate-100">{{ $child->label[$locale] ?? $child->label['en'] ?? '' }}</a>
                            @endif
                        @endforeach
                    @endforeach
                    <div class="pt-2">
                        <x-language-switcher />
                    </div>
                </div>
            </div>
        </header>

        <main class="mx-auto w-full max-w-6xl px-4 py-8 md:px-6 md:py-12">
            @yield('content')
        </main>

        <footer class="mt-10 border-t border-slate-200 bg-white/90">
            <div class="mx-auto grid w-full max-w-6xl gap-6 px-4 py-10 text-sm text-slate-600 md:grid-cols-3 md:px-6">
                <div>
                    <p class="mb-2 font-semibold text-slate-900">{{ $siteName }}</p>
                    <p>{{ $siteSetting?->footer_content[$locale] ?? __('ui.no_content_available') }}</p>
                </div>
                <div class="space-y-1">
                    <p class="font-semibold text-slate-900">{{ __('ui.contact_information') }}</p>
                    <p>{{ $siteSetting?->contact_email ?: __('ui.no_content_available') }}</p>
                    <p>{{ $siteSetting?->phone ?: __('ui.no_content_available') }}</p>
                </div>
                <div class="space-y-1">
                    <p class="font-semibold text-slate-900">{{ __('Navigation') }}</p>
                    @forelse($footerMenu?->items ?? [] as $item)
                        @php($url = $item->resolveUrl($locale))
                        @if($url)
                            <a class="block transition hover:text-slate-900" href="{{ $url }}">{{ $item->label[$locale] ?? $item->label['en'] ?? '' }}</a>
                        @endif
                        @foreach($item->children as $child)
                            @php($childUrl = $child->resolveUrl($locale))
                            @if($childUrl)
                                <a class="{{ $isRtl ? 'mr-4' : 'ml-4' }} block text-slate-500 transition hover:text-slate-900" href="{{ $childUrl }}">{{ $child->label[$locale] ?? $child->label['en'] ?? '' }}</a>
                            @endif
                        @endforeach
                    @empty
                        <p>{{ __('ui.no_content_available') }}</p>
                    @endforelse
                </div>
            </div>
        </footer>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const elements = document.querySelectorAll('[data-reveal]');
            if (!elements.length) return;

            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('show');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.08, rootMargin: '0px 0px -40px 0px' });

            elements.forEach((el, index) => {
                el.classList.add('reveal');
                el.style.transitionDelay = `${Math.min(index * 40, 240)}ms`;
                observer.observe(el);
            });
        });
    </script>
</body>
</html>

@php
    use App\Support\Localization\Locale;

    $locale = app()->getLocale();
    $isRtl = Locale::isRtl($locale);
@endphp

<!DOCTYPE html>
<html lang="{{ $locale }}" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? config('app.name') }}</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-900 min-h-screen {{ $isRtl ? 'text-right' : 'text-left' }}">
    <header class="border-b bg-white">
        <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">
            <a href="{{ route('front.home') }}" class="font-semibold text-lg">{{ config('app.name') }}</a>
            <x-language-switcher />
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-4 py-10">
        @yield('content')
    </main>
</body>
</html>

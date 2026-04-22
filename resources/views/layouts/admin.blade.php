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
    <title>{{ $title ?? __('ui.admin_panel') }}</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 min-h-screen text-slate-900 {{ $isRtl ? 'text-right' : 'text-left' }}">
    <div class="min-h-screen grid grid-cols-1 md:grid-cols-[240px_1fr]">
        <aside class="bg-slate-900 text-slate-100 p-4 space-y-3">
            <h1 class="font-semibold">{{ __('ui.admin_panel') }}</h1>
            <nav class="space-y-2 text-sm">
                <a class="block hover:text-white" href="{{ route('admin.dashboard') }}">{{ __('ui.dashboard') }}</a>
                <a class="block hover:text-white" href="{{ route('admin.settings.edit') }}">{{ __('ui.settings') }}</a>
                <a class="block hover:text-white" href="{{ route('admin.modules.index') }}">{{ __('ui.modules') }}</a>
            </nav>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="mt-4 text-xs underline">{{ __('ui.logout') }}</button>
            </form>
        </aside>
        <main class="p-6">
            @yield('content')
        </main>
    </div>
</body>
</html>

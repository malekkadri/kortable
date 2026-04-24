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
    <div class="min-h-screen grid grid-cols-1 md:grid-cols-[260px_1fr]">
        <aside class="bg-slate-900 text-slate-100 p-5">
            <h1 class="text-lg font-semibold mb-6">{{ __('ui.admin_panel') }}</h1>
            <nav class="space-y-1 text-sm">
                <a class="block px-3 py-2 rounded hover:bg-slate-800" href="{{ route('admin.dashboard') }}">{{ __('ui.dashboard') }}</a>

                @can('manage_users')
                    <a class="block px-3 py-2 rounded hover:bg-slate-800" href="{{ route('admin.users.index') }}">{{ __('ui.users') }}</a>
                @endcan

                @can('manage_settings')
                    <a class="block px-3 py-2 rounded hover:bg-slate-800" href="{{ route('admin.settings.edit') }}">{{ __('ui.settings') }}</a>
                @endcan

                @can('manage_messages')
                    <a class="block px-3 py-2 rounded hover:bg-slate-800" href="{{ route('admin.contact-messages.index') }}">{{ __('ui.contact_messages') }}</a>
                @endcan

                @can('manage_pages')
                    <a class="block px-3 py-2 rounded hover:bg-slate-800" href="{{ route('admin.pages.index') }}">Pages</a>
                    <a class="block px-3 py-2 rounded hover:bg-slate-800" href="{{ route('admin.home-sections.index') }}">Homepage Sections</a>
                    <a class="block px-3 py-2 rounded hover:bg-slate-800" href="{{ route('admin.testimonials.index') }}">Testimonials</a>
                    <a class="block px-3 py-2 rounded hover:bg-slate-800" href="{{ route('admin.project-categories.index') }}">Project Categories</a>
                    <a class="block px-3 py-2 rounded hover:bg-slate-800" href="{{ route('admin.blog-categories.index') }}">Blog Categories</a>
                    <a class="block px-3 py-2 rounded hover:bg-slate-800" href="{{ route('admin.blog-posts.index') }}">Blog Posts</a>
                @endcan

                @can('manage_projects')
                    <a class="block px-3 py-2 rounded hover:bg-slate-800" href="{{ route('admin.projects.index') }}">Projects</a>
                @endcan

                @can('manage_services')
                    <a class="block px-3 py-2 rounded hover:bg-slate-800" href="{{ route('admin.services.index') }}">Services</a>
                @endcan

                @can('manage_menus')
                    <a class="block px-3 py-2 rounded hover:bg-slate-800" href="{{ route('admin.menus.index') }}">Menus</a>
                @endcan
            </nav>
        </aside>

        <section class="flex flex-col">
            <header class="bg-white border-b px-6 py-4 flex items-center justify-between gap-4">
                <p class="text-sm text-slate-500">{{ __('ui.admin_welcome') }}</p>
                <div class="flex items-center gap-3">
                    <p class="text-sm font-medium">{{ auth()->user()?->name }}</p>
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-xs px-3 py-2 rounded border border-slate-300 hover:bg-slate-50">{{ __('ui.logout') }}</button>
                    </form>
                </div>
            </header>

            <main class="p-6">
                @if (session('status'))
                    <div class="mb-4 rounded border border-green-200 bg-green-50 text-green-800 px-4 py-3 text-sm">
                        {{ session('status') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </section>
    </div>
</body>
</html>

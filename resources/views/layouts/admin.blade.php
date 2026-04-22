<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin · '.config('app.name') }}</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 min-h-screen text-slate-900">
    <div class="min-h-screen grid grid-cols-1 md:grid-cols-[240px_1fr]">
        <aside class="bg-slate-900 text-slate-100 p-4 space-y-3">
            <h1 class="font-semibold">Kortable Admin</h1>
            <nav class="space-y-2 text-sm">
                <a class="block hover:text-white" href="{{ route('admin.dashboard') }}">Dashboard</a>
                <a class="block hover:text-white" href="{{ route('admin.settings.edit') }}">Settings</a>
                <a class="block hover:text-white" href="{{ route('admin.modules.index') }}">Modules</a>
            </nav>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="mt-4 text-xs underline">Logout</button>
            </form>
        </aside>
        <main class="p-6">
            @yield('content')
        </main>
    </div>
</body>
</html>

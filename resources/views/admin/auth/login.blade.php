@php
    use App\Support\Localization\Locale;

    $locale = app()->getLocale();
@endphp

<!DOCTYPE html>
<html lang="{{ $locale }}" dir="{{ Locale::direction($locale) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('ui.admin_login') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 min-h-screen grid place-items-center">
    <form class="bg-white border rounded-xl p-6 w-full max-w-md space-y-4" method="POST" action="{{ route('admin.login.store') }}">
        @csrf
        <h1 class="text-xl font-semibold">{{ __('ui.admin_login') }}</h1>

        <div>
            <label class="block text-sm mb-1" for="email">{{ __('ui.email') }}</label>
            <input class="w-full border rounded px-3 py-2" id="email" name="email" type="email" value="{{ old('email') }}" required>
            @error('email') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm mb-1" for="password">{{ __('ui.password') }}</label>
            <input class="w-full border rounded px-3 py-2" id="password" name="password" type="password" required>
        </div>

        <button class="w-full bg-slate-900 text-white py-2 rounded" type="submit">{{ __('ui.login') }}</button>
    </form>
</body>
</html>

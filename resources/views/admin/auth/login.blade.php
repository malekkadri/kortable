<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 min-h-screen grid place-items-center">
    <form class="bg-white border rounded-xl p-6 w-full max-w-md space-y-4" method="POST" action="{{ route('admin.login.store') }}">
        @csrf
        <h1 class="text-xl font-semibold">Admin Login</h1>

        <div>
            <label class="block text-sm mb-1" for="email">Email</label>
            <input class="w-full border rounded px-3 py-2" id="email" name="email" type="email" value="{{ old('email') }}" required>
            @error('email') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm mb-1" for="password">Password</label>
            <input class="w-full border rounded px-3 py-2" id="password" name="password" type="password" required>
        </div>

        <button class="w-full bg-slate-900 text-white py-2 rounded" type="submit">Login</button>
    </form>
</body>
</html>

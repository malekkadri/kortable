@props([
    'name',
    'label',
    'values' => [],
    'locales' => config('kortable.locales'),
])

<div>
    <h3 class="font-medium mb-2">{{ $label }}</h3>
    <div class="grid md:grid-cols-3 gap-3">
        @foreach ($locales as $locale)
            <div>
                <label class="block text-xs text-slate-500 mb-1" for="{{ $name }}_{{ $locale }}">{{ strtoupper($locale) }}</label>
                <input
                    id="{{ $name }}_{{ $locale }}"
                    name="{{ $name }}[{{ $locale }}]"
                    value="{{ old($name.'.'.$locale, $values[$locale] ?? '') }}"
                    class="w-full border rounded px-3 py-2"
                >
                @error($name.'.'.$locale)
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
        @endforeach
    </div>
</div>

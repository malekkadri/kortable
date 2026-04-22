@props([
    'name',
    'label',
    'values' => [],
    'type' => 'text',
    'locales' => config('kortable.locales'),
    'rows' => 4,
    'required' => false,
])

<div x-data="{ activeLocale: '{{ $locales[0] ?? 'en' }}' }" class="space-y-2">
    <label class="block text-sm font-medium text-slate-700">{{ $label }}</label>
    <div class="flex gap-2 border-b border-slate-200 pb-2">
        @foreach ($locales as $locale)
            <button
                type="button"
                class="px-3 py-1 text-xs rounded border"
                :class="activeLocale === '{{ $locale }}' ? 'bg-slate-900 text-white border-slate-900' : 'bg-white text-slate-600 border-slate-300'"
                @click="activeLocale = '{{ $locale }}'"
            >
                {{ strtoupper($locale) }}
            </button>
        @endforeach
    </div>

    @foreach ($locales as $locale)
        <div x-show="activeLocale === '{{ $locale }}'" x-cloak>
            @if ($type === 'textarea')
                <textarea
                    name="{{ $name }}[{{ $locale }}]"
                    rows="{{ $rows }}"
                    class="w-full border rounded px-3 py-2"
                    @required($required)
                >{{ old($name.'.'.$locale, $values[$locale] ?? '') }}</textarea>
            @else
                <input
                    type="text"
                    name="{{ $name }}[{{ $locale }}]"
                    value="{{ old($name.'.'.$locale, $values[$locale] ?? '') }}"
                    class="w-full border rounded px-3 py-2"
                    @required($required)
                >
            @endif

            @error($name.'.'.$locale)
                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>
    @endforeach
</div>

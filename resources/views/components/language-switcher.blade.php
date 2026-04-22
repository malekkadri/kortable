@php
    $currentLocale = app()->getLocale();
    $locales = config('kortable.locales');
@endphp

<div class="flex items-center gap-2 text-sm" aria-label="{{ __('ui.language_switcher') }}">
    <span>{{ __('messages.language') }}:</span>
    @foreach ($locales as $locale)
        <a href="{{ route('localization.switch', ['locale' => $locale]) }}"
           hreflang="{{ $locale }}"
           class="px-2 py-1 rounded border {{ $locale === $currentLocale ? 'bg-slate-900 text-white' : 'bg-white text-slate-700' }}">
            {{ __('ui.locale_name_'.$locale) }}
        </a>
    @endforeach
</div>

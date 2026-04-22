<section class="bg-slate-900 text-white rounded-xl p-8 mb-6">
    <h2 class="text-2xl font-semibold mb-2">{{ $section->getLocalized('title') }}</h2>
    @if ($section->getLocalized('subtitle'))
        <p class="text-slate-300 mb-2">{{ $section->getLocalized('subtitle') }}</p>
    @endif
    @if ($section->getLocalized('content'))
        <p class="text-slate-200 mb-5">{{ $section->getLocalized('content') }}</p>
    @endif

    @if ($section->getLocalized('cta_label') && $section->cta_link)
        <a href="{{ $section->cta_link }}" class="inline-flex px-4 py-2 bg-white text-slate-900 rounded">
            {{ $section->getLocalized('cta_label') }}
        </a>
    @endif
</section>

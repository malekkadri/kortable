<section data-reveal class="mb-8 rounded-3xl bg-slate-900 p-8 text-white md:p-10">
    <h2 class="mb-2 text-2xl font-semibold">{{ $section->getLocalized('title') ?: __('Let us build something remarkable.') }}</h2>
    @if ($section->getLocalized('subtitle'))
        <p class="mb-2 text-slate-300">{{ $section->getLocalized('subtitle') }}</p>
    @endif
    @if ($section->getLocalized('content'))
        <p class="mb-5 text-slate-200">{{ $section->getLocalized('content') }}</p>
    @endif

    @if ($section->getLocalized('cta_label') && $section->localizedCtaLink())
        <a href="{{ $section->localizedCtaLink() }}" class="inline-flex rounded-xl bg-white px-5 py-3 font-semibold text-slate-900 transition hover:bg-slate-100">
            {{ $section->getLocalized('cta_label') }}
        </a>
    @endif
</section>

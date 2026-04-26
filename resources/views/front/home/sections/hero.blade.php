<section data-reveal class="mb-8 overflow-hidden rounded-3xl border border-slate-200 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 p-8 text-white md:p-12">
    <div class="grid items-center gap-8 md:grid-cols-2">
        <div>
            <p class="mb-3 inline-flex rounded-full border border-white/20 bg-white/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-slate-200">{{ __('Portfolio Studio') }}</p>
            <h1 class="mb-4 text-3xl font-bold leading-tight md:text-5xl">{{ $section->getLocalized('title') ?: __('ui.no_content_available') }}</h1>
            @if ($section->getLocalized('subtitle'))
                <p class="mb-4 text-lg text-slate-200">{{ $section->getLocalized('subtitle') }}</p>
            @endif
            @if ($section->getLocalized('content'))
                <p class="mb-7 text-sm leading-7 text-slate-300 md:text-base">{{ $section->getLocalized('content') }}</p>
            @endif
            <div class="flex flex-wrap items-center gap-3">
                @if ($section->getLocalized('cta_label') && $section->localizedCtaLink())
                    <a href="{{ $section->localizedCtaLink() }}" class="inline-flex rounded-xl bg-white px-5 py-3 font-medium text-slate-900 transition hover:-translate-y-0.5 hover:bg-slate-100">
                        {{ $section->getLocalized('cta_label') }}
                    </a>
                @endif
                <a href="{{ route('front.projects.index', ['locale' => app()->getLocale()]) }}" class="inline-flex rounded-xl border border-white/30 px-5 py-3 font-medium text-white transition hover:bg-white/10">{{ __('Explore projects') }}</a>
            </div>
        </div>

        @if ($section->image)
            <div class="relative">
                <div class="absolute -inset-4 rounded-3xl bg-sky-400/20 blur-2xl"></div>
                <img src="{{ asset('storage/'.$section->image) }}" alt="{{ $section->getLocalized('title') }}" class="relative w-full rounded-2xl border border-white/10 object-cover shadow-2xl transition duration-500 hover:scale-[1.02]">
            </div>
        @else
            <div class="rounded-2xl border border-dashed border-white/30 bg-white/5 p-8 text-sm text-slate-300">
                {{ __('ui.no_content_available') }}
            </div>
        @endif
    </div>
</section>

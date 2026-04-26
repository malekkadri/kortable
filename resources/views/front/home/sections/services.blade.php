<section data-reveal class="mb-8 rounded-3xl border border-slate-200 bg-white p-6 md:p-8">
    <h2 class="mb-4 text-2xl font-semibold text-slate-900">{{ $section->getLocalized('title') ?: __('ui.services') }}</h2>
    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
        @forelse($services as $service)
            <article class="rounded-2xl border border-slate-200 bg-slate-50/70 p-5 transition hover:border-slate-300 hover:bg-white">
                <h3 class="mb-2 font-semibold text-slate-900">{{ $service->getTranslated('title') }}</h3>
                <p class="text-sm text-slate-600">{{ $service->getTranslated('short_description') ?: __('ui.no_content_available') }}</p>
            </article>
        @empty
            <p class="text-slate-500">{{ __('ui.no_content_available') }}</p>
        @endforelse
    </div>
</section>

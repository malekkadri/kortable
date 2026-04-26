<section data-reveal class="mb-8">
    <div class="mb-4 flex items-end justify-between gap-3">
        <div>
            <h2 class="text-2xl font-semibold text-slate-900">{{ $section->getLocalized('title') ?: __('Featured projects') }}</h2>
            @if ($section->getLocalized('subtitle'))
                <p class="text-slate-600">{{ $section->getLocalized('subtitle') }}</p>
            @endif
        </div>

        @if ($section->getLocalized('cta_label') && $section->localizedCtaLink())
            <a href="{{ $section->localizedCtaLink() }}" class="rounded-xl border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 transition hover:border-slate-900 hover:text-slate-900">{{ $section->getLocalized('cta_label') }}</a>
        @endif
    </div>

    <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
        @forelse($featuredProjects as $project)
            <article class="group overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-lg">
                <img src="{{ \App\Support\Media\MediaManager::url($project->featured_image) }}" alt="{{ $project->getTranslated('title') }}" class="h-44 w-full object-cover transition duration-500 group-hover:scale-105">
                <div class="p-5">
                    <p class="mb-2 text-xs uppercase tracking-wide text-slate-500">{{ $project->category?->getTranslated('name') ?: __('Uncategorized') }}</p>
                    <h3 class="mb-2 text-lg font-semibold text-slate-900">{{ $project->getTranslated('title') }}</h3>
                    <p class="line-clamp-3 text-sm text-slate-600">{{ $project->getTranslated('short_description') ?: __('ui.no_content_available') }}</p>
                    <a class="mt-4 inline-flex text-sm font-medium text-slate-900" href="{{ route('front.projects.show', ['locale' => app()->getLocale(), 'localizedProject' => $project->localizedSlug()]) }}">{{ __('View project') }} →</a>
                </div>
            </article>
        @empty
            <article class="rounded-2xl border border-dashed border-slate-300 bg-white p-6 text-slate-500 md:col-span-2 xl:col-span-3">
                {{ __('ui.no_content_available') }}
            </article>
        @endforelse
    </div>
</section>

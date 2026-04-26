<section class="mb-6">
    <div class="flex items-end justify-between mb-3 gap-2">
        <div>
            <h2 class="text-2xl font-semibold">{{ $section->getLocalized('title') }}</h2>
            @if ($section->getLocalized('subtitle'))
                <p class="text-slate-600">{{ $section->getLocalized('subtitle') }}</p>
            @endif
        </div>

        @if ($section->getLocalized('cta_label') && $section->localizedCtaLink())
            <a href="{{ $section->localizedCtaLink() }}" class="text-sm px-3 py-2 border rounded">{{ $section->getLocalized('cta_label') }}</a>
        @endif
    </div>

    <div class="grid md:grid-cols-3 gap-4">
        @forelse($featuredProjects as $project)
            <article class="bg-white border rounded p-4">
                <h3 class="font-semibold">{{ $project->getTranslated('title') }}</h3>
                <p class="text-sm text-slate-600">{{ $project->getTranslated('short_description') }}</p>
                <a class="text-sm underline mt-2 inline-block" href="{{ route('front.projects.show', ['locale' => app()->getLocale(), 'localizedProject' => $project->localizedSlug()]) }}">{{ __('View project') }}</a>
            </article>
        @empty
            <p class="text-slate-500">{{ __('ui.no_content_available') }}</p>
        @endforelse
    </div>
</section>

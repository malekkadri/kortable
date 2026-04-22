<section class="mb-6">
    <h2 class="text-2xl font-semibold mb-3">{{ $section->getLocalized('title') }}</h2>
    <div class="grid md:grid-cols-3 gap-4">
        @forelse($services as $service)
            <article class="bg-white border rounded p-4">
                <h3 class="font-semibold">{{ $service->title[app()->getLocale()] ?? $service->title['en'] ?? '' }}</h3>
                <p class="text-sm text-slate-600">{{ $service->short_description[app()->getLocale()] ?? $service->short_description['en'] ?? '' }}</p>
            </article>
        @empty
            <p class="text-slate-500">{{ __('ui.no_content_available') }}</p>
        @endforelse
    </div>
</section>

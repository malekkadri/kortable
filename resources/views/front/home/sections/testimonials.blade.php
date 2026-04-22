<section class="mb-6">
    <h2 class="text-2xl font-semibold mb-3">{{ $section->getLocalized('title') }}</h2>
    <div class="grid md:grid-cols-2 gap-4">
        @forelse($testimonials as $testimonial)
            <article class="bg-white border rounded p-4">
                <p class="text-slate-700">“{{ $testimonial->content[app()->getLocale()] ?? $testimonial->content['en'] ?? '' }}”</p>
                <p class="text-sm mt-2">— {{ $testimonial->author_name }}</p>
            </article>
        @empty
            <p class="text-slate-500">{{ __('ui.no_content_available') }}</p>
        @endforelse
    </div>
</section>

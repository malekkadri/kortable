<section data-reveal class="mb-8">
    <h2 class="mb-4 text-2xl font-semibold text-slate-900">{{ $section->getLocalized('title') ?: __('Testimonials') }}</h2>
    <div class="grid gap-4 md:grid-cols-2">
        @forelse($testimonials as $testimonial)
            <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="mb-3 flex items-center gap-3">
                    <img src="{{ \App\Support\Media\MediaManager::url($testimonial->avatar, 'images/placeholders/avatar.svg') }}" alt="{{ $testimonial->author_name ?: 'Avatar' }}" class="h-12 w-12 rounded-full object-cover">
                    <div>
                        <p class="text-sm font-medium text-slate-700">{{ $testimonial->author_name ?: __('Anonymous') }}</p>
                        <p class="text-xs text-slate-500">{{ $testimonial->company ?: ($testimonial->getTranslated('author_role') ?: '') }}</p>
                    </div>
                </div>
                <p class="text-slate-700">“{{ $testimonial->getTranslated('content') ?: __('ui.no_content_available') }}”</p>
                <p class="mt-3 text-sm font-medium text-slate-500">— {{ $testimonial->author_name ?: __('Anonymous') }}</p>
            </article>
        @empty
            <p class="text-slate-500">{{ __('ui.no_content_available') }}</p>
        @endforelse
    </div>
</section>

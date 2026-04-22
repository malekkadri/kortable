@extends('layouts.front')

@section('content')
<section class="bg-white rounded-xl border p-8 mb-6">
    <h1 class="text-3xl font-bold mb-3">{{ $page?->getLocalized('title', app()->getLocale()) ?? ($siteSetting?->tagline[app()->getLocale()] ?? '') }}</h1>
    @if ($page)
        <p class="text-slate-600 mb-6">{{ $page->getLocalized('excerpt', app()->getLocale()) }}</p>
        <div class="prose max-w-none">{!! nl2br(e($page->getLocalized('content', app()->getLocale()))) !!}</div>
    @endif
</section>

<section class="mb-6">
    <h2 id="services" class="text-2xl font-semibold mb-3">{{ __('ui.services', [], app()->getLocale()) }}</h2>
    <div class="grid md:grid-cols-3 gap-4">
        @foreach($services as $service)
            <article class="bg-white border rounded p-4">
                <h3 class="font-semibold">{{ $service->title[app()->getLocale()] ?? $service->title['en'] ?? '' }}</h3>
                <p class="text-sm text-slate-600">{{ $service->short_description[app()->getLocale()] ?? '' }}</p>
            </article>
        @endforeach
    </div>
</section>

<section>
    <h2 class="text-2xl font-semibold mb-3">{{ __('ui.testimonials', [], app()->getLocale()) }}</h2>
    <div class="grid md:grid-cols-2 gap-4">
        @foreach($testimonials as $testimonial)
            <article class="bg-white border rounded p-4">
                <p class="text-slate-700">“{{ $testimonial->content[app()->getLocale()] ?? '' }}”</p>
                <p class="text-sm mt-2">— {{ $testimonial->author_name }}</p>
            </article>
        @endforeach
    </div>
</section>
@endsection

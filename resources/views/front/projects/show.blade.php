@extends('layouts.front')

@section('content')
<article data-reveal class="mb-10 overflow-hidden rounded-3xl border border-slate-200 bg-white">
    @if($project->featured_image)
        <img src="{{ asset('storage/' . $project->featured_image) }}" alt="{{ $project->getTranslated('title') }}" class="h-72 w-full object-cover md:h-96">
    @endif

    <div class="p-6 md:p-8">
        <p class="mb-2 text-sm text-slate-500">{{ $project->category?->getTranslated('name') ?: __('Uncategorized') }}</p>
        <h1 class="mb-3 text-3xl font-bold">{{ $project->getTranslated('title') }}</h1>
        <p class="mb-6 text-slate-600">{{ $project->getTranslated('short_description') ?: __('ui.no_content_available') }}</p>

        <div class="mb-6 grid gap-3 rounded-2xl bg-slate-50 p-4 text-sm md:grid-cols-3">
            <p><span class="font-semibold">{{ __('Client') }}:</span> {{ $project->client_name ?: '-' }}</p>
            <p><span class="font-semibold">{{ __('Date') }}:</span> {{ optional($project->project_date)->format('Y-m-d') ?: '-' }}</p>
            <p><span class="font-semibold">{{ __('Website') }}:</span> @if($project->website_url)<a class="underline" href="{{ $project->website_url }}" target="_blank" rel="noopener">{{ $project->website_url }}</a>@else-@endif</p>
        </div>

        <div class="prose mb-6 max-w-none">{!! nl2br(e($project->getTranslated('description') ?: __('ui.no_content_available'))) !!}</div>

        @if(!empty($project->technologies))
            <div class="mb-6 flex flex-wrap gap-2">
                @foreach($project->technologies as $tech)
                    <span class="rounded-full border border-slate-200 bg-white px-3 py-1 text-xs font-medium">{{ $tech }}</span>
                @endforeach
            </div>
        @endif

        @if(!empty($project->gallery))
            <section>
                <h2 class="mb-3 text-xl font-semibold">{{ __('Gallery') }}</h2>
                <div class="grid gap-3 md:grid-cols-3">
                    @foreach($project->gallery as $image)
                        <img src="{{ asset('storage/' . $image) }}" alt="Gallery image" class="h-48 w-full rounded-xl border border-slate-200 object-cover transition hover:opacity-90">
                    @endforeach
                </div>
            </section>
        @endif
    </div>
</article>

@if($relatedProjects->isNotEmpty())
<section data-reveal>
    <h2 class="mb-4 text-2xl font-semibold">{{ __('Related projects') }}</h2>
    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
        @foreach($relatedProjects as $related)
            <article class="rounded-2xl border border-slate-200 bg-white p-5">
                <h3 class="mb-2 font-semibold">{{ $related->getTranslated('title') }}</h3>
                <p class="mb-2 text-sm text-slate-600">{{ $related->getTranslated('short_description') ?: __('ui.no_content_available') }}</p>
                <a class="text-sm font-medium text-slate-900" href="{{ route('front.projects.show', ['locale' => app()->getLocale(), 'localizedProject' => $related->localizedSlug()]) }}">{{ __('View project') }} →</a>
            </article>
        @endforeach
    </div>
</section>
@endif
@endsection

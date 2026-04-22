@extends('layouts.front')

@section('content')
<article class="bg-white border rounded-xl p-6 mb-8">
    <p class="text-sm text-slate-500 mb-2">{{ $project->category?->getTranslated('name') }}</p>
    <h1 class="text-3xl font-bold mb-3">{{ $project->getTranslated('title') }}</h1>
    <p class="text-slate-600 mb-6">{{ $project->getTranslated('short_description') }}</p>

    <div class="grid md:grid-cols-3 gap-4 text-sm mb-6">
        <p><span class="font-semibold">{{ __('Client') }}:</span> {{ $project->client_name ?: '-' }}</p>
        <p><span class="font-semibold">{{ __('Date') }}:</span> {{ optional($project->project_date)->format('Y-m-d') ?: '-' }}</p>
        <p><span class="font-semibold">{{ __('Website') }}:</span> @if($project->website_url)<a class="underline" href="{{ $project->website_url }}" target="_blank">{{ $project->website_url }}</a>@else-@endif</p>
    </div>

    <div class="prose max-w-none mb-6">{!! nl2br(e($project->getTranslated('description'))) !!}</div>

    @if(!empty($project->technologies))
    <div class="mb-6 flex flex-wrap gap-2">
        @foreach($project->technologies as $tech)
            <span class="px-2 py-1 bg-slate-100 border rounded text-xs">{{ $tech }}</span>
        @endforeach
    </div>
    @endif

    @if(!empty($project->gallery))
    <section>
        <h2 class="text-xl font-semibold mb-3">{{ __('Gallery') }}</h2>
        <div class="grid md:grid-cols-3 gap-3">
            @foreach($project->gallery as $image)
                <img src="{{ asset('storage/' . $image) }}" alt="Gallery image" class="w-full h-48 object-cover rounded border">
            @endforeach
        </div>
    </section>
    @endif
</article>

@if($relatedProjects->isNotEmpty())
<section>
    <h2 class="text-2xl font-semibold mb-4">{{ __('Related projects') }}</h2>
    <div class="grid md:grid-cols-3 gap-4">
        @foreach($relatedProjects as $related)
            <article class="bg-white border rounded-xl p-4">
                <h3 class="font-semibold mb-2">{{ $related->getTranslated('title') }}</h3>
                <p class="text-sm text-slate-600 mb-2">{{ $related->getTranslated('short_description') }}</p>
                <a class="underline text-sm" href="{{ route('front.projects.show', ['locale' => app()->getLocale(), 'localizedProject' => $related->localizedSlug()]) }}">{{ __('View project') }}</a>
            </article>
        @endforeach
    </div>
</section>
@endif
@endsection

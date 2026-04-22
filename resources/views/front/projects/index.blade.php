@extends('layouts.front')

@section('content')
<section class="mb-10">
    <h1 class="text-3xl font-bold mb-2">{{ __('Projects') }}</h1>
    <p class="text-slate-600">{{ __('A selection of portfolio work powered from database content.') }}</p>
</section>

@if($featuredProjects->isNotEmpty())
<section class="mb-10">
    <h2 class="text-2xl font-semibold mb-4">{{ __('Featured projects') }}</h2>
    <div class="grid md:grid-cols-3 gap-4">
        @foreach($featuredProjects as $project)
            <article class="bg-white border rounded-xl p-4">
                <p class="text-xs uppercase text-slate-500 mb-2">{{ $project->category?->getTranslated('name') }}</p>
                <h3 class="font-semibold text-lg mb-2">{{ $project->getTranslated('title') }}</h3>
                <p class="text-sm text-slate-600 mb-3">{{ $project->getTranslated('short_description') }}</p>
                <a class="text-sm underline" href="{{ route('front.projects.show', ['locale' => app()->getLocale(), 'localizedProject' => $project->localizedSlug()]) }}">{{ __('View project') }}</a>
            </article>
        @endforeach
    </div>
</section>
@endif

<section class="mb-6 flex flex-wrap gap-2">
    <a href="{{ route('front.projects.index', ['locale' => app()->getLocale()]) }}" class="px-3 py-2 rounded border {{ $categorySlug ? '' : 'bg-slate-900 text-white' }}">{{ __('All') }}</a>
    @foreach($categories as $category)
        @php($label = $category->getTranslated('name'))
        <a href="{{ route('front.projects.index', ['locale' => app()->getLocale(), 'category' => $category->slug]) }}" class="px-3 py-2 rounded border {{ $categorySlug === $category->slug ? 'bg-slate-900 text-white' : '' }}">{{ $label }} ({{ $category->projects_count }})</a>
    @endforeach
</section>

<section class="grid md:grid-cols-3 gap-4">
    @forelse($projects as $project)
        <article class="bg-white border rounded-xl overflow-hidden">
            @if($project->featured_image)
                <img src="{{ asset('storage/' . $project->featured_image) }}" alt="{{ $project->getTranslated('title') }}" class="w-full h-44 object-cover">
            @endif
            <div class="p-4">
                <h3 class="font-semibold text-lg mb-2">{{ $project->getTranslated('title') }}</h3>
                <p class="text-sm text-slate-600 mb-3">{{ $project->getTranslated('short_description') }}</p>
                <a class="text-sm underline" href="{{ route('front.projects.show', ['locale' => app()->getLocale(), 'localizedProject' => $project->localizedSlug()]) }}">{{ __('Read more') }}</a>
            </div>
        </article>
    @empty
        <p class="text-slate-600">{{ __('No projects found for this filter.') }}</p>
    @endforelse
</section>

<div class="mt-6">{{ $projects->links() }}</div>
@endsection

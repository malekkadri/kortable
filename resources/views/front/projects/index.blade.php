@extends('layouts.front')

@section('content')
<section data-reveal class="mb-10 rounded-3xl border border-slate-200 bg-white p-7 md:p-10">
    <h1 class="mb-2 text-3xl font-bold md:text-4xl">{{ __('Projects') }}</h1>
    <p class="text-slate-600">{{ __('A curated selection of dynamic portfolio work managed from the admin panel.') }}</p>
</section>

@if($featuredProjects->isNotEmpty())
<section data-reveal class="mb-10">
    <h2 class="mb-4 text-2xl font-semibold">{{ __('Featured projects') }}</h2>
    <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
        @foreach($featuredProjects as $project)
            <article class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-lg">
                <p class="mb-2 text-xs uppercase tracking-wide text-slate-500">{{ $project->category?->getTranslated('name') ?: __('Uncategorized') }}</p>
                <h3 class="mb-2 text-lg font-semibold">{{ $project->getTranslated('title') }}</h3>
                <p class="mb-3 text-sm text-slate-600">{{ $project->getTranslated('short_description') ?: __('ui.no_content_available') }}</p>
                <a class="text-sm font-medium text-slate-900" href="{{ route('front.projects.show', ['locale' => app()->getLocale(), 'localizedProject' => $project->localizedSlug()]) }}">{{ __('View project') }} →</a>
            </article>
        @endforeach
    </div>
</section>
@endif

<section data-reveal class="mb-6 flex flex-wrap gap-2">
    <a href="{{ route('front.projects.index', ['locale' => app()->getLocale()]) }}" class="rounded-xl border px-4 py-2 text-sm {{ $categorySlug ? 'bg-white' : 'border-slate-900 bg-slate-900 text-white' }}">{{ __('All') }}</a>
    @foreach($categories as $category)
        @php($label = $category->getTranslated('name') ?: __('Unnamed'))
        <a href="{{ route('front.projects.index', ['locale' => app()->getLocale(), 'category' => $category->slug]) }}" class="rounded-xl border px-4 py-2 text-sm {{ $categorySlug === $category->slug ? 'border-slate-900 bg-slate-900 text-white' : 'bg-white' }}">{{ $label }} ({{ $category->projects_count }})</a>
    @endforeach
</section>

<section class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
    @forelse($projects as $project)
        <article data-reveal class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:shadow-md">
            @if($project->featured_image)
                <img src="{{ asset('storage/' . $project->featured_image) }}" alt="{{ $project->getTranslated('title') }}" class="h-48 w-full object-cover">
            @endif
            <div class="p-5">
                <h3 class="mb-2 text-lg font-semibold">{{ $project->getTranslated('title') }}</h3>
                <p class="mb-4 text-sm text-slate-600">{{ $project->getTranslated('short_description') ?: __('ui.no_content_available') }}</p>
                <a class="text-sm font-medium text-slate-900" href="{{ route('front.projects.show', ['locale' => app()->getLocale(), 'localizedProject' => $project->localizedSlug()]) }}">{{ __('Read more') }} →</a>
            </div>
        </article>
    @empty
        <article class="rounded-2xl border border-dashed border-slate-300 bg-white p-8 text-slate-600 md:col-span-2 xl:col-span-3">{{ __('No projects found for this filter.') }}</article>
    @endforelse
</section>

<div class="mt-8">{{ $projects->links() }}</div>
@endsection

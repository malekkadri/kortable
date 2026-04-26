@extends('layouts.front')

@section('content')
<article class="max-w-4xl mx-auto bg-white border rounded-xl overflow-hidden">
    <img src="{{ \App\Support\Media\MediaManager::url($blogPost->featured_image) }}" alt="{{ $blogPost->getTranslated('title') }}" class="w-full h-72 object-cover">
    <div class="p-6 md:p-8">
        <p class="text-sm text-slate-500 mb-2">{{ optional($blogPost->published_at)->format('Y-m-d H:i') }}</p>
        <h1 class="text-3xl font-semibold mb-3">{{ $blogPost->getTranslated('title') }}</h1>
        <p class="text-slate-600 mb-6">{{ $blogPost->getTranslated('excerpt') }}</p>
        <div class="prose max-w-none whitespace-pre-line">{{ $blogPost->getTranslated('content') }}</div>
    </div>
</article>

@if($relatedPosts->isNotEmpty())
<section class="mt-10">
    <h2 class="text-2xl font-semibold mb-4">{{ __('Related posts') }}</h2>
    <div class="grid md:grid-cols-3 gap-4">
        @foreach($relatedPosts as $related)
            <a href="{{ route('front.blog.show', ['locale' => app()->getLocale(), 'localizedBlogPost' => $related->localizedSlug(app()->getLocale())]) }}" class="bg-white border rounded-xl p-4 hover:border-slate-400 transition">
                <p class="text-xs text-slate-500 mb-1">{{ optional($related->published_at)->format('Y-m-d') }}</p>
                <h3 class="font-semibold">{{ $related->getTranslated('title') }}</h3>
            </a>
        @endforeach
    </div>
</section>
@endif
@endsection

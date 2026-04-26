@extends('layouts.front')

@section('content')
<div class="grid lg:grid-cols-[280px_1fr] gap-8">
    <aside class="bg-white border rounded-xl p-4 h-fit">
        <h2 class="font-semibold mb-3">{{ __('Categories') }}</h2>
        <a href="{{ route('front.blog.index', ['locale' => app()->getLocale()]) }}" class="block px-3 py-2 rounded {{ $categorySlug === '' ? 'bg-slate-100' : 'hover:bg-slate-50' }}">{{ __('All') }}</a>
        @foreach($categories as $category)
            <a href="{{ route('front.blog.index', ['locale' => app()->getLocale(), 'category' => $category->slug]) }}" class="flex justify-between px-3 py-2 rounded {{ $categorySlug === $category->slug ? 'bg-slate-100' : 'hover:bg-slate-50' }}">
                <span>{{ $category->getTranslated('name') }}</span>
                <span class="text-slate-400 text-xs">{{ $category->posts_count }}</span>
            </a>
        @endforeach
    </aside>

    <div>
        <h1 class="text-3xl font-semibold mb-6">{{ __('Blog & News') }}</h1>
        <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-5">
            @forelse($blogPosts as $post)
                <article class="bg-white border rounded-xl overflow-hidden">
                    <img src="{{ \App\Support\Media\MediaManager::url($post->featured_image) }}" alt="{{ $post->getTranslated('title') }}" class="w-full h-40 object-cover">
                    <div class="p-4">
                        <p class="text-xs text-slate-500 mb-2">{{ optional($post->published_at)->format('Y-m-d') }}</p>
                        <h2 class="text-lg font-semibold mb-2">{{ $post->getTranslated('title') }}</h2>
                        <p class="text-sm text-slate-600 mb-3">{{ $post->getTranslated('excerpt') }}</p>
                        <a class="text-sm font-medium text-slate-900" href="{{ route('front.blog.show', ['locale' => app()->getLocale(), 'localizedBlogPost' => $post->localizedSlug(app()->getLocale())]) }}">{{ __('Read more') }} →</a>
                    </div>
                </article>
            @empty
                <p class="text-slate-500">{{ __('No blog posts yet.') }}</p>
            @endforelse
        </div>

        <div class="mt-6">{{ $blogPosts->links() }}</div>
    </div>
</div>
@endsection

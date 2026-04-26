@extends('layouts.front')

@section('content')
    <article data-reveal class="rounded-3xl border border-slate-200 bg-white p-6 md:p-8">
        <h1 class="mb-4 text-3xl font-semibold">{{ $page->getLocalized('title', app()->getLocale()) ?: __('ui.no_content_available') }}</h1>
        <p class="mb-6 text-slate-600">{{ $page->getLocalized('excerpt', app()->getLocale()) ?: __('ui.no_content_available') }}</p>
        <div class="prose max-w-none">{!! nl2br(e($page->getLocalized('content', app()->getLocale()) ?: __('ui.no_content_available'))) !!}</div>
    </article>
@endsection

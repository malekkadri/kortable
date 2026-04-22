@extends('layouts.front')

@section('content')
    <article class="bg-white rounded-xl border p-8">
        <h1 class="text-3xl font-semibold mb-4">{{ $page->getLocalized('title', app()->getLocale()) }}</h1>
        <p class="text-slate-600 mb-6">{{ $page->getLocalized('excerpt', app()->getLocale()) }}</p>
        <div class="prose max-w-none">{!! nl2br(e($page->getLocalized('body', app()->getLocale()))) !!}</div>
    </article>
@endsection

@extends('layouts.front')

@section('content')
    <section class="bg-white rounded-xl border p-8">
        <h1 class="text-3xl font-bold mb-3">{{ $headline }}</h1>
        @if ($page)
            <p class="text-slate-600 mb-6">{{ $page->getLocalized('excerpt', app()->getLocale()) }}</p>
            <div class="prose max-w-none">
                {!! nl2br(e($page->getLocalized('body', app()->getLocale()))) !!}
            </div>
        @else
            <p class="text-slate-600">{{ __('ui.no_content_available') }}</p>
        @endif
    </section>
@endsection

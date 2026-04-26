@extends('layouts.front')

@section('content')
<section class="mb-10">
    <h1 class="text-3xl font-bold mb-2">{{ __('ui.services') }}</h1>
    <p class="text-slate-600">{{ __('Services managed from the admin panel and localized in three languages.') }}</p>
</section>

<section class="grid md:grid-cols-3 gap-4">
    @forelse($services as $service)
        <article class="bg-white border rounded-xl p-5">
            <img src="{{ \App\Support\Media\MediaManager::url($service->image) }}" alt="{{ $service->getTranslated('title') }}" class="mb-3 h-40 w-full rounded-lg object-cover">
            <h2 class="font-semibold text-xl mb-2">{{ $service->getTranslated('title') }}</h2>
            @if($service->getTranslated('short_description'))
                <p class="text-slate-600 text-sm mb-3">{{ $service->getTranslated('short_description') }}</p>
            @endif
            @if($service->getTranslated('description'))
                <p class="text-slate-700">{{ $service->getTranslated('description') }}</p>
            @endif
        </article>
    @empty
        <article class="bg-white border rounded-xl p-8 text-slate-600">
            {{ __('ui.no_content_available') }}
        </article>
    @endforelse
</section>
@endsection

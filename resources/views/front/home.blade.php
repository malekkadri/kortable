@extends('layouts.front')

@section('content')
    @forelse ($homeSections as $section)
        @php
            $sectionConfig = config('kortable.home_sections.types.'.$section->section_type);
            $view = $sectionConfig['view'] ?? null;
        @endphp

        @if ($view && view()->exists($view))
            @include($view, [
                'section' => $section,
                'featuredProjects' => $featuredProjects,
                'services' => $services,
                'testimonials' => $testimonials,
            ])
        @endif
    @empty
        <section class="bg-white rounded-xl border p-8">
            <p class="text-slate-500">{{ __('ui.no_content_available') }}</p>
        </section>
    @endforelse
@endsection

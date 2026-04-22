@extends('layouts.admin')

@section('content')
    <h2 class="text-2xl font-semibold mb-6">{{ __('ui.dashboard') }}</h2>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="bg-white border rounded-xl p-5">
            <p class="text-sm text-slate-500">{{ __('ui.projects_count') }}</p>
            <p class="mt-2 text-3xl font-semibold">{{ $stats['projects'] }}</p>
        </div>
        <div class="bg-white border rounded-xl p-5">
            <p class="text-sm text-slate-500">{{ __('ui.pages_count') }}</p>
            <p class="mt-2 text-3xl font-semibold">{{ $stats['pages'] }}</p>
        </div>
        <div class="bg-white border rounded-xl p-5">
            <p class="text-sm text-slate-500">{{ __('ui.services_count') }}</p>
            <p class="mt-2 text-3xl font-semibold">{{ $stats['services'] }}</p>
        </div>
        <div class="bg-white border rounded-xl p-5">
            <p class="text-sm text-slate-500">{{ __('ui.unread_messages') }}</p>
            <p class="mt-2 text-3xl font-semibold">{{ $stats['unread_messages'] }}</p>
        </div>
    </div>
@endsection

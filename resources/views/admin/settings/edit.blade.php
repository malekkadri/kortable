@extends('layouts.admin')

@section('content')
    <h2 class="text-2xl font-semibold mb-4">{{ __('ui.site_settings') }}</h2>

    @if (session('status'))
        <p class="mb-4 text-green-700 bg-green-50 border border-green-200 rounded p-3">{{ session('status') }}</p>
    @endif

    <form class="space-y-6 bg-white border rounded-xl p-6" method="POST" action="{{ route('admin.settings.update') }}">
        @csrf
        @method('PUT')

        <x-admin.translatable-inputs
            name="site_name"
            :label="__('ui.site_name')"
            :values="$siteName"
            :locales="$locales"
        />

        <x-admin.translatable-inputs
            name="homepage_headline"
            :label="__('ui.homepage_headline')"
            :values="$homepageHeadline"
            :locales="$locales"
        />

        <button type="submit" class="bg-slate-900 text-white rounded px-4 py-2">{{ __('ui.save_settings') }}</button>
    </form>
@endsection

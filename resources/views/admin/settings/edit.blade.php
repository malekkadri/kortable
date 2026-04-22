@extends('layouts.admin')

@section('content')
    <h2 class="text-2xl font-semibold mb-4">Site settings</h2>

    @if (session('status'))
        <p class="mb-4 text-green-700 bg-green-50 border border-green-200 rounded p-3">{{ session('status') }}</p>
    @endif

    <form class="space-y-6 bg-white border rounded-xl p-6" method="POST" action="{{ route('admin.settings.update') }}">
        @csrf
        @method('PUT')

        <div>
            <h3 class="font-medium mb-2">Site name</h3>
            <div class="grid md:grid-cols-3 gap-3">
                @foreach (['fr', 'ar', 'en'] as $locale)
                    <input name="site_name[{{ $locale }}]" value="{{ old('site_name.'.$locale, $siteName[$locale]) }}" class="border rounded px-3 py-2" placeholder="{{ strtoupper($locale) }}">
                @endforeach
            </div>
        </div>

        <div>
            <h3 class="font-medium mb-2">Homepage headline</h3>
            <div class="grid md:grid-cols-3 gap-3">
                @foreach (['fr', 'ar', 'en'] as $locale)
                    <input name="homepage_headline[{{ $locale }}]" value="{{ old('homepage_headline.'.$locale, $homepageHeadline[$locale]) }}" class="border rounded px-3 py-2" placeholder="{{ strtoupper($locale) }}">
                @endforeach
            </div>
        </div>

        <button type="submit" class="bg-slate-900 text-white rounded px-4 py-2">Save settings</button>
    </form>
@endsection

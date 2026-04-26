@extends('layouts.front')

@section('content')
<section class="grid gap-6 lg:grid-cols-3">
    <article data-reveal class="lg:col-span-2 rounded-3xl border border-slate-200 bg-white p-6 md:p-8">
        <h1 class="mb-4 text-3xl font-semibold">
            {{ $contactPage?->getLocalized('title', app()->getLocale()) ?? __('ui.contact_us') }}
        </h1>
        @if($contactPage?->getLocalized('content', app()->getLocale()))
            <p class="mb-6 text-slate-600">{{ $contactPage->getLocalized('content', app()->getLocale()) }}</p>
        @endif

        @if (session('status'))
            <div class="mb-4 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">{{ session('status') }}</div>
        @endif
        @if ($errors->any())
            <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">{{ __('messages.contact_form_error') }}</div>
        @endif

        <form method="POST" action="{{ route('front.contact.store', ['locale' => app()->getLocale()]) }}" class="space-y-4">
            @csrf
            <div class="hidden" aria-hidden="true">
                <label for="company_website">Company website</label>
                <input id="company_website" name="company_website" type="text" tabindex="-1" autocomplete="off">
            </div>
            <input type="hidden" name="submitted_at" value="{{ now()->timestamp }}">

            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label for="name" class="mb-1 block text-sm">{{ __('ui.name') }}</label>
                    <input id="name" name="name" value="{{ old('name') }}" required class="w-full rounded-xl border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none">
                    @error('name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="email" class="mb-1 block text-sm">{{ __('ui.email') }}</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required class="w-full rounded-xl border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none">
                    @error('email')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label for="phone" class="mb-1 block text-sm">{{ __('ui.phone') }}</label>
                    <input id="phone" name="phone" value="{{ old('phone') }}" class="w-full rounded-xl border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none">
                    @error('phone')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="subject" class="mb-1 block text-sm">{{ __('ui.subject') }}</label>
                    <input id="subject" name="subject" value="{{ old('subject') }}" required class="w-full rounded-xl border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none">
                    @error('subject')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <div>
                <label for="message" class="mb-1 block text-sm">{{ __('ui.message') }}</label>
                <textarea id="message" name="message" rows="6" required class="w-full rounded-xl border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none">{{ old('message') }}</textarea>
                @error('message')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
            @error('submitted_at')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror

            <button class="rounded-xl bg-slate-900 px-5 py-3 font-medium text-white transition hover:bg-slate-700">{{ __('ui.send_message') }}</button>
        </form>
    </article>

    <aside data-reveal class="h-fit space-y-3 rounded-3xl border border-slate-200 bg-white p-6">
        <h2 class="text-xl font-semibold">{{ __('ui.contact_information') }}</h2>
        <p><strong>{{ __('ui.email') }}:</strong> {{ $siteSetting?->contact_email ?: __('ui.no_content_available') }}</p>
        <p><strong>{{ __('ui.phone') }}:</strong> {{ $siteSetting?->phone ?: __('ui.no_content_available') }}</p>
        <p><strong>{{ __('ui.address') }}:</strong> {{ $siteSetting?->getLocalized('address', app()->getLocale()) ?: __('ui.no_content_available') }}</p>

        <div class="rounded-xl border border-slate-200 bg-slate-50 p-3 text-sm text-slate-600 min-h-24">
            @if($siteSetting?->map_embed_url)
                <iframe src="{{ $siteSetting->map_embed_url }}" class="h-56 w-full rounded-lg border-0" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            @else
                {{ __('ui.map_placeholder') }}
            @endif
        </div>
    </aside>
</section>
@endsection

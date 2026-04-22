@extends('layouts.front')

@section('content')
    <section class="grid lg:grid-cols-3 gap-6">
        <article class="lg:col-span-2 bg-white rounded-xl border p-8">
            <h1 class="text-3xl font-semibold mb-4">
                {{ $contactPage?->getLocalized('title', app()->getLocale()) ?? __('ui.contact_us') }}
            </h1>
            @if($contactPage?->getLocalized('content', app()->getLocale()))
                <p class="text-slate-600 mb-6">{{ $contactPage->getLocalized('content', app()->getLocale()) }}</p>
            @endif

            @if (session('status'))
                <div class="mb-4 rounded border border-green-200 bg-green-50 text-green-800 px-4 py-3 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 rounded border border-red-200 bg-red-50 text-red-800 px-4 py-3 text-sm">
                    {{ __('messages.contact_form_error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('front.contact.store', ['locale' => app()->getLocale()]) }}" class="space-y-4">
                @csrf
                <div class="hidden" aria-hidden="true">
                    <label for="company_website">Company website</label>
                    <input id="company_website" name="company_website" type="text" tabindex="-1" autocomplete="off">
                </div>
                <input type="hidden" name="submitted_at" value="{{ now()->timestamp }}">

                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label for="name" class="block text-sm mb-1">{{ __('ui.name') }}</label>
                        <input id="name" name="name" value="{{ old('name') }}" required class="w-full border rounded px-3 py-2">
                        @error('name')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="email" class="block text-sm mb-1">{{ __('ui.email') }}</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required class="w-full border rounded px-3 py-2">
                        @error('email')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label for="phone" class="block text-sm mb-1">{{ __('ui.phone') }}</label>
                    <input id="phone" name="phone" value="{{ old('phone') }}" class="w-full border rounded px-3 py-2">
                    @error('phone')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>
                    <div>
                        <label for="subject" class="block text-sm mb-1">{{ __('ui.subject') }}</label>
                        <input id="subject" name="subject" value="{{ old('subject') }}" required class="w-full border rounded px-3 py-2">
                        @error('subject')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div>
                    <label for="message" class="block text-sm mb-1">{{ __('ui.message') }}</label>
                    <textarea id="message" name="message" rows="6" required class="w-full border rounded px-3 py-2">{{ old('message') }}</textarea>
                    @error('message')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>
                @error('submitted_at')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror

                <button class="px-4 py-2 bg-slate-900 text-white rounded">{{ __('ui.send_message') }}</button>
            </form>
        </article>

        <aside class="bg-white rounded-xl border p-6 space-y-3 h-fit">
            <h2 class="text-xl font-semibold">{{ __('ui.contact_information') }}</h2>
            @if($siteSetting?->contact_email)<p><strong>{{ __('ui.email') }}:</strong> {{ $siteSetting->contact_email }}</p>@endif
            @if($siteSetting?->phone)<p><strong>{{ __('ui.phone') }}:</strong> {{ $siteSetting->phone }}</p>@endif
            @if($siteSetting?->getLocalized('address', app()->getLocale()))
                <p><strong>{{ __('ui.address') }}:</strong> {{ $siteSetting->getLocalized('address', app()->getLocale()) }}</p>
            @endif

            <div class="border rounded bg-slate-50 p-4 text-sm text-slate-600 min-h-24">
                @if($siteSetting?->map_embed_url)
                    <iframe src="{{ $siteSetting->map_embed_url }}" class="w-full h-48 border-0" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                @else
                    {{ __('ui.map_placeholder') }}
                @endif
            </div>
        </aside>
    </section>
@endsection

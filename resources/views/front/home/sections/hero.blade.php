<section class="bg-white rounded-xl border p-8 mb-6">
    <div class="grid md:grid-cols-2 gap-6 items-center">
        <div>
            <h1 class="text-3xl font-bold mb-3">{{ $section->getLocalized('title') }}</h1>
            @if ($section->getLocalized('subtitle'))
                <p class="text-lg text-slate-600 mb-3">{{ $section->getLocalized('subtitle') }}</p>
            @endif
            @if ($section->getLocalized('content'))
                <p class="text-slate-600 mb-5">{{ $section->getLocalized('content') }}</p>
            @endif
            @if ($section->getLocalized('cta_label') && $section->localizedCtaLink())
                <a href="{{ $section->localizedCtaLink() }}" class="inline-flex px-4 py-2 bg-slate-900 text-white rounded">
                    {{ $section->getLocalized('cta_label') }}
                </a>
            @endif
        </div>

        @if ($section->image)
            <img src="{{ asset('storage/'.$section->image) }}" alt="{{ $section->getLocalized('title') }}" class="w-full rounded-lg border object-cover max-h-80">
        @endif
    </div>
</section>

<section class="bg-white rounded-xl border p-8 mb-6">
    <h2 class="text-2xl font-semibold mb-2">{{ $section->getLocalized('title') }}</h2>
    @if ($section->getLocalized('subtitle'))
        <p class="text-slate-600 mb-3">{{ $section->getLocalized('subtitle') }}</p>
    @endif
    @if ($section->getLocalized('content'))
        <div class="prose max-w-none">{!! nl2br(e($section->getLocalized('content'))) !!}</div>
    @endif
</section>

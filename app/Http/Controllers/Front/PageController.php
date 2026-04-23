<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\SiteSetting;
use App\Support\Seo\SeoData;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class PageController extends Controller
{
    public function show(string $locale, string $slug): View|RedirectResponse
    {
        $page = Page::published()
            ->where(function ($query) use ($slug, $locale) {
                $query->where('slug', $slug)
                    ->orWhere("slug_translations->{$locale}", $slug);
            })
            ->firstOrFail();

        $localizedSlug = $page->localizedSlug($locale);
        if ($slug !== $localizedSlug) {
            return redirect()->route('front.pages.show', ['locale' => $locale, 'slug' => $localizedSlug], 301);
        }

        $seo = SeoData::forContent(
            $page->seo ?? [],
            $page->getLocalized('title', $locale),
            $page->getLocalized('excerpt', $locale),
            $page->featured_image
        );
        $seo['canonical'] = route('front.pages.show', ['locale' => $locale, 'slug' => $localizedSlug]);

        if ($page->slug === 'contact') {
            return view('front.contact', [
                'contactPage' => $page,
                'siteSetting' => SiteSetting::first(),
                'seo' => $seo,
            ]);
        }

        return view('front.page', compact('page', 'seo'));
    }
}

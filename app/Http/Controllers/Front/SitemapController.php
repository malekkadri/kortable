<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Project;
use App\Support\Localization\Locale;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $locales = Locale::all();
        $urls = [];

        foreach ($locales as $locale) {
            $urls[] = ['loc' => route('front.home', ['locale' => $locale]), 'lastmod' => now()];
            $urls[] = ['loc' => route('front.projects.index', ['locale' => $locale]), 'lastmod' => now()];
            $urls[] = ['loc' => route('front.contact.show', ['locale' => $locale]), 'lastmod' => now()];
        }

        $pages = Page::query()->published()->get();
        foreach ($pages as $page) {
            foreach ($locales as $locale) {
                $urls[] = [
                    'loc' => route('front.pages.show', ['locale' => $locale, 'slug' => $page->localizedSlug($locale)]),
                    'lastmod' => $page->updated_at ?? $page->created_at,
                ];
            }
        }

        $projects = Project::query()->published()->get();
        foreach ($projects as $project) {
            foreach ($locales as $locale) {
                $urls[] = [
                    'loc' => route('front.projects.show', ['locale' => $locale, 'localizedProject' => $project->localizedSlug($locale)]),
                    'lastmod' => $project->updated_at ?? $project->created_at,
                ];
            }
        }

        $content = view('front.sitemap', ['urls' => $urls])->render();

        return response($content, 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
    }
}

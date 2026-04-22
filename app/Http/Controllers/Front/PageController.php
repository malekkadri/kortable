<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Contracts\View\View;

class PageController extends Controller
{
    public function show(string $locale, string $slug): View
    {
        $page = Page::published()
            ->where(function ($query) use ($slug, $locale) {
                $query->where('slug', $slug)
                    ->orWhere("slug_translations->{$locale}", $slug);
            })
            ->firstOrFail();

        return view('front.page', compact('page'));
    }
}

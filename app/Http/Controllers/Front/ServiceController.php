<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Support\Seo\SeoData;
use Illuminate\Contracts\View\View;

class ServiceController extends Controller
{
    public function index(string $locale): View
    {
        $services = Service::query()->active()->get();
        $siteSetting = SiteSetting::query()->first();

        $seo = SeoData::forContent(
            [],
            __('ui.services').' | '.($siteSetting?->getLocalized('site_name', $locale) ?? config('app.name')),
            $siteSetting?->getLocalized('tagline', $locale)
        );
        $seo['canonical'] = route('front.services.index', ['locale' => $locale]);

        return view('front.services.index', compact('services', 'seo'));
    }
}

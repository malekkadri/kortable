<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Services\SettingService;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __invoke(SettingService $settingService): View
    {
        $page = Page::published()->where('slug', 'home')->first();

        return view('front.home', [
            'page' => $page,
            'siteName' => $settingService->get('site_name', default: config('app.name')),
            'headline' => $settingService->get('homepage_headline', default: __('messages.default_headline')),
        ]);
    }
}

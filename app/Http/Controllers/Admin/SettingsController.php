<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateSiteSettingsRequest;
use App\Services\SettingService;
use App\Support\Localization\Locale;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class SettingsController extends Controller
{
    public function edit(SettingService $settingService): View
    {
        $siteName = [];
        $homepageHeadline = [];

        foreach (Locale::all() as $locale) {
            $siteName[$locale] = $settingService->get('site_name', $locale, config('app.name'));
            $homepageHeadline[$locale] = $settingService->get('homepage_headline', $locale, __('messages.default_headline', locale: $locale));
        }

        return view('admin.settings.edit', [
            'locales' => Locale::all(),
            'siteName' => $siteName,
            'homepageHeadline' => $homepageHeadline,
        ]);
    }

    public function update(UpdateSiteSettingsRequest $request, SettingService $settingService): RedirectResponse
    {
        $settingService->set('general', 'site_name', $request->validated('site_name'));
        $settingService->set('homepage', 'homepage_headline', $request->validated('homepage_headline'));

        return back()->with('status', __('messages.settings_updated'));
    }
}

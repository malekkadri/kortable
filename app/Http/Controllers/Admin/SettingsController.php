<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateSiteSettingsRequest;
use App\Services\SettingService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class SettingsController extends Controller
{
    public function edit(SettingService $settingService): View
    {
        return view('admin.settings.edit', [
            'siteName' => [
                'fr' => $settingService->get('site_name', 'fr', 'Kortable'),
                'ar' => $settingService->get('site_name', 'ar', 'كورتابل'),
                'en' => $settingService->get('site_name', 'en', 'Kortable'),
            ],
            'homepageHeadline' => [
                'fr' => $settingService->get('homepage_headline', 'fr', 'Bienvenue sur Kortable'),
                'ar' => $settingService->get('homepage_headline', 'ar', 'مرحبًا بكم في كورتابل'),
                'en' => $settingService->get('homepage_headline', 'en', 'Welcome to Kortable'),
            ],
        ]);
    }

    public function update(UpdateSiteSettingsRequest $request, SettingService $settingService): RedirectResponse
    {
        $settingService->set('general', 'site_name', $request->validated('site_name'));
        $settingService->set('homepage', 'homepage_headline', $request->validated('homepage_headline'));

        return back()->with('status', __('messages.settings_updated'));
    }
}

<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\UpdateSiteSettingRequest;
use App\Models\SiteSetting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Support\Media\MediaManager;

class SiteSettingController extends Controller
{
    public function edit(): View
    {
        return view('admin.content.site-settings.edit', [
            'setting' => SiteSetting::firstOrNew(['id' => 1]),
            'locales' => config('kortable.locales'),
        ]);
    }

    public function update(UpdateSiteSettingRequest $request): RedirectResponse
    {
        $setting = SiteSetting::firstOrNew(['id' => 1]);
        $data = $request->validated();

        foreach (['logo', 'favicon'] as $imageField) {
            if ($request->hasFile($imageField)) {
                if ($setting->{$imageField}) {
                    MediaManager::deletePublic($setting->{$imageField});
                }
                $data[$imageField] = $request->file($imageField)->store('site-settings', 'public');
            } else {
                unset($data[$imageField]);
            }
        }

        $setting->fill($data)->save();

        return back()->with('status', __('messages.settings_updated'));
    }
}

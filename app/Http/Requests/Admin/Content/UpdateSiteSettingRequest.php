<?php

namespace App\Http\Requests\Admin\Content;

use App\Support\Localization\Locale;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSiteSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('manage_settings') ?? false;
    }

    public function rules(): array
    {
        $rules = [
            'default_locale' => ['required', 'in:'.implode(',', Locale::all())],
            'contact_email' => ['nullable', 'email'],
            'phone' => ['nullable', 'string', 'max:50'],
            'logo' => ['nullable', 'image', 'max:2048'],
            'favicon' => ['nullable', 'image', 'max:1024'],
            'social_links' => ['nullable', 'array'],
            'social_links.*' => ['nullable', 'url'],
            'seo_defaults.og_image' => ['nullable', 'string', 'max:255'],
        ];

        foreach (Locale::all() as $locale) {
            $rules["site_name.$locale"] = ['required', 'string', 'max:255'];
            $rules["tagline.$locale"] = ['nullable', 'string', 'max:255'];
            $rules["address.$locale"] = ['nullable', 'string', 'max:255'];
            $rules["footer_content.$locale"] = ['nullable', 'string'];
            $rules["seo_defaults.title.$locale"] = ['nullable', 'string', 'max:255'];
            $rules["seo_defaults.description.$locale"] = ['nullable', 'string', 'max:255'];
        }

        return $rules;
    }
}

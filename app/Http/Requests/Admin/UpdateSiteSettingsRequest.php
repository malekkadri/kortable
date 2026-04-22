<?php

namespace App\Http\Requests\Admin;

use App\Support\Localization\Locale;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSiteSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user()?->is_admin;
    }

    public function rules(): array
    {
        $rules = [];

        foreach (Locale::all() as $locale) {
            $rules["site_name.$locale"] = ['required', 'string', 'max:255'];
            $rules["homepage_headline.$locale"] = ['required', 'string', 'max:255'];
        }

        return $rules;
    }

    public function attributes(): array
    {
        $attributes = [];

        foreach (Locale::all() as $locale) {
            $attributes["site_name.$locale"] = __('ui.site_name').' ('.strtoupper($locale).')';
            $attributes["homepage_headline.$locale"] = __('ui.homepage_headline').' ('.strtoupper($locale).')';
        }

        return $attributes;
    }
}

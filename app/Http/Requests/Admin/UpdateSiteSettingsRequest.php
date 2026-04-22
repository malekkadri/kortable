<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSiteSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user()?->is_admin;
    }

    public function rules(): array
    {
        return [
            'site_name.fr' => ['required', 'string', 'max:255'],
            'site_name.ar' => ['required', 'string', 'max:255'],
            'site_name.en' => ['required', 'string', 'max:255'],
            'homepage_headline.fr' => ['required', 'string', 'max:255'],
            'homepage_headline.ar' => ['required', 'string', 'max:255'],
            'homepage_headline.en' => ['required', 'string', 'max:255'],
        ];
    }
}

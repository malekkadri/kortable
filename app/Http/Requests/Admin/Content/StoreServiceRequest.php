<?php

namespace App\Http\Requests\Admin\Content;

use App\Support\Localization\Locale;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreServiceRequest extends FormRequest
{
    public function authorize(): bool { return $this->user()?->can('manage_pages') ?? false; }

    public function rules(): array
    {
        $rules = [
            'slug' => ['required', 'string', 'max:255', 'unique:services,slug'],
            'icon' => ['nullable', 'string', 'max:100'],
            'image' => ['nullable', 'image', 'max:3072'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['required', 'boolean'],
            'seo.og_image' => ['nullable', 'string', 'max:255'],
            'seo_og_image' => ['nullable', 'image', 'max:3072'],
        ];

        foreach (Locale::all() as $locale) {
            $rules["title.$locale"] = ['required', 'string', 'max:255'];
            $rules["short_description.$locale"] = ['nullable', 'string', 'max:500'];
            $rules["description.$locale"] = ['nullable', 'string'];
            $rules["seo.meta_title.$locale"] = ['nullable', 'string', 'max:255'];
            $rules["seo.meta_description.$locale"] = ['nullable', 'string', 'max:255'];
        }

        return $rules;
    }

    protected function prepareForValidation(): void
    {
        $slug = Str::slug((string) $this->input('slug'));
        $fallbackLocale = Locale::fallback();
        $title = (array) $this->input('title', []);

        if ($slug === '' && ! empty($title[$fallbackLocale])) {
            $slug = Str::slug((string) $title[$fallbackLocale]);
        }

        if ($slug !== '') {
            $this->merge(['slug' => $slug]);
        }
    }
}

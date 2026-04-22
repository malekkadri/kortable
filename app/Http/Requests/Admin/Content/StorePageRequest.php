<?php

namespace App\Http\Requests\Admin\Content;

use App\Support\Localization\Locale;
use Illuminate\Foundation\Http\FormRequest;

class StorePageRequest extends FormRequest
{
    public function authorize(): bool { return $this->user()?->can('manage_pages') ?? false; }

    public function rules(): array
    {
        $rules = [
            'slug' => ['required', 'string', 'max:255', 'unique:pages,slug'],
            'status' => ['required', 'in:published,draft,archived'],
            'is_active' => ['required', 'boolean'],
            'featured_image' => ['nullable', 'image', 'max:3072'],
            'template' => ['required', 'string', 'max:50'],
            'published_at' => ['nullable', 'date'],
            'seo.og_image' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ];

        foreach (Locale::all() as $locale) {
            $rules["title.$locale"] = ['required', 'string', 'max:255'];
            $rules["slug_translations.$locale"] = ['nullable', 'string', 'max:255'];
            $rules["excerpt.$locale"] = ['nullable', 'string', 'max:500'];
            $rules["content.$locale"] = ['nullable', 'string'];
            $rules["body.$locale"] = ['nullable', 'string'];
            $rules["seo.meta_title.$locale"] = ['nullable', 'string', 'max:255'];
            $rules["seo.meta_description.$locale"] = ['nullable', 'string', 'max:255'];
        }

        return $rules;
    }
}

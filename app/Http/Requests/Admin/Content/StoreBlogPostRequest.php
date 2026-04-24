<?php

namespace App\Http\Requests\Admin\Content;

use App\Support\Localization\Locale;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreBlogPostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('manage_pages') ?? false;
    }

    public function rules(): array
    {
        $rules = [
            'category_id' => ['nullable', 'exists:blog_categories,id'],
            'slug' => ['required', 'string', 'max:255', 'unique:blog_posts,slug'],
            'featured_image' => ['nullable', 'image', 'max:4096'],
            'is_published' => ['required', 'boolean'],
            'published_at' => ['nullable', 'date'],
            'seo_og_image' => ['nullable', 'image', 'max:4096'],
            'seo.og_image' => ['nullable', 'string', 'max:255'],
        ];

        foreach (Locale::all() as $locale) {
            $rules["title.$locale"] = ['required', 'string', 'max:255'];
            $rules["slug_translations.$locale"] = ['nullable', 'string', 'max:255'];
            $rules["excerpt.$locale"] = ['nullable', 'string', 'max:500'];
            $rules["content.$locale"] = ['nullable', 'string'];
            $rules["seo.meta_title.$locale"] = ['nullable', 'string', 'max:255'];
            $rules["seo.meta_description.$locale"] = ['nullable', 'string', 'max:255'];
        }

        return $rules;
    }

    protected function prepareForValidation(): void
    {
        $fallbackLocale = Locale::fallback();
        $title = (array) $this->input('title', []);
        $slug = Str::slug((string) $this->input('slug'));
        $slugTranslations = (array) $this->input('slug_translations', []);

        if ($slug === '' && ! empty($title[$fallbackLocale])) {
            $slug = Str::slug((string) $title[$fallbackLocale]);
        }

        foreach (Locale::all() as $locale) {
            if (empty($slugTranslations[$locale])) {
                continue;
            }

            $slugTranslations[$locale] = Str::slug((string) $slugTranslations[$locale]);
        }

        $this->merge([
            'slug' => $slug,
            'slug_translations' => $slugTranslations,
        ]);
    }
}

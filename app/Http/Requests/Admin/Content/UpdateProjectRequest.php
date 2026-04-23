<?php

namespace App\Http\Requests\Admin\Content;

use App\Support\Localization\Locale;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('manage_pages') ?? false;
    }

    public function rules(): array
    {
        $projectId = (int) $this->route('project')?->id;

        $rules = [
            'category_id' => ['nullable', 'exists:project_categories,id'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('projects', 'slug')->ignore($projectId)],
            'client_name' => ['nullable', 'string', 'max:255'],
            'project_date' => ['nullable', 'date'],
            'website_url' => ['nullable', 'url', 'max:255'],
            'featured_image' => ['nullable', 'image', 'max:4096'],
            'gallery_uploads.*' => ['nullable', 'image', 'max:4096'],
            'existing_gallery' => ['nullable', 'array'],
            'existing_gallery.*' => ['string', 'max:255'],
            'technologies' => ['nullable', 'string'],
            'is_featured' => ['required', 'boolean'],
            'is_published' => ['required', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'published_at' => ['nullable', 'date'],
            'seo.og_image' => ['nullable', 'string', 'max:255'],
            'seo_og_image' => ['nullable', 'image', 'max:4096'],
        ];

        foreach (Locale::all() as $locale) {
            $rules["title.$locale"] = ['required', 'string', 'max:255'];
            $rules["slug_translations.$locale"] = ['nullable', 'string', 'max:255'];
            $rules["short_description.$locale"] = ['nullable', 'string', 'max:500'];
            $rules["description.$locale"] = ['nullable', 'string'];
            $rules["seo.meta_title.$locale"] = ['nullable', 'string', 'max:255'];
            $rules["seo.meta_description.$locale"] = ['nullable', 'string', 'max:255'];
        }

        return $rules;
    }
}

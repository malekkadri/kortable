<?php

namespace App\Http\Requests\Admin\Content;

use App\Support\Localization\Locale;
use Illuminate\Foundation\Http\FormRequest;

class StoreProjectCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('manage_pages') ?? false;
    }

    public function rules(): array
    {
        $rules = [
            'slug' => ['required', 'string', 'max:255', 'unique:project_categories,slug'],
            'is_active' => ['required', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ];

        foreach (Locale::all() as $locale) {
            $rules["name.$locale"] = ['required', 'string', 'max:255'];
            $rules["description.$locale"] = ['nullable', 'string'];
        }

        return $rules;
    }
}

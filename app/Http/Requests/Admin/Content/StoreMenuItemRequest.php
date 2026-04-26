<?php

namespace App\Http\Requests\Admin\Content;

use App\Support\Localization\Locale;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMenuItemRequest extends FormRequest
{
    public function authorize(): bool { return $this->user()?->can('manage_menus') ?? false; }

    public function rules(): array
    {
        $rules = [
            'parent_id' => ['nullable', 'exists:menu_items,id'],
            'type' => ['required', 'in:page,custom,blog_index,blog_category'],
            'linked_page_id' => ['nullable', 'exists:pages,id', Rule::requiredIf(fn () => $this->input('type') === 'page')],
            'linked_blog_category_id' => ['nullable', 'exists:blog_categories,id', Rule::requiredIf(fn () => $this->input('type') === 'blog_category')],
            'custom_url' => ['nullable', 'string', 'max:255', Rule::requiredIf(fn () => $this->input('type') === 'custom')],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['required', 'boolean'],
        ];

        foreach (Locale::all() as $locale) {
            $rules["label.$locale"] = ['required', 'string', 'max:255'];
        }

        return $rules;
    }
}

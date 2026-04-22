<?php

namespace App\Http\Requests\Admin\Content;

use App\Support\Localization\Locale;
use Illuminate\Foundation\Http\FormRequest;

class StoreMenuItemRequest extends FormRequest
{
    public function authorize(): bool { return $this->user()?->can('manage_pages') ?? false; }

    public function rules(): array
    {
        $rules = [
            'parent_id' => ['nullable', 'exists:menu_items,id'],
            'type' => ['required', 'in:page,custom'],
            'linked_page_id' => ['nullable', 'exists:pages,id'],
            'custom_url' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['required', 'boolean'],
        ];

        foreach (Locale::all() as $locale) {
            $rules["label.$locale"] = ['required', 'string', 'max:255'];
        }

        return $rules;
    }
}

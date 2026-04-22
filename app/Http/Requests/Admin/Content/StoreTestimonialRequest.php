<?php

namespace App\Http\Requests\Admin\Content;

use App\Support\Localization\Locale;
use Illuminate\Foundation\Http\FormRequest;

class StoreTestimonialRequest extends FormRequest
{
    public function authorize(): bool { return $this->user()?->can('manage_pages') ?? false; }

    public function rules(): array
    {
        $rules = [
            'author_name' => ['required', 'string', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'avatar' => ['nullable', 'image', 'max:3072'],
            'rating' => ['required', 'integer', 'between:1,5'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['required', 'boolean'],
        ];

        foreach (Locale::all() as $locale) {
            $rules["author_role.$locale"] = ['nullable', 'string', 'max:255'];
            $rules["content.$locale"] = ['required', 'string'];
        }

        return $rules;
    }
}

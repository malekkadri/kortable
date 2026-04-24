<?php

namespace App\Http\Requests\Admin\Content;

use Illuminate\Validation\Rule;

class UpdateBlogCategoryRequest extends StoreBlogCategoryRequest
{
    public function rules(): array
    {
        $rules = parent::rules();
        $rules['slug'] = ['required', 'string', 'max:255', Rule::unique('blog_categories', 'slug')->ignore($this->route('blogCategory'))];

        return $rules;
    }
}

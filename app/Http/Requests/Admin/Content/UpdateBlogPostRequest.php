<?php

namespace App\Http\Requests\Admin\Content;

use Illuminate\Validation\Rule;

class UpdateBlogPostRequest extends StoreBlogPostRequest
{
    public function rules(): array
    {
        $rules = parent::rules();
        $rules['slug'] = ['required', 'string', 'max:255', Rule::unique('blog_posts', 'slug')->ignore($this->route('blogPost'))];

        return $rules;
    }
}

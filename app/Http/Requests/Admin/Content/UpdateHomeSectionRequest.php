<?php

namespace App\Http\Requests\Admin\Content;

class UpdateHomeSectionRequest extends StoreHomeSectionRequest
{
    public function rules(): array
    {
        $rules = parent::rules();
        $rules['section_key'] = [
            'required',
            'string',
            'max:255',
            'regex:/^[a-z0-9_-]+$/',
            'unique:home_sections,section_key,'.$this->route('homeSection')->id,
        ];

        return $rules;
    }
}

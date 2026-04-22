<?php

namespace App\Http\Requests\Admin\Content;

class UpdatePageRequest extends StorePageRequest
{
    public function rules(): array
    {
        $rules = parent::rules();
        $rules['slug'] = ['required', 'string', 'max:255', 'unique:pages,slug,'.$this->route('page')->id];

        return $rules;
    }
}

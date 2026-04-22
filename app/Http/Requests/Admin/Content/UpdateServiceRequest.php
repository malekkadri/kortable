<?php

namespace App\Http\Requests\Admin\Content;

class UpdateServiceRequest extends StoreServiceRequest
{
    public function rules(): array
    {
        $rules = parent::rules();
        $rules['slug'] = ['required', 'string', 'max:255', 'unique:services,slug,'.$this->route('service')->id];

        return $rules;
    }
}

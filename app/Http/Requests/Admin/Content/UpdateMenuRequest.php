<?php

namespace App\Http\Requests\Admin\Content;

class UpdateMenuRequest extends StoreMenuRequest
{
    public function rules(): array
    {
        $rules = parent::rules();
        $rules['location'] = ['required', 'string', 'max:100', 'unique:menus,location,'.$this->route('menu')->id];

        return $rules;
    }
}

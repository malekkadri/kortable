<?php

namespace App\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email:rfc,dns', 'max:190'],
            'phone' => ['nullable', 'string', 'max:40'],
            'subject' => ['required', 'string', 'max:190'],
            'message' => ['required', 'string', 'max:5000'],
            'company_website' => ['nullable', 'max:0'],
        ];
    }

    protected function prepareForValidation(): void
    {
        if (is_string($this->company_website) && $this->company_website !== '') {
            $this->merge(['company_website' => trim($this->company_website)]);
        }
    }

    public function messages(): array
    {
        return [
            'company_website.max' => __('messages.contact_form_spam_detected'),
        ];
    }

    public function validatedPayload(): array
    {
        return $this->safe()->only([
            'name',
            'email',
            'phone',
            'subject',
            'message',
        ]);
    }
}

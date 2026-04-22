<?php

namespace App\Http\Requests\Admin\Contact;

use App\Models\ContactMessage;
use Illuminate\Foundation\Http\FormRequest;

class UpdateContactMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('manage_messages') ?? false;
    }

    public function rules(): array
    {
        return [
            'status' => ['required', 'in:'.implode(',', ContactMessage::statuses())],
            'notes' => ['nullable', 'string', 'max:5000'],
        ];
    }
}

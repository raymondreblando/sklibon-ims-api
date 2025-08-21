<?php

namespace App\Http\Requests\V1\Contact;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'string', 'exists:users,id'],
            'contact_number' => [
                'nullable',
                'string',
                'min:11',
                'max:11',
                Rule::unique('contacts', 'contact_number')->withoutTrashed()
            ]
        ];
    }
}

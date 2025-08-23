<?php

namespace App\Http\Requests\V1\Chat;

use Illuminate\Foundation\Http\FormRequest;

class StorePrivateChatRequest extends FormRequest
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
            'receiver_id' => ['required', 'string', 'exists:users,id'],
            'message' => ['required', 'string']
        ];
    }
}

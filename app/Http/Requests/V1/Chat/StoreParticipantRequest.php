<?php

namespace App\Http\Requests\V1\Chat;

use Illuminate\Foundation\Http\FormRequest;

class StoreParticipantRequest extends FormRequest
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
            'chat_id' => ['required', 'string', 'exists:chats,id'],
            'participants' => ['required', 'array'],
            'participants.*.user_id' => ['required', 'string', 'exists:users,id']
        ];
    }

    public function messages(): array
    {
        return [
            'participants.array' => 'Please specify the participants.',
            'participants.*.user_id.required' => 'Please specify the user participants.'
        ];
    }
}

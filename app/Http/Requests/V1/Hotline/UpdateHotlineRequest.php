<?php

namespace App\Http\Requests\V1\Hotline;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateHotlineRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'max:150',
                Rule::unique('hotlines', 'name')->ignore($this->route('hotline'))
            ],
            'abbreviation' => [
                'required',
                'string',
                'max:30',
                Rule::unique('hotlines', 'abbreviation')->ignore($this->route('hotline'))
            ],
            'hotline' => [
                'required',
                'string',
                'max:30',
                Rule::unique('hotlines', 'hotline')->ignore($this->route('hotline'))
            ],
            'status' => ['required', 'string', 'in:active,inactive']
        ];
    }
}

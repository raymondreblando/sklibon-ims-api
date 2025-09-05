<?php

namespace App\Http\Requests\V1\Account;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
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
            'account' => ['array:username,email'],
            'account.username' => [
                'required',
                'string',
                'max:100',
                Rule::unique('users', 'username')->ignore($this->user()->id)
            ],
            'account.email' => [
                'required',
                'string',
                'email',
                'max:100',
                Rule::unique('users', 'email')->ignore($this->user()->id)
            ],
            'info' => ['array:firstname,middlename,lastname,gender,age,phone_number,birthdate,position_id,province_id,municipality_id,barangay_id,addtional_address'],
            'info.firstname' => ['required', 'string', 'max:100'],
            'info.middlename' => ['nullable', 'string', 'max:100'],
            'info.lastname' => ['required', 'string', 'max:100'],
            'info.gender' => ['required', 'string', 'in:Male,Female'],
            'info.age' => ['required', 'integer', 'min:1'],
            'info.phone_number' => [
                'required',
                'string',
                'max:11',
                Rule::unique('user_infos', 'phone_number')->ignore($this->user()->id, 'user_id')
            ],
            'info.birthdate' => ['required', 'date'],
            'info.position_id' => ['required', 'string', 'exists:positions,id'],
            'info.province_id' => ['required', 'string', 'exists:provinces,id'],
            'info.municipality_id' => ['required', 'string', 'exists:municipalities,id'],
            'info.barangay_id' => ['required', 'string', 'exists:barangays,id'],
            'info.addtional_address' => ['nullable', 'string', 'max:255'],
        ];
    }
}

<?php

namespace App\Http\Requests\V1\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            'account' => ['array:username,email,password,password_confirmation,role_id,status'],
            'account.username' => [
                'required',
                'string',
                'max:100',
                Rule::unique('users', 'username')->ignore($this->route('user'))
            ],
            'account.email' => [
                'required',
                'string',
                'email',
                'max:100',
                Rule::unique('users', 'email')->ignore($this->route('user'))
            ],
            'account.password' => ['required', 'string', 'min:8', 'confirmed'],
            'account.role_id' => ['required', 'string', 'exists:roles,id'],
            'account.status' => ['required', 'string', 'in:active,deactivated,blocked'],
            'info' => ['array:firstname,middlename,lastname,gender,age,phone_number,birthdate,position_id,province_code,municipality_code,barangay_code,additional_address'],
            'info.firstname' => ['required', 'string', 'max:100'],
            'info.middlename' => ['nullable', 'string', 'max:100'],
            'info.lastname' => ['required', 'string', 'max:100'],
            'info.gender' => ['required', 'string', 'in:Male,Female'],
            'info.age' => ['required', 'integer', 'min:1'],
            'info.phone_number' => [
                'required',
                'string',
                'max:11',
                Rule::unique('user_infos', 'phone_number')->ignore($this->route('user')->id, 'user_id')
            ],
            'info.birthdate' => ['required', 'date', 'date_format:Y-m-d'],
            'info.position_id' => ['required', 'string', 'exists:positions,id'],
            'info.province_code' => ['required', 'string', 'exists:provinces,code'],
            'info.municipality_code' => ['required', 'string', 'exists:municipalities,code'],
            'info.barangay_code' => ['required', 'string', 'exists:barangays,code'],
            'info.additional_address' => ['nullable', 'string', 'max:255'],
        ];
    }
}

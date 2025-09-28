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
            'action' => ['in:update,deactivated,blocked'],
            'account.username' => [
                'required_if:action,update',
                'string',
                'max:100',
                Rule::unique('users', 'username')->ignore($this->route('user'))
            ],
            'account.email' => [
                'required_if:action,update',
                'string',
                'email',
                'max:100',
                Rule::unique('users', 'email')->ignore($this->route('user'))
            ],
            'account.password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'account.role_id' => ['nullable', 'string', 'exists:roles,id'],
            'account.status' => ['required', 'string', 'in:active,deactivated,blocked'],
            'info' => ['array:firstname,middlename,lastname,gender,age,phone_number,birthdate,position_id,province_id,municipality_id,barangay_id,additional_address'],
            'info.firstname' => ['required_if:action,update', 'string', 'max:100'],
            'info.middlename' => ['nullable', 'string', 'max:100'],
            'info.lastname' => ['required_if:action,update', 'string', 'max:100'],
            'info.gender' => ['required_if:action,update', 'string', 'in:Male,Female'],
            'info.age' => ['required_if:action,update', 'integer', 'min:1'],
            'info.phone_number' => [
                'required_if:action,update',
                'string',
                'max:11',
                Rule::unique('user_infos', 'phone_number')->ignore($this->route('user')->id, 'user_id')
            ],
            'info.birthdate' => ['required_if:action,update', 'date', 'date_format:Y-m-d'],
            'info.position_id' => ['required_if:action,update', 'string', 'exists:positions,id'],
            'info.province_id' => ['required_if:action,update', 'string', 'exists:provinces,id'],
            'info.municipality_id' => ['required_if:action,update', 'string', 'exists:municipalities,id'],
            'info.barangay_id' => ['required_if:action,update', 'string', 'exists:barangays,id'],
            'info.additional_address' => ['nullable', 'string', 'max:255'],
        ];
    }

    protected function prepareForValidation()
    {
        if (
            $this->input('account.password') === ''
            || $this->input('account.password') === null
        ) {
            $this->merge([
                'account' => collect($this->input('account'))
                    ->except('password')
                    ->toArray()
            ]);
        }
    }
}

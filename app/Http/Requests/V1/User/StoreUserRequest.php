<?php

namespace App\Http\Requests\V1\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'account' => ['array:username,email,password,password_confirmation,role_id'],
            'account.username' => ['required', 'string', 'max:100', 'unique:users,username'],
            'account.email' => ['required', 'string', 'email', 'max:100', 'unique:users,email'],
            'account.password' => ['required', 'string', 'min:8', 'confirmed'],
            'account.role_id' => ['required', 'string', 'exists:roles,id'],
            'info' => ['array:firstname,middlename,lastname,gender,age,phone_number,birthdate,position_id,province_id,municipality_id,barangay_id,additional_address'],
            'info.firstname' => ['required', 'string', 'max:100'],
            'info.middlename' => ['nullable', 'string', 'max:100'],
            'info.lastname' => ['required', 'string', 'max:100'],
            'info.gender' => ['required', 'string', 'in:Male,Female'],
            'info.age' => ['required', 'integer', 'min:1'],
            'info.phone_number' => ['required', 'string', 'max:11', 'unique:user_infos,phone_number'],
            'info.birthdate' => ['required', 'date', 'date_format:Y-m-d'],
            'info.position_id' => ['required', 'string', 'exists:positions,id'],
            'info.province_id' => ['required', 'string', 'exists:provinces,id'],
            'info.municipality_id' => ['required', 'string', 'exists:municipalities,id'],
            'info.barangay_id' => ['required', 'string', 'exists:barangays,id'],
            'info.additional_address' => ['nullable', 'string', 'max:255'],
        ];
    }
}

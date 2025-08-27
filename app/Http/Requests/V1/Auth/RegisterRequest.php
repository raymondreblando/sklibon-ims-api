<?php

namespace App\Http\Requests\V1\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'account' => ['array:username,email,password,password_confirmation'],
            'account.username' => ['required', 'string', 'max:100', 'unique:users,username'],
            'account.email' => ['required', 'string', 'email', 'max:100', 'unique:users,email'],
            'account.password' => ['required', 'string', 'min:8', 'confirmed'],
            'account.password_confirmation' => ['required'],
            'info' => ['array:firstname,middlename,lastname,gender,position_id,barangay_id'],
            'info.firstname' => ['required', 'string', 'max:100'],
            'info.middlename' => ['nullable', 'string', 'max:100'],
            'info.lastname' => ['required', 'string', 'max:100'],
            'info.gender' => ['required', 'string', 'in:Male,Female'],
            'info.position_id' => ['required', 'string', 'exists:positions,id'],
            'info.barangay_id' => ['required', 'string', 'exists:barangays,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'account.password_confirmation.required' => 'Confirm account password.'
        ];
    }
}

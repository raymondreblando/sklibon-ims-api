<?php

namespace App\Http\Requests\V1\Report;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReportRequest extends FormRequest
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
            'barangay_id' => ['required_if:status,active', 'string', 'exists:barangays,id'],
            'subject' => ['required_if:status,active', 'string', 'max:255'],
            'description' => ['required_if:status,active', 'string'],
            'status' => ['nullable', 'in:active,archived']
        ];
    }
}

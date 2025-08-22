<?php

namespace App\Http\Requests\V1\Report;

use Illuminate\Foundation\Http\FormRequest;

class StoreReportRequest extends FormRequest
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
            'barangay_id' => ['required', 'string', 'exists:barangays,id'],
            'subject' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'attachments' => ['required', 'array'],
            'attachments.*.attachment' => ['required', 'url:https']
        ];
    }
}

<?php

namespace App\Http\Requests\V1\Attachment;

use Illuminate\Foundation\Http\FormRequest;

class StoreAttachmentRequest extends FormRequest
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
            'report_id' => ['required', 'string', 'exists:reports,id'],
            'attachments' => ['required', 'array'],
            'attachments.*.attachment' => ['required', 'url:https'],
            'attachments.*.filename' => ['required', 'string'],
            'attachments.*.file_type' => ['required', 'string'],
            'attachments.*.file_size' => ['required', 'numeric']
        ];
    }
}

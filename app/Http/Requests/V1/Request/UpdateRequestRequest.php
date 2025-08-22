<?php

namespace App\Http\Requests\V1\Request;

use App\Rules\V1\ValidReceivable;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequestRequest extends FormRequest
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
            'request_type_id' => ['required_if:status,pending', 'string', 'exists:request_types,id'],
            'name' => ['required_if:status,pending', 'string', 'max:250'],
            'description' => ['required_if:status,pending', 'string'],
            'date_needed' => ['required_if:status,pending', 'date', 'date_format:Y-m-d'],
            'attachment' => ['required_if:status,pending', 'string', 'url:https'],
            'receivable_type' => ['required_if:status,pending', 'string', 'in:user,barangay'],
            'receivable_id' => ['required_if:status,pending', 'string', new ValidReceivable($this->input('receivable_type'))],
            'status' => ['nullable', 'string', 'in:pending,approved,disapproved,completed,cancelled'],
            'approved_date' => ['nullable', 'date', 'date_format:Y-m-d'],
            'approved_by' => ['nullable', 'string', 'exists:users,id'],
            'disapproved_date' => ['nullable', 'date', 'date_format:Y-m-d'],
            'disapproved_by' => ['nullable', 'string', 'exists:users,id'],
            'reason' => ['nullable', 'string']
        ];
    }
}

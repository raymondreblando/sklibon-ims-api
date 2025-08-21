<?php

namespace App\Http\Requests\V1\Request;

use App\Rules\V1\ValidReceivable;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequestRequest extends FormRequest
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
            'request_type_id' => ['required', 'string', 'exists:request_types,id'],
            'name' => ['required', 'string', 'max:250'],
            'description' => ['required', 'string'],
            'date_needed' => ['required', 'date', 'date_format:Y-m-d'],
            'attachment' => ['required', 'string', 'url:https'],
            'receivable_type' => ['required', 'string', 'in:user,barangay'],
            'receivable_id' => ['required', 'string', new ValidReceivable($this->input('receivable_type'))],
        ];
    }
}

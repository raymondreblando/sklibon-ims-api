<?php

namespace App\Http\Requests\V1\Event;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEventRequest extends FormRequest
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
        $requiredIfEventIsActive = Rule::requiredIf(
            fn () => in_array($this->status, ['upcoming', 'ongoing'])
        );

        return [
            'barangay_id' => [
                $requiredIfEventIsActive,
                'string',
                'exists:barangays,id'
            ],
            'name' => [
                $requiredIfEventIsActive,
                'string',
                'max:255'
            ],
            'description' => [
                $requiredIfEventIsActive,
                'string'
            ],
            'event_date' => [
                $requiredIfEventIsActive,
                'date',
                'date_format:Y-m-d H:i:s'
            ],
            'expired_date' => [
                $requiredIfEventIsActive,
                'date',
                'date_format:Y-m-d H:i:s'
            ],
            'open_attendance' => [
                $requiredIfEventIsActive,
                'boolean'
            ],
            'image_url' => [
                $requiredIfEventIsActive,
                'string',
                'url:https'
            ],
            'status' => [
                'required',
                'string',
                'in:upcoming,ongoing,completed,cancelled,archived'
            ],
            'latitude' => [
                $requiredIfEventIsActive,
                'numeric'
            ],
            'longitude' => [
                $requiredIfEventIsActive,
                'numeric'
            ],
        ];
    }
}

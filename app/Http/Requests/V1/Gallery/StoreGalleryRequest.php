<?php

namespace App\Http\Requests\V1\Gallery;

use Illuminate\Foundation\Http\FormRequest;

class StoreGalleryRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'images' => ['required', 'array'],
            'images.*.image_url' => ['required', 'url:https'],
        ];
    }

    public function messages(): array
    {
        return [
            'images' => 'Upload a gallery image'
        ];
    }
}

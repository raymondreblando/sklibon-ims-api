<?php

namespace App\Http\Requests\V1\GalleryImage;

use Illuminate\Foundation\Http\FormRequest;

class StoreGalleryImageRequest extends FormRequest
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
            'gallery_id' => ['required', 'string', 'exists:galleries,id'],
            'images' => ['required', 'array'],
            'images.*.image_url' => ['required', 'string', 'url:https'],
        ];
    }
}

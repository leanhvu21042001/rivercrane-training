<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveProductRequest extends FormRequest
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
            'name' => ['required', 'string', 'min:5'],
            'price' => ['required', 'numeric', 'min:0'],
            'is_sales' => ['required', 'numeric'],
            'fileUpload' => [
                'image',
                'file_extension:png,jpg,jpeg',
                'mimes:png,jpg,jpeg',
                'mimetypes:image/png,image/jpg,image/jpeg',
                'max:2048',
            ]
        ];
    }
}

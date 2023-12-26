<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required',
            'status' => 'required',
        ];

        $fields = $request->query('fields');

        // If fields has any values
        // only accept rules has contains in fields
        if (isset($fields) && !empty($fields)) {
            return array_intersect_key($rules, array_flip($fields));
        }

        return $rules;
    }
}

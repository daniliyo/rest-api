<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:departments|max:255'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The field must be filled ',
            'name.unique' => 'The field must be unique',
            'name.max' => 'The field must be the maximum size',

        ];
    }
}

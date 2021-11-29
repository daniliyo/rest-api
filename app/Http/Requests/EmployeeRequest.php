<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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
            'firstname' => 'required|max:255',
            'lastname' => 'required|max:255',
            'patronymic' => 'required|max:255',
            'salary' => 'required|integer'
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'firstname.required' => 'The field must be filled ',
            'firstname.max' => 'The field must be the maximum size',
            'lastname.required' => 'The field must be filled ',
            'lastname.max' => 'The field must be the maximum size',
            'patronymic.required' => 'The field must be filled ',
            'patronymic.max' => 'The field must be the maximum size',
            'salary' => 'The field must be filled',
            'salary' => 'The field must be integer',

        ];
    }
}

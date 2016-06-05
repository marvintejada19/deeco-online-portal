<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserDetailRequest extends Request
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
            'idNumberPre' => 'required|numeric',
            'idNumberPost' => 'required|numeric',
        ];
    }

    /**
     * Get the output messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'idNumberPre.required' => 'The first part of the ID number is required.',
            'idNumberPost.required' => 'The second part of the ID number is required.',   
            'idNumberPre.numeric' => 'The first part of the ID number must be a number.',
            'idNumberPost.numeric' => 'The second part of the ID number must be a number.',
        ];
    }
}

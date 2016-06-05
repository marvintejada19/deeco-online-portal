<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserRequest extends Request
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
            'username' => 'required|max:255',
            'password' => 'required|confirmed|min:6|max:255',
            'role_id'  => 'required',
            'lastname'  => 'required|max:255',
            'firstname' => 'required|max:255',
            'idNumberPre' => 'required|numeric',
            'idNumberPost' => 'required|numeric',
            'gender' => 'required',
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
            'role_id.required'   => 'Please specify role of user.',
            'idNumberPre.required' => 'The first part of the ID number is required.',
            'idNumberPost.required' => 'The second part of the ID number is required.',   
            'idNumberPre.numeric' => 'The first part of the ID number must be a number.',
            'idNumberPost.numeric' => 'The second part of the ID number must be a number.',
        ];
    }
}

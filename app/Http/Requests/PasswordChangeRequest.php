<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PasswordChangeRequest extends Request
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
            'oldPassword' => 'required',
            'newPassword' => 'required|confirmed|min:6|max:255',
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
            'oldPassword.required' => 'Please enter your old password.',
            'newPassword.required' => 'Please enter a new password.',
        ];
    }
}

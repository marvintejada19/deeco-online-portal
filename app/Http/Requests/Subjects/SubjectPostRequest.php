<?php

namespace App\Http\Requests\Subjects;

use App\Http\Requests\Request;

class SubjectPostRequest extends Request
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
            'title'         => 'required|max:255',
            'body'          => 'required',
            'published_at'  => 'required',
            'files'         => 'max:16384',
        ];
    }

    public function messages()
    {
        return [
            'files.max' => 'Files must be 16mb at most.',
        ];
    }
}

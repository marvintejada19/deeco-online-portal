<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class SubjectRequirementRequest extends Request
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
            'title'         => 'required|max:255|unique:subject_requirements,title',
            'body'          => 'required',
            'published_at'  => 'required',
            'event_start'   => 'required',
            'event_end'     => 'required|after:event_start',
            'files'         => 'max:16384',
        ];
    }

    public function messages()
    {
        return [
            'files.max'         => 'Files must be 16mb at most.',
            'event_end.after'   => 'Please set a date succeeding the previous date'
        ];
    }
}

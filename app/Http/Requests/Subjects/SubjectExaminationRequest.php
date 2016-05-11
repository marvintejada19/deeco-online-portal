<?php

namespace App\Http\Requests\Subjects;

use App\Http\Requests\Request;

class SubjectExaminationRequest extends Request
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
            'published_at'  => 'required',
            'exam_start'   => 'required',
            'exam_end'     => 'required|after:exam_start',
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
            'exam_end.after'   => 'Please set a date succeeding the previous date',
        ];
    }
}

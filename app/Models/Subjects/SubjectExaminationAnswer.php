<?php

namespace App\Models\Subjects;

use Illuminate\Database\Eloquent\Model;

class SubjectExaminationAnswer extends Model
{
    protected $fillable = [
	    'examination_instance_id',
	    'question_id',
    	'matching_type_item_id',
    	'answer',
    ];

    protected $table = 'examination_answers';
    public $timestamps = false;

}

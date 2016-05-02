<?php

namespace App\Models\Subjects;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class SubjectExamination extends Model
{
	protected $fillable = ['title', 'is_published'];
	protected $table = 'examinations';

    public function subject(){
    	return $this->belongsTo('App\Models\Subjects\Subject');
    }

    public function questions(){
    	return $this->belongsToMany('App\Models\Questions\Question', 'examination_questions', 'examination_id', 'question_id');
    }
}

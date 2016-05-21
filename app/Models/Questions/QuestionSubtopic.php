<?php

namespace App\Models\Questions;

use Illuminate\Database\Eloquent\Model;

class QuestionSubtopic extends Model
{
	protected $fillable = ['name'];
    
    public function questionTopic(){
		return $this->belongsTo('App\Models\Questions\QuestionTopic');
	}

	public function questions(){
		return $this->hasMany('App\Models\Questions\Question')->orderBy('question_type_id', 'asc');
	}

	public function examinationPartItems(){
		return $this->hasMany('App\Models\Subjects\SubjectExaminationPartItem', 'question_subtopic_id');
	}
}

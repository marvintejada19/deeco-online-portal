<?php

namespace App\Models\Questions;

use Illuminate\Database\Eloquent\Model;

class QuestionTopic extends Model
{
	protected $fillable = ['name'];

	public function questionCategory(){
		return $this->belongsTo('App\Models\Questions\QuestionCategory', 'question_category_id');
	}

    public function questionSubtopics(){
    	return $this->hasMany('App\Models\Questions\QuestionSubtopic')->orderBy('name', 'asc');
    }
}


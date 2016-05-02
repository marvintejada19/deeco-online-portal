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
		return $this->hasMany('App\Models\Questions\Question');
	}
}

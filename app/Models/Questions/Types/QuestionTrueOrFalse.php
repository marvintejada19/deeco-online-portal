<?php

namespace App\Models\Questions\Types;

use Illuminate\Database\Eloquent\Model;

class QuestionTrueOrFalse extends Model
{
	protected $fillable = ['right_answer'];
	protected $table = 'question_true_or_false';
	
    public function question(){
    	return $this->belongsTo('App\Models\Questions\Question');
    }
}

<?php

namespace App\Models\Questions\Types;

use Illuminate\Database\Eloquent\Model;

class QuestionFillInTheBlanks extends Model
{
	protected $fillable = ['right_answer'];
	protected $table = 'question_fill_in_the_blanks';
	
    public function question(){
    	return $this->belongsTo('App\Models\Questions\Question');
    }
}

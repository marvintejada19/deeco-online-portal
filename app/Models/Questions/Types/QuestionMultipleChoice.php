<?php

namespace App\Models\Questions\Types;

use Illuminate\Database\Eloquent\Model;
use DB;

class QuestionMultipleChoice extends Model
{
	protected $fillable = [
		'text',
		'is_right_answer',
	];

    protected $table = 'question_multiple_choice';
	
    public function question(){
    	return $this->belongsTo('App\Models\Questions\Question');
    }
}

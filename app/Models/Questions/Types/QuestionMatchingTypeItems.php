<?php

namespace App\Models\Questions\Types;

use Illuminate\Database\Eloquent\Model;

class QuestionMatchingTypeItems extends Model
{
	protected $fillable = [
		'text', 
		'correct_answer'
	];
	
	public $timestamps = false;
	protected $table = 'question_matching_type_items';
	
    public function questionMatchingType(){
    	return $this->belongsTo('App\Models\Questions\Types\QuestionMatchingType');
    }
}

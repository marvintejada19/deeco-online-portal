<?php

namespace App\Models\Questions\Types;

use Illuminate\Database\Eloquent\Model;

class QuestionMatchingTypeChoices extends Model
{
	protected $fillable = ['text'];
	public $timestamps = false;
	protected $table = 'question_matching_type_choices';
	
    public function questionMatchingType(){
    	return $this->belongsTo('App\Models\Questions\Types\QuestionMatchingType');
    }
}

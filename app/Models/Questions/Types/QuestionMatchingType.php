<?php

namespace App\Models\Questions\Types;

use Illuminate\Database\Eloquent\Model;

class QuestionMatchingType extends Model
{
	protected $fillable = ['format'];
	protected $table = 'question_matching_type';

	public function question(){
		return $this->belongsTo('App\Models\Questions\Question');
	}

    public function matchingTypeItems(){
        return $this->hasMany('App\Models\Questions\Types\QuestionMatchingTypeItems', 'matching_type_id');
    }

    public function matchingTypeChoices(){
        return $this->hasMany('App\Models\Questions\Types\QuestionMatchingTypeChoices', 'matching_type_id');
    }
}

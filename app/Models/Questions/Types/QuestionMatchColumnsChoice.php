<?php

namespace App\Models\Questions\Types;

use Illuminate\Database\Eloquent\Model;

class QuestionMatchColumnsChoice extends Model
{
    protected $fillable = ['text'];
    protected $table = 'question_match_columns_choices';
	public $timestamps = false;

	public function question(){
    	return $this->belongsTo('App\Models\Questions\Question');
    }

    public function item(){
    	return $this->hasOne('App\Models\Questions\Types\QuestionMatchColumnsItem', 'columns_choice_id');
    }
}

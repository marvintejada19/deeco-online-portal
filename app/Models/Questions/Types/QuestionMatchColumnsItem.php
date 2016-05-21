<?php

namespace App\Models\Questions\Types;

use Illuminate\Database\Eloquent\Model;

class QuestionMatchColumnsItem extends Model
{
    protected $fillable = ['text', 'columns_choice_id'];
    protected $table = 'question_match_columns_items';
	public $timestamps = false;

	public function choice(){
    	return $this->belongsTo('App\Models\Questions\Types\QuestionMatchColumnsChoice', 'columns_choice_id');
    }
}

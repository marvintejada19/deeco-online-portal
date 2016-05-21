<?php

namespace App\Models\Questions\Types;

use Illuminate\Database\Eloquent\Model;

class QuestionSelectFromTheWordboxItem extends Model
{
	protected $fillable = ['text', 'wordbox_choice_id'];
    protected $table = 'question_select_from_the_wordbox_items';
	public $timestamps = false;

	public function choice(){
    	return $this->belongsTo('App\Models\Questions\Types\QuestionSelectFromTheWordboxChoice', 'wordbox_choice_id');
    }
}

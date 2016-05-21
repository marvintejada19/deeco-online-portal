<?php

namespace App\Models\Questions\Types;

use Illuminate\Database\Eloquent\Model;

class QuestionSelectFromTheWordboxChoice extends Model
{
	protected $fillable = ['text'];
    protected $table = 'question_select_from_the_wordbox_choices';
	public $timestamps = false;

	public function question(){
    	return $this->belongsTo('App\Models\Questions\Question');
    }

    public function items(){
    	return $this->hasMany('App\Models\Questions\Types\QuestionSelectFromTheWordboxItem', 'wordbox_choice_id');
    }
}

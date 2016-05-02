<?php

namespace App\Models\Questions;

use Illuminate\Database\Eloquent\Model;

class QuestionCategory extends Model
{
	protected $fillable = ['name'];
    protected $table = 'question_categories';

    public function questionTopics(){
    	return $this->hasMany('App\Models\Questions\QuestionTopic')->orderBy('name', 'asc');
    }
}

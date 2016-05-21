<?php

namespace App\Models\Questions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Question extends Model
{
	use SoftDeletes;
	
	protected $fillable = [
		'question_type_id',
		'question_subtopic_id',
		'title',
		'body',
		'points',
		'user_id',
	];

    public function move($categoryName, $topicName, $subtopicName){
        $category = QuestionCategory::where('name', '=', $categoryName)->first();
        $topic = QuestionTopic::where('name', '=', $topicName)->where('question_category_id', '=', $category->id)->first();
        $subtopic = QuestionSubtopic::where('name', '=', $subtopicName)->where('question_topic_id', '=', $topic->id)->first();
        
        if (empty($category) || empty($topic) || empty($subtopic)){
            return redirect('home');
        } else {
            $this->question_subtopic_id = $subtopic->id;
            $this->save();
        }
    }

    public function getQuestionType(){
        return DB::table('question_types')->where('id', $this->question_type_id)->first()->name;
    }

    public function getAuthor(){
        return DB::table('users')->where('id', $this->user_id)->first()->username;
    }

    public function questionSubtopic(){
        return $this->belongsTo('App\Models\Questions\QuestionSubtopic');
    }

    public function subjectExaminations(){
        return $this->belongsToMany('App\Models\Subjects\SubjectExamination', 'examination_questions', 'examination_id', 'question_id');
    }

    public function trueOrFalse(){
        return $this->hasOne('App\Models\Questions\Types\QuestionTrueOrFalse');
    }

    public function fillInTheBlanks(){
        return $this->hasOne('App\Models\Questions\Types\QuestionFillInTheBlanks');
    }

    public function multipleChoice(){
        return $this->hasMany('App\Models\Questions\Types\QuestionMultipleChoice');
    }

    public function matchColumnsChoices(){
        return $this->hasMany('App\Models\Questions\Types\QuestionMatchColumnsChoice');
    }

    public function selectFromTheWordboxChoices(){
        return $this->hasMany('App\Models\Questions\Types\QuestionSelectFromTheWordboxChoice');
    }
}

<?php

namespace App\Http\Controllers\Questions;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Questions\QuestionCategory;
use App\Models\Questions\QuestionTopic;
use App\Models\Questions\QuestionSubtopic;
use App\Models\Questions\Question;
use App\Models\Questions\Types\QuestionMatchColumnsChoice;
use App\Models\Questions\Types\QuestionMatchColumnsItem;
use URL;

class QuestionMatchColumnsController extends Controller
{
    public function createItem(QuestionCategory $category, $url_topic, $url_subtopic, Question $question){
    	$topic = QuestionTopic::where('name', '=', $url_topic)->where('question_category_id', '=', $category->id)->first();
        $subtopic = QuestionSubtopic::where('name', '=', $url_subtopic)->where('question_topic_id', '=', $topic->id)->first();    	
    	return view('questions.content.create-type.match-column-a-with-column-b-item', compact('category', 'topic', 'subtopic', 'question', 'choices'));
    }

    public function storeItem(QuestionCategory $category, $url_topic, $url_subtopic, Question $question, Request $request){
    	$topic = QuestionTopic::where('name', '=', $url_topic)->where('question_category_id', '=', $category->id)->first();
        $subtopic = QuestionSubtopic::where('name', '=', $url_subtopic)->where('question_topic_id', '=', $topic->id)->first();

        $choice = $question->matchColumnsChoices()->create(['text' => $request->input('choice')]);
        $choice->item()->create(['text' => $request->input('item')]);
    	return redirect('/categories/' . $category->name . '/topics/' . $topic->name . '/subtopics/' . $subtopic->name . '/questions/' . $question->id);
    }

    public function removeChoice($id){
        $choice = QuestionMatchColumnsChoice::find($id);
        $choice->delete();
        return redirect(URL::previous());
    }
}

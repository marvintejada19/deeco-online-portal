<?php

namespace App\Http\Controllers\Questions;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Questions\Question;
use App\Models\Questions\QuestionCategory;
use App\Models\Questions\QuestionTopic;
use App\Models\Questions\QuestionSubtopic;
use App\Models\Questions\Types\QuestionMultipleChoice;
use URL;

class QuestionMultipleChoiceController extends Controller
{
    public function createChoice(QuestionCategory $category, $url_topic, $url_subtopic, Question $question){
    	$topic = QuestionTopic::where('name', '=', $url_topic)->where('question_category_id', '=', $category->id)->first();
        $subtopic = QuestionSubtopic::where('name', '=', $url_subtopic)->where('question_topic_id', '=', $topic->id)->first();    	
    	return view('questions.content.create-type.multiple-choice-choice', compact('category', 'topic', 'subtopic', 'question', 'choices'));
    }

    public function storeChoice(QuestionCategory $category, $url_topic, $url_subtopic, Question $question, Request $request){
    	$topic = QuestionTopic::where('name', '=', $url_topic)->where('question_category_id', '=', $category->id)->first();
        $subtopic = QuestionSubtopic::where('name', '=', $url_subtopic)->where('question_topic_id', '=', $topic->id)->first();

        if ($request->input('text') == "<br>" || $request->input('text') == ""){
            flash()->error('Please fill up all necessary fields');
            return redirect('/categories/' . $category->name . '/topics/' . $topic->name . '/subtopics/' . $subtopic->name . '/questions/create/' . $url_type)
                     ->withInput($request->all());
        }
        $choice = $question->multipleChoice()->create(['text' => $request->input('text'), 'is_right_answer' => '0']);
    	return redirect('/categories/' . $category->name . '/topics/' . $topic->name . '/subtopics/' . $subtopic->name . '/questions/' . $question->id);
    }

    public function removeChoice($id){
        $choice = QuestionMultipleChoice::find($id);
        $choice->delete();
        return redirect(URL::previous());
    }
}

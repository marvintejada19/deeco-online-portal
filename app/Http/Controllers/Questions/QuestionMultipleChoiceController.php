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

class QuestionMultipleChoiceController extends Controller
{
    public function create(QuestionCategory $category, $url_topic, $url_subtopic, $url_type, Request $request){
    	$topic = QuestionTopic::where('name', '=', $url_topic)->where('question_category_id', '=', $category->id)->first();
        $subtopic = QuestionSubtopic::where('name', '=', $url_subtopic)->where('question_topic_id', '=', $topic->id)->first();    	
    	$quantity = ($request->input('quantity') - 1);
        $type = 'Multiple Choice';
        return view('questions.content.create-type.multiple-choice', compact('category', 'topic', 'subtopic', 'type', 'url_type', 'quantity'));
    }

    public function edit(QuestionCategory $category, $url_topic, $url_subtopic, Question $question, $id){
        $topic = QuestionTopic::where('name', '=', $url_topic)->where('question_category_id', '=', $category->id)->first();
        $subtopic = QuestionSubtopic::where('name', '=', $url_subtopic)->where('question_topic_id', '=', $topic->id)->first();      
        $choice = QuestionMultipleChoice::find($id);
        return view('questions.content.edit-type.multiple-choice', compact('category', 'topic', 'subtopic', 'question', 'choice'));
    }

    public function update(QuestionCategory $category, $url_topic, $url_subtopic, Question $question, $id, Request $request){
        $topic = QuestionTopic::where('name', '=', $url_topic)->where('question_category_id', '=', $category->id)->first();
        $subtopic = QuestionSubtopic::where('name', '=', $url_subtopic)->where('question_topic_id', '=', $topic->id)->first();      
        $choice = QuestionMultipleChoice::find($id);
        $choice->text = $request->input('text');
        $choice->update();
        return redirect('/categories/' . $category->name . '/topics/' . $topic->name . '/subtopics/' . $subtopic->name . '/questions/' . $question->id);
    }
}

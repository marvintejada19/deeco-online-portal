<?php

namespace App\Http\Controllers\Questions;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Questions\QuestionCategory;
use App\Models\Questions\QuestionTopic;
use App\Models\Questions\QuestionSubtopic;
use App\Models\Questions\Question;
use App\Models\Questions\Types\QuestionSelectFromTheWordboxChoice;
use App\Models\Questions\Types\QuestionSelectFromTheWordboxItem;
use URL;

class QuestionSelectFromTheWordboxController extends Controller
{
    public function createChoice(QuestionCategory $category, $url_topic, $url_subtopic, Question $question){
    	$topic = QuestionTopic::where('name', '=', $url_topic)->where('question_category_id', '=', $category->id)->first();
        $subtopic = QuestionSubtopic::where('name', '=', $url_subtopic)->where('question_topic_id', '=', $topic->id)->first();
    	return view('questions.content.create-type.select-from-the-wordbox-choice', compact('category', 'topic', 'subtopic', 'question'));
    }

    public function storeChoice(QuestionCategory $category, $url_topic, $url_subtopic, Question $question, Request $request){
    	$topic = QuestionTopic::where('name', '=', $url_topic)->where('question_category_id', '=', $category->id)->first();
        $subtopic = QuestionSubtopic::where('name', '=', $url_subtopic)->where('question_topic_id', '=', $topic->id)->first();
    	
        $question->selectFromTheWordboxChoices()->create($request->all());
    	return redirect('/categories/' . $category->name . '/topics/' . $topic->name . '/subtopics/' . $subtopic->name . '/questions/' . $question->id);
    }

    public function createItem(QuestionCategory $category, $url_topic, $url_subtopic, Question $question){
    	$topic = QuestionTopic::where('name', '=', $url_topic)->where('question_category_id', '=', $category->id)->first();
        $subtopic = QuestionSubtopic::where('name', '=', $url_subtopic)->where('question_topic_id', '=', $topic->id)->first();
    	
        $choices = QuestionSelectFromTheWordboxChoice::where('question_id', $question->id)->lists('text', 'id');
    	return view('questions.content.create-type.select-from-the-wordbox-item', compact('category', 'topic', 'subtopic', 'question', 'choices'));
    }

    public function storeItem(QuestionCategory $category, $url_topic, $url_subtopic, Question $question, Request $request){
    	$topic = QuestionTopic::where('name', '=', $url_topic)->where('question_category_id', '=', $category->id)->first();
        $subtopic = QuestionSubtopic::where('name', '=', $url_subtopic)->where('question_topic_id', '=', $topic->id)->first();

        $choice = $question->selectFromTheWordboxChoices()->find($request->input('wordbox_choice_id'));
        $choice->items()->create(['text' => $request->input('text')]);
    	return redirect('/categories/' . $category->name . '/topics/' . $topic->name . '/subtopics/' . $subtopic->name . '/questions/' . $question->id);
    }

    public function removeItem($id){
        $item = QuestionSelectFromTheWordboxItem::find($id);
        $item->delete();
        return redirect(URL::previous());
    }

    public function removeChoice($id){
        $choice = QuestionSelectFromTheWordboxChoice::find($id);
        $choice->delete();
        return redirect(URL::previous());
    }
}

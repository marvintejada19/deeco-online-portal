<?php

namespace App\Http\Controllers\Questions;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\Questions\QuestionSubtopicRequest;
use App\Models\Questions\QuestionCategory;
use App\Models\Questions\QuestionTopic;
use App\Models\Questions\QuestionSubtopic;

class QuestionSubtopicsController extends Controller
{
    public function __construct(){
    }

    public function show(QuestionCategory $category, $url_topic, $url_subtopic){
    	$topic = QuestionTopic::where('name', '=', $url_topic)->where('question_category_id', '=', $category->id)->first();
        $subtopic = QuestionSubtopic::where('name', '=', $url_subtopic)->where('question_topic_id', '=', $topic->id)->first();
		return view('questions.subtopics.show', compact('category', 'topic', 'subtopic'));
	}

    public function create(QuestionCategory $category, $url_topic){
    	$topic = QuestionTopic::where('name', '=', $url_topic)->where('question_category_id', '=', $category->id)->first();
    	return view('questions.subtopics.create', compact('category', 'topic'));
    }

	public function store(QuestionCategory $category, $url_topic, QuestionSubtopicRequest $request){
        $topic = QuestionTopic::where('name', '=', $url_topic)->where('question_category_id', '=', $category->id)->first();
        $name = $request->input('name');
        if($this->checkIfAvailable($topic, $name)){
	        $topic->questionSubtopics()->create($request->all());
	        flash()->success('New subtopic has been added.');
	        return redirect('/categories/' . $category->name . '/topics/' . $topic->name);
    	} else {
    		return redirect('/categories/' . $category->name . '/topics/' . $topic->name . '/subtopics/create')->withErrors(['name' => 'Subtopic name already exists for this topic.']);
    	}
	}

	public function edit(QuestionCategory $category, $url_topic, $url_subtopic){
		$topic = QuestionTopic::where('name', '=', $url_topic)->where('question_category_id', '=', $category->id)->first();
        $subtopic = QuestionSubtopic::where('name', '=', $url_subtopic)->where('question_topic_id', '=', $topic->id)->first();
		return view('questions.subtopics.edit', compact('category', 'topic', 'subtopic'));
	}

	public function update(QuestionCategory $category, $url_topic, $url_subtopic, QuestionSubtopicRequest $request){
		$topic = QuestionTopic::where('name', '=', $url_topic)->where('question_category_id', '=', $category->id)->first();
        $subtopic = QuestionSubtopic::where('name', '=', $url_subtopic)->where('question_topic_id', '=', $topic->id)->first();
		$name = $request->input('name');
        if($this->checkIfAvailable($topic, $name)){
			$subtopic->update($request->all());
	        flash()->success('Subtopic successfully updated');
	        return redirect('/categories/' . $category->name . '/topics/' . $topic->name);
	    } else {
			return redirect('/categories/' . $category->name . '/topics/' . $topic->name . '/subtopics/' . $subtopic->name . '/edit')->withErrors(['name' => 'Subtopic name already exists for this topic.']);
	    }
	}

	public function showDeleteConfirmation(QuestionCategory $category, $url_topic, $url_subtopic){
		$topic = QuestionTopic::where('name', '=', $url_topic)->where('question_category_id', '=', $category->id)->first();
        $subtopic = QuestionSubtopic::where('name', '=', $url_subtopic)->where('question_topic_id', '=', $topic->id)->first();

		return view('questions.subtopics.delete', compact('category', 'topic', 'subtopic'));
	}

	public function delete(QuestionCategory $category, $url_topic, $url_subtopic){
		$topic = QuestionTopic::where('name', '=', $url_topic)->where('question_category_id', '=', $category->id)->first();
        $subtopic = QuestionSubtopic::where('name', '=', $url_subtopic)->where('question_topic_id', '=', $topic->id)->first();

        foreach ($subtopic->questions as $question){
        	$question->move($category->name, $topic->name, 'Default Subtopic');
        }

		$subtopic->delete();
        return redirect('/categories/' . $category->name . '/topics/' . $topic->name);
	}

	private function checkIfAvailable($topic, $name){
		$result = QuestionSubtopic::where('name', '=', $name)->where('question_topic_id', '=', $topic->id)->first();
		if(empty($result)){
			return true;
		} else {
			return false;
		}
	}
}

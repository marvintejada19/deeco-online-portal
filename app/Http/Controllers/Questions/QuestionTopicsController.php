<?php

namespace App\Http\Controllers\Questions;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\Questions\QuestionTopicRequest;
use App\Models\Questions\QuestionCategory;
use App\Models\Questions\QuestionTopic;
use Validator;

class QuestionTopicsController extends Controller
{
    /**
     * Show the contents of a given topic
     *
     * @param QuestionCategory $category
     * @param $url_topic a string containing the title of the topic that falls under the specified category
     * @return \Illuminate\Http\Response
     */
	public function show(QuestionCategory $category, $url_topic){
    	$topic = QuestionTopic::where('name', '=', $url_topic)->where('question_category_id', '=', $category->id)->first();
		return view('questions.topics.show', compact('category', 'topic'));
    }

    /**
     * Show the form in creating a topic
     *
     * @param QuestionCategory $category
     * @return \Illuminate\Http\Response
     */
	public function create(QuestionCategory $category){
    	return view('questions.topics.create', compact('category'));
    }

	/**
     * Store the topic in the database
     *
     * @param QuestionCategory $category
     * @param QuestionTopicRequest $request
     * @return \Illuminate\Http\Response
     */
	public function store(QuestionCategory $category, QuestionTopicRequest $request){
        $name = $request->input('name');
        if($this->checkIfAvailable($category, $name)){
	        $topic = $category->questionTopics()->create($request->all());
	        $topic->questionSubtopics()->create(['name' => 'Default Subtopic']);
	        flash()->success('New topic has been added.');
	        return redirect('/categories/' . $category->name);
        } else {
        	return redirect('/categories/' . $category->name . '/topics/create')->withErrors(['name' => 'Topic name already exists for this category.']);
        }
	}

	/**
     * Show the form in editing a topic
     *
     * @param QuestionCategory $category
     * @param $url_topic a string containing the title of the topic that falls under the specified category
     * @return \Illuminate\Http\Response
     */
	public function edit(QuestionCategory $category, $url_topic){
		$topic = QuestionTopic::where('name', '=', $url_topic)->where('question_category_id', '=', $category->id)->first();
		return view('questions.topics.edit', compact('category', 'topic'));
	}

	/**
     * Update the topic in the database
     *
     * @param QuestionCategory $category
     * @param $url_topic a string containing the title of the topic that falls under the specified category
     * @param QuestionTopicRequest $request
     * @return \Illuminate\Http\Response
     */
	public function update(QuestionCategory $category, $url_topic, QuestionTopicRequest $request){
		$topic = QuestionTopic::where('name', '=', $url_topic)->where('question_category_id', '=', $category->id)->first();
		$name = $request->input('name');
		if($this->checkIfAvailable($category, $name)){
			$topic->update($request->all());
	        flash()->success('Topic successfully updated');
	        return redirect('/categories/' . $category->name);
		} else {
			return redirect('/categories/' . $category->name . '/topics/' . $topic->name . '/edit')->withErrors(['name' => 'Topic name already exists for this category.']);
		}
	}

	/**
     * Show the form in deleting a topic
     *
     * @param QuestionCategory $category
     * @param $url_topic a string containing the title of the topic that falls under the specified category
     * @return \Illuminate\Http\Response
     */
	public function showDeleteConfirmation(QuestionCategory $category, $url_topic){
		$topic = QuestionTopic::where('name', '=', $url_topic)->where('question_category_id', '=', $category->id)->first();
		return view('questions.topics.delete', compact('category', 'topic'));
	}

	/**
     * Delete the topic in the database
     *
     * @param QuestionCategory $category
     * @param $url_topic a string containing the title of the topic that falls under the specified category
     * @return \Illuminate\Http\Response
     */
	public function delete(QuestionCategory $category, $url_topic){
		$topic = QuestionTopic::where('name', '=', $url_topic)->where('question_category_id', '=', $category->id)->first();

    	foreach ($topic->questionSubtopics as $subtopic){
	        foreach ($subtopic->questions as $question){
	        	$question->move($category->name, 'Default Topic', 'Default Subtopic');
	        }
    	}
		$topic->delete();
        return redirect('/categories/' . $category->name);
	}

	/**
     * Check if the submitted topic name is available for the given category
     *
     * @param $category the id of the specified category
     * @param $name a string containing the title of the topic that falls under the specified category
     * @return boolean
     */
	private function checkIfAvailable($category, $name){
		$result = QuestionTopic::where('name', '=', $name)->where('question_category_id', '=', $category->id)->first();
		if(empty($result)){
			return true;
		} else {
			return false;
		}
	}
}

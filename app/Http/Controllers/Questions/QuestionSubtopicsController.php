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
    /**
     * Show the contents of a given subtopic
     *
     * @param QuestionCategory $category
     * @param $url_topic a string containing the title of the topic that falls under the specified category
     * @param $url_subtopic a string containing the title of the subtopic that falls under the specified topic
     * @return \Illuminate\Http\Response
     */
    public function show(QuestionCategory $category, $url_topic, $url_subtopic){
    	$topic = QuestionTopic::where('name', '=', $url_topic)->where('question_category_id', '=', $category->id)->first();
        $subtopic = QuestionSubtopic::where('name', '=', $url_subtopic)->where('question_topic_id', '=', $topic->id)->first();
		return view('questions.subtopics.show', compact('category', 'topic', 'subtopic'));
	}

    /**
     * Show the form in creating a subtopic
     *
     * @param QuestionCategory $category
     * @param $url_topic a string containing the title of the topic that falls under the specified category
     * @return \Illuminate\Http\Response
     */
    public function create(QuestionCategory $category, $url_topic){
    	$topic = QuestionTopic::where('name', '=', $url_topic)->where('question_category_id', '=', $category->id)->first();
    	return view('questions.subtopics.create', compact('category', 'topic'));
    }

	/**
     * Store the subtopic in the database
     *
     * @param QuestionCategory $category
     * @param $url_topic a string containing the title of the topic that falls under the specified category
     * @param QuestionSubtopicRequest $request
     * @return \Illuminate\Http\Response
     */
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

	/**
     * Show the form in editing a subtopic
     *
     * @param QuestionCategory $category
     * @param $url_topic a string containing the title of the topic that falls under the specified category
     * @param $url_subtopic a string containing the title of the subtopic that falls under the specified topic
     * @return \Illuminate\Http\Response
     */
	public function edit(QuestionCategory $category, $url_topic, $url_subtopic){
		$topic = QuestionTopic::where('name', '=', $url_topic)->where('question_category_id', '=', $category->id)->first();
        $subtopic = QuestionSubtopic::where('name', '=', $url_subtopic)->where('question_topic_id', '=', $topic->id)->first();
		return view('questions.subtopics.edit', compact('category', 'topic', 'subtopic'));
	}

	/**
     * Update the subtopic in the database
     *
     * @param QuestionCategory $category
     * @param $url_topic a string containing the title of the topic that falls under the specified category
     * @param $url_subtopic a string containing the title of the subtopic that falls under the specified topic
     * @return \Illuminate\Http\Response
     */
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

	/**
     * Show the form in deleting a subtopic
     *
     * @param QuestionCategory $category
     * @param $url_topic a string containing the title of the topic that falls under the specified category
     * @param $url_subtopic a string containing the title of the subtopic that falls under the specified topic
     * @return \Illuminate\Http\Response
     */
	public function showDeleteConfirmation(QuestionCategory $category, $url_topic, $url_subtopic){
		$topic = QuestionTopic::where('name', '=', $url_topic)->where('question_category_id', '=', $category->id)->first();
        $subtopic = QuestionSubtopic::where('name', '=', $url_subtopic)->where('question_topic_id', '=', $topic->id)->first();

		return view('questions.subtopics.delete', compact('category', 'topic', 'subtopic'));
	}

	/**
     * Delete the subtopic in the database
     *
     * @param QuestionCategory $category
     * @param $url_topic a string containing the title of the topic that falls under the specified category
     * @param $url_subtopic a string containing the title of the subtopic that falls under the specified topic
     * @return \Illuminate\Http\Response
     */
	public function delete(QuestionCategory $category, $url_topic, $url_subtopic){
		$topic = QuestionTopic::where('name', '=', $url_topic)->where('question_category_id', '=', $category->id)->first();
        $subtopic = QuestionSubtopic::where('name', '=', $url_subtopic)->where('question_topic_id', '=', $topic->id)->first();

        foreach ($subtopic->questions as $question){
        	$question->move($category->name, $topic->name, 'Default Subtopic');
        }
		$subtopic->delete();
        return redirect('/categories/' . $category->name . '/topics/' . $topic->name);
	}

	/**
     * Check if the submitted subtopic name is available for the given topic
     *
     * @param $topic the id of the specified topic
     * @param $name a string containing the title of the subtopic that falls under the specified topic
     * @return boolean
     */
	private function checkIfAvailable($topic, $name){
		$result = QuestionSubtopic::where('name', '=', $name)->where('question_topic_id', '=', $topic->id)->first();
		if(empty($result)){
			return true;
		} else {
			return false;
		}
	}
}

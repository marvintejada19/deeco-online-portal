<?php

namespace App\Http\Controllers\Questions;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\Questions\QuestionCategoryRequest;
use App\Models\Questions\QuestionCategory;
use URL;

class QuestionCategoriesController extends Controller
{
    /**
     * Show list of all categories
     *
     * @param $url nullable string
     * @return \Illuminate\Http\Response
     */
    public function index($url = '/home'){
    	if(session()->has('url')){
			$url = session()->get('url');
            session()->put('url', $url); 
        }
    	$categories = QuestionCategory::orderBy('name', 'asc')->get();
    	return view('questions.categories.index', compact('categories', 'url'));
    }

    /**
     * Show the contents of a given category
     *
     * @param QuestionCategory $category
     * @return \Illuminate\Http\Response
     */
	public function show(QuestionCategory $category){
		$topics = $category->questionTopics()->get();
		return view('questions.categories.show', compact('category', 'topics'));
	}

    /**
     * Show the form in creating a category
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
    	return view('questions.categories.create');
    }

	/**
     * Store the category in the database
     *
     * @param QuestionCategoryRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuestionCategoryRequest $request){
        $category = QuestionCategory::create($request->all());
        $topic = $category->questionTopics()->create(['name' => 'Default Topic']);
        $topic->questionSubtopics()->create(['name' => 'Default Subtopic']);
        flash()->success('New category has been added.');
        return redirect('/categories');
	}

	/**
     * Show the form in editing a category
     *
     * @param QuestionCategory $category
     * @return \Illuminate\Http\Response
     */
    public function edit(QuestionCategory $category){
		return view('questions.categories.edit', compact('category'));
	}

	/**
     * Update the category in the database
     *
     * @param QuestionCategory $category
     * @param QuestionCategoryRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(QuestionCategory $category, QuestionCategoryRequest $request){
		$category->update($request->all());
        flash()->success('Category successfully updated');
        return redirect('/categories');
	}

	/**
     * Show the form in deleting a catgeory
     *
     * @param QuestionCategory $category
     * @return \Illuminate\Http\Response
     */
    public function showDeleteConfirmation(QuestionCategory $category){
		return view('questions.categories.delete', compact('category'));
	}

	/**
     * Delete the category in the database
     *
     * @param QuestionCategory $category
     * @return \Illuminate\Http\Response
     */
    public function delete(QuestionCategory $category){
		foreach ($category->questionTopics as $topic){
			foreach ($topic->questionSubtopics as $subtopic){
		        foreach ($subtopic->questions as $question){
		        	$question->move('Default Category', 'Default Topic', 'Default Subtopic');
		        }
			}
    	}
		$category->delete();
        return redirect('/categories');
	}

	/**
     * Determine the url for redirecting back
     *
     * @param $url string containing a subject id
     * @return \Illuminate\Http\Response
     */
	public function indexFrom($url){
		$url = '/subjects/' . $url . '/examinations';
 		session()->put('url', $url);
 		return redirect('/categories');
	}
}

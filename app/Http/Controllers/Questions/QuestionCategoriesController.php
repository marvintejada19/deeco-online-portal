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
    public function __construct(){
    }

    public function index($url = '/home'){
    	if(session()->has('url')){
			$url = session()->get('url');
            session()->put('url', $url); 
        }

    	$categories = QuestionCategory::orderBy('name', 'asc')->get();
    	return view('questions.categories.index', compact('categories', 'url'));
    }

	public function show(QuestionCategory $category){
		$topics = $category->questionTopics()->get();
		return view('questions.categories.show', compact('category', 'topics'));
	}

    public function create(){
    	return view('questions.categories.create');
    }

	public function store(QuestionCategoryRequest $request){
        $category = QuestionCategory::create($request->all());
        $topic = $category->questionTopics()->create(['name' => 'Default Topic']);
        $topic->questionSubtopics()->create(['name' => 'Default Subtopic']);
        flash()->success('New category has been added.');
        return redirect('/categories');
	}

	public function edit(QuestionCategory $category){
		return view('questions.categories.edit', compact('category'));
	}

	public function update(QuestionCategory $category, QuestionCategoryRequest $request){
		$category->update($request->all());
        flash()->success('Category successfully updated');
        return redirect('/categories');
	}

	public function showDeleteConfirmation(QuestionCategory $category){
		return view('questions.categories.delete', compact('category'));
	}

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

	public function indexFrom($url){
		$url = '/subjects/' . $url . '/examinations';
        session()->put('url', $url);
        return redirect('/categories');
	}
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubjectPostRequest;
use App\Models\Subject;

class SubjectPostsController extends Controller
{
	public function __construct(){
    }

    public function show(SubjectPost $subjectPost, Request $request){
        return view('subjects.posts.show', compact('subjectPost'));
    }

    public function create(){
        return view('subjects.posts.create');
    }

    public function store(Subject $subjects, SubjectPostRequest $request){
        $subjects->subjectPosts()->create($request->all());
        flash()->success('Post has been saved. It will be published at the specified date.');
        return redirect('/subject/' . $subjects->id);
    }

    public function edit(SubjectPost $subjectPost){
        return view('subjects.posts.edit', compact('subjectPost'));
    }

    //SUBJECTPOSTREQUEST NOT YET FINISHED
    public function update(SubjectPost $subjectPost, SubjectPostRequest $request){
        $article->update($request->all());
        flash()->success('Article successfully updated');
        return redirect('articles/list');
    }
}

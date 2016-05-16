<?php

namespace App\Http\Controllers\Subjects;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Services\SubjectArticlesService;
use App\Models\Subjects\Subject;

class SubjectsController extends Controller
{
    private $subjectArticlesService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(SubjectArticlesService $subjectArticlesService){
        $this->subjectArticlesService = $subjectArticlesService;
    }

    /**
     * Show the contents of the given class
     *
     * @param Subject $subject
     * @return \Illuminate\Http\Response
     */
    public function show(Subject $subject){
        $articles = $this->subjectArticlesService->sortArticles($subject);
        $types = session()->pull('types');
        $is_teacher = true;
        return view('subjects.content.show', compact('subject', 'articles', 'types', 'is_teacher'));
    }

    /**
     * Show the details of the given class
     *
     * @param Subject $subject
     * @return \Illuminate\Http\Response
     */
    public function showDetails(Subject $subject){
        return view('subjects.content.details', compact('subject'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Services\SubjectArticlesService;
use App\Models\Subjects\Subject;

class ClassesController extends Controller
{
    private $subjectArticlesService;

    public function __construct(SubjectArticlesService $subjectArticlesService){
        $this->subjectArticlesService = $subjectArticlesService;
        $this->middleware('classEnrolled');
    }

    public function show(Subject $subject){
    	$articles = $this->subjectArticlesService->sortArticles($subject);
        $types = session()->pull('types');
        $is_teacher = false;
        return view('classes.content.show', compact('subject', 'articles', 'types', 'is_teacher'));
    }
}

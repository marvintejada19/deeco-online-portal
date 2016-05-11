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

    public function __construct(SubjectArticlesService $subjectArticlesService){
        $this->subjectArticlesService = $subjectArticlesService;
    }

    public function show(Subject $subject){
        $articles = $this->subjectArticlesService->sortArticles($subject);
        $types = session()->pull('types');
        $is_teacher = true;
        return view('subjects.content.show', compact('subject', 'articles', 'types', 'is_teacher'));
    }

    public function showDetails(Subject $subject){
        return view('subjects.content.details', compact('subject'));
    }
}

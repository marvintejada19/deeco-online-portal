<?php

namespace App\Http\Controllers\Subjects;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Subjects\Subject;
use App\Models\Subjects\SubjectExamination;

class SubjectExaminationsController extends Controller
{
    public function __construct(){
    }

    public function index(Subject $subject){
    	return view('subjects.examinations.index', compact('subject'));
    }

    public function show(Subject $subject, SubjectExamination $examination){
        return view('subjects.examinations.show', compact('subject', 'examination'));
    }

    public function create(Subject $subject){
        return view('subjects.examinations.create', compact('subject'));
    }

    public function store(Subject $subject, Request $request){
        $examRequest = $request->all();
        $examRequest['is_published'] = false;

    	$examination = $subject->subjectExaminations()->create($examRequest);

        return redirect('/subjects/' . $subject->id . '/examinations/' . $examination->id);
    }

    public function edit(Subject $subject, SubjectExamination $examination){
        //if unpublished
        return view('subjects.examinations.edit');
    }
}

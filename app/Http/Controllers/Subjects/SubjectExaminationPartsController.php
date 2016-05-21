<?php

namespace App\Http\Controllers\Subjects;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Questions\Question;
use App\Models\Subjects\Subject;
use App\Models\Subjects\SubjectExamination;
use App\Models\Subjects\SubjectExaminationPart;
use DB;

class SubjectExaminationPartsController extends Controller
{
    public function index(Subject $subject, SubjectExamination $examination){
    	return view('subjects.examinations.parts.content.index', compact('subject', 'examination'));
    }

    public function show(Subject $subject, SubjectExamination $examination, SubjectExaminationPart $part){
        if (!strcmp($part->getQuestionType(), 'Select from the Wordbox') || 
            !strcmp($part->getQuestionType(), 'Match Column A with Column B')){
            if ($part->items->first() == null){
                $question = null;
            } else {
                $question = Question::find($part->items()->first()->question_id);
            }
            return view('subjects.examinations.parts.content.show-one', compact('subject', 'examination', 'part', 'question'));
        } else {
            return view('subjects.examinations.parts.content.show', compact('subject', 'examination', 'part'));
        }
    }

    public function create(Subject $subject, SubjectExamination $examination){
    	$types = DB::table('question_types')->lists('name', 'id');
    	return view('subjects.examinations.parts.content.create', compact('subject', 'examination', 'types'));
    }

    public function store(Subject $subject, SubjectExamination $examination, Request $request){
    	// if ($request->input('quantity') < 1){
     //        return redirect('/subjects/' . $subject->id . '/examinations/' . $examination->id . '/parts/create')
     //                        ->withInput($request->all())->withErrors(['quantity' => 'Value must be at least 1.']);
     //    }
        $examination->parts()->create($request->all());
    	return redirect('/subjects/' . $subject->id . '/examinations/' . $examination->id . '/parts');
    }

    public function edit(Subject $subject, SubjectExamination $examination, SubjectExaminationPart $part){
    	$types = DB::table('question_types')->lists('name', 'id');
    	return view('subjects.examinations.parts.content.edit', compact('subject', 'examination', 'part', 'types'));
    }

    public function update(Subject $subject, SubjectExamination $examination, SubjectExaminationPart $part, Request $request){
    	// $questionType = DB::table('question_types')->where('id', $question_type_id)->first()->name;
     //    if (!strcmp($questionType, 'Select from the Wordbox') || 
     //        !strcmp($questionType, 'Match Column A with Column B')){
     //        foreach ($part->items as $item){
     //            $item->delete();
     //        }
     //    }
        $part->update($request->all());
    	return redirect('/subjects/' . $subject->id . '/examinations/' . $examination->id . '/parts');
    }

    public function showDeleteConfirmation(Subject $subject, SubjectExamination $examination, SubjectExaminationPart $part){
        return view('');
    }

    public function delete(){
        return redirect('');
    }
}

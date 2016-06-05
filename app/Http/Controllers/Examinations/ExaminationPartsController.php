<?php

namespace App\Http\Controllers\Examinations;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Questions\Question;
use App\Models\Examinations\Examination;
use App\Models\Examinations\ExaminationPart;
use DB;

class ExaminationPartsController extends Controller
{
    public function index(Examination $examination){
    	return view('grade-section-subjects.examinations.parts.content.index', compact('examination'));
    }

    public function show(Examination $examination, ExaminationPart $part){
        if (!strcmp($part->getQuestionType(), 'Select from the Wordbox') || 
            !strcmp($part->getQuestionType(), 'Match Column A with Column B')){
            if ($part->items->first() == null){
                $question = null;
            } else {
                $question = Question::find($part->items()->first()->question_id);
            }
            return view('grade-section-subjects.examinations.parts.content.show-one', compact('subject', 'examination', 'part', 'question'));
        } else {
            return view('grade-section-subjects.examinations.parts.content.show', compact('subject', 'examination', 'part'));
        }
    }

    public function create(Examination $examination){
    	$types = DB::table('question_types')->lists('name', 'id');
    	return view('grade-section-subjects.examinations.parts.content.create', compact('subject', 'examination', 'types'));
    }

    public function store(Examination $examination, Request $request){
        $part = $examination->parts()->create($request->all());
        $examination->total_points = $examination->computeTotalPoints();
        $examination->update();
        return redirect('/examinations/' . $examination->id . '/parts/' . $part->id);
    }

    public function edit(Examination $examination, ExaminationPart $part){
    	$types = DB::table('question_types')->lists('name', 'id');
    	return view('grade-section-subjects.examinations.parts.content.edit', compact('subject', 'examination', 'part', 'types'));
    }

    public function update(Examination $examination, ExaminationPart $part, Request $request){
        if ($part->question_type_id != $request->input('question_type_id')){
            foreach ($part->items as $item){
                $item->delete();
            }
        }
        $part->update($request->all());
        $examination->total_points = $examination->computeTotalPoints();
        $examination->update();
        return redirect('/examinations/' . $examination->id . '/parts');
    }

    public function showDeleteConfirmation(Examination $examination, ExaminationPart $part){
        return view('grade-section-subjects.examinations.parts.content.delete', compact('subject', 'examination', 'part'));
    }

    public function delete(Examination $examination, ExaminationPart $part, Request $request){
        $examination->total_points = $examination->computeTotalPoints();
        $examination->update();
        $part->delete();
        return redirect('/examinations/' . $examination->id . '/parts');
    }
}

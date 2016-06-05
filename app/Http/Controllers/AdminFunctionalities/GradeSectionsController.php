<?php

namespace App\Http\Controllers\AdminFunctionalities;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\GradeSections\GradeSection;
use App\Models\GradeSections\Subject;
use DB;

class GradeSectionsController extends Controller
{
	public function index(){
		$gradeSections = GradeSection::all();
		return view('grade-sections.index', compact('gradeSections'));
	}

    public function show(GradeSection $gradeSection){
        return view('grade-sections.show', compact('gradeSection'));
    }

    public function assignment($gradeSectionSelected = null, $subjectsAssignedInSection = []){
        $activeSchoolYear = DB::table('school_years')->where('active','1')->first();
        $subjectIdsAssignedInSection = [];
        foreach ($subjectsAssignedInSection as $subject){
            $subjectIdsAssignedInSection[] = $subject->id;
        }
        $subjects = Subject::get();
        $gradeSections = GradeSection::where('school_year_id', $activeSchoolYear->id)->get();
        return view('grade-sections.subjects.assignment', compact('subjects', 'gradeSections', 'gradeSectionSelected', 'subjectIdsAssignedInSection', 'subjectsAssignedInSection'));
    }

    public function postSearch(Request $request){
        $gradeSection = GradeSection::find($request->input('gradeSectionId'));
        $subjects = $gradeSection->subjects;
        return $this->assignment($gradeSection, $subjects);
    }

    public function assign(Request $request){
        $gradeSection = GradeSection::find($request->input('assignSection'));
        $selectedIds = explode(',', $request->input('assignList'));
        $gradeSection->subjects()->sync($selectedIds);
        return redirect('/grade-sections/' . $gradeSection->id);
    }
}

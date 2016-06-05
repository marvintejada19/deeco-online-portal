<?php

namespace App\Http\Controllers\AdminFunctionalities;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\User;
use App\Models\GradeSections\FacultyLoading;
use App\Models\GradeSections\Subject;
use App\Models\GradeSectionSubjects\GradeSectionSubject;
use DB;

class FacultyLoadingsController extends Controller
{
    public function index(){
    	$facultyList = User::where('role_id', '3')->where('active', '1')->get();
        return view('grade-sections.faculty-loadings.index', compact('facultyList'));
    }

    public function show(User $user){
        $activeSchoolYear = DB::table('school_years')->where('active','1')->first();
        $facultyLoadings = FacultyLoading::where('user_id', $user->id)->where('school_year_id', $activeSchoolYear->id)->get(); 
        return view('grade-sections.faculty-loadings.show', compact('user', 'facultyLoadings'));
    }

    public function assignment($facultySelected = null, $gradeSectionSubjectsAssignedToFaculty = []){
        $activeSchoolYear = DB::table('school_years')->where('active','1')->first();
        $gradeSectionSubjectList = GradeSectionSubject::orderBy('subject_id')->get();
        $gradeSectionSubjects = [];
        foreach ($gradeSectionSubjectList as $gradeSectionSubject){
            $facultyLoading = FacultyLoading::where('grade_section_subject_id', $gradeSectionSubject->id)->where('school_year_id', $activeSchoolYear->id)->first();
            if ($facultyLoading == null){
                $gradeSectionSubjects[] = $gradeSectionSubject;
            }
        }
        $facultyList = User::where('role_id', '3')->where('active', '1')->get();
        return view('grade-sections.faculty-loadings.assignment', compact('gradeSectionSubjects', 'facultyList', 'facultySelected', 'gradeSectionSubjectsAssignedToFaculty'));
    }

    public function postSearch(Request $request){
        $activeSchoolYear = DB::table('school_years')->where('active','1')->first();
        $faculty = User::find($request->input('facultyId'));
        $gradeSectionSubjectIds = FacultyLoading::where('user_id', $faculty->id)->where('school_year_id', $activeSchoolYear->id)->pluck('grade_section_subject_id');
        $gradeSectionSubjects = [];
        foreach ($gradeSectionSubjectIds as $id){
        	$gradeSectionSubjects[] = GradeSectionSubject::find($id);
        }
        return $this->assignment($faculty, $gradeSectionSubjects);
    }

    public function assign(Request $request){
        $activeSchoolYear = DB::table('school_years')->where('active','1')->first();
        $faculty = User::find($request->input('assignFaculty'));
        $selectedIds = explode(',', $request->input('assignList'));
        if ($selectedIds[0] == ""){
            $faculty->gradeSectionSubjects()->detach();
        } else {
            $faculty->gradeSectionSubjects()->sync($selectedIds);
        }
        $facultyLoadings = FacultyLoading::whereIn('grade_section_subject_id', $selectedIds)->where('user_id', $faculty->id)->get();
        if (!$facultyLoadings->isEmpty()){
            foreach ($facultyLoadings as $facultyLoading){
            	$facultyLoading->school_year_id = $activeSchoolYear->id;
            	$facultyLoading->update();
            }
        }
        return redirect('faculty-loadings/' . $faculty->id);
    }
}

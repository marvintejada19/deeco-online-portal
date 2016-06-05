<?php

namespace App\Http\Controllers\AdminFunctionalities;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\GradeSections\SchoolYear;
use App\Models\GradeSections\GradeSection;
use DB;

class SchoolYearsController extends Controller
{
    public function create(){
    	return view('grade-sections.school-years.create');
    }

    public function store(Request $request){
        $activeSchoolYear = DB::table('school_years')->where('active', '1')->first();
        $activeSchoolYear->active = 0;
        $activeSchoolYear->update();
    	$schoolYear = SchoolYear::create([
    		'name' => $request->input('name'),
    		'active' => '1'
    	]);
    	$gradeSectionNames = DB::table('grade_section_names')->get();
    	foreach ($gradeSectionNames as $gradeSectionName){
    		GradeSection::create([
    			'grade_section_name_id' => $gradeSectionName->id,
    			'school_year_id' => $schoolYear->id,
    		]);
    	}
    	return redirect('/home');
    }
}

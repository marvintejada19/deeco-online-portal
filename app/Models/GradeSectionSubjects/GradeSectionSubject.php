<?php

namespace App\Models\GradeSectionSubjects;

use Illuminate\Database\Eloquent\Model;
use App\Models\GradeSections\FacultyLoading;
use DB;

class GradeSectionSubject extends Model
{
    protected $table = 'grade_section_subjects';
    public $timestamps = false;

    public function faculty(){
        $activeSchoolYear = DB::table('school_years')->where('active','1')->first();
    	return $this->belongsToMany('App\Models\User', 'faculty_loadings')->where('school_year_id', $activeSchoolYear->id);
    }

    public function gradeSection(){
    	return $this->belongsTo('App\Models\GradeSections\GradeSection');
    }

    public function subject(){
        return $this->belongsTo('App\Models\GradeSections\Subject');
    }

    public function deployments(){
        return $this->hasMany('App\Models\Examinations\Deployment');
    }
}

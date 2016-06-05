<?php

namespace App\Models\GradeSections;

use Illuminate\Database\Eloquent\Model;
use App\Models\GradeSectionSubjects\GradeSectionSubject;
use DB;

class GradeSection extends Model
{
    protected $fillable = [
    	'grade_section_name_id',
    	'school_year_id'
    ];

    protected $table = 'grade_sections';
    public $timestamps = false;

    public function getName(){
        return $this->belongsTo('App\Models\GradeSections\GradeSectionName', 'grade_section_name_id');
    }

    public function students(){
    	return $this->belongsToMany('App\Models\User', 'enrollments', 'grade_section_id', 'user_id');
    }

    public function subjects(){
        return $this->belongsToMany('App\Models\GradeSections\Subject', 'grade_section_subjects');
    }

    public function schoolYear(){
        return $this->belongsTo('App\Models\GradeSections\SchoolYear');
    }

    public function getGradeSectionSubject($subject){
        return GradeSectionSubject::where('subject_id', $subject->id)->where('grade_section_id', $this->id)->first();
    }
}

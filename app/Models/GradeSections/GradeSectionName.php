<?php

namespace App\Models\GradeSections;

use Illuminate\Database\Eloquent\Model;
use DB;

class GradeSectionName extends Model
{
	protected $table = 'grade_section_names';
	public $timestamps = false;

    public function getGradeLevel(){
    	return DB::table('grade_levels')->find($this->grade_level_id)->name;
    }

    public function gradeSection(){
    	return $this->hasMany('App\Models\GradeSections\GradeSection');
    }
}

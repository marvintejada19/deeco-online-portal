<?php

namespace App\Models\GradeSections;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = ['name'];
    public $timestamps = false;

    public function gradeSections(){
    	return $this->belongsToMany('App\Models\GradeSections\GradeSection', 'grade_section_subjects');
    }
}

<?php

namespace App\Models\GradeSections;

use Illuminate\Database\Eloquent\Model;

class FacultyLoading extends Model
{
    protected $fillable = [
    	'subject_id',
    	'user_id',
    	'school_year_id'
    ];

    protected $table = 'faculty_loadings';
    public $timestamps = false;

    public function faculty(){
    	return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function gradeSectionSubject(){
        return $this->belongsTo('App\Models\GradeSectionSubjects\GradeSectionSubject');
    }

    public function schoolYear(){
        return $this->belongsTo('App\Models\GradeSections\SchoolYear');
    }
}

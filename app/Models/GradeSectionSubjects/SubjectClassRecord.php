<?php

namespace App\Models\GradeSectionSubjects;

use Illuminate\Database\Eloquent\Model;

class SubjectClassRecord extends Model
{
	protected $fillable = [
		'grade_section_subject_id',
		'deployment_id',
        'quarter',
	];

	protected $table = "subject_class_records";
	public $timestamps = false;
    
    public function gradeSectionSubject(){
    	return $this->belongsTo('App\Models\GradeSectionSubjects\GradeSectionSubject');
    }

    public function deployment(){
    	return $this->belongsTo('App\Models\Examinations\Deployment');
    }

    public function instances(){
    	return $this->hasMany('App\Models\GradeSectionSubjects\SubjectClassRecordInstance', 'subject_class_record_id');
    }
}

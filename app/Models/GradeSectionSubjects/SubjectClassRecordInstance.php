<?php

namespace App\Models\GradeSectionSubjects;

use Illuminate\Database\Eloquent\Model;

class SubjectClassRecordInstance extends Model
{
	protected $fillable = [
		'subject_class_record_id',
		'user_id',
		'score',
	];

    protected $table = "subject_class_record_instances";
    public $timestamps = false;

    public function classRecord(){
    	return $this->belongsTo('App\Models\Subjects\SubjectClassRecord', 'subject_class_record_id');
    }
}

<?php

namespace App\Models\GradeSectionSubjects;

use Illuminate\Database\Eloquent\Model;
use DB;

class GradeSectionSubjectRequirementInstance extends Model
{
    protected $fillable = [
		'user_id',
		'file_id',
		'submitted_at',
	];

	protected $table = 'subject_requirement_instances';
	protected $dates = ['submitted_at'];
	public $timestamps = false;

	public function subjectRequirement(){
		return $this->belongsTo('App\Models\GradeSectionSubjects\GradeSectionSubjectRequirement', 'subject_requirement_id');
	}

	public function user(){
		return $this->belongsTo('App\Models\User');
	}

	public function getFile(){
		return DB::table('files')->where('id', $this->file_id)->first();
	}
}

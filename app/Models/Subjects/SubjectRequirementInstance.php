<?php

namespace App\Models\Subjects;

use Illuminate\Database\Eloquent\Model;
use DB;

class SubjectRequirementInstance extends Model
{
    protected $fillable = [
		'user_id',
		'file_id',
		'submitted_at',
	];

	protected $dates = ['submitted_at'];
	public $timestamps = false;

	public function subjectRequirement(){
		return $this->belongsTo('App\Models\Subjects\SubjectRequirement');
	}

	public function user(){
		return $this->belongsTo('App\Models\User');
	}

	public function getFile(){
		return DB::table('files')->where('id', $this->file_id)->first();
	}
}

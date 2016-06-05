<?php

namespace App\Models\PostsAndRequirements;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Requirement extends Model
{
    use SoftDeletes;
	
	protected $fillable = [
		'user_id',
		'title',
		'body',
	];

	public function gradeSectionSubjects(){
		return $this->belongsToMany('App\Models\GradeSectionSubjects\GradeSectionSubject', 'subject_posts');
	}

	public function faculty(){
		return $this->belongsTo('App\Models\User', 'user_id');
	}

	public function files(){
		return $this->belongsToMany('App\Models\File', 'requirement_files');
	}

	// public function instances(){
	// 	return $this->hasMany('App\Models\Subjects\SubjectRequirementInstance');	
	// }
}

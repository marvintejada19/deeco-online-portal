<?php

namespace App\Models\Subjects;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
	protected $fillable = [
		'user_id',
		'section_id',
		'sy',
		'subject_title',
	];

	public $timestamps = false;
	
	public function section(){
		return $this->belongsTo('App\Models\Subjects\Section');
	}

    public function faculty(){
		return $this->belongsTo('App\Models\User', 'user_id');
	}

	public function students(){
		return $this->belongsToMany('App\Models\User', 'subject_class_enrollments')->orderBy('username', 'asc');
	}

	public function subjectPosts(){
		return $this->hasMany('App\Models\Subjects\SubjectPost')->orderBy('published_at', 'desc');
	}

	public function subjectRequirements(){
		return $this->hasMany('App\Models\Subjects\SubjectRequirement')->orderBy('published_at', 'desc');
	}

	public function subjectExaminations(){
		return $this->hasMany('App\Models\Subjects\SubjectExamination')->orderBy('published_at', 'desc');
	}
}

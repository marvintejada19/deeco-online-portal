<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use DB;

class Subject extends Model
{
	public function getSection(){
		return DB::table('sections')->where('id', $this->section_id)->first();
	}

    public function faculty(){
		return $this->belongsTo('App\Models\User');
	}

	public function students(){
		return $this->belongsToMany('App\Models\User', 'subject_class_enrollments');
	}

	public function subjectPosts(){
		return $this->hasMany('App\Models\SubjectPost');
	}
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
	protected $fillable = [
		'destination_path',
		'file_name',
	];

    public function subjectPosts(){
		return $this->belongsToMany('App\Models\Subjects\SubjectPost', 'subject_post_files');
	}

	public function subjectRequirements(){
		return $this->belongsToMany('App\Models\Subjects\SubjectRequirement', 'subject_requirement_files');
	}

	public function user(){
		return $this->belongsTo('App\Models\User');
	}

	public function downloadHistory(){
		return $this->hasMany('App\Models\FileDownloadHistory');
	}
}

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
		return $this->belongsTo('App\Models\Subjects\SubjectPost');
	}

	public function subjectRequirements(){
		return $this->belongsTo('App\Models\Subjects\SubjectRequirement');
	}

	public function user(){
		return $this->belongsTo('App\Models\User');
	}
}

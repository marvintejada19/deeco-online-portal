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
		return $this->belongsToMany('App\Models\SubjectPost', 'subject_post_files');
	}

	public function user(){
		return $this->belongsTo('App\Models\User');
	}
}
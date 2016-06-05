<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
	protected $fillable = [
		'destination_path',
		'file_name',
	];

    public function posts(){
		return $this->belongsToMany('App\Models\PostsAndRequirements\Post', 'post_files');
	}

	public function requirements(){
		return $this->belongsToMany('App\Models\PostsAndRequirements\Requirement', 'requirement_files');
	}

	public function user(){
		return $this->belongsTo('App\Models\User');
	}

	public function downloadHistory(){
		return $this->hasMany('App\Models\FileDownloadHistory');
	}
}

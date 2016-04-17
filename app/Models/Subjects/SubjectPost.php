<?php

namespace App\Models\Subjects;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class SubjectPost extends Model
{
	use SoftDeletes;
	
	protected $fillable = [
		'title',
		'body',
		'published_at',
	];

	protected $dates = ['published_at'];

	public function scopePublished($query){
		$query->where('published_at', '<=', Carbon::now());
	}

	public function scopeUnpublished($query){
		$query->where('published_at', '>', Carbon::now());
	}

	public function getPublishedAtAttribute($date){
		return Carbon::parse($date)->format('Y-m-d\\TH:i');
	}

	public function setPublishedAtAttribute($date){
		$this->attributes['published_at'] = Carbon::parse($date);
	}
	
    public function subject(){
		return $this->belongsTo('App\Models\Subject');
	}

	public function files(){
		return $this->belongsToMany('App\Models\File', 'subject_post_files');
	}
}

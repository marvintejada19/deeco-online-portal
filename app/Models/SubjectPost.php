<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class SubjectPost extends Model
{
	protected $fillable = [
		'title',
		'body',
		'published_at',
		'is_deleted',
	];

	protected $dates = ['published_at'];

	public function scopePublished($query){
		$query->where('published_at', '<=', Carbon::now());
	}

	public function scopeUnpublished($query){
		$query->where('published_at', '>', Carbon::now());
	}

	public function getPublishedAtAttribute($date){
		return Carbon::parse($date)->format('Y-m-d');
	}

	public function setPublishedAtAttribute($date){
		$this->attributes['published_at'] = Carbon::parse($date);
	}
	
    public function subject(){
		return $this->belongsTo('App\Models\Subject');
	}
}

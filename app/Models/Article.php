<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Article extends Model
{
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
		return Carbon::parse($date)->format('Y-m-d');
	}

	public function setPublishedAtAttribute($date){
		$this->attributes['published_at'] = Carbon::parse($date);
	}

	public function user(){
		return $this->belongsTo('App\Models\User');
	}
}

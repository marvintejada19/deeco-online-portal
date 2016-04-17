<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Article extends Model
{
	use SoftDeletes;

    protected $fillable = [
		'title',
		'body',
		'published_at',
	];

	protected $dates = ['published_at'];

	public function is_unpublished(){
		$bool = ($this->published_at > Carbon::now());
		return $bool;
	}

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

	public function user(){
		return $this->belongsTo('App\Models\User');
	}
}

<?php

namespace App\Models\Subjects;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use DB;

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

	public function getPublishedAtAttribute($date){
		return Carbon::parse($date)->format('Y-m-d\\TH:i');
	}

	public function setPublishedAtAttribute($date){
		$this->attributes['published_at'] = Carbon::parse($date);
	}

	public function getUnformattedDate($attribute){
		return DB::table('subject_posts')->where('id', $this->id)->first()->$attribute;
	}
	
    public function subject(){
		return $this->belongsTo('App\Models\Subjects\Subject');
	}

	public function files(){
		return $this->belongsToMany('App\Models\File', 'subject_post_files');
	}
}

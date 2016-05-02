<?php

namespace App\Models\Subjects;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class SubjectRequirement extends Model
{
    use SoftDeletes;
	
	protected $fillable = [
		'title',
		'body',
		'published_at',
		'event_start',
		'event_end',
	];

	protected $dates = ['published_at', 'event_start', 'event_end'];

	public function getPublishedAtAttribute($date){
		return Carbon::parse($date)->format('Y-m-d\\TH:i');
	}

	public function setPublishedAtAttribute($date){
		$this->attributes['published_at'] = Carbon::parse($date);
	}

	public function getEventStartAttribute($date){
		return Carbon::parse($date)->format('Y-m-d\\TH:i');
	}

	public function setEventStartAttribute($date){
		$this->attributes['event_start'] = Carbon::parse($date);
	}

	public function getEventEndAttribute($date){
		return Carbon::parse($date)->format('Y-m-d\\TH:i');
	}

	public function setEventEndAttribute($date){
		$this->attributes['event_end'] = Carbon::parse($date);
	}

	public function subject(){
		return $this->belongsTo('App\Models\Subjects\Subject');
	}

	public function files(){
		return $this->belongsToMany('App\Models\File', 'subject_requirement_files');
	}
}

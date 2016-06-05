<?php

namespace App\Models\GradeSectionSubjects;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;

class GradeSectionSubjectRequirement extends Model
{
    protected $fillable = [
        'requirement_id',
    	'grade_section_subject_id', 
    	'publish_on',
    	'event_start',
    	'event_end'
    ];

    protected $table = 'subject_requirements';
    public $timestamps = false;

    protected $dates = ['publish_on', 'event_start', 'event_end'];

    public function scopePublished($query){
        $query->where('publish_on', '<=', Carbon::now());
    }

    public function scopeActive($query){
        $query->where('event_start', '<=', Carbon::now());
        $query->where('event_end', '>=', Carbon::now());
    }

    public function getPublishOnAttribute($date){
        return Carbon::parse($date)->format('Y-m-d\\TH:i');
    }

    public function setPublishOnAttribute($date){
        $this->attributes['publish_on'] = Carbon::parse($date);
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

    public function getUnformattedDate($attribute){
        return DB::table('subject_requirements')->find($this->id)->$attribute;
    }

    public function gradeSectionSubject(){
        return $this->belongsTo('App\Models\GradeSectionSubjects\GradeSectionSubject');
    }

    public function requirement(){
        return $this->belongsTo('App\Models\PostsAndRequirements\Requirement');
    }

    public function instances(){
        return $this->hasMany('App\Models\GradeSectionSubjects\GradeSectionSubjectRequirementInstance', 'subject_requirement_id');
    }
}

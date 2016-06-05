<?php

namespace App\Models\GradeSectionSubjects;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;

class GradeSectionSubjectPost extends Model
{
	protected $fillable = ['post_id', 'grade_section_subject_id', 'publish_on'];
    protected $table = 'subject_posts';
    public $timestamps = false;

    protected $dates = ['publish_on'];

    public function scopePublished($query){
        $query->where('publish_on', '<=', Carbon::now());
    }

    public function getPublishOnAttribute($date){
        return Carbon::parse($date)->format('Y-m-d\\TH:i');
    }

    public function setPublishOnAttribute($date){
        $this->attributes['publish_on'] = Carbon::parse($date);
    }

    public function getUnformattedDate($attribute){
        return DB::table('subject_posts')->find($this->id)->$attribute;
    }

    public function gradeSectionSubject(){
        return $this->belongsTo('App\Models\GradeSectionSubjects\GradeSectionSubject');
    }

    public function post(){
        return $this->belongsTo('App\Models\PostsAndRequirements\Post');
    }
}

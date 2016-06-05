<?php

namespace App\Models\Examinations;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;

class Deployment extends Model
{
    protected $fillable = [
    	'examination_id',
    	'grade_section_subject_id',
    	'publish_on',
    	'exam_start',
    	'exam_end'
    ];

    protected $table = 'deployments';
    public $timestamps = false;

    public function scopePublished($query){
        $query->where('publish_on', '<=', Carbon::now());
    }

    public function getPublishOnAttribute($date){
        return Carbon::parse($date)->format('Y-m-d\\TH:i');
    }

    public function setPublishOnAttribute($date){
        $this->attributes['publish_on'] = Carbon::parse($date);
    }

    public function getExamStartAttribute($date){
        return Carbon::parse($date)->format('Y-m-d\\TH:i');
    }

    public function setExamStartAttribute($date){
        $this->attributes['exam_start'] = Carbon::parse($date);
    }

    public function getExamEndAttribute($date){
        return Carbon::parse($date)->format('Y-m-d\\TH:i');
    }

    public function setExamEndAttribute($date){
        $this->attributes['exam_end'] = Carbon::parse($date);
    }

    public function getUnformattedDate($attribute){
        return DB::table('deployments')->where('id', $this->id)->first()->$attribute;
    }

    public function gradeSectionSubject(){
        return $this->belongsTo('App\Models\GradeSectionSubjects\GradeSectionSubject');
    }

    public function examination(){
    	return $this->belongsTo('App\Models\Examinations\Examination');
    }

    public function instances(){
        return $this->hasMany('App\Models\Examinations\DeploymentInstance');
    }

}

<?php

namespace App\Models\Subjects;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use DB;

class SubjectExamination extends Model
{
    use SoftDeletes;
    
	protected $fillable = [
        'title', 
        'exam_start',
        'exam_end',
        'published_at',
        'is_published',
    ];


	protected $table = 'examinations';

    protected $dates = ['published_at', 'exam_start', 'exam_end'];

    public function getPublishedAtAttribute($date){
        return Carbon::parse($date)->format('Y-m-d\\TH:i');
    }

    public function setPublishedAtAttribute($date){
        $this->attributes['published_at'] = Carbon::parse($date);
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
        return DB::table('examinations')->where('id', $this->id)->first()->$attribute;
    }

    public function subject(){
    	return $this->belongsTo('App\Models\Subjects\Subject');
    }

    public function questions(){
    	return $this->belongsToMany('App\Models\Questions\Question', 'examination_questions', 'examination_id', 'question_id');
    }

    public function instances(){
    	return $this->hasMany('App\Models\Subjects\SubjectExaminationInstance', 'examination_id');
    }
}

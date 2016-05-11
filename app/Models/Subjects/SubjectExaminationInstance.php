<?php

namespace App\Models\Subjects;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubjectExaminationInstance extends Model
{
    use SoftDeletes;

    protected $fillable = [
    	'user_id',
    	'examination_id',
    	'exam_start',
    	'exam_end',
    	'score',
    	'time_started',
    	'time_ended', 
    	'questions_order',
    	'is_finished',
    	'is_recorded',
    ];

	protected $table = 'examination_instances';

    public function examination(){
    	return $this->belongsTo('App\Models\Subjects\SubjectExamination');
    }

    public function user(){
    	return $this->belongsTo('App\Models\User');
    }
}

<?php

namespace App\Models\Examinations;

use Illuminate\Database\Eloquent\Model;
use DB;

class ExaminationPart extends Model
{
	protected $fillable = [
        'question_type_id',
        'points', 
        'questions_quantity'
    ];

    protected $table = 'examination_parts';
    public $timestamps = false;

    public function getQuestionType(){
        return DB::table('question_types')->where('id', $this->question_type_id)->first()->name;
    }

    public function getQuestionsCount(){
        $itemsQuantity = DB::table('examination_part_items')->where('examination_part_id', $this->id)->pluck('quantity');
        return array_sum($itemsQuantity);
    }

    public function examination(){
        return $this->belongsTo('App\Models\Examinations\Examination');
    }

    public function items(){
        return $this->hasMany('App\Models\Examinations\ExaminationPartItem', 'examination_part_id');
    }

    public function instances(){
        return $this->hasMany('App\Models\Examinations\DeploymentInstancePart', 'examination_part_id');
    }
}

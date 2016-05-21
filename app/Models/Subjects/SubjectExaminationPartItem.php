<?php

namespace App\Models\Subjects;

use Illuminate\Database\Eloquent\Model;

class SubjectExaminationPartItem extends Model
{
    protected $fillable = [
        'question_subtopic_id',
        'quantity', 
        'choices_quantity',
        'question_id'
    ];

    protected $table = 'examination_part_items';
    public $timestamps = false;

    public function part(){
    	return $this->belongsTo('App\Models\Subjects\SubjectExaminationPart', 'examination_part_id');
    }

    public function questionSubtopic(){
    	return $this->belongsTo('App\Models\Questions\QuestionSubtopic');
    }
}

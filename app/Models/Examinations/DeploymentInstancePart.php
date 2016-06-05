<?php

namespace App\Models\Examinations;

use Illuminate\Database\Eloquent\Model;
use DB;

class DeploymentInstancePart extends Model
{
    protected $fillable = [
    	'examination_part_id',
    	'question_order',
    ];

	protected $table = 'deployment_instance_parts';
	public $timestamps = false;

    public function instance(){
    	return $this->belongsTo('App\Models\Examinations\DeploymentInstance', 'deployment_instance_id');
    }

    public function examinationPart(){
        return $this->belongsTo('App\Models\Examinations\ExaminationPart');
    }

    public function getQuestionOrder(){
        return (explode("|", $this->question_order));
    }
}

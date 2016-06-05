<?php

namespace App\Models\Examinations;

use Illuminate\Database\Eloquent\Model;

class DeploymentAnswer extends Model
{
    protected $fillable = [
	    'deployment_instance_part_id',
	    'question_id',
    	'wordbox_item_id',
    	'columns_item_id',
    	'answer',
    ];

    protected $table = 'deployment_answers';
    public $timestamps = false;

}

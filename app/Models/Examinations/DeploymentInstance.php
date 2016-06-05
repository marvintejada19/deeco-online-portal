<?php

namespace App\Models\Examinations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class DeploymentInstance extends Model
{
    use SoftDeletes;

    protected $fillable = [
    	'user_id',
        'deployment_id',
        'score',
        'time_started',
        'time_ended',
        'is_finished',
    ];

	protected $table = 'deployment_instances';

    public function getUnformattedDate($attribute){
        return DB::table('deployment_instances')->where('id', $this->id)->first()->$attribute;
    }

    public function deployment(){
    	return $this->belongsTo('App\Models\Examinations\Deployment');
    }

    public function user(){
    	return $this->belongsTo('App\Models\User');
    }

    public function parts(){
        return $this->hasMany('App\Models\Examinations\DeploymentInstancePart', 'deployment_instance_id');
    }
}

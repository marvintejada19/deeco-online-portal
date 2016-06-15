<?php

namespace App\Models\Examinations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use DB;

class Examination extends Model
{
    use SoftDeletes;
    
	protected $fillable = [
        'user_id',
        'subcategory',
        'description',
        'total_points',
        'quarter',
    ];

	protected $table = 'examinations';

    public function faculty(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function computeTotalPoints(){
        $totalPoints = 0;
        foreach ($this->parts as $part){
            $quantity = $part->getQuestionsCount();
            $pointsPerItem = $part->points;
            $totalPoints += ($quantity * $pointsPerItem);
        }
        return $totalPoints;
    }

    public function parts(){
    	return $this->hasMany('App\Models\Examinations\ExaminationPart', 'examination_id');
    }

    public function deployments(){
    	return $this->hasMany('App\Models\Examinations\Deployment');
    }
}

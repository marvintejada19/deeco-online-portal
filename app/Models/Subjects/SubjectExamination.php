<?php

namespace App\Models\Subjects;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class SubjectExamination extends Model
{
    public function subject(){
    	return $this->belongsTo('App\Models\Subject');
    }
}

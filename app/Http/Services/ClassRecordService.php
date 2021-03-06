<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use App\Http\Requests;
use Response;
use App\Models\GradeSectionSubjects\SubjectClassRecord;
use App\Models\GradeSectionSubjects\SubjectClassRecordInstance;
use Auth;

class ClassRecordService
{
    public function storeResultsInClassRecord($gradeSectionSubject, $deployment, $instance){
    	$classRecord = SubjectClassRecord::where('grade_section_subject_id', $gradeSectionSubject->id)
                        ->where('deployment_id', $deployment->id)
    					->first();
        
    	if ($classRecord == null){
    		$classRecord = SubjectClassRecord::create([
				    			'grade_section_subject_id' => $gradeSectionSubject->id,
                                'deployment_id' => $deployment->id,
                                'quarter' => $deployment->examination->quarter,
				    		]);
    	}

    	$classRecord->instances()->create(['user_id' => Auth::user()->id,
    										'score' => $instance->score]);
    }
}

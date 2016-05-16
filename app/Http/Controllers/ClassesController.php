<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Services\SubjectArticlesService;
use App\Http\Services\FilesService;
use App\Http\Services\QuestionsService;
use App\Models\Subjects\Subject;
use App\Models\Subjects\SubjectRequirement;
use App\Models\Subjects\SubjectRequirementInstance;
use App\Models\Subjects\SubjectExamination;
use App\Models\Subjects\SubjectExaminationInstance;
use Carbon\Carbon;
use Auth;

class ClassesController extends Controller
{
    private $subjectArticlesService;
    private $filesService;
    private $questionsService; 

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(SubjectArticlesService $subjectArticlesService, FilesService $filesService, QuestionsService $questionsService){
        $this->subjectArticlesService = $subjectArticlesService;
        $this->filesService = $filesService;
        $this->questionsService = $questionsService;
    }

    /**
     * Show the contents of a given class
     *
     * @param Subject $subject
     * @return \Illuminate\Http\Response
     */
    public function show(Subject $subject){
    	$articles = $this->subjectArticlesService->sortArticles($subject);
        $types = session()->pull('types');
        $is_teacher = false;
        return view('classes.content.show', compact('subject', 'articles', 'types', 'is_teacher'));
    }

    /**
     * Show the page with details of students submission to a given requirement
     *
     * @param Subject $subject
     * @param SubjectRequirement $requirement
     * @return \Illuminate\Http\Response
     */
    public function showRequirementStatus(Subject $subject, SubjectRequirement $requirement){
        $timeNow = strtotime(Carbon::now());
        $timeStart = strtotime($requirement->event_start);
        $timeEnd = strtotime($requirement->event_end);
        if ($timeStart <= $timeNow && $timeNow <= $timeEnd){
            $status = '<font color="green">Ongoing</font>';
            $ongoing = true;
        } else {
            $status = '<font color="red">Finished</font>';
            $ongoing = false;
        }
        $instance = $requirement->instances()->where('user_id', Auth::user()->id)->first();
        $file = (($instance) ? $instance->getFile() : null);
        $is_teacher = false;
        return view('classes.requirements.instance', compact('subject', 'requirement', 'status', 'ongoing', 'instance', 'file', 'is_teacher'));
    }

    /**
     * Verifies and uploads any file uploaded to the requirement
     *
     * @param Subject $subject
     * @param SubjectRequirement $requirement
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function submitRequirement(Subject $subject, SubjectRequirement $requirement, Request $request){
        $this->validate($request, ['file' => 'required|max:16384'], ['file.required' => 'File required']);
        $destinationPath = 'documents/' . Auth::user()->username . '/' . $subject->subject_title . '/' . $requirement->id;
        $file_ids = $this->filesService->upload([$request->file('file')], $destinationPath);
        $request['file_id'] = $file_ids[0];
        $request['user_id'] = Auth::user()->id;
        $request['submitted_at'] = Carbon::now();
        
        $instance = $requirement->instances()->where('user_id', Auth::user()->id)->first();
        if ($instance){
            $instance->delete();
        }
        $requirement->instances()->create($request->all());
        flash()->success('Your submission is successfully updated.');
        return redirect('/classes/' . $subject->id . '/requirements/' . $requirement->id . '/submission');
    }
}

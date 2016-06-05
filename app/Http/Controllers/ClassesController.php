<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Services\SubjectArticlesService;
use App\Http\Services\FilesService;
use App\Http\Services\QuestionsService;
use App\Models\GradeSectionSubjects\GradeSectionSubject;
use App\Models\GradeSectionSubjects\GradeSectionSubjectRequirement;
use App\Models\GradeSectionSubjects\GradeSectionSubjectRequirementInstance;
// use App\Models\Subjects\Subject;
// use App\Models\Subjects\SubjectExamination;
// use App\Models\Subjects\SubjectExaminationInstance;
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
     * @param GradeSectionSubject $gradeSectionSubject
     * @return \Illuminate\Http\Response
     */
    public function show(GradeSectionSubject $gradeSectionSubject){
    	$articles = $this->subjectArticlesService->sortArticles($gradeSectionSubject);
        $types = session()->pull('types');
        $is_teacher = false;
        return view('classes.content.show', compact('gradeSectionSubject', 'articles', 'types', 'is_teacher'));
    }

    /**
     * Show the page with details of students submission to a given requirement
     *
     * @param GradeSectionSubject $gradeSectionSubject
     * @param GradeSectionSubjectRequirement $subjectRequirement
     * @return \Illuminate\Http\Response
     */
    public function showRequirementStatus(GradeSectionSubject $gradeSectionSubject, GradeSectionSubjectRequirement $subjectRequirement){
        $timeNow = strtotime(Carbon::now());
        $timeStart = strtotime($subjectRequirement->event_start);
        $timeEnd = strtotime($subjectRequirement->event_end);
        if ($timeStart <= $timeNow && $timeNow <= $timeEnd){
            $status = '<font color="green">Ongoing</font>';
            $ongoing = true;
        } else {
            $status = '<font color="red">Finished</font>';
            $ongoing = false;
        }
        $instance = $subjectRequirement->instances()->where('user_id', Auth::user()->id)->first();
        $file = (($instance) ? $instance->getFile() : null);
        $is_teacher = false;
        return view('classes.requirements.instance', compact('gradeSectionSubject', 'subjectRequirement', 'status', 'ongoing', 'instance', 'file', 'is_teacher'));
    }

    /**
     * Verifies and uploads any file uploaded to the requirement
     *
     * @param GradeSectionSubject $gradeSectionSubject
     * @param GradeSectionSubjectRequirement $requirement
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function submitRequirement(GradeSectionSubject $gradeSectionSubject, GradeSectionSubjectRequirement $requirement, Request $request){
        $this->validate($request, ['file' => 'required|max:16384'], ['file.required' => 'File required']);
        $destinationPath = 'documents/' . Auth::user()->username . '/' . $gradeSectionSubject->subject->name . '/' . $requirement->id;
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
        return redirect('/classes/' . $gradeSectionSubject->id . '/requirements/' . $requirement->id . '/submission');
    }
}

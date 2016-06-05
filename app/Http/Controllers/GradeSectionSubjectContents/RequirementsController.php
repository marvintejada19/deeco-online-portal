<?php

namespace App\Http\Controllers\GradeSectionSubjectContents;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\GradeSectionSubjects\RequirementRequest;
use App\Http\Services\FilesService;
use App\Models\File;
use App\Models\PostsAndRequirements\Requirement;
use App\Models\GradeSectionSubjects\GradeSectionSubject;
use App\Models\GradeSectionSubjects\GradeSectionSubjectRequirement;
use App\Models\GradeSectionSubjects\GradeSectionSubjectRequirementInstance;
use Auth;
use Carbon\Carbon;


class RequirementsController extends Controller
{
    private $filesService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(FilesService $filesService){
        $this->filesService = $filesService;
    }

    /**
     * Show list of all subject requirements
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $requirements = Requirement::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        return view('grade-section-subjects.requirements.index', compact('requirements'));
    }

    /**
     * Show the contents of the given subject requirement
     *
     * @param Requirement $requirement
     * @return \Illuminate\Http\Response
     */
    public function show(Requirement $requirement){
        $is_teacher = true;
        $attachments = GradeSectionSubjectRequirement::where('requirement_id', $requirement->id)->get();
        return view('grade-section-subjects.requirements.show', compact('requirement', 'attachments', 'is_teacher'));
    }

    /**
     * Show the form in creating a subject requirement
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $timeNow = Carbon::parse(Carbon::now())->format('Y-m-d\\TH:i');
        $timeEnd = Carbon::parse(Carbon::now())->addDays(1)->format('Y-m-d\\TH:i');
        $gradeSectionSubjectsList = Auth::user()->gradeSectionSubjects;
        $gradeSectionSubjects = [];
        $gradeSectionSubjects[0] = "--Disable--";
        foreach ($gradeSectionSubjectsList as $gradeSectionSubject){
            $gradeSectionSubjects[$gradeSectionSubject->id] = $gradeSectionSubject->subject->name . ' (' . $gradeSectionSubject->gradeSection->getName->name . ')';
        }
        return view('grade-section-subjects.requirements.create', compact('gradeSectionSubjects', 'timeNow', 'timeEnd'));
    }

    /**
     * Store the subject requirement in the database
     *
     * @param RequirementRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(RequirementRequest $request){
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        $requirement = Requirement::create($data);

        $destinationPath = 'documents/' . Auth::user()->username . '/requirements/' . $requirement->id;
        $files = $request->file('files');
        $file_ids = $this->uploadFiles($files, $destinationPath);
        $requirement->files()->sync($file_ids);  

        flash()->success('Requirement has been created and attached. It will be published on the specified date.');
        return redirect('/requirements/' . $requirement->id);
    }

    /**
     * Show the form in editing a subject requirement
     *
     * @param Requirement $requirement
     * @return \Illuminate\Http\Response
     */
    public function edit(Requirement $requirement){
        return view('grade-section-subjects.requirements.edit', compact('requirement'));
    }

    /**
     * Update the subject requirement in the database
     *
     * @param Requirement $requirement
     * @param RequirementRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(Requirement $requirement, RequirementRequest $request){
        $files = $request->file('files');
        $destinationPath = 'documents/' . Auth::user()->username . '/requirements' . $requirement->id;
        $new_file_ids = $this->uploadFiles($files, $destinationPath);
        $old_file_ids = ($request->input('old_files') == null ? [] : $request->input('old_files'));
        $file_ids = array_merge($old_file_ids, $new_file_ids);

        $requirement->update($request->all());
        $requirement->files()->sync($file_ids);
        flash()->success('Requirement successfully updated');
        return redirect('/requirements');
    }

    public function assignment(Requirement $requirement){
        $gradeSectionSubjects = Auth::user()->gradeSectionSubjects;
        $timeNow = Carbon::parse(Carbon::now())->format('Y-m-d\\TH:i');
        $timeEnd = Carbon::parse(Carbon::now())->addDays(1)->format('Y-m-d\\TH:i');
        $gradeSectionSubjectsList = Auth::user()->gradeSectionSubjects;
        $gradeSectionSubjects = [];
        $gradeSectionSubjects[0] = "--Disable--";
        foreach ($gradeSectionSubjectsList as $gradeSectionSubject){
            $gradeSectionSubjects[$gradeSectionSubject->id] = $gradeSectionSubject->subject->name . ' (' . $gradeSectionSubject->gradeSection->getName->name . ')';
        }
        return view('grade-section-subjects.requirements.attach', compact('requirement', 'gradeSectionSubjects', 'timeNow', 'timeEnd'));
    }

    public function assign(Requirement $requirement, Request $request){
        $gradeSectionSubjectIdList = $request->input('grade_section_subject_id');
        $publishOnList = $request->input('publish_on');
        $eventStartList = $request->input('event_start');
        $eventEndList = $request->input('event_end');
        for ($i = 0; $i < count($gradeSectionSubjectIdList); $i++){
            if ($gradeSectionSubjectIdList[$i] != '0'){
                GradeSectionSubjectRequirement::create([
                    'requirement_id' => $requirement->id,
                    'grade_section_subject_id' => $gradeSectionSubjectIdList[$i],
                    'publish_on' => Carbon::parse($publishOnList[$i]),
                    'event_start' => Carbon::parse($eventStartList[$i]),
                    'event_end' => Carbon::parse($eventEndList[$i]),
                ]);
            }
        }
        flash()->success('Requirement has been created and attached. It will be published on the specified date.');
        return redirect('/requirements/' . $requirement->id);
    }

    public function showStudentSubmissions(GradeSectionSubject $gradeSectionSubject, GradeSectionSubjectRequirement $requirement){
        $submissions = [];
        foreach ($gradeSectionSubject->gradeSection->students as $student){
            $submissions[$student->id] = GradeSectionSubjectRequirementInstance::where('user_id', $student->id)->where('subject_requirement_id', $requirement->id)->first();
        }
        return view('grade-section-subjects.requirements.student-submissions', compact('gradeSectionSubject', 'requirement', 'submissions'));
    }

    /**
     * Store into the database the files uploaded by the faculty 
     *
     * @param array $files
     * @param string $destinationPath
     * @return array
     */
    private function uploadFiles($files, $destinationPath){
        if($files[0]){
            return $this->filesService->upload($files, $destinationPath);
        } else {
            return [];
        }
    }
}

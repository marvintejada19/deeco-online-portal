<?php

namespace App\Http\Controllers\Examinations;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Services\QuestionsService;
use App\Http\Services\ExaminationsService;
use App\Models\Questions\Question;
use App\Models\Examinations\Examination;
use App\Models\Examinations\Deployment;

use App\Models\GradeSectionSubjects\GradeSectionSubject;
use App\Models\Examinations\DeploymentInstance;
use Carbon\Carbon;
use Auth;

class ExaminationsController extends Controller
{
    private $questionsService;
    private $examinationsService;

    public function __construct(QuestionsService $questionsService, ExaminationsService $examinationsService){
        $this->questionsService = $questionsService;
        $this->examinationsService = $examinationsService;
    }

    public function index(){
        $examinations = Examination::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        return view('grade-section-subjects.examinations.content.index', compact('examinations'));
    }

    public function show(Examination $examination){
    	$attachments = Deployment::where('examination_id', $examination->id)->get();
        return view('grade-section-subjects.examinations.content.show', compact('examination', 'attachments'));
    }

    public function create(){
        $subcategories = $this->fetchExamSubcategories();
        return view('grade-section-subjects.examinations.content.create', compact('subcategories'));
    }

    public function store(Request $request){
        $examRequest = $request->all();
        $examRequest['total_points'] = 0;
        $examRequest['user_id'] = Auth::user()->id;
        $examRequest['quarter'] = $request->input('quarter');
    	$examination = Examination::create($examRequest);
        flash()->success('Examination successfully created');
        return redirect('/examinations/' . $examination->id);
    }

    public function edit(Examination $examination){
        $subcategories = $this->fetchExamSubcategories();
        return view('grade-section-subjects.examinations.content.edit', compact('subject', 'examination', 'subcategories'));
    }

    public function update(Examination $examination, Request $request){
        $examination->update($request->all());
        flash()->success('Examination successfully updated');
        return redirect('/examinations/' . $examination->id);
    }

    public function attachment(Examination $examination){
        $gradeSectionSubjects = Auth::user()->gradeSectionSubjects;
        $timeNow = Carbon::parse(Carbon::now())->format('Y-m-d\\TH:i');
        $timeEnd = Carbon::parse(Carbon::now())->addDays(1)->format('Y-m-d\\TH:i');
        $gradeSectionSubjectsList = Auth::user()->gradeSectionSubjects;
        $gradeSectionSubjects = [];
        $gradeSectionSubjects[0] = "--Disable--";
        foreach ($gradeSectionSubjectsList as $gradeSectionSubject){
            $gradeSectionSubjects[$gradeSectionSubject->id] = $gradeSectionSubject->subject->name . ' (' . $gradeSectionSubject->gradeSection->getName->name . ')';
        }
        return view('grade-section-subjects.examinations.content.attach', compact('examination', 'gradeSectionSubjects', 'timeNow', 'timeEnd'));
    }

    public function attach(Examination $examination, Request $request){
        $gradeSectionSubjectIdList = $request->input('grade_section_subject_id');
        $publishOnList = $request->input('publish_on');
        $examStartList = $request->input('exam_start');
        $examEndList = $request->input('exam_end');
        for ($i = 0; $i < count($gradeSectionSubjectIdList); $i++){
            if ($gradeSectionSubjectIdList[$i] != '0'){
                Deployment::create([
                    'examination_id' => $examination->id,
                    'grade_section_subject_id' => $gradeSectionSubjectIdList[$i],
                    'publish_on' => Carbon::parse($publishOnList[$i]),
                    'exam_start' => Carbon::parse($examStartList[$i]),
                    'exam_end' => Carbon::parse($examEndList[$i]),
                ]);
            }
        }
        flash()->success('Examination has been attached. It will be published on the specified date.');
        return redirect('/examinations/' . $examination->id);
    }

    public function editAssignment(Examination $examination, $id){
        $attachment = Deployment::find($id);
        $gradeSectionSubject = GradeSectionSubject::find($attachment->grade_section_subject_id);
        return view('grade-section-subjects.examinations.content.attach-edit', compact('examination', 'attachment', 'gradeSectionSubject'));
    }

    public function updateAssignment(Examination $examination, $id, Request $request){
        $attachment = Deployment::find($id);
        $attachment->update($request->all());
        flash()->success('Examination attachment to grade section subject has been successfully updated.');
        return redirect('/examinations/' . $examination->id);
    }

    public function confirmDeleteAssignment(Examination $examination, $id){
        $attachment = Deployment::find($id);
        return view('grade-section-subjects.examinations.content.attach-delete', compact('examination', 'attachment'));
    }

    public function deleteAssignment(Examination $examination, $id){
        $attachment = Deployment::find($id);
        $attachment->delete();
        flash()->success('Examination attachment to grade section subject has been successfully removed.');
        return redirect('/examinations/' . $examination->id);
    }

    public function showExamResults(GradeSectionSubject $gradeSectionSubject, Deployment $deployment){
        $instance = DeploymentInstance::where('user_id', Auth::user()->id)->where('deployment_id', $deployment->id)->first();
        if (!strcmp(Auth::user()->getRole(), 'Student') && $instance != null && $instance->is_finished){
            return view('classes.examinations.results', compact('gradeSectionSubject', 'deployment', 'instance'));
        } else {
            return redirect('/classes/' . $gradeSectionSubject->id . '/deployments/' . $deployment->id . '/instances/');
        }
    }

    public function showResultsIndex(GradeSectionSubject $gradeSectionSubject, Deployment $deployment){
        $exams = [];
        foreach ($gradeSectionSubject->gradeSection->students as $student){
            $instance = DeploymentInstance::where('deployment_id', $deployment->id)->where('user_id', $student->id)->first();
            $exams[$student->id] = $instance;
        }
        return view('grade-section-subjects.examinations.students.index', compact('gradeSectionSubject', 'deployment', 'exams'));
    }

    public function showStudentResults(GradeSectionSubject $gradeSectionSubject, Deployment $deployment, DeploymentInstance $instance){
        return $this->examinationsService->showResults($gradeSectionSubject, $deployment, $instance);
    }

    private function fetchExamSubcategories(){
        $subcategories['Seatwork'] = 'Seatwork';
        $subcategories['Homework'] = 'Homework';
        $subcategories['Quiz'] = 'Quiz';
        $subcategories['Long test'] = 'Long test';
        $subcategories['Others'] = 'Others';
        return $subcategories;
    }
}

<?php

namespace App\Http\Controllers\Examinations;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Services\QuestionsService;
use App\Http\Services\ExaminationsService;
use App\Http\Services\ClassRecordService;
use App\Models\Questions\Question;
use App\Models\Questions\Types\QuestionMultipleChoice;
use App\Models\Questions\Types\QuestionTrueOrFalse;
use App\Models\Questions\Types\QuestionFillInTheBlanks;
use App\Models\Questions\Types\QuestionSelectFromTheWordboxChoice;
use App\Models\Questions\Types\QuestionSelectFromTheWordboxItem;
use App\Models\Questions\Types\QuestionMatchColumnsChoice;
use App\Models\Questions\Types\QuestionMatchColumnsItem;
use App\Models\GradeSectionSubjects\GradeSectionSubject;
use App\Models\Examinations\Examination;
use App\Models\Examinations\Deployment;
use App\Models\Examinations\DeploymentInstance;
use App\Models\Examinations\DeploymentAnswer;
use Carbon\Carbon;
use Auth;

class ExaminationInstancesController extends Controller
{
	private $questionsService;
	private $examinationsService;
    private $classRecordService;

    public function __construct(QuestionsService $questionsService, ExaminationsService $examinationsService, ClassRecordService $classRecordService){
        $this->questionsService = $questionsService;
        $this->examinationsService = $examinationsService;
        $this->classRecordService = $classRecordService;
        $this->middleware('examFinished', ['only' => ['showExamPage', 'processExamPage', 'showExamFinishPage', 'finish']]);
    }

    public function showInstanceConfirmation(GradeSectionSubject $gradeSectionSubject, Deployment $deployment){
        $instance = DeploymentInstance::where('user_id', Auth::user()->id)->where('deployment_id', $deployment->id)->first();
        $timeNow = Carbon::parse(Carbon::now());
        $examStart = Carbon::parse($deployment->exam_start);
        $examEnd = Carbon::parse($deployment->exam_end);
        if ($instance == null){
            return view('classes.examinations.instance', compact('gradeSectionSubject', 'deployment', 'timeNow', 'examStart', 'examEnd'));
        } else if ($instance->is_finished){
            return redirect('/classes/' . $gradeSectionSubject->id . '/deployments/' . $deployment->id . '/results');
        } else if (!$instance->is_finished){
            return redirect('/classes/' . $gradeSectionSubject->id . '/deployments/' . $deployment->id . '/instances/' . $instance->id . '/page/1');
        } else {
            flash()->error('Some error occurred. Please try again.');
            return redirect('/home');
        }
    }

    public function createExaminationInstance(GradeSectionSubject $gradeSectionSubject, Deployment $deployment, Request $request){
        if (!$this->examinationsService->verifyQuestionQuantity($deployment->examination)){
            dd('questions not enough');
        } else{
            $deploymentInstance = $this->createInstance($deployment);
            foreach ($deployment->examination->parts as $examPart){
                $questionTypeId = $examPart->question_type_id;
                $first = true;
                $questionsOrder = '';
                if (!strcmp($examPart->getQuestionType(), 'Select from the Wordbox')){
                    $questionItem = $examPart->items()->first();
                    $question = Question::find($questionItem->question_id);
                    $wordboxChoiceIds = QuestionSelectFromTheWordboxChoice::get()->pluck('id');
                    $wordboxItems = QuestionSelectFromTheWordboxItem::whereIn('wordbox_choice_id', $wordboxChoiceIds)->get()->shuffle();
                    for ($i = 0; $i < $examPart->items->first()->quantity; $i++){
                        if (!$first){
                            $questionsOrder = $questionsOrder . '|' . $wordboxItems[$i]->id;
                        } else {
                            $questionsOrder = '' . $wordboxItems[$i]->id;
                            $first = false;
                        }
                    }
                } else if (!strcmp($examPart->getQuestionType(), 'Match Column A with Column B')){
                    $questionItem = $examPart->items()->first();
                    $question = Question::find($questionItem->question_id);
                    $columnsChoiceIds = QuestionMatchColumnsChoice::get()->pluck('id');
                    $columnsItems = QuestionMatchColumnsItem::whereIn('columns_choice_id', $columnsChoiceIds)->get()->shuffle();                    
                    for ($i = 0; $i < ($questionItem->quantity + $questionItem->choices_quantity); $i++){
                        if (!$first){
                            $questionsOrder = $questionsOrder . '|' . $columnsItems[$i]->id;
                        } else {
                            $questionsOrder = '' . $columnsItems[$i]->id;
                            $first = false;
                        }
                    }
                } else {
                    foreach ($examPart->items as $item){
                        $questions = Question::where('question_type_id', $questionTypeId)->where('question_subtopic_id', $item->question_subtopic_id)->get()->shuffle();
                        for ($i = 0; $i < $item->quantity; $i++){
                            if (!$first){
                                $questionsOrder = $questionsOrder . '|' . $questions[$i]->id;
                            } else {
                                $questionsOrder = '' . $questions[$i]->id;
                                $first = false;
                            }
                        }
                    }
                }
                $deploymentInstance->parts()->create([
                    'examination_part_id' => $examPart->id,
                    'question_order' => $questionsOrder,
                ]);
            }
        }
        return redirect('/classes/' . $gradeSectionSubject->id . '/deployments/' . $deployment->id . '/instances/' . $deploymentInstance->id . '/page/1');
    }

    public function showExamPage(GradeSectionSubject $gradeSectionSubject, Deployment $deployment, DeploymentInstance $instance, $page){
        if ($page > count($instance->parts)){
            return redirect('/classes/' . $gradeSectionSubject->id . '/deployments/' . $deployment->id . '/instances/' . $instance->id . '/page/finish');
        } else {    	
	        $instancePart = $instance->parts[$page-1];
	        $questionIds = explode('|', $instancePart->question_order);
	        $choices_quantity = 0;
	        foreach ($questionIds as $id){
	        	if (!strcmp($instancePart->examinationPart->getQuestionType(), 'Select from the Wordbox')){
	        		$questions[$id] = QuestionSelectFromTheWordboxItem::find($id);
	        	} else if (!strcmp($instancePart->examinationPart->getQuestionType(), 'Match Column A with Column B')){
	        		$questions[$id] = QuestionMatchColumnsItem::find($id);
	        		$choices_quantity = $deployment->examination->parts[$page-1]->items()->first()->choices_quantity;
	        	} else {
	        		$questions[$id] = Question::find($id);
	        	}
	        }
	        $navbar = $this->createNavbar($gradeSectionSubject, $deployment, $instance, $page);
            $submitUrl = '/classes/' . $gradeSectionSubject->id . '/deployments/' . $deployment->id . '/instances/' . $instance->id . '/page/' . $page;
	        return $this->examinationsService->generatePage($instancePart, $questions, $navbar, $submitUrl, $choices_quantity);
        }
    }

    public function processExamPage(GradeSectionSubject $gradeSectionSubject, Deployment $deployment, DeploymentInstance $instance, $page, Request $request){
        $instancePart = $instance->parts[$page-1];
        $questionIds = explode('|', $instancePart->question_order);
        foreach ($questionIds as $id){
        	$questions[$id] = Question::find($id);
        }
	    $nextUrl = '/classes/' . $gradeSectionSubject->id . '/deployments/' . $deployment->id . '/instances/' . $instance->id . '/page/' . ($page + 1);
        return $this->examinationsService->processPage($instancePart, $questions, $nextUrl, $page, $request);
    }

    public function showExamFinishPage(GradeSectionSubject $gradeSectionSubject, Deployment $deployment, DeploymentInstance $instance){
        $navbar = $this->createNavbar($gradeSectionSubject, $deployment, $instance, 'finish');
        $nextUrl = '/classes/' . $gradeSectionSubject->id . '/deployments/' . $deployment->id . '/instances/' . $instance->id . '/page/finish';
        $startUrl = '/classes/' . $gradeSectionSubject->id . '/deployments/' . $deployment->id . '/instances/' . $instance->id . '/page/1';
        return view('grade-section-subjects.examinations.instances.finish', compact('navbar', 'nextUrl', 'startUrl'));
    }

    public function finish(GradeSectionSubject $gradeSectionSubject, Deployment $deployment, DeploymentInstance $instance){
        $score = 0;
        foreach ($instance->parts as $instancePart){
            $questionType = $instancePart->examinationPart->getQuestionType();
            $questionIds = explode('|', $instancePart->question_order);
            if (!strcmp($questionType, 'Match Column A with Column B')) {
                $ch_quantity = $instancePart->examinationPart->items()->first()->choices_quantity;
                $questionIds = array_slice($questionIds, 0, count($questionIds) - $ch_quantity);
            }
            $pointsPerItem = $instancePart->examinationPart->points;
            foreach ($questionIds as $questionId){
                switch ($questionType){
                    case 'Multiple Choice':
                        $question = Question::find($questionId);
                        if ($this->examinationsService->fetchAnswer($instancePart->id, $question->id) != null){
                            $answer = $this->examinationsService->fetchAnswer($instancePart->id, $question->id)->answer;
                            $correctAnswer = QuestionMultipleChoice::where('question_id', $question->id)->where('is_right_answer', '1')->first()->text;
                            $score += (!strcmp($answer, $correctAnswer)) ? $pointsPerItem : 0;
                        }
                        break;
                    case 'True or False':
                        $question = Question::find($questionId);
                        if ($this->examinationsService->fetchAnswer($instancePart->id, $question->id) != null){
                            $answer = $this->examinationsService->fetchAnswer($instancePart->id, $question->id)->answer;
                            $correctAnswer = QuestionTrueOrFalse::where('question_id', $question->id)->first()->right_answer;
                            $score += (!strcmp($answer, $correctAnswer)) ? $pointsPerItem : 0;
                        }
                        break;
                    case 'Fill in the Blanks':
                        $question = Question::find($questionId);
                        if ($this->examinationsService->fetchAnswer($instancePart->id, $question->id) != null){
                            $answer = $this->examinationsService->fetchAnswer($instancePart->id, $question->id)->answer;
                            $correctAnswer = QuestionFillInTheBlanks::where('question_id', $question->id)->first()->right_answer;
                            $score += (!strcmp(strtolower($answer), strtolower($correctAnswer))) ? $pointsPerItem : 0;
                        }
                        break;
                    case 'Select from the Wordbox':
                        $wordboxItemId = $questionId;
                        if (DeploymentAnswer::where('deployment_instance_part_id', $instancePart->id)->where('wordbox_item_id', $wordboxItemId)->first() != null){
                            $answer = DeploymentAnswer::where('deployment_instance_part_id', $instancePart->id)->where('wordbox_item_id', $wordboxItemId)->first()->answer;
                            $item = QuestionSelectFromTheWordboxItem::find($wordboxItemId);
                            $correctAnswer = $item->choice->text;
                            $score += (!strcmp($answer, $correctAnswer)) ? $pointsPerItem : 0;
                        }
                        break;
                    case 'Match Column A with Column B':
                        $columnsItemId = $questionId;
                        if (DeploymentAnswer::where('deployment_instance_part_id', $instancePart->id)->where('columns_item_id', $columnsItemId)->first()){
                            $answer = DeploymentAnswer::where('deployment_instance_part_id', $instancePart->id)->where('columns_item_id', $columnsItemId)->first()->answer;
                            $item = QuestionMatchColumnsItem::find($columnsItemId);
                            $correctAnswer = $item->choice->text;
                            $score += (!strcmp($answer, $correctAnswer)) ? $pointsPerItem : 0;
                        }
                        break;
                    default:
                        flash()->error('Some error occurred. Please try again.');
                        return redirect('/home');    
                }
            }
        }
        $instance->time_ended = Carbon::now();
        $instance->score =  $score;
        $instance->is_finished = true;
        $instance->update();

        $this->classRecordService->storeResultsInClassRecord($gradeSectionSubject, $deployment, $instance);
        return redirect('/classes/' . $gradeSectionSubject->id . '/deployments/' . $deployment->id . '/results');
    }

    private function createInstance($deployment){
        $deploymentInstance = new DeploymentInstance();
        $deploymentInstance->user_id = Auth::user()->id;
        $deploymentInstance->deployment_id = $deployment->id;
        $deploymentInstance->score = null;
        $deploymentInstance->time_started = Carbon::now();
        $deploymentInstance->time_ended = null;
        $deploymentInstance->is_finished = false;
        $deploymentInstance->save();
        return $deploymentInstance;
    }

    public function createNavbar($gradeSectionSubject, $deployment, $instance, $page){
		$navbar = "<nav><ul class='pager'>";
		if ($page == 1){
			$navbar = $navbar . "<li class='previous disabled'><a href='#'><span aria-hidden='true'>&larr;</span> Previous page</a></li>";
		} else if ($page == 'finish'){
            $navbar = $navbar . "<li class='previous'><a href='/classes/" . $gradeSectionSubject->id . "/deployments/" . $deployment->id . "/instances/" . $instance->id . "/page/" . count($instance->parts) . "'><span aria-hidden='true'>&larr;</span> Previous page</a></li>";
        } else {
			$navbar = $navbar . "<li class='previous'><a href='/classes/" . $gradeSectionSubject->id . "/deployments/" . $deployment->id . "/instances/" . $instance->id . "/page/" . ($page - 1) . "'><span aria-hidden='true'>&larr;</span> Previous page</a></li>";
		}
		if ($page == 'finish'){
			$navbar = $navbar . "<li class='next disabled'><a href='#'>Next page <span aria-hidden='true'>&rarr;</span></a></li>";
		} else {
			$navbar = $navbar . "<li class='next'><a href='/classes/" . $gradeSectionSubject->id . "/deployments/" . $deployment->id . "/instances/" . $instance->id . "/page/" . ($page + 1) . "'>
						Next page <span aria-hidden='true'>&rarr;</span></a></li>";
		}
		$navbar = $navbar . "</ul></nav>";
        return $navbar;
    }
}

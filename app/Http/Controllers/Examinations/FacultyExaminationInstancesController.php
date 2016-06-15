<?php

namespace App\Http\Controllers\Examinations;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Services\QuestionsService;
use App\Http\Services\ExaminationsService;
use App\Http\Requests;
use App\Models\Questions\Question;
use App\Models\Questions\Types\QuestionMultipleChoice;
use App\Models\Questions\Types\QuestionTrueOrFalse;
use App\Models\Questions\Types\QuestionFillInTheBlanks;
use App\Models\Questions\Types\QuestionSelectFromTheWordboxChoice;
use App\Models\Questions\Types\QuestionSelectFromTheWordboxItem;
use App\Models\Questions\Types\QuestionMatchColumnsChoice;
use App\Models\Questions\Types\QuestionMatchColumnsItem;
use App\Models\Examinations\Examination;
use App\Models\Examinations\DeploymentInstance;
use App\Models\Examinations\DeploymentInstancePart;
use App\Models\Examinations\DeploymentAnswer;   
use Auth;

class FacultyExaminationInstancesController extends Controller
{
	private $questionsService;
	private $examinationsService;

    public function __construct(QuestionsService $questionsService, ExaminationsService $examinationsService){
        $this->questionsService = $questionsService;
        $this->examinationsService = $examinationsService;
    }

    public function showInstanceConfirmation(Examination $examination){
        return view('grade-section-subjects.examinations.content.instance', compact('examination'));
    }

    public function createExaminationInstance(Examination $examination, Request $request){
        if (!$this->examinationsService->verifyQuestionQuantity($examination)){
            return redirect('/examinations/' . $examination->id . '/parts');
        } else{
            $deploymentInstance = $this->createDeploymentInstance($examination);
            foreach ($examination->parts as $examPart){
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
        return redirect('/examinations/' . $examination->id . '/faculty/instances/' . $deploymentInstance->id . '/page/1');
    }

    public function showExamPage(Examination $examination, DeploymentInstance $deploymentInstance, $page){
        if ($page > count($deploymentInstance->parts)){
            return redirect('/examinations/' . $examination->id . '/faculty/instances/' . $deploymentInstance->id . '/page/finish');
        } else {    	
	        $deploymentInstancePart = $deploymentInstance->parts[$page-1];
	        $questionIds = explode('|', $deploymentInstancePart->question_order);
	        $choices_quantity = 0;
	        foreach ($questionIds as $id){
	        	if (!strcmp($deploymentInstancePart->examinationPart->getQuestionType(), 'Select from the Wordbox')){
	        		$questions[$id] = QuestionSelectFromTheWordboxItem::find($id);
	        	} else if (!strcmp($deploymentInstancePart->examinationPart->getQuestionType(), 'Match Column A with Column B')){
	        		$questions[$id] = QuestionMatchColumnsItem::find($id);
	        		$choices_quantity = $examination->parts[$page-1]->items()->first()->choices_quantity;
	        	} else {
	        		$questions[$id] = Question::find($id);
	        	}
	        }
	        $navbar = $this->createNavbar($examination, $deploymentInstance, $page);
            $submitUrl = '/examinations/' . $examination->id . '/faculty/instances/' . $deploymentInstance->id . '/page/' . $page;
	        return $this->examinationsService->generatePage($deploymentInstancePart, $questions, $navbar, $submitUrl, $choices_quantity);
        }
    }

    public function processExamPage(Examination $examination, DeploymentInstance $deploymentInstance, $page, Request $request){
        $deploymentInstancePart = $deploymentInstance->parts[$page-1];
        $questionIds = explode('|', $deploymentInstancePart->question_order);
        foreach ($questionIds as $id){
        	$questions[$id] = Question::find($id);
        }
	    $nextUrl = '/examinations/' . $examination->id . '/faculty/instances/' . $deploymentInstance->id . '/page/' . ($page + 1);
        return $this->examinationsService->processPage($deploymentInstancePart, $questions, $nextUrl, $page, $request);
    }

    public function showExamFinishPage(Examination $examination, DeploymentInstance $deploymentInstance){
        $navbar = $this->createNavbar($examination, $deploymentInstance, 'finish');
        $nextUrl = '/examinations/' . $examination->id . '/faculty/instances/' . $deploymentInstance->id . '/page/finish';
        $startUrl = '/examinations/' . $examination->id . '/faculty/instances/' . $deploymentInstance->id . '/page/1';
        return view('grade-section-subjects.examinations.instances.finish', compact('navbar', 'nextUrl', 'startUrl'));
    }

    public function finish(Examination $examination, DeploymentInstance $deploymentInstance){
        $score = 0;
        foreach ($deploymentInstance->parts as $instancePart){
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
                        $answer = $this->examinationsService->fetchAnswer($instancePart->id, $question->id)->answer;
                        $correctAnswer = QuestionMultipleChoice::where('question_id', $question->id)->where('is_right_answer', '1')->first()->text;
                        $score += (!strcmp($answer, $correctAnswer)) ? $pointsPerItem : 0;
                        break;
                    case 'True or False':
                        $question = Question::find($questionId);
                        $answer = $this->examinationsService->fetchAnswer($instancePart->id, $question->id)->answer;
                        $correctAnswer = QuestionTrueOrFalse::where('question_id', $question->id)->first()->right_answer;
                        $score += (!strcmp($answer, $correctAnswer)) ? $pointsPerItem : 0;
                        break;
                    case 'Fill in the Blanks':
                        $question = Question::find($questionId);
                        $answer = $this->examinationsService->fetchAnswer($instancePart->id, $question->id)->answer;
                        $correctAnswer = QuestionFillInTheBlanks::where('question_id', $question->id)->first()->right_answer;
                        $score += (!strcmp(strtolower($answer), strtolower($correctAnswer))) ? $pointsPerItem : 0;
                        break;
                    case 'Select from the Wordbox':
                        $wordboxItemId = $questionId;
                        $answer = DeploymentAnswer::where('deployment_instance_part_id', $instancePart->id)->where('wordbox_item_id', $wordboxItemId)->first()->answer;
                        $item = QuestionSelectFromTheWordboxItem::find($wordboxItemId);
                        $correctAnswer = $item->choice->text;
                        $score += (!strcmp($answer, $correctAnswer)) ? $pointsPerItem : 0;
                        break;
                    case 'Match Column A with Column B':
                        $columnsItemId = $questionId;
                        $answer = DeploymentAnswer::where('deployment_instance_part_id', $instancePart->id)->where('columns_item_id', $columnsItemId)->first()->answer;
                        $item = QuestionMatchColumnsItem::find($columnsItemId);
                        $correctAnswer = $item->choice->text;
                        $score += (!strcmp($answer, $correctAnswer)) ? $pointsPerItem : 0;
                        break;
                    default:
                        flash()->error('Some error occurred. Please try again.');
                        return redirect('/home');    
                }
            }
        }
        $deploymentInstance->score =  $score;
        $deploymentInstance->is_finished = true;
        $deploymentInstance->update();
        return redirect('/examinations/' . $examination->id . '/faculty/instances/' . $deploymentInstance->id . '/results');
    }

    public function showExamResults(Examination $examination, DeploymentInstance $deploymentInstance){
        return view('grade-section-subjects.examinations.instances.results', compact('examination', 'deploymentInstance'));
    }

    private function createDeploymentInstance($examination){
        $deploymentInstance = new DeploymentInstance();
        $deploymentInstance->user_id = Auth::user()->id;
        $deploymentInstance->deployment_id = null;
        $deploymentInstance->is_finished = false;
        $deploymentInstance->score = null;
        $deploymentInstance->time_started = null;
        $deploymentInstance->time_ended = null;
        $deploymentInstance->save();
        return $deploymentInstance;
    }

    public function createNavbar($examination, $deploymentInstance, $page){
		$navbar = "<nav><ul class='pager'>";
		if ($page == 1){
			$navbar = $navbar . "<li class='previous disabled'><a href='#'><span aria-hidden='true'>&larr;</span> Previous page</a></li>";
		} else if ($page == 'finish'){
            $navbar = $navbar . "<li class='previous'><a href='/examinations/" . $examination->id . "/faculty/instances/" . $deploymentInstance->id . "/page/" . count($deploymentInstance->parts) . "'><span aria-hidden='true'>&larr;</span> Previous page</a></li>";
        } else {
			$navbar = $navbar . "<li class='previous'><a href='/examinations/" . $examination->id . "/faculty/instances/" . $deploymentInstance->id . "/page/" . ($page - 1) . "'><span aria-hidden='true'>&larr;</span> Previous page</a></li>";
		}
		if ($page == 'finish'){
			$navbar = $navbar . "<li class='next disabled'><a href='#'>Next page <span aria-hidden='true'>&rarr;</span></a></li>";
		} else {
			$navbar = $navbar . "<li class='next'><a href='/examinations/" . $examination->id . "/faculty/instances/" . $deploymentInstance->id . "/page/" . ($page + 1) . "'>
						Next page <span aria-hidden='true'>&rarr;</span></a></li>";
		}
		$navbar = $navbar . "</ul></nav>";
        return $navbar;
    }
}

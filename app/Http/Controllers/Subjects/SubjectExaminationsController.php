<?php

namespace App\Http\Controllers\Subjects;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\Subjects\SubjectExaminationRequest;
use App\Http\Services\QuestionsService;
use App\Models\Questions\Question;
use App\Models\Questions\Types\QuestionFillInTheBlanks;
use App\Models\Questions\Types\QuestionMatchingType;
use App\Models\Questions\Types\QuestionMatchingTypeChoices;
use App\Models\Questions\Types\QuestionMatchingTypeItems;
use App\Models\Questions\Types\QuestionTrueOrFalse;
use App\Models\Questions\Types\QuestionMultipleChoice;
use App\Models\Subjects\Subject;
use App\Models\Subjects\SubjectExamination;
use App\Models\Subjects\SubjectExaminationInstance;
use App\Models\Subjects\SubjectExaminationAnswer;
use Carbon\Carbon;
use Auth;

class SubjectExaminationsController extends Controller
{
    private $questionsService;

    public function __construct(QuestionsService $questionsService){
        $this->questionsService = $questionsService;
    }

    public function index(Subject $subject){
    	return view('subjects.examinations.index', compact('subject'));
    }

    public function show(Subject $subject, SubjectExamination $examination){
        return view('subjects.examinations.show', compact('subject', 'examination'));
    }

    public function create(Subject $subject){
        return view('subjects.examinations.create', compact('subject'));
    }

    public function store(Subject $subject, SubjectExaminationRequest $request){
        $examRequest = $request->all();
        $examRequest['total_points'] = 0;
        $examRequest['is_published'] = false;
    	$subject->subjectExaminations()->create($examRequest);

        return redirect('/subjects/' . $subject->id . '/examinations/');
    }

    public function edit(Subject $subject, SubjectExamination $examination){
        return view('subjects.examinations.edit', compact('subject', 'examination'));
    }

    public function update(Subject $subject, SubjectExamination $examination, SubjectExaminationRequest $request){
        $examination->update($request->all());
        return redirect('/subjects/' . $subject->id . '/examinations/');
    }

    public function showDeleteConfirmation(Subject $subject, SubjectExamination $examination){
        return view('subjects.examinations.delete', compact('subject', 'examination'));
    }

    public function delete(Subject $subject, SubjectExamination $examination){
        $examination->delete();
        return redirect('/subjects/' . $subject->id . '/examinations');
    }

    public function showInstanceConfirmation(Subject $subject, SubjectExamination $examination){
        $instance = SubjectExaminationInstance::where('user_id', Auth::user()->id)->where('examination_id', $examination->id)->first();
        $continueUrl = '/subjects/' . $subject->id . '/examinations/' . $examination->id . '/instances/' . $instance->id . '/page/finish';
        if($instance){
            $hasInstance = true;
            $questionOrder = explode("|", $instance->questions_order);
            for ($i = 0; $i < count($questionOrder); $i++){
                $question = Question::find($questionOrder[$i]);
                $hasAnswer = SubjectExaminationAnswer::where('examination_instance_id', $instance->id)->where('question_id', $question->id)->first();
                if(!$hasAnswer){
                    $continueUrl = '/subjects/' . $subject->id . '/examinations/' . $examination->id . '/instances/' . $instance->id . '/page/' . ($i + 1);
                }
            }
        } else {
            $hasInstance = false;
        }

        return view('subjects.examinations.instance', compact('subject', 'examination', 'instance', 'hasInstance', 'continueUrl'));
    }

    public function createExaminationInstance(Subject $subject, SubjectExamination $examination, Request $request){
        $instance = SubjectExaminationInstance::where('user_id', Auth::user()->id)->where('examination_id', $examination->id)->first();
        if($instance){
            $instance->delete();
        }

        $questions = $examination->questions->shuffle();
        $first = true;
        foreach ($questions as $question){
            if (!$first){
                $questionsOrder = $questionsOrder . '|' . $question->id;
            } else {
                $questionsOrder = '' + $question->id;
                $first = false;
            }
        }

        $instance = new SubjectExaminationInstance();
        $instance->user_id = Auth::user()->id;
        $instance->examination_id = $examination->id;
        $instance->exam_start = $examination->exam_start;
        $instance->exam_end = $examination->exam_end;
        $instance->questions_order = $questionsOrder;
        $instance->is_recorded = false;
        $instance->is_finished = false;
        $instance->score = null;
        $instance->time_started = Carbon::now();
        $instance->time_ended = null;
        $instance->save();

        return redirect('/subjects/' . $subject->id . '/examinations/' . $examination->id . '/instances/' . $instance->id . '/page/1');
    }

    public function showExamPage(Subject $subject, SubjectExamination $examination, SubjectExaminationInstance $instance, $page){
        $questionOrder = explode("|", $instance->questions_order);
        if ($page > count($questionOrder)){
            return redirect('/subjects/' . $subject->id . '/examinations/' . $examination->id . '/instances/' . $instance->id . '/page/finish');
        } else {
            $question = Question::where('id', $questionOrder[$page-1])->first();
            $navbar = $this->createNavbar($subject, $examination, $instance, $page, $questionOrder);
            $nextUrl = '/subjects/' . $subject->id . '/examinations/' . $examination->id . '/instances/' . $instance->id . '/page/' . $page;
            $answer = $this->fetchAnswer($instance->id, $question->id)->get();
            return $this->questionsService->generateInstance($question, $navbar, $nextUrl, true, $answer);
        }
    }

    public function processExamPage(Subject $subject, SubjectExamination $examination, SubjectExaminationInstance $instance, $page, Request $request){
        $questionOrder = explode("|", $instance->questions_order);
        $question = Question::where('id', $questionOrder[$page-1])->first();
        $nextUrl = '/subjects/' . $subject->id . '/examinations/' . $examination->id . '/instances/' . $instance->id . '/page/' . ($page + 1);
        $navbar = $this->createNavbar($subject, $examination, $instance, $page, $questionOrder);
        $answer = $this->fetchAnswer($instance->id, $question->id)->get();
        if (!$answer->isEmpty()){
            $answer->first()->delete();
        }
        return $this->questionsService->processInstance($question, $nextUrl, $request, true, $instance);
    }

    public function showExamFinishPage(Subject $subject, SubjectExamination $examination, SubjectExaminationInstance $instance){
        $questionOrder = explode("|", $instance->questions_order);
        $navbar = $this->createNavbar($subject, $examination, $instance, 'finish', $questionOrder);
        
        $questions = $examination->questions;
        $answeredQuestions = 0;
        foreach ($questions as $question){
            $answer = $this->fetchAnswer($instance->id, $question->id)->first();
            if(!is_null($answer)){
                $answeredQuestions++;
            }
        }
        $totalQuestions = count($questions);

        return view('subjects.examinations.finish', compact('subject', 'examination', 'instance', 'navbar', 'answeredQuestions', 'totalQuestions'));
    }

    public function finish(Subject $subject, SubjectExamination $examination, SubjectExaminationInstance $instance){
        $score = 0;
        foreach ($examination->questions as $question){
            $answers = $this->fetchAnswer($instance->id, $question->id);
            switch($question->getQuestionType()){
                case 'Multiple Choice':
                    $answer = $answers->first()->answer;
                    $correctAnswer = QuestionMultipleChoice::where('question_id', $question->id)->where('is_right_answer', '1')->first()->text;
                    $score += (!strcmp($answer, $correctAnswer)) ? $question->points : 0;
                    break;
                case 'True or False':
                    $answer = $answers->first()->answer;
                    $correctAnswer = QuestionTrueOrFalse::where('question_id', $question->id)->first()->right_answer;
                    $score += (!strcmp($answer, $correctAnswer)) ? $question->points : 0;
                    break;
                case 'Fill in the Blanks':
                    $answer = $answers->first()->answer;
                    $correctAnswer = QuestionFillInTheBlanks::where('question_id', $question->id)->first()->right_answer;
                    $score += (!strcmp($answer, $correctAnswer)) ? $question->points : 0;
                    break;
                case 'Matching Type':
                    $all_answers = $answers->get();
                    foreach ($all_answers as $answer){
                        $correctAnswer = QuestionMatchingTypeItems::where('id', $answer->matching_type_item_id)->first()->correct_answer;
                        $score += (!strcmp($answer->answer, $correctAnswer)) ? $question->points : 0;
                    }
                    break;
                default:
                    flash()->error('Some error occurred. Please try again.');
                    return redirect('/home');    
            }
        }
        $instance->time_ended = Carbon::now();
        $instance->score =  $score;
        $instance->is_finished = true;
        $instance->update();
        return redirect('/subjects/' . $subject->id . '/examinations/' . $examination->id . '/results');
    }

    public function showExamResults(Subject $subject, SubjectExamination $examination){
        $instance = SubjectExaminationInstance::where('user_id', Auth::user()->id)->where('examination_id', $examination->id)->first();
        $timeStarted = SubjectExaminationInstance::find($instance->id)->time_started;
        $timeEnded = SubjectExaminationInstance::find($instance->id)->time_ended;
        $answers = [];
        $correctAnswers = [];
        $matchingTypeItems = [];
        $matchingTypeAnswers = [];

        foreach ($examination->questions as $question){
            switch($question->getQuestionType()){
                case 'Multiple Choice':
                    $answers[$question->id] = $this->fetchAnswer($instance->id, $question->id)->first()->answer;
                    $correctAnswers[$question->id] = QuestionMultipleChoice::where('question_id', $question->id)->where('is_right_answer', '1')->first()->text;
                    break;
                case 'True or False':
                    $answers[$question->id] = $this->fetchAnswer($instance->id, $question->id)->first()->answer;
                    $correctAnswers[$question->id] = QuestionTrueOrFalse::where('question_id', $question->id)->first()->right_answer;
                    break;
                case 'Fill in the Blanks':
                    $answers[$question->id] = $this->fetchAnswer($instance->id, $question->id)->first()->answer;
                    $correctAnswers[$question->id] = QuestionFillInTheBlanks::where('question_id', $question->id)->first()->right_answer;
                    break;
                case 'Matching Type':
                    $matchingTypeId = $question->matchingType->id;
                    $items = QuestionMatchingTypeItems::where('matching_type_id', $matchingTypeId)->get();
                    $matchingTypeItems[$matchingTypeId] = $items;
                    foreach ($items as $item){
                        $matchingTypeAnswers[$item->id] = $this->fetchAnswer($instance->id, $question->id)->where('matching_type_item_id', $item->id)->first()->answer;
                    }
                    break;
                default:
                    flash()->error('Some error occurred. Please try again.');
                    return redirect('/home');    
            }
        }
        return view('subjects.examinations.results', compact('subject', 'examination', 'instance', 'timeStarted', 'timeEnded', 'answers', 'correctAnswers', 'matchingTypeItems', 'matchingTypeAnswers'));
    }

    private function createNavbar($subject, $examination, $instance, $page, $questionOrder){
        $navbar = "<nav><ul class='pagination'>";
        for ($i = 1; $i < count($questionOrder) + 1; $i++){
            $tempQuestion = Question::where('id', $questionOrder[$i-1])->first();
            $examinationAnswer = $this->fetchAnswer($instance->id, $tempQuestion->id)->get();
            if ($i == $page && !($examinationAnswer->isEmpty())){
                $navbar = $navbar . "<li class='active'><a href='/subjects/" . $subject->id . "/examinations/" . $examination->id . "/instances/" . $instance->id . "/page/" . $i . "'><span class='glyphicon glyphicon-ok'></span></a></li>";
            } else if ($i == $page){
                $navbar = $navbar . "<li class='active'><a href='/subjects/" . $subject->id . "/examinations/" . $examination->id . "/instances/" . $instance->id . "/page/" . $i . "'>" . $i . "</a></li>";
            } else if (!($examinationAnswer->isEmpty())){
                $navbar = $navbar . "<li><a href='/subjects/" . $subject->id . "/examinations/" . $examination->id . "/instances/" . $instance->id . "/page/" . $i . "'><span class='glyphicon glyphicon-ok'></span></a></li>";
            } else {
                $navbar = $navbar . "<li><a href='/subjects/" . $subject->id . "/examinations/" . $examination->id . "/instances/" . $instance->id . "/page/" . $i . "'>" . $i . "</a></li>";
            }
        }
        if (!strcmp($page, 'finish')){
            $navbar = $navbar . "<li class='active'><a href='/subjects/" . $subject->id . "/examinations/" . $examination->id . "/instances/" . $instance->id . "/page/finish'>Finish examination</a></li>";
        } else {
            $navbar = $navbar . "<li><a href='/subjects/" . $subject->id . "/examinations/" . $examination->id . "/instances/" . $instance->id . "/page/finish'>Finish examination</a></li>";
        }
        $navbar = $navbar . "</ul></nav>";

        return $navbar;
    }

    private function fetchAnswer($instanceId, $questionId){
        return SubjectExaminationAnswer::where('examination_instance_id', $instanceId)->where('question_id', $questionId);
    }
}

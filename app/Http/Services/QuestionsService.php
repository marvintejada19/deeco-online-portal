<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Models\Questions\Question;
use App\Models\Questions\Types\QuestionFillInTheBlanks;
use App\Models\Questions\Types\QuestionMatchingType;
use App\Models\Questions\Types\QuestionMatchingTypeChoices;
use App\Models\Questions\Types\QuestionMatchingTypeItems;
use App\Models\Questions\Types\QuestionTrueOrFalse;
use App\Models\Questions\Types\QuestionMultipleChoice;
use App\Models\Subjects\SubjectExaminationAnswer;
use Illuminate\Foundation\Validation\ValidatesRequests;

class QuestionsService
{
    use ValidatesRequests;

    public function showByType(Question $question, $backUrl, $generateUrl){
        switch($question->getQuestionType()){
            case 'Multiple Choice':
                $rightAnswer = QuestionMultipleChoice::where('question_id', $question->id)->where('is_right_answer', '1')->first()->text;
                $wrongAnswers = QuestionMultipleChoice::where('question_id', $question->id)->where('is_right_answer', '0')->orderBy('text', 'asc')->get();
                return view('questions.content.show-partials.multiple-choice', compact('question', 'backUrl', 'generateUrl', 'rightAnswer', 'wrongAnswers'));
                break;
            case 'True or False':
                $rightAnswer = QuestionTrueOrFalse::where('question_id', $question->id)->first()->right_answer;
                return view('questions.content.show-partials.true-or-false', compact('question', 'backUrl', 'generateUrl', 'rightAnswer'));
                break;
            case 'Fill in the Blanks':
                $rightAnswer = QuestionFillInTheBlanks::where('question_id', $question->id)->first()->right_answer;
                return view('questions.content.show-partials.fill-in-the-blanks', compact('question', 'backUrl', 'generateUrl', 'rightAnswer'));
                break;
            case 'Matching Type':
                $matchingType = QuestionMatchingType::where('question_id', $question->id)->first();
                $choices = QuestionMatchingTypeChoices::where('matching_type_id', $matchingType->id)->orderBy('text', 'asc')->get();
                $items = QuestionMatchingTypeItems::where('matching_type_id', $matchingType->id)->get();
                
                $correctChoices = [];
                foreach($items as $item){
                    $correctChoices[] = $item->correct_answer;
                }

                return view('questions.content.show-partials.matching-type', compact('question', 'backUrl', 'generateUrl', 'matchingType', 'choices', 'items', 'correctChoices'));
                break;
            default:
                flash()->error('Some error occurred. Please try again.');
                return redirect('/home');
        }
    }

    public function generateInstance($question, $navbar, $nextUrl, $fromExam = false, $answerCollection = null){
        $answer = $answerCollection;
        switch($question->getQuestionType()){
            case 'Multiple Choice':
                $choices = QuestionMultipleChoice::where('question_id', $question->id)->get()->shuffle();
                if ($fromExam && !($answerCollection->isEmpty())){
                    $answer = $answerCollection->first()->answer;
                } else {
                    $answer = '';
                }
                return view('questions.content.instances.multiple-choice', compact('question', 'navbar', 'nextUrl', 'choices', 'answer'));
                break;
            case 'True or False':
                if ($fromExam && !($answerCollection->isEmpty())){
                    $answer = $answerCollection->first()->answer;
                } else {
                    $answer = '';
                }
                return view('questions.content.instances.true-or-false', compact('question', 'navbar', 'nextUrl', 'answer'));
                break;
            case 'Fill in the Blanks':
                if ($fromExam && !($answerCollection->isEmpty())){
                    $answer = $answerCollection->first()->answer;
                } else {
                    $answer = '';
                }
                return view('questions.content.instances.fill-in-the-blanks', compact('question', 'navbar', 'nextUrl', 'answer'));
                break;
            case 'Matching Type':
                $answers = [];
                $format = $question->matchingType->format;
                $choices = QuestionMatchingTypeChoices::where('matching_type_id', $question->matchingType->id)->get()->shuffle()->pluck('text');
                $items = QuestionMatchingTypeItems::where('matching_type_id', $question->matchingType->id)->get()->shuffle();
                if($fromExam && !($answerCollection->isEmpty())){
                    foreach ($answerCollection as $answerPerItem){
                        $answers[$answerPerItem->matching_type_item_id] = $answerPerItem->answer;
                    }
                }
                if (!strcmp($format, 'columns')) {
                    return view('questions.content.instances.matching-type-columns', compact('question', 'navbar', 'nextUrl', 'answers', 'choices', 'items'));
                } else if (!strcmp($format, 'wordbox')) {
                    return view('questions.content.instances.matching-type-wordbox', compact('question', 'navbar', 'nextUrl', 'answers', 'choices', 'items'));
                } else {
                    return redirect('/home');
                }
                break;
            default:
                flash()->error('Some error occurred. Please try again.');
                return redirect('/home');
        }
    }

    public function processInstance($question, $nextUrl, $request, $fromExam = false, $instance = null){
        switch($question->getQuestionType()){
            case 'Multiple Choice':
                $this->validate($request, ['answer' => 'required'], ['answer.required' => 'Please answer the question.']);
                $answer = QuestionMultipleChoice::find($request->input('answer'))->text;
                $correctAnswer = QuestionMultipleChoice::where('question_id', $question->id)->where('is_right_answer', '1')->first()->text;
                $points = (!strcmp($answer, $correctAnswer)) ? $question->points : 0;
                if ($fromExam){
                    $this->recordAnswer($instance, $question, $answer);
                    return redirect($nextUrl);
                } else {
                    return view('questions.content.results.multiple-choice', compact('question', 'nextUrl', 'answer', 'correctAnswer', 'points'));
                }
                break;
            case 'True or False':
                $this->validate($request, ['answer' => 'required'], ['answer.required' => 'Please answer the question.']);
                $answer = $request->input('answer');
                $correctAnswer = QuestionTrueOrFalse::where('question_id', $question->id)->first()->right_answer;
                $points = (!strcmp($answer, $correctAnswer)) ? $question->points : 0;
                if ($fromExam){
                    $this->recordAnswer($instance, $question, $answer);
                    return redirect($nextUrl);
                } else {
                    return view('questions.content.results.true-or-false', compact('question', 'nextUrl', 'answer', 'correctAnswer', 'points'));
                }
                break;
            case 'Fill in the Blanks':
                $this->validate($request, ['answer' => 'max:255'], ['answer.required' => 'Please answer the question.']);
                $answer = $request->input('answer');
                $correctAnswer = QuestionFillInTheBlanks::where('question_id', $question->id)->first()->right_answer;
                $points = (!strcmp($answer, $correctAnswer)) ? $question->points : 0;
                if ($fromExam){
                    $this->recordAnswer($instance, $question, $answer);
                    return redirect($nextUrl);
                } else {
                    return view('questions.content.results.fill-in-the-blanks', compact('question', 'nextUrl', 'answer', 'correctAnswer', 'points'));
                }
                break;
            case 'Matching Type':
                $answers = $request->input('answers');
                $items = QuestionMatchingTypeItems::where('matching_type_id', $question->matchingType->id)->get();
                $points = 0;
                foreach ($answers as $itemId => $answer){
                    $item = QuestionMatchingTypeItems::where('id', $itemId)->first();
                    $points += (!strcmp($answer, $item->correct_answer)) ? $question->points : 0;
                }
                if ($fromExam){
                    foreach($answers as $itemId => $answer){
                        $this->recordAnswer($instance, $question, $answer, $itemId);
                    }
                    return redirect($nextUrl);
                } else {
                    return view('questions.content.results.matching-type', compact('question', 'nextUrl', 'answers', 'items', 'points'));
                }
                break;
            default:
                flash()->error('Some error occurred. Please try again.');
                return redirect('/home');    
        }
    }

    private function recordAnswer($instance, $question, $answer, $matching_type_item_id = null){
        $examinationAnswer = new SubjectExaminationAnswer();
        $examinationAnswer->examination_instance_id = $instance->id;
        $examinationAnswer->question_id = $question->id;
        $examinationAnswer->answer = $answer;
        if (!strcmp($question->getQuestionType(), 'Matching Type')){
            $examinationAnswer->matching_type_item_id = $matching_type_item_id;
        }

        $examinationAnswer->save();
    }       
}

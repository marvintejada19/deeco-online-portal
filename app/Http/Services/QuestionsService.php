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

class QuestionsService
{
    public function showByType(Question $question, $backUrl){
        switch($question->getQuestionType()){
            case 'Multiple Choice':
                $rightAnswer = QuestionMultipleChoice::where('question_id', $question->id)->where('is_right_answer', '1')->first()->text;
                $wrongAnswers = QuestionMultipleChoice::where('question_id', $question->id)->where('is_right_answer', '0')->orderBy('text', 'asc')->get();
                return view('questions.content.show-partials.multiple-choice', compact('question', 'backUrl', 'rightAnswer', 'wrongAnswers'));
                break;
            case 'True or False':
                $rightAnswer = QuestionTrueOrFalse::where('question_id', $question->id)->first()->right_answer;
                return view('questions.content.show-partials.true-or-false', compact('question', 'backUrl', 'rightAnswer'));
                break;
            case 'Fill in the Blanks':
                $rightAnswer = QuestionFillInTheBlanks::where('question_id', $question->id)->first()->right_answer;
                return view('questions.content.show-partials.fill-in-the-blanks', compact('question', 'backUrl', 'rightAnswer'));
                break;
            case 'Matching Type':
                $matchingType = QuestionMatchingType::where('question_id', $question->id)->first();
                $choices = QuestionMatchingTypeChoices::where('matching_type_id', $matchingType->id)->orderBy('text', 'asc')->get();
                $items = QuestionMatchingTypeItems::where('matching_type_id', $matchingType->id)->get();
                
                $correctChoices = [];
                foreach($items as $item){
                    $correctChoices[] = $item->correct_answer;
                }

                return view('questions.content.show-partials.matching-type', compact('question', 'backUrl', 'matchingType', 'choices', 'items', 'correctChoices'));
                break;
            default:
                flash()->error('Some error occurred. Please try again.');
                return redirect('/home');
        }
    }       
}
